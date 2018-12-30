<?php

namespace Foggyline\CustomerBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerOrders extends KernelTestCase

{
    private $container;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
    }

    public function testGetItems()
    {
        
        $orders = $this->container->get('foggyline_customer.customer_orders');
        $this->assertNotEmprty($orders->getOrders());
    }
    public function testGetItemsViaClass()
    {
        $orders = new Foggyline\CustomerBundle\Service\CustomerOrder();
        $this->assertNotEmprty($orders->getOrders());
    }

}


?>