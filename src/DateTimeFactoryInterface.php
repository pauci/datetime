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
}
