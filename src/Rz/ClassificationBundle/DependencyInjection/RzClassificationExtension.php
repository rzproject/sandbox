<?php

namespace Rz\ClassificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzClassificationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('twig.xml');
        $this->configureManagerClass($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function configureManagerClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.classification.entity.manager.tag.class',        $config['manager_class']['orm']['tag']);
        $container->setParameter('rz.classification.entity.manager.category.class',   $config['manager_class']['orm']['category']);
        $container->setParameter('rz.classification.entity.manager.collection.class', $config['manager_class']['orm']['collection']);
        $container->setParameter('rz.classification.entity.manager.context.class',    $config['manager_class']['orm']['context']);
    }
}
