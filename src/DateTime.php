<?php

namespace Pauci\DateTime;

use DateTimeZone;

class DateTime extends \DateTime implements DateTimeInterface
{
    /**
     * @var string
     */
    private static $format = 'Y-m-d\TH:i:s.uP';

    /**
     * @var DateTimeFactoryInterface
     */
    private static $factory;

    /**
     * @return DateTimeFactoryInterface
     */
    public static function getFactory()
    {
        if (!self::$factory) {
            self::$factory = new DateTimeFactory();
        }
        return self::$factory;
    }

    /**
     * @param DateTimeFactoryInterface $factory
     */
    public static function setFactory(DateTimeFactoryInterface $factory)
    {
        self::$factory = $factory;
    }

    /**
     * @return DateTimeInterface
     */
    public static function now()
    {
        return self::getFactory()->now();
    }

    /**
     * @return DateTimeInterface
     */
    public static function microsecondsNow()
    {
        return self::getFactory()->microsecondsNow();
    }

    /**
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTimeInterface
     */
    public static function fromString($time, DateTimeZone $timezone = null)
    {
        return self::getFactory()->fromString($time, $timezone);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->format(self::$format);
    }

    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);

        $this->precision = random_int(1, 1000);
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
}