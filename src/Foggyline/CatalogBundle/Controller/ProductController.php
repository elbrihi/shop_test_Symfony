<?php

namespace Foggyline\CatalogBundle\Controller;

use Foggyline\CatalogBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Foggyline\CatalogBundle\Security\ProductVoter;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $products = $this->get('foggyline_catalog.onSale')->getItems();

      
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('FoggylineCatalogBundle:Product')->findAll();

        return $this->render('FoggylineCatalogBundle:default:product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Lists all product entities.
     *
     * @Route("/fetch", name="product_fetch")
     */
    public function fetchAction()
    {
        $product = $this->get('foggyline_product.product_fetch')->getProductData();
        
       // return new Response($category);
         return new Response($product );
    }
    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        
        $product = new Product();
        $form = $this->createForm('Foggyline\CatalogBundle\Form\ProductType', $product);
        $form->handleRequest($request);
        
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $product->getImage()) {
            
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $product->setImage($name);
                $product->setUser($this->getUser());
            }
      
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
           
            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('FoggylineCatalogBundle:default:product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }
       /**
     * Creates a new product entity.
     *
     * @Route("/add", name="product_add")
     */
    public function addAction(Request $request)
    {
       
        $product = new Product();
        $image = $product->getImage();
       
        $form = $this->createForm('Foggyline\CatalogBundle\Form\ProductType', $product);
        $form->handleRequest($request);
    
       
        if ($form->isSubmitted() && $form->isValid()) {
 
           if($user = $this->getUser())
           {
            $product->setUser($user);
           }
           /* @var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
           if ($image = $product->getImage()) {
            
            $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
            $product->setImage($name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            
            $em->flush();
            
            //return $this->redirectToRoute('category_show', array('id' => $category->getId()));
            return new Response('the category form was added with succefully!!');
        }
        
        return $this->render('FoggylineCatalogBundle:default:product/new.html.1.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
        
    }
    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
      
        //dump($product->getUser());
        if($this->getUser()===$product->getUser())
        {
            //echo 'nice';
            
        }
     //   die;
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('FoggylineCatalogBundle:default:product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $existingImage=$product->getImage();

        if($existingImage)
        {
            $product->setImage(new File($this->getParameter('foggyline_catalog_images_directory').'/'.$existingImage)) ;
        }
        //$deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('Foggyline\CatalogBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($user  = $this->getUser())
            {
                $product->setUser($user);
            }
            
            if($image =$product->getImage())
            {
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $product->setImage($name);
            }
            elseif ($existingImage) {
                $product->setImage($existingImage);
              }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('FoggylineCatalogBundle:default:product/edit.html.twig', array(
            'product' => $product,
            'form_edit' => $editForm->createView(),
          //  'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/delete", name="product_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        
       
        $em = $this->getDoctrine()->getManager();

        
        $product_id = $request->get('product_id');

       
        $product =  $em->getRepository('FoggylineCatalogBundle:Product')->findOneBy(array('id'=>$product_id));
  

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
  
        return new Response('delete');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
