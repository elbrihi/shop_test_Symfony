<?php

namespace Foggyline\CustomerBundle\Tests\Service\Menu;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
//use Foggyline\CustomerBundle\Service\Menu\CustomerMenu;

class CustomerMenu extends KernelTestCase
{
    private $container;
    private $tockenStorage;
    private $router;
    public function setUp()
    {
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->tockenStorage = $this->container->get('security.token_storage');
        $this->router =  $this->container->get('router');
    }
    public function testGetItemsViaService()
    {
        $menu = new Foggyline\CustomerBundle\Service\Menu\CustomerMenu($this->tockenStorage, $this->router);
        $this->assertNotEmty($menu->getItems());
    }
}
