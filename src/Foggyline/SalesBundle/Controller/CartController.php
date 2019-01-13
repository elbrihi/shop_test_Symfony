<?php

namespace Foggyline\SalesBundle\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Foggyline\SalesBundle\Entity\Cart;
use Foggyline\SalesBundle\Entity\CartItem;

use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function updateAction(Request $request)
    {
        $qtes = $request->get('item');
        $em =  $this->getDoctrine()->getManager();
       // $cart = new CartItem();
        foreach($qtes as $_id=>$qte)
        {
            $cartItem = $em->getRepository('FoggylineSalesBundle:CartItem')->find($_id);
            
            if($qte > 1)
            {                
               $cartItem->setQty($qte);        
               $em->persist($cartItem);     
            } 
            else
            {
                $em->remove($cartItem);
            }
        }
        $em->flush();
        $this->addFlash('success', 'Cart updated.');
        return $this->redirectToRoute('foggyline_sales_cart');
    }
    public function indexAction()
    {
        if($customer =$this->getUser())
        {
            
            $em = $this->getDoctrine()->getManager();
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(array('customer'=>$customer->getId()));
            $total = 0;
            $items  = array();
            if(!empty($cart))
            {
                                /**
             * Attempted to call an undefined method named "getUniPrice" of class "Foggyline\SalesBundle\Entity\CartItem"
             * .Did you mean to call e.g. "getUnitPrice" or "setUnitPrice"?
             */
          //  print_r($cart->getItems());
            $items = $cart->getItems();
           
            
            foreach($items as $item)
            {
                $total  = $total  + $item->getQty() * $item->getUnitPrice();;
            }
            }

        }
        else
        {
            return $this->redirect('/');
        }
        return  $this->render('FoggylineSalesBundle:default:cart/index.html.twig',
            array( 
                   'items'=>$items,
                   'total'=> $total,
                   'customer'=>$customer,
                   ));

    }
    public function addAction($id)
    {
       
        if($customer = $this->getUser())
        {
            $customer = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $now = new \DateTime();
            
            $cart = $em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(
                array('customer'=>$customer)
            );

            $product = $em->getRepository('FoggylineCatalogBundle:Product')->find($id);
          
            if(!$cart)
            {
                $cart = new \Foggyline\SalesBundle\Entity\Cart();
                $cart->setModifiedAt($now);
                $cart->setCreatedAt($now);
                $cart->setCustomer($customer);
                $em->persist($cart);
                $em->flush();
            }
            else
            {
                $cart->setModifiedAt($now);
                  
            }
            
               $cartItem = $em->getRepository('FoggylineSalesBundle:CartItem')->findOneBy(
                array('cart'=>$cart->getId(),
                      'product'=>$product->getId(),
                      )
                     );
                     

            if(!$cartItem)
            {
              
                $cartItem = new \Foggyline\SalesBundle\Entity\CartItem();
                $cartItem->setQty(1);
                $cartItem->setProduct($product);
                $cartItem->setCart($cart);
                $cartItem->setUnitPrice($product->getPrice());
                $cartItem->setCreatedAt($now);
                $cartItem->setModifiedAt($now);
                $em = $this->getDoctrine()->getManager();
                        
            }else
            {   
                $cartItem->setQty($cartItem->getQty()+1);
            }
           
            
            $em->persist($cartItem);
            $em->flush();
            
            $this->addFlash('success', sprintf('%s successfully added to cart', $product->getTitle()));
            return $this->redirectToRoute('foggyline_sales_cart');
        }
        else
        {
            $this->addFlash('warning', 'Only logged in users can  add to cart.');
          return $this->redirect('/');
        }
        
       // return $this->render('FoggylineSalesBundle:default:cart/index.html.twig');

    }
}




?>