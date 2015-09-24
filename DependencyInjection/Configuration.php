<?php

namespace Clarity\YandexOAuthBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('clarity_yandex_o_auth');

        $rootNode
            ->children()
                ->arrayNode('apps')
                    ->requiresAtLeastOneElement()
                    ->isRequired()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('client_id')->end()
                            ->scalarNode('client_secret')->end()
                            ->arrayNode('scopes')
                                ->requiresAtLeastOneElement()
                                ->isRequired()
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                     ->requiresAtLeastOneElement()
                                     ->prototype('scalar')
                                            ->cannotBeEmpty()
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
