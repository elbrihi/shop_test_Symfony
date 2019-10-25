<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\Paginator;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
         
        $checkout = $this->get('foggyline_sales.checkout_menu');

        return $this->render('AppBundle:default:index.html.twig'
        );
    }
    /**
     * @Route("/about", name="about")
     * 
     */
    public function aboutAction()
    {
        return $this->render('AppBundle:default:about.html.twig');
    }
    /**
     * @Route("/customer-service", name="customer_service")
     */
    public function customerServiceAction()
    {
        return $this->render('AppBundle:default:customer-service.html.twig');
    }
    /**
     * @Route("/orders-and-returns", name="orders_returns")
     */
    public function ordersAndReturnsAction()
    {
        return $this->render('AppBundle:default:orders-returns.html.twig');
    }
    /**
     * @Route("/privacy-and-cookie-policy", name="privacy_cookie")
     */
    public function privacyAndCookiePolicyAction()
    {
        return $this->render('AppBundle:default:privacy-cookie.html.twig');
    }


    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        
        // Build a form, with validation rules in place
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array(
                'constraints' => new NotBlank()
            ))
            ->add('email', EmailType::class, array(
                'constraints' => new Email()
            ))
            ->add('message', TextareaType::class, array(
                'constraints' => new Length(array('min' => 3))
            ))
            ->add('save', SubmitType::class, array(
                'label' =>'Reach Out!',
                'attr' => array('class' =>'button'),
            ))
            ->getForm();
        // Check if this is a POST type request and if so, handle form
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash(
                    'success',
                    'Your form has been submitted. Thank you.'
                );
                // todo: Send an email out...
                return $this->redirect($this->generateUrl('contact'));
            }
        }
        // Render "contact us" page
        return $this->render('AppBundle:default:contact.html.twig',
            array(
                'form' => $form->createView()
            ));
    }
     /**
     * @Route("/getProduct", name="get_product")
     */
    public function getProductAction(Request $request)
    {
    
    
      $minimum_price = $request->get('minimum_price');
      $maximum_price = $request->get('maximum_price');
      $record_per_page = $request->get('record_per_page');
      $page = $request->get('page');
      //$fetch_data = $this->get('foggyline_catalog.onSale')->fetch_data();

     // $pagination =  $this->get('foggyline_catalog.onSale')->pagination($request,$page);
      $query = $this->get('foggyline_catalog.onSale')->make_query($maximum_price, $minimum_price).' LIMIT 3, 6 ';
      
      $fetch_data = $this->get('foggyline_catalog.onSale')->fetch_data($maximum_price,$minimum_price,$request,$record_per_page,$page);

       
      die;
      return false;
    }
}
