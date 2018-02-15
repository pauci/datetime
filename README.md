# pauci/datetime

[![Latest Stable Version](https://poser.pugx.org/pauci/datetime/v/stable)](https://packagist.org/packages/pauci/datetime)
[![Total Downloads](https://poser.pugx.org/pauci/datetime/downloads)](https://packagist.org/packages/pauci/datetime)
[![Build Status](https://travis-ci.org/pauci/datetime.svg?branch=master)](https://travis-ci.org/pauci/datetime)
[![Coverage Status](https://coveralls.io/repos/pauci/datetime/badge.png?branch=master)](https://coveralls.io/r/pauci/datetime)

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
echo json_encode($now); // "2016-05-20T14:30:54+02:00"

echo DateTime::microsecondsNow(); // 2016-05-20T14:30:54.074420+02:00

echo DateTime::fromFloatTimestamp(1512148033.000005); // 2017-12-01T18:07:13.000005+01:00
```
