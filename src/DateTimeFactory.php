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
        return $this->fromFloatTimestamp(microtime(true));
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromString(string $time, DateTimeZone $timezone = null): DateTimeInterface
    {
        try {
            return new DateTime($time, $timezone);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (0 === strpos($message, 'DateTimeImmutable::__construct(): ')) {
                $message = substr($message, 34);
            }
            throw new Exception\InvalidTimeStringException($message, $e->getCode(), $e);
        }
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
            throw new Exception\InvalidTimeStringException(
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
            ->setTimezone($timezone ?? $this->getDefaultTimezone());
    }

    /**
     * @param float $timestamp
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public function fromFloatTimestamp(float $timestamp, DateTimeZone $timezone = null): DateTimeInterface
    {
        $integerPart = (int) floor($timestamp);
        $fractionalPart = substr(sprintf('%.6f', $timestamp - $integerPart), 2);
        $time = date('Y-m-d H:i:s.' . $fractionalPart, $integerPart);

        $dateTime = $this->fromString($time);
        return $timezone ? $dateTime->setTimezone($timezone) : $dateTime;
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
