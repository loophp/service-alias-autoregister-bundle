<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use ArrayIterator;
use Generator;
use loophp\ServiceAliasAutoRegisterBundle\Model\ServiceData;

use function array_slice;
use function strlen;

final class AliasBuilder implements AliasBuilderInterface
{
    public function alter(array $taggedServiceIds): Generator
    {
        /** @var ArrayIterator<int, ServiceData> $aliases */
        $aliases = new ArrayIterator([]);

        foreach (array_keys($taggedServiceIds) as $fqdn) {
            $interfaces = class_implements($fqdn);

            if (false === $interfaces) {
                continue;
            }

            foreach ($interfaces as $interface) {
                $aliases->append((new ServiceData($fqdn, $interface, 1)));
            }
        }

        foreach ($aliases as $key => $item) {
            $namespacePart = implode(
                '\\',
                array_slice(
                    explode(
                        '\\',
                        $item->getFQDN()
                    ),
                    -1 * $item->getLevel()
                )
            );

            if (1 !== $this->countItemEndingWith($item->getInterface(), $namespacePart, $aliases->getArrayCopy())) {
                $aliases[$key] = $item->withLevel($item->getLevel() + 1);
                $aliases->rewind();
            }
        }

        yield from $aliases;
    }

    /**
     * @param list<ServiceData> $data
     */
    private function countItemEndingWith(string $interface, string $namespace, array $data = []): int
    {
        return iterator_count($this->findItemEndingWith($interface, $namespace, $data));
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        return 0 < $length ? substr($haystack, -$length) === $needle : true;
    }

    /**
     * @param list<ServiceData> $data
     *
     * @return Generator<int, ServiceData>
     */
    private function findItemEndingWith(string $interface, string $namespace, array $data = []): Generator
    {
        foreach ($data as $item) {
            if ($item->getInterface() !== $interface) {
                continue;
            }

            if ($this->endsWith($item->getFQDN(), $namespace)) {
                yield $item;
            }
        }
    }
}
