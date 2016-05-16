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
        $intervalSpec = self::toString($dateInterval);
        return self::fromString($intervalSpec);
    }

    /**
     * @param string $interval
     * @return DateInterval
     */
    public static function fromString($interval)
    {
        return new self($interval);
    }

    public function __toString()
    {
        return self::toString($this);
    }

    public function jsonSerialize()
    {
        return self::toString($this);
    }

    /**
     * @param \DateInterval $interval
     * @return string
     */
    private static function toString(\DateInterval $interval)
    {
        $dateString = '';
        if ($interval->y !== 0) {
            $dateString .= $interval->y . 'Y';
        }
        if ($interval->m !== 0) {
            $dateString .= $interval->m . 'M';
        }
        if ($interval->d !== 0) {
            $dateString .= $interval->d . 'D';
        }

        $timeString = '';
        if ($interval->h !== 0) {
            $timeString .= $interval->h . 'H';
        }
        if ($interval->i !== 0) {
            $timeString .= $interval->i . 'M';
        }
        if ($interval->s !== 0) {
            $timeString .= $interval->s . 'S';
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
