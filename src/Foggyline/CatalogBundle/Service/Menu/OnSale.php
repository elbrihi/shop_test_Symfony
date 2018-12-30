<?php

namespace Foggyline\CatalogBundle\Service\Menu;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class OnSale
{
    private $em;
    private $router;
    public function __construct(EntityManager $entityManager, Router $router)
    {
        $this->em = $entityManager;
        $this->router = $router;
    }

    public function getItems()
    {
        $products = array();
        $_products = $this->em->getRepository('FoggylineCatalogBundle:Product')->findAll();
        
        foreach($_products as $_product)
        {
            $products[] = array('path'=>$this->router->generate('product_show', array('id'=>$_product->getId())),
                                'label' => $_product->getTitle() 
                                   
                            );
        }

        return $products;
        
    }
}




?>