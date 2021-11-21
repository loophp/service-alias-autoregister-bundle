<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\DependencyInjection\Compiler;

use ArrayIterator;
use Generator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use function array_slice;
use function strlen;

final class ServiceAliasAutoRegisterPass implements CompilerPassInterface
{
    public const TAG = 'autowire.alias';

    public function process(ContainerBuilder $container): void
    {
        $taggedServices = $container->findTaggedServiceIds(ServiceAliasAutoRegisterPass::TAG);

        $data = new ArrayIterator([]);

        foreach (array_keys($taggedServices) as $fqdn) {
            foreach (class_implements($fqdn) as $interface) {
                $data->append([
                    'level' => 1,
                    'interface' => $interface,
                    'fqdn' => $fqdn,
                ]);
            }
        }

        foreach ($data as $key => $item) {
            $namespacePart = implode(
                '\\',
                array_slice(
                    explode(
                        '\\',
                        $item['fqdn']
                    ),
                    -1 * $item['level']
                )
            );

            if (1 !== $this->countItemEndingWith($namespacePart, $data->getArrayCopy())) {
                ++$item['level'];
                $data[$key] = $item;
                $data->rewind();
            }
        }

        foreach ($data as $item) {
            $container
                ->registerAliasForArgument(
                    $item['fqdn'],
                    $item['interface'],
                    str_replace(
                        '_',
                        '',
                        $container->camelize(
                            implode(
                                '\\',
                                array_slice(
                                    explode(
                                        '\\',
                                        $item['fqdn']
                                    ),
                                    -1 * $item['level']
                                )
                            )
                        )
                    )
                );
        }
    }

    private function countItemEndingWith(string $namespace, array $data = []): int
    {
        return iterator_count($this->findItemEndingWith($namespace, $data));
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        return 0 < $length ? substr($haystack, -$length) === $needle : true;
    }

    private function findItemEndingWith(string $namespace, array $data = []): Generator
    {
        foreach ($data as $item) {
            if ($this->endsWith($item['fqdn'], $namespace)) {
                yield $item;
            }
        }
    }
}
