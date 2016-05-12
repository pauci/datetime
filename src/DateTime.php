<?php

namespace Pauci\DateTime;

use DateInterval;
use DateTime as PhpDateTime;
use DateTimeZone;
use JsonSerializable;

class DateTime extends PhpDateTime implements JsonSerializable
{
    private static $format = self::ATOM;

    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    public function add(DateInterval $interval)
    {
    }

    public function __toString()
    {
        return $this->format(self::$format);
    }

    public function jsonSerialize()
    {
        return (string) $this;
    }
}