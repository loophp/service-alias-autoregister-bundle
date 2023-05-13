<?php

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

final class FQDNAlter implements FQDNAlterInterface
{
    public function alter(string $namespacePart): string
    {
        return str_replace('_', '', $namespacePart);
    }
}
