<?php

namespace Foggyline\CatalogBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
         
        $container->removeDefinition('category_menu');
        $container->setDefinition('category_menu', $container->getDefinition('foggyline_catalog.category_menu'));
      
        // Override the core module 'category_menu' service     
    }
}




?>