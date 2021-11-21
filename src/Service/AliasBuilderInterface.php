<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use Generator;
use loophp\ServiceAliasAutoRegisterBundle\Model\ServiceData;

interface AliasBuilderInterface
{
    /**
     * @param array<string, array<mixed>> $taggedServiceIds
     *
     * @return Generator<int, ServiceData>
     */
    public function alter(array $taggedServiceIds): Generator;
}
