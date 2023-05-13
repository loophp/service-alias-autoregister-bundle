<?php

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('service_alias_auto_register');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('whitelist')
            ->prototype('scalar')->end()
            ->defaultValue([])
            ->end()
            ->arrayNode('blacklist')
            ->prototype('scalar')->end()
            ->defaultValue([])
            ->end()
            ->end();

        return $treeBuilder;
    }
}
