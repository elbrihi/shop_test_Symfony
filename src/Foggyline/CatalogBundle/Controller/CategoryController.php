<?php

namespace Foggyline\CatalogBundle\Controller;

use Foggyline\CatalogBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Foggyline\CatalogBundle\Security\CategoryVoter;
use Symfony\Component\HttpFoundation\Response;
/**
 * 
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
       // $user =  $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
      
       // $checker =  $this->get('foggyline_catalog.category_fetch')->testSecurityUser();

       
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('FoggylineCatalogBundle:Category')->findAll();

        return $this->render('FoggylineCatalogBundle:default:category/index.html.twig', array(
            'categories' => $categories,
        ));
    }
    /**
     * Lists all category entities.
     *
     * @Route("/fetch", name="category_fetch")
     */
    public function fetchAction()
    {
        $category = $this->get('foggyline_catalog.category_fetch')->getCategoryData();
        
       // return new Response($category);
       return new Response($category);
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
       
        $category = new Category();
        $image = $category->getImage();
        
        $form = $this->createForm('Foggyline\CatalogBundle\Form\CategoryType', $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
 
           /* @var $image \Symfony\Component\HttpFoundation\File\UploadedFile */
           if ($image = $category->getImage()) {
            
            $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
            $category->setImage($name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            
            $em->flush();

            //return $this->redirectToRoute('category_show', array('id' => $category->getId()));
            return new Response('the categoer form was added with succefully!!');
        }

        return $this->render('FoggylineCatalogBundle:default:category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
    
        
       // dump($this->getUser());
       //dump($category->getUser());
       if($this->getUser()===$category->getUser())
       {
           //echo 'nice';
           //die;
       }
      

        $deleteForm = $this->createDeleteForm($category);

        return $this->render('FoggylineCatalogBundle:default:category/show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        // $category = new  Category();
        
        $existingImage=$category->getImage();


        if($existingImage)
        {
            $category->setImage(new File($this->getParameter('foggyline_catalog_images_directory').'/'.$existingImage)) ;
        }
        $editForm = $this->createForm('Foggyline\CatalogBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($image = $category->getImage())
            {
                $name = $this->get('foggyline_catalog.image_uploader')->upload($image);
                $category->setImage($name);
            }
            elseif ($existingImage) {
                $category->setImage($existingImage);
              }
            
            $this->getDoctrine()->getManager()->flush();
            return new Response('the categoer form was eddited with succefully!!');

        }

        return $this->render('FoggylineCatalogBundle:default:category/edit.html.1.twig', array(
            'category' => $category,
            'form_edit' => $editForm->createView(),
        ));
    }
    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
