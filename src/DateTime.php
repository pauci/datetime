<?php

declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

class DateTime extends DateTimeImmutable implements DateTimeInterface
{
    protected static ?ClockInterface $clock = null;

    public static function getClock(): ClockInterface
    {
        return static::$clock ??= new SystemClock();
    }

    public static function setClock(ClockInterface $clock): void
    {
        static::$clock = $clock;
    }

    public static function now(): DateTimeInterface
    {
        return static::getClock()->now();
    }

    /**
     * @throws Exception
     */
    public static function fromString(string $time, DateTimeZone $timezone = null): static
    {
        $dateTime = parent::createFromInterface(new \DateTime($time, $timezone));
        \assert($dateTime instanceof static);

        return $dateTime;
    }

    /**
     * @throws Exception
     */
    public static function fromTimestamp(int $timestamp, DateTimeZone $timezone = null): static
    {
        $dateTime = static::createFromFormat('U', (string) $timestamp);
        \assert(false !== $dateTime);

        return null !== $timezone
            ? $dateTime->setTimezone($timezone)
            : $dateTime->inDefaultTimezone();
    }

    public static function fromFloatTimestamp(float $timestamp, DateTimeZone $timezone = null): static
    {
        $integer = floor($timestamp);
        $fract = fmod($timestamp, 1);
        if ($fract < 0) {
            ++$fract;
        }

        $dateTime = static::createFromFormat('U u', sprintf('%d %06d', $integer, round($fract * 1_000_000)));
        \assert(false !== $dateTime);

        return null !== $timezone
            ? $dateTime->setTimezone($timezone)
            : $dateTime->inDefaultTimezone();
    }

    #[\ReturnTypeWillChange]
    public static function createFromFormat(
        string $format,
        string $datetime,
        DateTimeZone $timezone = null
    ): static|false {
        return parent::createFromFormat($format, $datetime, $timezone);
    }

    #[\ReturnTypeWillChange]
    public static function createFromMutable(\DateTime $object): static
    {
        return parent::createFromMutable($object);
    }

    #[\ReturnTypeWillChange]
    public static function createFromInterface(\DateTimeInterface $object): static
    {
        $dateTime = parent::createFromInterface($object);
        \assert($dateTime instanceof static);

        return $dateTime;
    }

    /**
     * @throws Exception
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

    public function modify(string $modifier): static|false
    {
        return parent::modify($modifier);
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

    public function inDefaultTimezone(): static
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
