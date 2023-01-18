<?php

declare(strict_types=1);

namespace Pauci\DateTime;

class DateInterval extends \DateInterval implements DateIntervalInterface
{
    /**
     * @throws \Exception
     */
    public static function fromDateInterval(\DateInterval $dateInterval): static
    {
        $interval = new static('P0D');
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
     * @throws \Exception
     */
    public static function fromParts(
        int $years = 0,
        int $months = 0,
        int $days = 0,
        int $hours = 0,
        int $minutes = 0,
        int $seconds = 0
    ): static {
        $interval = new static('P0D');
        $interval->y = $years;
        $interval->m = $months;
        $interval->d = $days;
        $interval->h = $hours;
        $interval->i = $minutes;
        $interval->s = $seconds;

        return $interval;
    }

    final public function __construct(string $duration)
    {
        parent::__construct($duration);
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $interval): static
    {
        return new static($interval);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        $datePart = '';

        if ($this->y !== 0) {
            $datePart .= $this->y . 'Y';
        }

        if ($this->m !== 0) {
            $datePart .= $this->m . 'M';
        }

        if ($this->d !== 0) {
            $datePart .= $this->d . 'D';
        }

        $timePart = '';

        if ($this->h !== 0) {
            $timePart .= $this->h . 'H';
        }

        if ($this->i !== 0) {
            $timePart .= $this->i . 'M';
        }

        if ($this->s !== 0) {
            $timePart .= $this->s . 'S';
        }

        if ($timePart === '') {
            if ($datePart === '') {
                return 'P0D';
            }

            return 'P' . $datePart;
        }

        return 'P' . $datePart . 'T' . $timePart;
    }
}
