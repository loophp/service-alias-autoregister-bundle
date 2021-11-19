<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\ServiceAliasAutoRegisterBundle\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class FQDNAlter implements FQDNAlterInterface
{
    private array $configuration;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->configuration = $parameterBag->get('service_alias_auto_register');
    }

    public function alter(string $fqdn): string
    {
        return $fqdn;
    }
}
