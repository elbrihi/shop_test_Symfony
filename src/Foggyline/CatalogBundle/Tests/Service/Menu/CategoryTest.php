<?php

namespace Foggyline\CatalogBundle\Tests\Menu ;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Foggyline\CatalogBundle\Service\Menu\Category;

class CategoryTest extends KernelTestCase
{
    private $router;
    private $em;
    private $container;

    public function setUp()
    {
        static::bootkernel();
        $this->container = static::$kernel->getContainers();
        $this->em =   $this->container->get('doctrine.orm.entity_manager');
        $this->router =    $this->container->get('router');
    }
    public function testGetItems()
    {
        $service = new Category($this->em,  $this->router);
        $this->assertNotEmpty($service->getItems());
    }

    protected function tearDown()
    {
      $this->em->close();
      unset($this->em, $this->router);
    }
  
}








?>