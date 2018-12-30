<?php

namespace Foggyline\SalesBundle\Service;

class Payment
{
    private $_methods ;
    private $container;
    public function __construct($container, $methods) // container of the checkPayment and cardPayment from target
    {
        $this->container = $container ; 
        $this->_methods = $methods ; 
    }
    public function getAvailableMethods()
    {
        //return $this->container->get($this->_methods);
       $methods = array(); 
       foreach($this->_methods as $_method)
       {
            $methods[] = $this->container->get($_method);
       }
       return $methods;
    }
    
}




?>