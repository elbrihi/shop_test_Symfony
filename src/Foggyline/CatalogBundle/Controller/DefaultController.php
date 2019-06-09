<?php

namespace Foggyline\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Foggyline\CatalogBundle\Entity\Category;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        return $this->render('FoggylineCatalogBundle:Default:index.html.twig');
    }
    public function fetchAction()
    {
      

        //$category = $this->get('foggyline_catalog.category_fetch')->getCategoryData();
        
       // return new Response($category);

    }
    public function addAction(Request $request)
    {  
     
        
        $category = new Category();
        $form = $this->get('foggyline_catalog.category_fetch')->getFromAdd($category,$request);

   //   return new Response($form);
        return $this->render('FoggylineCatalogBundle:default:category/new.html.twig',array(
        'user'=>$category,
        'form'=>$form->createView(),
      ));
    }
}
