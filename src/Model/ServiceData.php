<?php

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Model;

use function array_slice;

final class ServiceData
{
    public function __construct(
        private readonly string $fqdn,
        private readonly string $interface,
        private int $level = 1
    ) {
    }

    public function getFQDN(): string
    {
        return $this->fqdn;
    }

    public function getInterface(): string
    {
        return $this->interface;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getNamespacePart(): string
    {
        return implode(
            '\\',
            array_slice(
                explode(
                    '\\',
                    $this->getFQDN()
                ),
                -1 * $this->getLevel()
            )
        );
    }

    public function withLevel(int $level): self
    {
        $clone = clone $this;
        $clone->level = $level;

        return $clone;
    }
}
