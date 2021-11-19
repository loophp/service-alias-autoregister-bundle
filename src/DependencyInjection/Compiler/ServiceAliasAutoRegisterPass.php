<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ServiceAliasAutoRegisterPass implements CompilerPassInterface
{
    public const TAG = 'autowire.alias';

    public function process(ContainerBuilder $container): void
    {
        $taggedServices = $container->findTaggedServiceIds(ServiceAliasAutoRegisterPass::TAG);

        foreach (array_keys($taggedServices) as $fqdn) {
            $fqdnExploded = explode('\\', $fqdn);

            foreach (class_implements($fqdn) as $interface) {
                $container
                    ->registerAliasForArgument(
                        $fqdn,
                        $interface,
                        str_replace(
                            '_',
                            '',
                            $container->camelize(end($fqdnExploded))
                        )
                    );
            }
        }
    }
}
