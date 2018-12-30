<?php

namespace Foggyline\CatalogBundle\Service\Menu;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class Category
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
        $categories = array();
        $_categories = $this->em->getRepository('FoggylineCatalogBundle:Category')->findAll();
        
        foreach($_categories as $_categorie)
        {
            $categories[] = array('path'=>$this->router->generate('category_show', array('id'=>$_categorie->getId())),
                                'label' => $_categorie->getTitle() 
                                   
                                );
        }

        return $categories;
    }
}



?>