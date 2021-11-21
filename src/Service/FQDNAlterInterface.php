<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use loophp\ServiceAliasAutoRegisterBundle\Model\ServiceData;

interface FQDNAlterInterface
{
    /**
     * @param callable(string): string $returnWith
     */
    public function alter(ServiceData $item, callable $returnWith): string;
}
