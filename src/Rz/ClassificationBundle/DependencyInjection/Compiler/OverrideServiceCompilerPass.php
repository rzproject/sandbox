<?php

namespace Rz\ClassificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        #####################################
        ## Override Entity Manager
        #####################################
        $definition = $container->getDefinition('sonata.classification.manager.tag');
        $definition->setClass($container->getParameter('rz.classification.entity.manager.tag.class'));

        $definition = $container->getDefinition('sonata.classification.manager.category');
        $definition->setClass($container->getParameter('rz.classification.entity.manager.category.class'));

        $definition = $container->getDefinition('sonata.classification.manager.collection');
        $definition->setClass($container->getParameter('rz.classification.entity.manager.collection.class'));

        $definition = $container->getDefinition('sonata.classification.manager.context');
        $definition->setClass($container->getParameter('rz.classification.entity.manager.context.class'));

        #####################################
        ## Override Collection Admin
        #####################################
        $definition = $container->getDefinition('sonata.classification.admin.collection');
        $definition->addMethodCall('setContextManager', array(new Reference('sonata.classification.manager.context')));

        #####################################
        ## Override Tag Admin
        #####################################
        $definition = $container->getDefinition('sonata.classification.admin.tag');
        $definition->addMethodCall('setContextManager', array(new Reference('sonata.classification.manager.context')));
    }
}
