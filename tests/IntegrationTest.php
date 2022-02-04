<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\ServiceAliasAutoRegisterBundle;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 * @covers \loophp\ServiceAliasAutoRegisterBundle\Service\AliasBuilder
 * @covers \loophp\ServiceAliasAutoRegisterBundle\Service\FQDNAlter
 */
final class IntegrationTest extends KernelTestCase
{
    public function getAliases(): Generator
    {
        yield ['tests\App\Service\FooInterface $c'];

        yield ['tests\App\Service\FooInterface $fooA'];

        yield ['tests\App\Service\FooInterface $barA'];

        yield ['tests\App\Service\FooInterface $barFooB'];

        yield ['tests\App\Service\FooInterface $serviceFooB'];
    }

    /**
     * @dataProvider getAliases
     */
    public function testSomething(string $serviceAlias)
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = self::getContainer();

        self::assertTrue($container->has($serviceAlias));
    }
}
