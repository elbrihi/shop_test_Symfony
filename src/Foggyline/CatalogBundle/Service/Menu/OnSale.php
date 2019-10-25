<?php

namespace Foggyline\CatalogBundle\Service\Menu;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Foggyline\SalesBundle\Service\AddToCartUrl;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\File;
use  Knp\Component\Pager\Paginator;
class OnSale
{
    private $em;
    private $router;
    private $add_to_cart_url;
    private $product_img;
    private $paginator;
    public function __construct(EntityManager $entityManager, Router $router, AddToCartUrl $add_to_cart_url,Paginator $paginator)
    {
        $this->em = $entityManager;
        $this->router = $router;
        $this->add_to_cart_url = $add_to_cart_url;
        $this->paginator =  $paginator;

    }

    public function getItems()
    {
        $products = array();
        $_products = $this->em->getRepository('FoggylineCatalogBundle:Product')->findAll();
        
        foreach($_products as $_product)
        {
            $products[] = array('path'=>$this->router->generate('product_show', array('id'=>$_product->getId())),
                                'label' => $_product->getTitle() 
                                   
                            );
        }

        return $products;
        
    }
    public function make_query($maximum_price, $minimum_price)
    {

        $query = '';
        //  SELECT * FROM product WHERE price IN(14,45)
        $query .= "SELECT * FROM
        product WHERE 1";

        if(isset($minimum_price, $maximum_price) && !empty($minimum_price) &&  !empty($maximum_price))
        {
            $query .= "
        AND price BETWEEN '".$minimum_price."' AND '".$maximum_price." '
        ";
        
        }
        $query .= ' ORDER BY product_id DESC ';
        return $query;
    }
    public function count_rows()
    {
        
        $query = '';
        //  SELECT * FROM product WHERE price IN(14,45)
        $query .= "SELECT product_id FROM
        product WHERE 1";
        $statement = $this->em->getConnection()->prepare($query);

        $statement->execute();
        
        return $result = $statement->rowCount();

    }
    public function count_all($maximum_price, $minimum_price)
    {
        
        $statement = $this->em->getConnection()->prepare($this->make_query($maximum_price, $minimum_price));

        $statement->execute();

        return $result = $statement->fetchAll();
        
    }
    public function fetch_data($maximum_price, $minimum_price,$request,$record_per_page,$pagee)
    {
        if(isset($pagee))  
        {  
             $page = $pagee;  
        }  
        else  
        {  
             $page = 1;  
        }  
       
        $start_from = ($page - 1)*$record_per_page;   

        $statement = $this->em->getConnection()->prepare($this->make_query($maximum_price, $minimum_price).' LIMIT '.$start_from.', '.$record_per_page.' ');

        $statement->execute();

        $products = $statement->fetchAll();
        
        $output = '';
      
        $data = array();
        
       
        if($statement->rowCount() > 0)
        {
            $sub_array = array();
            foreach($products as $product)
            {
                
                $image = $_SERVER['BASE'].'/uploads/foggyline_catalog_images/'.$product['product_image'];
                $path = $this->router->generate('product_show', array('id'=>$product['product_id']));
                
                $sub_array[] = $this->html_product($image, $path,$product['product_title'] ,$product['price'], $product['product_id']);
            }
            $data['product_list'] = $sub_array;
        }

        $data = array(
            'product_list'=> $sub_array,
            'pagination'=> $this->pagination($request,$record_per_page),
            'test' => $this->test($maximum_price, $minimum_price,$request,$record_per_page,$pagee)
            

        );
        
        echo json_encode($data);
  
    }
    

    public function pagination($request,$record_per_page )
    {
      
       
        $row_number =$this->count_rows();
        
        $row_number = ceil($row_number/$record_per_page);
        
        
        $pagination ='';
        $pagination .='<div class="pagination">';
        $pagination .='<div >&laquo;</div>';
       
        for($i = 1; $i<$row_number+1; $i++)
        {
            $pagination .= '<div id="'.$i.'" class="active+ pagination_link">'.$i.'</div>';
        }
        $pagination .='<div class="active+ pagination_link1">&raquo;</div></div>';

        return $pagination ;
      
    }


    public function test($maximum_price, $minimum_price,$request,$record_per_page,$pagee)
    {
       
        
        $row_number =$this->count_rows();
 
        if(isset($pagee))  
        {  
             $page = $pagee;  
        }  
        else  
        {  
             $page = 1;  
        }  
       
        $start_from = ($page - 1)*$record_per_page;  
        
        $statement = $this->make_query($maximum_price, $minimum_price).' LIMIT '.$start_from.', '.$record_per_page.' ';

        return $statement;
  
    }    
    public function html_product($product_img, $product_path,$product_name,$product_price, $product_id)
    {

        
        $html_product =
                        '<div class="col-md-4 product-men">
                            <div class="product-shoe-info shoe">
                                <div class="men-pro-item">
                                    <div class="men-thumb-item">
                                        <img src=" '.$product_img.' " alt="">
                                        <div class="men-cart-pro">
                                            <div class="inner-men-cart-pro">
                                                <a href=" '.$product_path.' " class="link-product-add-cart">Quick View</a>
                                            </div>
                                        </div>
                                        <span class="product-new-top">New</span>
                                    </div>
                                    <div class="item-info-product">
                                        <h4>
                                            <a href=" '.$product_path.' "> '.$product_name.' </a>
                                        </h4>
                                        <div class="info-product-price">
                                            <div class="grid_meta">
                                                <div class="product_price">
                                                    <div class="grid-price ">
                                                        <span class="money ">$ '.$product_price.' </span>
                                                    </div>
                                                </div>
                                                <ul class="stars">
                                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="shoe single-item hvr-outline-out">
                                                <button class="shoe-cart pshoe-cart"><a type="submit" class="shoe-cart pshoe-cart" href=" '.$this->add_to_cart_url->getAddToCartUrl($product_id).' "><i class="fa fa-cart-plus" aria-hidden="true"></i></a></botton>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        return $html_product;
    }

     /*public function fetch_data($maximum_price, $minimum_price)
    {
        //echo $this->router->generate('product_show',array('id'=>2));
        
        $statement = $this->em->getConnection()->prepare($this->make_query($maximum_price, $minimum_price));

        $statement->execute();

        $products = $statement->fetchAll();
        
        $output = '';
      
        $data = array();
        
        if($statement->rowCount() > 0)
        {
            
            foreach($products as $product)
            {
                $sub_array = array();
                $sub_array['product_image'] = 'uploads/foggyline_catalog_images/'.$product['product_image'];
                $sub_array['product_title'] = $product['product_title'];
                $sub_array['price'] = $product['price'];
                $sub_array['product_id'] = $product['product_id'];
                $sub_array['path'] = $this->router->generate('product_show', array('id'=>$product['product_id']));
                $data[] = $sub_array;
            }
            
        }

  
        $data = array(
            'data'=> $data
        );
        
        echo json_encode($data);
       

        
    }*/
}




?>