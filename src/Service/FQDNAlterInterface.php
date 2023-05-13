<?php

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

interface FQDNAlterInterface
{
    public function alter(string $namespacePart): string;
}
