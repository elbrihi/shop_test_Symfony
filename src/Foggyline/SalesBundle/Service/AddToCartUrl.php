<?php 

namespace Foggyline\SalesBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
class AddToCartUrl
{
    private $router;
    public function __construct(Router $router )
    {
        $this->router = $router;        
    }
    public function getAddToCartUrl($id)
    {
       return $this->router->generate('foggyline_sales_cart_add',array('id'=>$id));
    }
}



?>