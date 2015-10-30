<?php

namespace Rz\ClassificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
        $node = $treeBuilder->root('rz_classification');
        $this->addManagerSection($node);
        return $treeBuilder;
    }
     /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addManagerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('manager_class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('orm')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('tag')->defaultValue('Rz\\ClassificationBundle\\Entity\\TagManager')->end()
                                ->scalarNode('category')->defaultValue('Rz\\ClassificationBundle\\Entity\\CategoryManager')->end()
                                ->scalarNode('collection')->defaultValue('Rz\\ClassificationBundle\\Entity\\CollectionManager')->end()
                                ->scalarNode('context')->defaultValue('Rz\\ClassificationBundle\\Entity\\ContextManager')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
