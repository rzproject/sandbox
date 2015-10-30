<?php

namespace Rz\MediaBundle\DependencyInjection\Compiler;

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
        $definition = $container->getDefinition('sonata.media.manager.media');
        $definition->setClass($container->getParameter('rz.media.entity.manager.media.class'));

        $definition = $container->getDefinition('sonata.media.manager.gallery');
        $definition->setClass($container->getParameter('rz.media.entity.manager.gallery.class'));


        #####################################
        ## Override Media Admin
        #####################################
        $definition = $container->getDefinition('sonata.media.admin.media');
        $definition->setClass($container->getParameter('rz.media.admin.media.class'));
        $definition->addMethodCall('setTranslationDomain', array($container->getParameter('rz.media.admin.media.translation_domain')));
        $definition->addMethodCall('setBaseControllerName', array($container->getParameter('rz.media.admin.media.controller')));


        #####################################
        ## Override Gallery Admin
        #####################################
        $definition = $container->getDefinition('sonata.media.admin.gallery');
        $definition->setClass($container->getParameter('rz.media.admin.gallery.class'));
        $definition->addMethodCall('setTranslationDomain', array($container->getParameter('rz.media.admin.gallery.translation_domain')));
        $definition->addMethodCall('setBaseControllerName', array($container->getParameter('rz.media.admin.gallery.controller')));

        #####################################
        ## Override Gallery_Has_Media Admin
        #####################################
        $definition = $container->getDefinition('sonata.media.admin.gallery_has_media');
        $definition->setClass($container->getParameter('rz.media.admin.gallery_has_media.class'));
        $definition->addMethodCall('setTranslationDomain', array($container->getParameter('rz.media.admin.gallery_has_media.translation_domain')));
        $definition->addMethodCall('setBaseControllerName', array($container->getParameter('rz.media.admin.gallery_has_media.controller')));
    }
}
