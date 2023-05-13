<?php

declare(strict_types=1);

namespace tests\loophp\ServiceAliasAutoRegisterBundle;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\ServiceAliasAutoRegisterBundle
 */
final class IntegrationTest extends KernelTestCase
{
    public static function somethingProvider(): Generator
    {
        yield ['tests\App\Service\FooInterface $c'];

        yield ['tests\App\Service\FooInterface $fooA'];

        yield ['tests\App\Service\FooInterface $barA'];

        yield ['tests\App\Service\FooInterface $barFooB'];

        yield ['tests\App\Service\FooInterface $serviceFooB'];
    }

    /**
     * @dataProvider somethingProvider
     */
    public function testSomething(string $serviceAlias): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = self::getContainer();

        self::assertTrue($container->has($serviceAlias));
    }
}
