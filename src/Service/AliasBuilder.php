<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use ArrayIterator;
use Generator;
use function array_slice;
use function strlen;

final class AliasBuilder implements AliasBuilderInterface
{
    public function alter(array $taggedServiceIds): Generator
    {
        $aliases = new ArrayIterator([]);

        foreach (array_keys($taggedServiceIds) as $fqdn) {
            foreach (class_implements($fqdn) as $interface) {
                $aliases->append([
                    'level' => 1,
                    'interface' => $interface,
                    'fqdn' => $fqdn,
                ]);
            }
        }

        foreach ($aliases as $key => $item) {
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

            if (1 !== $this->countItemEndingWith($item['interface'], $namespacePart, $aliases->getArrayCopy())) {
                ++$item['level'];
                $aliases[$key] = $item;
                $aliases->rewind();
            }
        }

        yield from $aliases;
    }

    private function countItemEndingWith(string $interface, string $namespace, array $data = []): int
    {
        return iterator_count($this->findItemEndingWith($interface, $namespace, $data));
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        return 0 < $length ? substr($haystack, -$length) === $needle : true;
    }

    private function findItemEndingWith(string $interface, string $namespace, array $data = []): Generator
    {
        foreach ($data as $item) {
            if ($item['interface'] !== $interface) {
                continue;
            }

            if ($this->endsWith($item['fqdn'], $namespace)) {
                yield $item;
            }
        }
    }
}
