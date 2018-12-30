<?php 

namespace Foggyline\SalesBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;


class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {  
        
          $container->removeDefinition('products_onsale');
          $container->setDefinition('products_onsale', $container->getDefinition('foggyline_sales.bestseller'));

          $container->removeDefinition('add_to_cart_url');
          $container->setDefinition('add_to_cart_url', $container->getDefinition('foggyline_sales.add_to_cart_url'));

          $container->removeDefinition('dynamic_rate_shipment');
          $container->setDefinition('dynamic_rate_shipment', $container->getDefinition('foggyline_sales.dynamic_rate_shipment'));
          
          $container->removeDefinition('checkout_menu');        
          $container->setDefinition('checkout_menu', $container->getDefinition('foggyline_sales.checkout_menu'));

          $container->getDefinition('foggyline_sales.shipment')->addArgument(
                        array_keys($container->findTaggedServiceIds('shipment_method'))
            );
            
          $container->getDefinition('foggyline_sales.payment')->addArgument(
                        array_keys($container->findTaggedServiceIds('payment_method'))
            );

          $container->removeDefinition('foggyline_customer.customer_orders');
          $container->setDefinition('foggyline_customer.customer_orders', $container->getDefinition('foggyline_sales.customer_orders'));
        
    }
}


?>