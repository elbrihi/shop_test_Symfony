<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class StoreManagerController extends Controller
{
    /**
     * 
     * @Route("/store_manager", name="store_manager")
    */
    public function indexAction()
    {
        $users = $this->getUser()->getId();
        
       
        return $this->render('AppBundle:default:store_manager.html.twig',array(
            'id_user'=>$users
        ));

    }
    
}

?>