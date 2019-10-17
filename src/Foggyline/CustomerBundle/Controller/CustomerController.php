<?php

namespace Foggyline\CustomerBundle\Controller;

use Foggyline\CustomerBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Customer controller.
 *
 * @Route("customer")
 */
class CustomerController extends Controller
{
    /**
     * check the customer
     * 
     * @Route("/login", name="foggyline_customer_login")
     * @Method({"GET","POST"})
     */
    public function login(Request $request):Response
    {   
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'FoggylineCustomerBundle:default:customer/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

    }
    /**
     * Creates a new customer entity.
     *
     * @Route("/register", name="foggyline_customer_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
       
        $user = new Customer();
        $form = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType', $user);
        $form->handleRequest($request);
  
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
           
            $em->persist($user);
           
            $em->flush();
          
            return $this->redirectToRoute('customer_show', array('id' => $user->getId()));
        }

        return $this->render('FoggylineCustomerBundle:default:customer/register.html.twig', array(
            'customer' => $user,
            'form' => $form->createView(),
        ));
    }

     /**
     * Finds and displays a Customer entity.
     *
     * @Route("/account", name="customer_account")
     * @Method({"GET", "POST"})
     */
    public function accountAction(Request $request):Response
    {
        
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        } 
       if($customer = $this->getUser())
       {
           $editForm = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType',
           $customer,array( 'action' => $this->generateUrl('customer_account')));
           $editForm->handleRequest($request);
           if($editForm->isSubmitted() && $editForm->isValid())
           {
               $em = $this->getDoctrine()->getManager();
               $em->persist($customer);
               $em->flush();
               $this->addFlash('success', 'Account updated.');
               return $this->redirectToRoute('customer_account');

           }
           $etems = $this->get('foggyline_sales.customer_orders')->getOrders();
         
           return $this->render('FoggylineCustomerBundle:default:customer/account.html.twig',
                    array(
                        'customer'=>$customer,
                        'form'=>$editForm->createView(),
                        //'customer_orders' => $this->get('foggyline_customer.customer_orders')->getOrders(),
                        'customer_orders' =>$etems,
                        )
                );

       }
     //  die;
       return $this->redirectToRoute('foggyline_customer_login');
    }
    /**
     * Lists all customer entities.
     *
     * @Route("/", name="customer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('FoggylineCustomerBundle:Customer')->findAll();

        return $this->render('FoggylineCustomerBundle:default:customer/index.html.twig', array(
            'customers' => $customers,
        ));
    }

    /**
     * Creates a new customer entity.
     *
     * @Route("/new", name="customer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
       
        $user = new Customer();
        $form = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType', $user);
        $form->handleRequest($request);
  
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
           
            $em->persist($user);
           
            $em->flush();
          
            return $this->redirectToRoute('customer_show', array('id' => $user->getId()));
        }

        return $this->render('FoggylineCustomerBundle:default:customer/new.html.twig', array(
            'customer' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a customer entity.
     *
     * @Route("/{id}", name="customer_show")
     * @Method("GET")
     */
    public function showAction(Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);

        return $this->render('FoggylineCustomerBundle:default:customer/show.html.twig', array(
            'customer' => $customer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing customer entity.
     *
     * @Route("/{id}/edit", name="customer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);
        $editForm = $this->createForm('Foggyline\CustomerBundle\Form\CustomerType', $customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customer_edit', array('id' => $customer->getId()));
        }

        return $this->render('FoggylineCustomerBundle:default:customer/edit.html.twig', array(
            'customer' => $customer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a customer entity.
     *
     * @Route("/{id}", name="customer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Customer $customer)
    {
        $form = $this->createDeleteForm($customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer);
            $em->flush();
        }

        return $this->redirectToRoute('customer_index');
    }

    /**
     * Creates a form to delete a customer entity.
     *
     * @param Customer $customer The customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Customer $customer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * check the customer
     * 
     * @Route("/login", name="customer_logout")
     */
    public function logout(Request $request):Response
    {   
        
        return $this->render( );

    }
}
