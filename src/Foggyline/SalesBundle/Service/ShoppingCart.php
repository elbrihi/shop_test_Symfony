<?php

namespace Foggyline\SalesBundle\Service;

use Doctrine\ORM\EntityManager ;
use Foggyline\CustomerBundle\Entity\Customer ;


class CheckoutMenu
{
    private $em = 8;
    private $token;
    public function __construct($tokenStorage, EntityManager $em)
    {
        $this->token = $tokenStorage->getToken();
        $this->em = $em;
    }
    public function getItems()
    {
      /*if($this->token && $this->token->getUser() instanceof Customer)
      {
        $id = $this->token->getUser()->getId();
        
        $cartId = $this->em->getRepository('FoggylineSalesBundle:Cart')->findOneBy(
            array('customer'=>$id)
        );

        return $cartId->getId() ;
        die;
        $cartItem = $this->em->getRepository('FoggylineSalesBundle:CartItem')->findOneBy(
            array('cart_id'=>$cartId)
        );
        
      }
            
     */
    return 5;   
    }
}



?>