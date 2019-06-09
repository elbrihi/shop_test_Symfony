<?php

namespace Foggyline\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Foggyline\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class DefaultController extends Controller
{
    
    
    public function indexAction()
    {
        return $this->render('FoggylineUserBundle:Default:index.html.twig');
    }
    public function fetchAction(Request $request)
    {       
       $user = $this->get('foggyline_user.fetch_user')->getUserData($request);
       return new Response($user);
    }
     

    public function editAction(Request $request)
    {  
      
      $em = $this->getDoctrine()->getManager();

      $user_id = $request->get('user_id');

      $user =  $em->getRepository('FoggylineUserBundle:User')->findOneBy(array('id'=>$user_id));
      
      $editForm = $this->createForm('Foggyline\UserBundle\Form\UserType',$user);
      
      $editForm->handleRequest($request);
      if($editForm->isSubmitted() && $editForm->isValid())
       
      {
         
        $em->persist($user);
        $em->flush();
        return new Response('nice work');
      }
      return $this->render('FoggylineUserBundle:default:user/edit.html.1.twig',array(
        'user'=>$user,
        'form'=>$editForm->createView(),
      ));

      
        
    }
    public function addAction(Request $request)
    {  
     
      $user = new User();
      $form = $this->get('foggyline_user.fetch_user')->getFromAdd($user,$request);

      return $this->render('FoggylineUserBundle:default:user/new.html.1.twig',array(
        'user'=>$user,
        'form'=>$form->createView(),
      ));
        
    }
    public function deleteAction(Request $request)
    {  
     
      $em = $this->getDoctrine()->getManager();

      $user_id = $request->get('user_id');

      $user =  $em->getRepository('FoggylineUserBundle:User')->findOneBy(array('id'=>$user_id));

      $em = $this->getDoctrine()->getManager();
      $em->remove($user);
      $em->flush();

      return new Response('delete');
        
    }

}
