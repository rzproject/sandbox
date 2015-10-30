<?php

namespace Rz\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzMediaExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->configureManagerClass($config, $container);
        $this->configureAdminClass($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function configureManagerClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.media.entity.manager.media.class',             $config['manager_class']['orm']['media']);
        $container->setParameter('rz.media.entity.manager.gallery.class',           $config['manager_class']['orm']['gallery']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function configureAdminClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.media.admin.media.class',              $config['admin']['media']['class']);
        $container->setParameter('rz.media.admin.media.controller',         $config['admin']['media']['controller']);
        $container->setParameter('rz.media.admin.media.translation_domain', $config['admin']['media']['translation']);

        $container->setParameter('rz.media.admin.gallery.class',              $config['admin']['gallery']['class']);
        $container->setParameter('rz.media.admin.gallery.controller',         $config['admin']['gallery']['controller']);
        $container->setParameter('rz.media.admin.gallery.translation_domain', $config['admin']['gallery']['translation']);

        $container->setParameter('rz.media.admin.gallery_has_media.class',              $config['admin']['gallery_has_media']['class']);
        $container->setParameter('rz.media.admin.gallery_has_media.controller',         $config['admin']['gallery_has_media']['controller']);
        $container->setParameter('rz.media.admin.gallery_has_media.translation_domain', $config['admin']['gallery_has_media']['translation']);
    }
}
