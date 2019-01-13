<?php

namespace Foggyline\SalesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\HttpFoundation\Response;
use Foggyline\SalesBundle\Entity\Cart;
use Foggyline\SalesBundle\Entity\SalesOrder;
use Foggyline\SalesBundle\Entity\SalesOrderItem;
class CheckoutController extends Controller
{
    public function indexAction():Response
    {
        if($customer = $this->getUser()  )
        {
            $em = $this->getDoctrine()->getManager();
            $form = $this->getAddressForm();

            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(
                array('customer'=>$customer->getId()));

            $items = $cart->getItems();
            
            $total = 0;
            foreach($items  as $item)
            {
                $total = $total + $item->getUnitPrice()*$item->getQty();
            }
            $shipment = $this->get('foggyline_sales.shipment')->getAvailableMethods();
                
        }else
        {
           return  $this->redirect('/');
        }
    

        return $this->render('FoggylineSalesBundle:default:checkout/index.html.twig',
                array(
                    'items'=> $items,
                    'total'=> $total,
                    'shipping_address_form' => $form->createView(),
                    'shipping_methods' => $this->get('foggyline_sales.shipment')->getAvailableMethods(),
            
                ));
    }
    public function getAddressForm()
    {
        return $this->createFormBuilder()
            ->add('address_first_name', TextType::class)
            ->add('address_last_name', TextType::class)
            ->add('company', TextType::class)
            ->add('address_telephone', TextType::class)
            ->add('address_country', CountryType::class)
            ->add('address_state', TextType::class)
            ->add('address_city', TextType::class)
            ->add('address_postcode', TextType::class)
            ->add('address_street', TextType::class)
            ->getForm();

    }
    public function paymentAction(Request $request):Response
    {
        $addressForm = $this->getAddressForm();
        $addressForm->handleRequest($request);
        if($costumer = $this->getUser() )
        {
            $cart = new Cart();
            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(
                array('customer'=>$costumer->getId())
            );
            
            $items = $cart->getItems();

//            print_r($items->getQty());

            $totale_subtotale = 0;
            foreach($items as $item)
            {
                $totale_subtotale = $totale_subtotale +  floatval($item->getQty()*$item->getUnitPrice());
            }
            $totale_subtotale;
            
            $checkoutInfo = array();
            $a = $request->get('shipment_method');
            $shipment_method = explode('____',$a);
            $dynamic_rate_sdd = $shipment_method[0];
            $delivery_label_here = $shipment_method[1];
            $delivery_label_price = $shipment_method[2];
            $order_totale = floatval($shipment_method[2]+ $totale_subtotale); 
            $infoForm = $addressForm->getData();
            
            $checkoutInfo['order_totale'] = $order_totale;
            $checkoutInfo['infoForm'] = $infoForm ;
            $checkoutInfo['cart_subtotal'] = $totale_subtotale ;
            $checkoutInfo['shipment_price'] = $delivery_label_price ;
            $checkoutInfo['dynamic_rate_Sdd'] = $dynamic_rate_sdd ;
            $checkoutInfo['totale_price'] = $order_totale ;

            
        }
       
        $this->get('session')->set('checkoutInfo',$checkoutInfo);
        $methods = $this->get('foggyline_sales.payment')->getAvailableMethods();
        return $this->render('FoggylineSalesBundle:default:checkout/payment.html.twig',
                        array(
                              'payment_methods'=>$methods,
                              'cart_subtotal'=>$totale_subtotale,
                              'shipment_method'=>$shipment_method ,
                              //'delivery_label_price'=>$delivery_label_price,
                              'order_total'=>$order_totale,
                              'delivery_subtotal'=>$delivery_label_price,
                              'delivery_label'=> 'Delivery Label Here',
                              'checkoutInfo'=>$checkoutInfo,        
                              'items'=>$items,
                              'shipment_price'=>$delivery_label_price,
                             )
                    );
    }
    public function processAction(Request $request)
    {
        if($customer = $this->getUser() )
        { 
           
            $salesOrder = new SalesOrder();
            $now = new \DateTime();
            $em = $this->getDoctrine()->getManager();
            $checkoutInfo = $this->get('session')->get('checkoutInfo');
            $payment_method = $request->get('payment_method');
            $customer_first_name = $this->getUser()->getFirstName();
            $customer_last_name = $this->getUser()->getLastName();
            $customer_id = $this->getUser(); 
            $salesOrder->setCustomer($customer_id); 
            $salesOrder->setTotalPrice($checkoutInfo['order_totale']);
            $salesOrder->setItemsPrice($checkoutInfo['cart_subtotal']);
            $salesOrder->setShipmentPrice($checkoutInfo['shipment_price']); 
            $salesOrder->setStatus('processing');
            $salesOrder->setPaymentMethod($payment_method);
            $salesOrder->setShipmentMethod($checkoutInfo['dynamic_rate_Sdd']);    
            $salesOrder->setCustomerEmail($this->getUser()->getEmail());
            $salesOrder->setCustomerFirstName($customer_first_name);
            $salesOrder->setCustomerLastName($customer_last_name);
            $salesOrder->setCustomerLastName($customer_last_name);
            $salesOrder->setAdressState($checkoutInfo['infoForm']['address_state']);
            $salesOrder->setAdressCity($checkoutInfo['infoForm']['address_city']);
            $salesOrder->setAdressPostcode($checkoutInfo['infoForm']['address_postcode']);
            $salesOrder->setAdressStreet($checkoutInfo['infoForm']['address_street']);
            $salesOrder->setAdressFirstName($checkoutInfo['infoForm']['address_street']);
            $salesOrder->setAdressLastName($checkoutInfo['infoForm']['address_street']);
            $salesOrder->setAdressCountry($checkoutInfo['infoForm']['address_country']);
            $salesOrder->setAdressTelephone($checkoutInfo['infoForm']['address_telephone']);
            $salesOrder->setCreatedAt($now);
            $salesOrder->setModifiedAt($now);
            echo '<pre>';
            print_r($checkoutInfo);
            echo '</pre>';
            $em->persist($salesOrder);
            $em->flush();//
            $salesOrderId =  $salesOrder->getId();
            $cart = new Cart();

            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(
                array('customer'=>$customer)
            );
            $salesOrder->setStatus(\Foggyline\SalesBundle\Entity\SalesOrder::STATUS_PROCESSING);
            $items = $cart->getItems();
            $title = array();
           
                foreach($items as $item)
                {
                    
                    $OrderItem = new SalesOrderItem();
                    //$OrderItem->setSalesOrder($salesOrderId);
                    //$OrderItem->setSalesOrder($salesOrderId);
                    $OrderItem->setSalesOrder($salesOrder);
                    $OrderItem->setTitle($item->getProduct()->getTitle());
                    $OrderItem->setQty($item->getQty());
                    $OrderItem->setUnitPrice($item->getQty()*$item->getUnitPrice());
                    $OrderItem->setTotalPrice($item->getQty()*$item->getUnitPrice()+$checkoutInfo['shipment_price']);
                    $OrderItem->setProduct($item->getProduct());
                    $OrderItem->setCreatedAt($now);
                    $OrderItem->setModifiedAt($now);
                    $em->persist($OrderItem);
                    $em->remove($item);
    
                    
                }
                $em->remove($cart);
                $em->flush();
    
        
        }
        
        $this->get('session')->set('last_order',$OrderItem->getId());
        return $this->redirectToRoute('foggyline_sales_checkout_success');
    }
    public function successAction()
    {
        
        $etems = $this->get('foggyline_sales.customer_orders')->getOrders();
        return $this->render('FoggylineSalesBundle:default:order/success.html.twig',array(
            'last_order'=>$this->get('session')->get('last_order'),
            'customer_orders' =>$etems,
        ));
    }

    public function printAction($id)
    {
        if($customer  = $this->getUser())
        {
            $saleOrder = new SalesOrder();
            $em = $this->getDoctrine()->getManager();
            $saleOrder = $em->getRepository('FoggylineSalesBundle:SalesOrder')->findOneBy(array(
            'customer'=>$customer,
            'id' => $id,
        ));

        }
        
        
                
        return $this->render('FoggylineSalesBundle:default:Order\print.html.twig',
                            array('order'=>$saleOrder));
    }

    public function cancelAction($id)
    {
        
        if ($customer = $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $salesOrder = $em->getRepository('FoggylineSalesBundle:SalesOrder')
                ->findOneBy(array('customer' => $customer, 'id' => $id));
            if ($salesOrder->getStatus() != \Foggyline\SalesBundle\Entity\SalesOrder::STATUS_COMPLETE) {
                $salesOrder->setStatus(\Foggyline\SalesBundle\Entity\SalesOrder::STATUS_CANCELED);
                $em->persist($salesOrder);
                $em->flush();
            }
        }
        return $this->redirectToRoute('customer_account');
    }

   
}


?>