<?php

namespace Pauci\DateTime;

class DateInterval extends \DateInterval implements \JsonSerializable
{
    /**
     * @param \DateInterval $dateInterval
     * @return DateInterval
     * @throws \Exception
     */
    public static function fromDateInterval(\DateInterval $dateInterval): self
    {
        $interval = new self('P0D');
        $interval->y = $dateInterval->y;
        $interval->m = $dateInterval->m;
        $interval->d = $dateInterval->d;
        $interval->h = $dateInterval->h;
        $interval->i = $dateInterval->i;
        $interval->s = $dateInterval->s;
        $interval->invert = $dateInterval->invert;
        $interval->days = $dateInterval->days;
        return $interval;
    }

    /**
     * @param int $years
     * @param int $months
     * @param int $days
     * @param int $hours
     * @param int $minutes
     * @param int $seconds
     * @return DateInterval
     * @throws \Exception
     */
    public static function fromParts(
        int $years = 0,
        int $months = 0,
        int $days = 0,
        int $hours = 0,
        int $minutes = 0,
        int $seconds = 0
    ): self {
        $interval = new self('P0D');
        $interval->y = $years;
        $interval->m = $months;
        $interval->d = $days;
        $interval->h = $hours;
        $interval->i = $minutes;
        $interval->s = $seconds;
        return $interval;
    }

    /**
     * @param string $interval
     * @return DateInterval
     * @throws \Exception
     */
    public static function fromString(string $interval): self
    {
        return new self($interval);
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

    /**
     * @return string
     */
    public function toString(): string
    {
        $dateString = '';
        if ($this->y !== 0) {
            $dateString .= $this->y . 'Y';
        }
        if ($this->m !== 0) {
            $dateString .= $this->m . 'M';
        }
        if ($this->d !== 0) {
            $dateString .= $this->d . 'D';
        }

        $timeString = '';
        if ($this->h !== 0) {
            $timeString .= $this->h . 'H';
        }
        if ($this->i !== 0) {
            $timeString .= $this->i . 'M';
        }
        if ($this->s !== 0) {
            $timeString .= $this->s . 'S';
        }

        if ($timeString === '') {
            if ($dateString === '') {
                return 'P0D';
            }
            return 'P' . $dateString;
        }
        return 'P' . $dateString . 'T' . $timeString;
    }
}
