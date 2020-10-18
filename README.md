# bgy-neighborhoods-diagnostic

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Error detection strategy for [Boris Guéry's transient error handling](https://github.com/borisguery/PHPTransientFaultHandling) using [Neighborhoods' throwable diagnostic component](https://github.com/neighborhoods/ThrowableDiagnosticComponent).


## Install

Via Composer

``` bash
$ composer require yucadoo/bgy-neighborhoods-diagnostic
```

## Usage

``` php
use Bgy\TransientFaultHandling\RetryPolicy;
use Bgy\TransientFaultHandling\RetryStrategies\FixedInterval;
use YucaDoo\BgyNeighborhoodsDiagnostic\ExceptionDetectionStrategy as NeighborhoodsErrorDetectionStrategy;

/**
 * Obtain a preconfigured ThrowableDiagnostic builder factory.
 * You can use Symfony DI as explained in Neighborhoods' throwable diagnostic component.
 */
$throwableDiagnosticBuilderFactory = $container->get('ThrowableDiagnosticBuilderFactoryWithTailoredDecoratorStack');

$neighborhoodsErrorDetectionStrategy = new NeighborhoodsErrorDetectionStrategy();
$neighborhoodsErrorDetectionStrategy->setThrowableDiagnosticBuilderFactory($throwableDiagnosticBuilderFactory);

// Compose retry policy
$retryCount = 10;
$retryIntervalInMicroseconds = 1000000 // 1 sec 
$retryStrategy = new FixedInterval($retryCount, $retryIntervalInMicroseconds);
$retryPolicy = new RetryPolicy($neighborhoodsErrorDetectionStrategy, $retryStrategy);

$retryPolicy->execute(function() {
    // API calls
    // Database calls
});
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hrcajuka@gmail.com instead of using the issue tracker.

## Credits

- [Hrvoje Jukic][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yucadoo/bgy-neighborhoods-diagnostic.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/yucadoo/bgy-neighborhoods-diagnostic/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/yucadoo/bgy-neighborhoods-diagnostic.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/yucadoo/bgy-neighborhoods-diagnostic.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/yucadoo/bgy-neighborhoods-diagnostic.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/yucadoo/bgy-neighborhoods-diagnostic
[link-travis]: https://travis-ci.org/yucadoo/bgy-neighborhoods-diagnostic
[link-scrutinizer]: https://scrutinizer-ci.com/g/yucadoo/bgy-neighborhoods-diagnostic/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/yucadoo/bgy-neighborhoods-diagnostic
[link-downloads]: https://packagist.org/packages/yucadoo/bgy-neighborhoods-diagnostic
[link-author]: https://github.com/yucadoo
[link-contributors]: ../../contributors
