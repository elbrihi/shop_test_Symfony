<?php

namespace Foggyline\UserBundle\Controller;

use Foggyline\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('FoggylineUserBundle:User')->findAll();

        return $this->render('FoggylineUserBundle:default:user/index.html.twig', array(
            'users' => $users,
        ));
    }
    /**
     * 
     * 
     * @Route("/login", name = "user_login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        
      
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
          
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
       
        return $this->render('FoggylineUserBundle:default:user/login.html.twig',
            array(
            // last username entered by the user
            'username' => $lastUsername,
            'error'         => $error,
               ));
    }
    /**
     * 
     * 
     * @Route("/registration", name="user_registration")
     */
    public function registrationActin(Request $request)
    {
       $user = new User();
       $em = $this->getDoctrine()->getManager();

       $form = $this->createForm('Foggyline\UserBundle\Form\UserType',$user);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid() )
       {
            $password = $this->get('security.password_encoder')
                        ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("user_login");
            
       }
     return $this->render('FoggylineUserBundle:default:user/registration.html.twig',array(
                'form'=>$form->createView(),
        ));
    }
    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Foggyline\UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('FoggylineUserBundle:default:user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('FoggylineUserBundle:default:user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Foggyline\UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        dump($request);
      //  die;
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('FoggylineUserBundle:default:user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * 
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        return $this->render();
    }
}
