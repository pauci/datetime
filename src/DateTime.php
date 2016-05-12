<?php

namespace Pauci\DateTime;

use DateInterval;
use DateTime as PhpDateTime;
use DateTimeZone;
use JsonSerializable;

class DateTime extends PhpDateTime implements JsonSerializable
{
    private static $format = self::ATOM;

    public static function now()
    {
        return new self();
    }

    public static function fromString($time)
    {
        return new self($time);
    }

    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    public function toString()
    {
        return $this->format(self::$format);
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function jsonSerialize()
    {
        return $this->toString();
    }
}