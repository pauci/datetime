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
     * @return DateTimeInterface
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

        return $this->fromString($time, new DateTimeZone(date_default_timezone_get()));
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTime
     */
    public function fromFormat($format, $time, DateTimeZone $timezone = null)
    {
        $dateTime = \DateTime::createFromFormat($format, $time, $timezone);
        return $this->fromDateTime($dateTime);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTime
     */
    public function fromDateTime(\DateTimeInterface $dateTime)
    {
        return $this->fromString($dateTime->format('Y-m-d H:i:s.u'), $dateTime->getTimezone());
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
