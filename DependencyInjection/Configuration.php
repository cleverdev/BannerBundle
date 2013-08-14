<?php

namespace cleverdev\BannerBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('banner');

        $rootNode
            ->children()
                ->scalarNode('banner_class')
                    ->defaultValue('BannerBundle:Banner')
                ->end()
                ->arrayNode('spots')
                    ->useAttributeAsKey('spot')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('template')
                                ->defaultValue('BannerBundle:Banner:show.html.twig')
                            ->end()
                            ->arrayNode('params')
                                ->children()
                                    ->scalarNode('max_count')
                                        ->defaultValue(null)
                                    ->end()
                                    ->scalarNode('max_width')
                                        ->defaultValue(null)
                                    ->end()
                                    ->scalarNode('max_height')
                                        ->defaultValue(null)
                                    ->end()
                                    ->scalarNode('order_by')
                                        ->defaultValue(null)
                                    ->end()
                                    ->scalarNode('order_derection')
                                        ->defaultValue(null)
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
