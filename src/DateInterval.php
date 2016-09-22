<?php

namespace Pauci\DateTime;

class DateInterval extends \DateInterval implements \JsonSerializable
{
    /**
     * @param \DateInterval $dateInterval
     * @return DateInterval
     */
    public static function fromDateInterval(\DateInterval $dateInterval)
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
     */
    public static function fromParts($years = 0, $months = 0, $days = 0, $hours = 0, $minutes = 0, $seconds = 0)
    {
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
     */
    public static function fromString($interval)
    {
        return new self($interval);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
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
