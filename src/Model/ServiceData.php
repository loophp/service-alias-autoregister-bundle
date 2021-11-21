<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Model;

final class ServiceData
{
    private string $fqdn;

    private string $interface;

    private int $level = 1;

    public function __construct(string $fqdn, string $interface, int $level = 1)
    {
        $this->fqdn = $fqdn;
        $this->interface = $interface;
        $this->level = $level;
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

    public function withLevel(int $level): self
    {
        $clone = clone $this;
        $clone->level = $level;

        return $clone;
    }
}
