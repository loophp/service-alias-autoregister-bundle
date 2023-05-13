<?php

declare(strict_types=1);

namespace tests\App;

use loophp\ServiceAliasAutoRegisterBundle\ServiceAliasAutoRegisterBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new ServiceAliasAutoRegisterBundle();

        yield new FrameworkBundle();
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(__DIR__ . '/../config/services.yaml');

        foreach (glob(__DIR__ . '/../config/packages/*.yaml') as $file) {
            $container->import($file);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../config/routes.yaml');

        foreach (glob(__DIR__ . '/../config/routes/*.yaml') as $file) {
            $routes->import($file);
        }
    }
}
