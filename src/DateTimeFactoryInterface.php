<?php
declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeZone;

interface DateTimeFactoryInterface
{
    /**
     * @return DateTimeInterface
     */
    public function now(): DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    public function microsecondsNow(): DateTimeInterface;

    /**
     * @param string $string
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromString(string $string, DateTimeZone $timezone = null): DateTimeInterface;

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromFormat(string $format, string $time, DateTimeZone $timezone = null): DateTimeInterface;

    /**
     * @param int $timestamp
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromTimestamp(int $timestamp, DateTimeZone $timezone = null): DateTimeInterface;

    /**
     * @param float $timestamp
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromFloatTimestamp(float $timestamp, DateTimeZone $timezone = null): DateTimeInterface;

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTimeInterface
     */
    public function fromDateTime(\DateTimeInterface $dateTime): DateTimeInterface;
}
