<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\DependencyInjection;

use Countable;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('service_alias_auto_register');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->arrayNode('blacklist')
            ->prototype('scalar')->end()
            ->defaultValue([
                LoggerInterface::class,
                Countable::class,
                ServiceSubscriberInterface::class,
            ])
            ->end();

        return $treeBuilder;
    }
}
