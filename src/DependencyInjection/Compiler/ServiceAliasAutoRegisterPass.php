<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\DependencyInjection\Compiler;

use loophp\ServiceAliasAutoRegisterBundle\Service\AliasBuilderInterface;
use loophp\ServiceAliasAutoRegisterBundle\Service\FQDNAlterInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function in_array;

final class ServiceAliasAutoRegisterPass implements CompilerPassInterface
{
    public const TAG = 'autoregister.alias';

    public function process(ContainerBuilder $container): void
    {
        /** @var AliasBuilderInterface $aliasBuilder */
        $aliasBuilder = $container->get(AliasBuilderInterface::class);

        /** @var FQDNAlterInterface $fqdnAlterer */
        $fqdnAlterer = $container->get(FQDNAlterInterface::class);

        $parameters = $container->getParameter('service_alias_auto_register');

        $taggedServiceIds = $container->findTaggedServiceIds(ServiceAliasAutoRegisterPass::TAG);

        foreach ($aliasBuilder->alter($taggedServiceIds) as [$fqdn, $interface, $namespacePart]) {
            if (in_array($interface, $parameters['blacklist'], true)) {
                continue;
            }

            if ([] !== $parameters['whitelist'] && !in_array($interface, $parameters['whitelist'], true)) {
                continue;
            }

            $container
                ->registerAliasForArgument(
                    $fqdn,
                    $interface,
                    $container->camelize($fqdnAlterer->alter($namespacePart))
                );
        }
    }
}
