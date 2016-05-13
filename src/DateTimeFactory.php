<?php

namespace Pauci\DateTime;

use DateTimeZone;

class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * @return DateTime
     */
    public function now()
    {
        return new DateTime();
    }

    /**
     * @return DateTime
     */
    public function microsecondsNow()
    {
        $t = microtime(true);
        $micro = sprintf('%06d', ($t - floor($t)) * 1000000);
        $time = date('Y-m-d H:i:s.' . $micro, $t);

        return new DateTime($time, new DateTimeZone(date_default_timezone_get()));
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTime
     */
    public function fromString($time, DateTimeZone $timezone = null)
    {
        return new DateTime($time, $timezone);
    }
}
