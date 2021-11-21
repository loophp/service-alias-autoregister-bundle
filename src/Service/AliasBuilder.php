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

use function count;
use function strlen;

// phpcs:disable Generic.Files.LineLength.TooLong
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
                $aliases->append((new ServiceData($fqdn, $interface)));
            }
        }

        foreach ($aliases as $key => $item) {
            if (1 !== $this->countItemEndingWith($item, $aliases->getArrayCopy())) {
                $aliases[$key] = $item->withLevel($item->getLevel() + 1);
                $aliases->rewind();
            }
        }

        yield from $aliases;
    }

    /**
     * @param list<ServiceData> $data
     */
    private function countItemEndingWith(ServiceData $serviceDataSelected, array $data = []): int
    {
        return count(
            $this->findItemEndingWith(
                $serviceDataSelected->getNamespacePart(),
                array_filter(
                    $data,
                    static fn (ServiceData $serviceData): bool => $serviceData->getInterface() === $serviceDataSelected->getInterface()
                )
            )
        );
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        return 0 < $length ? substr($haystack, -$length) === $needle : true;
    }

    /**
     * @param list<ServiceData> $data
     *
     * @return array<int, ServiceData>
     */
    private function findItemEndingWith(string $namespace, array $data = []): array
    {
        return array_filter(
            $data,
            fn (ServiceData $serviceData): bool => $this->endsWith($serviceData->getFQDN(), $namespace)
        );
    }
}
