<?php

declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeZone;

class DateTime extends \DateTimeImmutable implements DateTimeInterface
{
    private static ?DateTimeFactoryInterface $factory;

    public static function getFactory(): DateTimeFactoryInterface
    {
        return self::$factory ??= new DateTimeFactory();
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

    #[\ReturnTypeWillChange]
    public static function createFromFormat(
        string $format,
        string $datetime,
        DateTimeZone $timezone = null
    ): DateTimeInterface {
        return self::fromFormat($format, $datetime, $timezone);
    }

    #[\ReturnTypeWillChange]
    public static function createFromMutable(\DateTime $object): DateTimeInterface
    {
        return self::fromDateTime($object);
    }

    /**
     * @throws \Exception
     */
    public function diff(\DateTimeInterface $targetObject, bool $absolute = false): DateInterval
    {
        return DateInterval::fromDateInterval(
            parent::diff($targetObject, $absolute)
        );
    }

    public function add(\DateInterval $interval): static
    {
        return parent::add($interval);
    }

    public function sub(\DateInterval $interval): static
    {
        return parent::sub($interval);
    }

    public function modify(string $modifier): static
    {
        try {
            $dateTime = parent::modify($modifier);
        } catch (\Throwable $e) {
            $message = strtr($e->getMessage(), [\DateTimeImmutable::class => static::class]);

            throw new Exception\FailedToModifyException($message, previous: $e);
        }

        return $dateTime;
    }

    public function setDate(int $year, int $month, int $day): static
    {
        return parent::setDate($year, $month, $day);
    }

    public function setISODate(int $year, int $week, int $dayOfWeek = 1): static
    {
        return parent::setISODate($year, $week, $dayOfWeek);
    }

    public function setTime(int $hour, int $minute, int $second = 0, int $microsecond = 0): static
    {
        return parent::setTime($hour, $minute, $second, $microsecond);
    }

    public function setTimestamp(int $timestamp): static
    {
        return parent::setTimestamp($timestamp);
    }

    public function setTimezone(\DateTimeZone $timezone): static
    {
        return parent::setTimezone($timezone);
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
        return $this->format('u') === '000000'
            ? \DateTimeInterface::ATOM
            : 'Y-m-d\TH:i:s.uP';
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
