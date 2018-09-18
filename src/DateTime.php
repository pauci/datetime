<?php
declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeZone;

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
class DateTime extends \DateTimeImmutable implements DateTimeInterface
{
    /**
     * @var DateTimeFactoryInterface|null
     */
    private static $factory;

    /**
     * @return DateTimeFactoryInterface
     */
    public static function getFactory(): DateTimeFactoryInterface
    {
        if (!self::$factory) {
            self::$factory = new DateTimeFactory();
        }
        return self::$factory;
    }

    /**
     * @param DateTimeFactoryInterface $factory
     */
    public static function setFactory(DateTimeFactoryInterface $factory): void
    {
        self::$factory = $factory;
    }

    /**
     * @return DateTimeInterface
     */
    public static function now(): DateTimeInterface
    {
        return self::getFactory()->now();
    }

    /**
     * @return DateTimeInterface
     */
    public static function microsecondsNow(): DateTimeInterface
    {
        return self::getFactory()->microsecondsNow();
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function fromString(string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromString($time, $timezone);
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function fromFormat(string $format, string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromFormat($format, $time, $timezone);
    }

    /**
     * @param int $timestamp
     * @param DateTimeZone $timezone
     * @return DateTimeInterface
     */
    public static function fromTimestamp(int $timestamp, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromTimestamp($timestamp, $timezone);
    }

    /**
     * @param float $timestamp
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function fromFloatTimestamp(float $timestamp, DateTimeZone $timezone = null): DateTimeInterface
    {
        return self::getFactory()->fromFloatTimestamp($timestamp, $timezone);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTimeInterface
     */
    public static function fromDateTime(\DateTimeInterface $dateTime): DateTimeInterface
    {
        return self::getFactory()->fromDateTime($dateTime);
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function createFromFormat($format, $time, $timezone = null): DateTimeInterface
    {
        return self::fromFormat($format, $time, $timezone);
    }

    /**
     * @param \DateTime $dateTime
     * @return DateTimeInterface
     */
    public static function createFromMutable($dateTime): DateTimeInterface
    {
        return self::fromDateTime($dateTime);
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @param bool $absolute
     * @return DateInterval
     * @throws \Exception
     */
    public function diff($dateTime, $absolute = false): DateInterval
    {
        return DateInterval::fromDateInterval(
            parent::diff($dateTime, $absolute)
        );
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return bool
     */
    public function equals(DateTimeInterface $dateTime): bool
    {
        return $this == $dateTime;
    }

    /**
     * @return DateTimeInterface
     */
    public function inDefaultTimezone(): DateTimeInterface
    {
        return $this->setTimezone(new DateTimeZone(date_default_timezone_get()));
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->format($this->getFormat());
    }

    /**
     * @return string
     */
    private function getFormat(): string
    {
        return $this->format('u') === '000000' ? \DateTime::ATOM : 'Y-m-d\TH:i:s.uP';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
