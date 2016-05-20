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

$string = (string) $now;
$json = json_encode($now);
```
