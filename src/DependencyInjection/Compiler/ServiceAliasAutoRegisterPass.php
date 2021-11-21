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

final class ServiceAliasAutoRegisterPass implements CompilerPassInterface
{
    public const TAG = 'autowire.alias';

    public function process(ContainerBuilder $container): void
    {
        /** @var AliasBuilderInterface $aliasBuilder */
        $aliasBuilder = $container->get(AliasBuilderInterface::class);

        /** @var FQDNAlterInterface $fqdnAlterer */
        $fqdnAlterer = $container->get(FQDNAlterInterface::class);

        $taggedServiceIds = $container->findTaggedServiceIds(ServiceAliasAutoRegisterPass::TAG);

        foreach ($aliasBuilder->alter($taggedServiceIds) as $item) {
            $container
                ->registerAliasForArgument(
                    $item->getFQDN(),
                    $item->getInterface(),
                    $container->camelize($fqdnAlterer->alter($item->getNamespacePart()))
                );
        }
    }
}
