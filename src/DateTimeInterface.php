<?php

declare(strict_types=1);

namespace Pauci\DateTime;

interface DateTimeInterface extends \DateTimeInterface, \Stringable, \JsonSerializable
{
    public function diff(\DateTimeInterface $targetObject, bool $absolute = false): DateInterval;

    public function equals(self $dateTime): bool;

    public function inDefaultTimezone(): DateTimeInterface;

    public function toString(): string;

    public function add(\DateInterval $interval): static;

    public function sub(\DateInterval $interval): static;

    public function modify(string $modifier): static;

    public function setDate(int $year, int $month, int $day): static;

    public function setISODate(int $year, int $week, int $dayOfWeek = 1): static;

    public function setTime(int $hour, int $minute, int $second = 0, int $microsecond = 0): static;

    public function setTimestamp(int $timestamp): static;

    public function setTimezone(\DateTimeZone $timezone): static;
}
