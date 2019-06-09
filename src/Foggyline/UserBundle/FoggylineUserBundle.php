<?php

namespace Foggyline\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Foggyline\CatalogBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;

class FoggylineUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {     
        parent::build($container);     
        $container->addCompilerPass(new  OverrideServiceCompilerPass()); 
    }
}
