# pauci/datetime

[![Latest Stable Version](https://poser.pugx.org/pauci/datetime/v/stable)](https://packagist.org/packages/pauci/datetime)
[![Total Downloads](https://poser.pugx.org/pauci/datetime/downloads)](https://packagist.org/packages/pauci/datetime)
[![Build Status](https://travis-ci.org/pauci/datetime.svg?branch=master)](https://travis-ci.org/pauci/datetime)
[![Coverage Status](https://coveralls.io/repos/pauci/datetime/badge.png?branch=master)](https://coveralls.io/r/pauci/datetime)

Enhanced DateTime, DateTimeImmutable and DateInterval objects:
- extends built-in types
- allows to obtain current time including microseconds
- supports conversion to string (ISO 8601)
- implementing JsonSerializable interface

## Usage example

```php
$now = \Pauci\DateTime\DateTime::now();
$nowWithMicroseconds = \Pauci\DateTime\DateTime::microsecondsNow();

$string = (string) $now;                  // 2016-05-20T14:30:54+02:00
$string2 = (string) $nowWithMicroseconds; // 2016-05-20T14:30:54.074420+02:00
$json = json_encode($now);                // "2016-05-20T14:30:54+02:00"
```
