<?php

namespace Pauci\DateTime;

use DateTimeZone;

class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * @var string
     */
    private $dateTimeClass;

    public function __construct($dateTimeClass = DateTime::class)
    {
        $this->dateTimeClass = $dateTimeClass;
    }

    /**
     * @return DateTime
     */
    public function now()
    {
        return new $this->dateTimeClass();
    }

    /**
     * @return DateTime
     */
    public function microsecondsNow()
    {
        $t = microtime(true);
        $micro = sprintf('%06d', ($t - floor($t)) * 1000000);
        $time = date('Y-m-d H:i:s.' . $micro, $t);

        return new $this->dateTimeClass($time, new DateTimeZone(date_default_timezone_get()));
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTime
     */
    public function fromString($time, DateTimeZone $timezone = null)
    {
        return new $this->dateTimeClass($time, $timezone);
    }
}
