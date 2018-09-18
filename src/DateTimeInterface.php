<?php
declare(strict_types=1);

namespace Pauci\DateTime;

/**
 * @method DateTimeInterface add(\DateInterval $interval)
 * @method DateTimeInterface sub(\DateInterval $interval)
 * @method DateTimeInterface modify($modify)
 * @method DateTimeInterface setDate($year, $month, $day)
 * @method DateTimeInterface setISODate($year, $week, $day = 1)
 * @method DateTimeInterface setTime($hour, $minute, $second = 0, $microseconds = 0)
 * @method DateTimeInterface setTimestamp($unixtimestamp)
 * @method DateTimeInterface setTimezone(\DateTimeZone $timezone)
 */
interface DateTimeInterface extends \DateTimeInterface, \JsonSerializable
{
    /**
     * @param \DateTimeInterface $datetime
     * @param bool $absolute
     * @return DateInterval
     */
    public function diff($datetime, $absolute = false): DateInterval;

    /**
     * @param DateTimeInterface $dateTime
     * @return bool
     */
    public function equals(self $dateTime): bool;

    /**
     * @return DateTimeInterface
     */
    public function inDefaultTimezone(): DateTimeInterface;

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
