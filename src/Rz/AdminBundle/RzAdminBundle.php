<?php

namespace Rz\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Rz\AdminBundle\DependencyInjection\Compiler\OverrideCompilerPass;

class RzAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
//    public function getParent()
//    {
//        return 'SonataAdminBundle';
//    }


    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverrideCompilerPass());
    }
}
