<?php
namespace Foggyline\PaymentBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CardPaymentTest extends KernelTestCase
{
    private $container;
    private $formFactory;
    private $router;

    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContent();
        $this->formFactory = $this->container->get('form.factory');
        $this->router = $this->container->get('router');
    }

    public function TestGetInfo()
    {
       $payment =  $this->container->get('foggyline_payment.card_payment');
       $info = $payment->getInfo();
       $this->assertNotEmtpty($info);
    }

    public function TestGetInfoViaClass()
    {
        $payment = new \Foggyline\PaymentBundle\Service\CaradPaymentTest
          (
            $this->formFactory,
            $this->container 
          );
          $this->assertNotEmpty($payment->getInfo());
    }
}



?>