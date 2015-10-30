<?php

namespace Rz\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzUserExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('%s.xml', $config['manager_type']));
        $this->aliasManagers($container, $config['manager_type']);
    }

    /**
     * Adds aliases for user & group managers depending on $managerType.
     *
     * @param ContainerBuilder $container
     * @param                  $managerType
     */
    protected function aliasManagers(ContainerBuilder $container, $managerType)
    {
        $container->setAlias('rz.user.user_manager', sprintf('rz.user.%s.user_manager', $managerType));
        $container->setAlias('rz.user.group_manager', sprintf('rz.user.%s.group_manager', $managerType));
    }
}
