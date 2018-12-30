<?php

namespace Foggyline\PaymentBundle\Service ;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

class CheckPayment{

    
    private $router ;
    
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getInfo()
    { 
         
    
        return array(
            'payment' => array(
                    'title' =>'Foggyline Check Payment',
                    'code' =>'check_payment', 
                  
            )
          );
      
     
    }
}




?>