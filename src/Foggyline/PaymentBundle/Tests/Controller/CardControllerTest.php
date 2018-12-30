<?php

namespace Foggyline\PaymentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardControllerTest extends WebTestCase
{
    private $client;
    private $container; 
    public function setUp()
    {
        $this->client = static::createClient();
        $this->router =  $this->client->getContainer->get('router');
    }
    public function testAuthorizeAction()
    {
        $this->client->request('GET', $this->router->generate('foggyline_payment_card_authorize'));
        $this->assertTests();
    }

}
