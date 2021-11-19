<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle;

use loophp\ServiceAliasAutoRegisterBundle\DependencyInjection\Compiler\ServiceAliasAutoRegisterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ServiceAliasAutoRegisterBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ServiceAliasAutoRegisterPass());
    }
}
