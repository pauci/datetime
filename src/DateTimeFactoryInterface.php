<?php

namespace Pauci\DateTime;

use DateTimeZone;

interface DateTimeFactoryInterface
{
    /**
     * @return DateTimeInterface
     */
    public function now();

    /**
     * @return DateTimeInterface
     */
    public function microsecondsNow();

    /**
     * @param string $string
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromString($string, DateTimeZone $timezone = null);

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromFormat($format, $time, DateTimeZone $timezone = null);

    /**
     * @param int $timestamp
     * @param DateTimeZone $timezone
     * @return DateTimeInterface
     */
    public function fromTimestamp($timestamp, DateTimeZone $timezone = null);

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTimeInterface
     */
    public function fromDateTime(\DateTimeInterface $dateTime);
}
