<?php

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use Generator;

interface AliasBuilderInterface
{
    /**
     * @param array<string, array<mixed>> $taggedServiceIds
     *
     * @return Generator<int, array{0: string, 1: string, 2: string}>
     */
    public function alter(array $taggedServiceIds): Generator;
}
