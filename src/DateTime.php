<?php
declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

/**
 * @method DateTimeInterface add(\DateInterval $interval)
 * @method DateTimeInterface sub(\DateInterval $interval)
 * @method DateTimeInterface modify($modify)
 * @method DateTimeInterface setDate($year, $month, $day)
 * @method DateTimeInterface setISODate($year, $week, $day = 1)
 * @method DateTimeInterface setTime($hour, $minute, $second = 0, $microseconds = 0)
 * @method DateTimeInterface setTimestamp($unixtimestamp)
 * @method DateTimeInterface setTimezone(DateTimeZone $timezone)
 */
class DateTime extends DateTimeImmutable implements DateTimeInterface
{
    /**
     * @var DateTimeFactoryInterface|null
     */
    private static $factory;

    public static function getFactory(): DateTimeFactoryInterface
    {
        if (!self::$factory) {
            self::$factory = new DateTimeFactory();
        }
        return self::$factory;
    }

    public static function setFactory(DateTimeFactoryInterface $factory): void
    {
        self::$factory = $factory;
    }

    public static function now(): DateTimeInterface
    {
        return self::getFactory()->now();
    }

    public static function microsecondsNow(): DateTimeInterface
    {
        return self::getFactory()->microsecondsNow();
    }

    public static function fromString(string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromString($time, $timezone);
    }

    public static function fromFormat(string $format, string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromFormat($format, $time, $timezone);
    }

    public static function fromTimestamp(int $timestamp, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromTimestamp($timestamp, $timezone);
    }

    public static function fromFloatTimestamp(float $timestamp, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromFloatTimestamp($timestamp, $timezone);
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): DateTimeInterface
    {
        return self::getFactory()->fromDateTime($dateTime);
    }

    /**
     * @param string $format
     * @param string $time
     */
    public static function createFromFormat($format, $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::fromFormat($format, $time, $timezone);
    }

    /**
     * @param \DateTime $dateTime
     */
    public static function createFromMutable($dateTime): DateTimeInterface
    {
        return self::fromDateTime($dateTime);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @param bool $absolute
     * @throws Exception
     */
    public function diff($dateTime, $absolute = false): DateInterval
    {
        return DateInterval::fromDateInterval(
            parent::diff($dateTime, $absolute)
        );
    }

    public function equals(DateTimeInterface $dateTime): bool
    {
        return $this == $dateTime;
    }

    public function inDefaultTimezone(): DateTimeInterface
    {
        return $this->setTimezone(new DateTimeZone(date_default_timezone_get()));
    }

    public function toString(): string
    {
        return $this->format($this->getFormat());
    }

    private function getFormat(): string
    {
        return $this->format('u') === '000000' ? \DateTimeInterface::ATOM : 'Y-m-d\TH:i:s.uP';
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
