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
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromFormat($format, $time, DateTimeZone $timezone = null);

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTimeInterface
     */
    public function fromDateTime(\DateTimeInterface $dateTime);

    /**
     * @param string $string
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromString($string, DateTimeZone $timezone = null);
}
