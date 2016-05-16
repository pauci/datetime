# pauci/datetime
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
