<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\ServiceAliasAutoRegisterBundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 * @coversNothing
 */
final class IntegrationTest extends KernelTestCase
{
    public function testSomething()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = self::getContainer();

        self::assertTrue($container->has('tests\App\Service\FooInterface $a'));
        self::assertTrue($container->has('tests\App\Service\FooInterface $b'));
    }
}
