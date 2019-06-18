<?php
declare(strict_types=1);

namespace Pauci\DateTime;

use JsonSerializable;

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
interface DateTimeInterface extends \DateTimeInterface, JsonSerializable
{
    /**
     * @param \DateTimeInterface $datetime
     * @param bool $absolute
     */
    public function diff($datetime, $absolute = false): DateInterval;

    public function equals(self $dateTime): bool;

    public function inDefaultTimezone(): DateTimeInterface;

    public function toString(): string;

    public function __toString(): string;
}
