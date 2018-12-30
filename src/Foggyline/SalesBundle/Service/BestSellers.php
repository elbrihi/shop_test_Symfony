<?php 

namespace Foggyline\SalesBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
class BestSellers

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
            $products[] = array(
                'id'=>$_product->getId(),
                'img'=>'/uploads/foggyline_catalog_images/'.$_product->getImage(),
                'name'=>$_product->getTitle(),
                'price'=>$_product->getPrice(),
//                'path'=>$this->router->generate('/product/'.$_product->getId()),
                'path'=>$this->router->generate('product_show',
                                                array('id'=>$_product->getId())
                    ),

                
            );
        }
        
        return $products ;
    }
    public function getBestsellers()
    {
        $products = array();
        $query = $this->em->createQuery('SELECT IDENTITY(t.product),  SUM(t.qty) AS HIDDEN q
            FROM Foggyline\SalesBundle\Entity\SalesOrderItem t GROUP BY t.product ORDER BY q DESC')->setMaxResults(5);
        $_products = $query->getResult();   
        foreach ($_products as $_product) 
        {
            $products[] = $this->_em->getRepository('FoggylineCatalogBundle:Product')->find(current($_product));
        }
    return $products;
    }
}



?>