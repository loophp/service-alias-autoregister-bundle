<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use loophp\ServiceAliasAutoRegisterBundle\Service\AliasBuilder;
use loophp\ServiceAliasAutoRegisterBundle\Service\AliasBuilderInterface;
use loophp\ServiceAliasAutoRegisterBundle\Service\FQDNAlter;
use loophp\ServiceAliasAutoRegisterBundle\Service\FQDNAlterInterface;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->set(AliasBuilder::class);

    $services
        ->alias(AliasBuilderInterface::class, AliasBuilder::class);

    $services
        ->set(FQDNAlter::class);

    $services
        ->alias(FQDNAlterInterface::class, FQDNAlter::class);
};
