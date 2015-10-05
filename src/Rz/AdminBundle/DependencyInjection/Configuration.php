<?php

namespace Rz\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rz_admin');

        $rootNode
            ->children()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('use_footable')->defaultTrue()->info('Enables Admin list responsive table')->end()
                    ->end()
                ->end()
                ->arrayNode('pool')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('base_admin_class')->defaultNull()->info('Base admin pool class')->end()
                    ->end()
                ->end()
                ->arrayNode('footable_settings')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('show_header')->defaultTrue()->end()
                        ->booleanNode('show_toggle')->defaultTrue()->end()
                        ->scalarNode('toggle_column')->defaultValue('last')->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
