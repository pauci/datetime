# pauci/datetime

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

Provides enhanced DateTime and DateInterval objects
- extends built-in DateTimeImmutable object (to discourage the use of mutable version)
- provides various static factory methods
- allows to obtain current time including microseconds
- supports conversion to string (ISO 8601)
- implements JsonSerializable interface

## Examples

```php
use Pauci\DateTime\DateTime;

date_default_timezone_set('Europe/Bratislava');

$now = DateTime::now();
echo $now;              // 2016-05-20T14:30:54+02:00
echo json_encode(['now' => $now]); // {"now":"2016-05-20T14:30:54+02:00"}

echo DateTime::microsecondsNow(); // 2016-05-20T14:30:54.074420+02:00

echo DateTime::fromFloatTimestamp(1512148033.000005); // 2017-12-01T18:07:13.000005+01:00
```



[badge-source]: https://img.shields.io/badge/source-pauci/datetime-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/pauci/datetime.svg?style=flat-square
[badge-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/pauci/datetime/master.svg?style=flat-square
[badge-coverage]: https://img.shields.io/coveralls/pauci/datetime/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/pauci/datetime.svg?style=flat-square

[source]: https://github.com/pauci/datetime
[release]: https://packagist.org/packages/pauci/datetime
[license]: https://github.com/pauci/datetime/blob/master/LICENSE
[build]: https://travis-ci.org/pauci/datetime
[coverage]: https://coveralls.io/r/pauci/datetime?branch=master
[downloads]: https://packagist.org/packages/pauci/datetime
