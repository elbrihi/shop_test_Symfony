<?php

namespace Foggyline\SalesBundle\Service;

use Doctrine\ORM\EntityManager ;
use Foggyline\CustomerBundle\Entity\Customer ;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class CheckoutMenu
{
    private $em ;
    private $token;
    private $router;
    public function __construct($tokenStorage, EntityManager $em,  Router $router)
    {
        $this->token = $tokenStorage->getToken();
        $this->em = $em ;
        $this->router = $router;
    }
    public function getItems()
    {
      if($this->token && $this->token->getUser() instanceof Customer)
      {

        $customer = $this->token->getUser()->getId();
           
        $cart = $this->em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(
            array('customer'=>$customer)
        );
        if($cart)
        {
            $items = $cart->getItems();
        }else{
            $items = false;   
        }
       // $items = $cart->getItems();
        
        
        return array(
                    array( 'path'=>$this->router->generate('foggyline_sales_cart'),
                           'label'=>sprintf('Cart (%s)',count($items))
                    )
        );
  
      }
            
     
      
    }
}



?>