<?php

declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeZone;

interface DateTimeFactoryInterface
{
    public function now(): DateTimeInterface;

    public function microsecondsNow(): DateTimeInterface;

    public function fromString(string $time, DateTimeZone $timezone = null): DateTimeInterface;

    public function fromFormat(string $format, string $time, DateTimeZone $timezone = null): DateTimeInterface;

    public function fromTimestamp(int $timestamp, DateTimeZone $timezone = null): DateTimeInterface;

    public function fromFloatTimestamp(float $timestamp, DateTimeZone $timezone = null): DateTimeInterface;

    public function fromDateTime(\DateTimeInterface $dateTime): DateTimeInterface;
}
