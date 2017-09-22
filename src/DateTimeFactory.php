<?php
declare(strict_types=1);

namespace Pauci\DateTime;

use DateTimeZone;

class DateTimeFactory implements DateTimeFactoryInterface
{
    public function now(): DateTimeInterface
    {
        return new DateTime();
    }

    public function microsecondsNow(): DateTimeInterface
    {
        $t = microtime(true);
        $micro = sprintf('%06d', ($t - floor($t)) * 1000000);
        $time = date('Y-m-d H:i:s.' . $micro, (int) $t);

        return $this->fromString($time, $this->getDefaultTimezone());
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromString(string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        return new DateTime($time, $timezone);
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     * @throws \InvalidArgumentException
     */
    public function fromFormat(string $format, string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        $dateTime = $timezone !== null
            ? \DateTime::createFromFormat($format, $time, $timezone)
            : \DateTime::createFromFormat($format, $time);

        if (!$dateTime) {
            throw new \InvalidArgumentException(
                sprintf('Failed to parse time string "%s" formatted as "%s"', $time, $format)
            );
        }

        return $this->fromDateTime($dateTime);
    }

    /**
     * @param int $timestamp
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromTimestamp(int $timestamp, DateTimeZone $timezone = null): DateTimeInterface
    {
        return $this->fromString('@' . $timestamp)
            ->setTimezone($timezone ?: $this->getDefaultTimezone());
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @return DateTimeInterface
     */
    public function fromDateTime(\DateTimeInterface $dateTime): DateTimeInterface
    {
        return $this->fromString($dateTime->format('Y-m-d H:i:s.u'), $dateTime->getTimezone());
    }

    /**
     * @return DateTimeZone
     */
    private function getDefaultTimezone(): DateTimeZone
    {
        return new DateTimeZone(date_default_timezone_get());
    }
}
