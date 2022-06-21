# pauci/datetime

[![Source Code][badge-source]][source]
[![PHP][badge-php]][php]
[![Latest Version][badge-release]][release]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Software License][badge-license]][license]
[![Total Downloads][badge-downloads]][downloads]

Provides enhanced `DateTime` and `DateInterval` objects with clock abstraction
- based on `DateTimeImmutable` object (to discourage the use of mutable version)
- provides `SystemClock` for production and `FrozenClock` for testing
- provides extra static factory methods: `now()` (uses clock), `fromString()`, `fromTimestamp()`, `fromFloatTimestamp()`
- implements `Stringable` and `JsonSerializable` with implicit conversion to string (ISO 8601)


## Examples

```php
use Pauci\DateTime\DateTime;

$now = $clock->now();
// or
DateTime::setClock($clock);
$now = DateTime::now();

echo $now;                                            // 2016-05-20T14:30:54.345678+02:00
echo json_encode($now);                               // "2016-05-20T14:30:54.345678+02:00"
echo DateTime::fromTimestamp(1512148033);             // 2017-12-01T18:07:13+01:00
echo DateTime::fromFloatTimestamp(1512148033.000005); // 2017-12-01T18:07:13.000005+01:00

DateTime::setFormat('Y-m-d H:i:s');
echo $now;                                            // 2016-05-20 14:30:54
echo json_encode($now);                               // "2016-05-20 14:30:54"
```



[badge-source]: https://img.shields.io/badge/source-pauci/datetime-blue.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/pauci/datetime?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/pauci/datetime.svg?style=flat-square&label=release
[badge-build]: https://img.shields.io/github/workflow/status/pauci/datetime/Continuous%20Integration?style=flat-square
[badge-coverage]: https://img.shields.io/codecov/c/github/pauci/datetime?style=flat-square&token=KmPSlqBuuG
[badge-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/pauci/datetime.svg?style=flat-square

[source]: https://github.com/pauci/datetime
[php]: https://php.net
[release]: https://packagist.org/packages/pauci/datetime
[build]: https://github.com/pauci/datetime/actions?query=workflow%3A%22Continuous+Integration%22
[coverage]: https://codecov.io/gh/pauci/datetime
[license]: https://github.com/pauci/datetime/blob/master/LICENSE
[downloads]: https://packagist.org/packages/pauci/datetime
