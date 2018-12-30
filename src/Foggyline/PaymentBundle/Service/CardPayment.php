<?php

namespace Foggyline\PaymentBundle\Service ;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Foggyline\PaymentBundle\Entity\Card;
use Foggyline\PaymentBundle\Form\CardType;
class CardPayment{

    private $formFactory;
    private $router ;
    public function __construct($formFactory , $router)
    {
       
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function getInfo()
    { 
         
        $card = new Card();
        $form = $this->formFactory->create('Foggyline\PaymentBundle\Form\CardType',$card);
                   
     
        return array(
            'payment' => array(
                    'title' =>'Foggyline Card Payment',
                    'code' =>'card_payment', 
                    'form'=>$form->createView(), 
            )
          );
      
     
    }
}




?>