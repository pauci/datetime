<?php

namespace Pauci\DateTime;

use DateTimeZone;

/**
 * @method DateTimeInterface add(\DateInterval $interval)
 * @method DateTimeInterface sub(\DateInterval $interval)
 * @method DateTimeInterface modify($modify)
 * @method DateTimeInterface setDate($year, $month, $day)
 * @method DateTimeInterface setISODate($year, $week, $day = 1)
 * @method DateTimeInterface setTime($hour, $minute, $second = 0)
 * @method DateTimeInterface setTimestamp($unixtimestamp)
 * @method DateTimeInterface setTimezone(DateTimeZone $timezone)
 */
class DateTime extends \DateTimeImmutable implements DateTimeInterface
{
    /**
     * @var DateTimeFactoryInterface
     */
    private static $factory;

    /**
     * @return DateTimeFactoryInterface
     */
    public static function getFactory()
    {
        if (!self::$factory) {
            self::$factory = new DateTimeFactory();
        }
        return self::$factory;
    }

    /**
     * @param DateTimeFactoryInterface $factory
     */
    public static function setFactory(DateTimeFactoryInterface $factory)
    {
        self::$factory = $factory;
    }

    /**
     * @return DateTimeInterface
     */
    public static function now()
    {
        return self::getFactory()->now();
    }

    /**
     * @return DateTimeInterface
     */
    public static function microsecondsNow()
    {
        return self::getFactory()->microsecondsNow();
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function fromString($time, DateTimeZone $timezone = null)
    {
        return self::getFactory()->fromString($time, $timezone);
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function fromFormat($format, $time, DateTimeZone $timezone = null)
    {
        return self::getFactory()->fromFormat($format, $time, $timezone);
    }

    /**
     * @param int $timestamp
     * @param DateTimeZone $timezone
     * @return DateTimeInterface
     */
    public static function fromTimestamp($timestamp, DateTimeZone $timezone = null)
    {
        return self::getFactory()->fromTimestamp($timestamp, $timezone);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTimeInterface
     */
    public static function fromDateTime(\DateTimeInterface $dateTime)
    {
        return self::getFactory()->fromDateTime($dateTime);
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        return self::fromFormat($format, $time, $timezone);
    }

    /**
     * @param \DateTime $dateTime
     * @return DateTimeInterface
     */
    public static function createFromMutable($dateTime)
    {
        return self::fromDateTime($dateTime);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @param bool $absolute
     * @return DateInterval
     */
    public function diff($dateTime, $absolute = false)
    {
        $interval = parent::diff($dateTime, $absolute);
        return DateInterval::fromDateInterval($interval);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->format($this->getFormat());
    }

    /**
     * @return string
     */
    private function getFormat()
    {
        return $this->format('u') === '000000' ? \DateTime::ATOM : 'Y-m-d\TH:i:s.uP';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }
}
