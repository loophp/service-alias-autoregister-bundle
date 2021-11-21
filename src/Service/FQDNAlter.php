<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

final class FQDNAlter implements FQDNAlterInterface
{
    public function alter(string $namespacePart): string
    {
        return str_replace('_', '', $namespacePart);
    }
}
