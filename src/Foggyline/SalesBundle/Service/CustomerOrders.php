<?php 

namespace Foggyline\SalesBundle\Service;

use Doctrine\ORM\EntityManager;
use Foggyline\SalesBundle\Entity\SalesOrder;
use Foggyline\CustomerBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class CustomerOrders
{
    private $em ;
    private $token;
    private $router;
    public function __construct($tokenStorage , EntityManager $emEntity, Router $router )
    {
       
        $this->em = $emEntity;
        $this->token = $tokenStorage->getToken();
        $this->router =  $router;
    }
    /**
     * array
     * 
     * return the cstomer orders
     * 
     */
    public function getOrders()
    {
        $orders = array();

        if($customer = $this->token->getUser())   
        {
           
          $salesOrders = $this->em->getRepository('FoggylineSalesBundle:SalesOrder')->findBy(
              array(
                  'customer'=>$customer         
                  )
              );
            
        $sales = array();
        foreach( $salesOrders as $salesOrder )
        {
            $orders[] = 
                array(
                    'id'=>$salesOrder->getId(),
                    'date' => $salesOrder->getCreatedAt()->format('d/m/Y H:i:s'),
                    'ship'=> $salesOrder->getCustomerLastName(),
                    'orderTotal'=> $salesOrder->getTotalPrice().' Euro',
                    'status'=> $salesOrder-> getStatus(),
                    'action'=> array(
                                        array('lebel'=>'cancel',
                                              'path' => $this->router->generate('foggyline_sales_order_cancel',
                                                        array('id'=>$salesOrder->getId())),
                                        ),
                                        array('lebel'=>'Print ',
                                              'path' => $this->router->generate('foggyline_sales_order_print',
                                               array('id'=>$salesOrder->getId())),
                                        ),
                                    )
                                     
            
                    )
            
            ;
             
            
        }

        return  $orders;
          
            
        }
         

        
        
    }
}



?>