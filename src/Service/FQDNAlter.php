<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use loophp\ServiceAliasAutoRegisterBundle\Model\ServiceData;

use function array_slice;

final class FQDNAlter implements FQDNAlterInterface
{
    public function alter(ServiceData $item, callable $returnWith): string
    {
        return str_replace(
            '_',
            '',
            $returnWith(
                implode(
                    '\\',
                    array_slice(
                        explode(
                            '\\',
                            $item->getFQDN()
                        ),
                        -1 * $item->getLevel()
                    )
                )
            )
        );
    }
}
