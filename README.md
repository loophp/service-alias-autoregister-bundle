[![Latest Stable Version][latest stable version]][1]
 [![GitHub stars][github stars]][1]
 [![Total Downloads][total downloads]][1]
 [![License][license]][1]
 [![Donate!][donate github]][5]
 [![Donate!][donate paypal]][6]

# Service Alias Auto Register

A bundle for Symfony 5.

## Description

The [S.O.L.I.D. principles][41] are a set of five design principles intended to make
software designs more understandable, flexible, and maintainable.

One of these principles is the [Open-Closed Principle][42], which promotes the use
of interfaces instead of concrete implementations.

In Symfony, when injecting services, we usually rely on concrete service implementations
rather than using an interface. This makes our code less flexible and sometimes harder to
test.

This issue can be fixed in Symfony by [adding aliases][50] in the container.
Sadly, you have to do it manually and for each class.

Then, in order to fix this issue and improve this behavior, this bundle will declare new
aliases in the Symfony container.

Aliases are automatically created when the discovered services implements interfaces.

If a service implements 3 interfaces, 3 new aliases are created in the container.

Aliases are automatically created using the service's class FQDN, when the discovered
services implements one or many interfaces.

Aliases let you inject services using interfaces and named parameters
instead of specific implementations and thus, fix the [Open-Closed Principle][42] that we
usually do not follow.

The following examples are showing an existing situation, as you can see, we do not respect
that principle and we inject an concrete implementation directly:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;

final class MyTestController
{
    // Here we inject a concrete implementation of a Doctrine repository.
    public function __invoke(UserRepository $userRepository): Response
    {
        // Do stuff.
    }
}
```

When the bundle is enabled, you can inject the repository using an interface,
using a specific parameter name.

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\Persistence\ObjectRepository;

final class MyTestController
{
    // Here we inject the UserRepository (which implements ObjectRepository)
    // using the variable which has been created from the UserRepository class name.
    public function __invoke(ObjectRepository $userRepository): Response
    {
        // Do stuff.
    }
}
```

We can even do better by injecting it in the constructor. Then we can use the interface when injecting, and we can use the implementation in the property. Best of both world.

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectRepository;

final class MyTestController
{
    private UserRepository $userRepository;

    public function __construct(ObjectRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(): Response
    {
        // Do stuff.
    }
}
```

## Installation

```shell
composer require loophp/service-alias-autoregister-bundle
```

See the next section to learn how to enable it in your project.

## Usage

The bundle can be enabled by just adding a specific tag: `autoregister.alias`

### Adds all the aliases it can find

```yaml
services:
    App\:
        resource: '../src/*'
        exclude: '../src/{DependencyInjection,Entity,Tests,Kernel.php}'
        tags:
            - { name: autoregister.alias }
```

### Adds only specific services implementing specific interfaces only

```yaml
services:
    _instanceof:
        Doctrine\Persistence\ObjectRepository:
            tags:
                - { name: autoregister.alias }
```

Once it is done, do the following command to verify:

```shell
bin/console debug:container --tag=autoregister.alias
```

Another example: find all the new aliases for Doctrine repositories:

```shell
bin/console debug:container ObjectRepository
```

### Configure the bundle

You can configure this bundle by creating a configuration file in your application.

```yaml
service_alias_auto_register:
    whitelist: ~
    blacklist:
        - Countable
        - Psr\Log\LoggerAwareInterface
        - Symfony\Contracts\Service\ServiceSubscriberInterface
```

The configuration keys that are available:

- `whitelist`: Let you configure a list of interface to use. Empty the list to whitelist them all.
- `blacklist`: Let you configure a list of interface to ignore. Default is empty array. It takes precedence on the `whitelist`.

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite responsive :-)

If you can't contribute to the code, you can also sponsor me on [Github][5] or
[Paypal][6].

## Changelog

See [CHANGELOG.md][47] for a changelog based on [git commits][46].

For more detailed changelogs, please check [the release changelogs][45].

[1]: https://packagist.org/packages/loophp/service-alias-autoregister-bundle
[latest stable version]: https://img.shields.io/packagist/v/loophp/service-alias-autoregister-bundle.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/service-alias-autoregister-bundle.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/service-alias-autoregister-bundle.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/service-alias-autoregister-bundle.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[34]: https://github.com/loophp/service-alias-autoregister-bundle/issues
[2]: https://github.com/loophp/service-alias-autoregister-bundle/actions
[35]: http://www.phpspec.net/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[5]: https://github.com/sponsors/drupol
[6]: https://www.paypal.me/drupol
[40]: https://packagist.org/packages/doctrine/doctrine-bundle
[41]: https://en.wikipedia.org/wiki/SOLID
[42]: https://en.wikipedia.org/wiki/Open%E2%80%93closed_principle
[43]: https://github.com/symfony/maker-bundle/pull/887
[44]: https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
[45]: https://github.com/loophp/service-alias-autoregister-bundle/releases
[46]: https://github.com/loophp/service-alias-autoregister-bundle/commits/master
[47]: https://github.com/loophp/service-alias-autoregister-bundle/blob/master/CHANGELOG.md
[48]: https://packagist.org/packages/symfony/maker-bundle
[49]: https://packagist.org/packages/doctrine/persistence
[50]: https://symfony.com/doc/current/service_container.html#binding-arguments-by-name-or-type