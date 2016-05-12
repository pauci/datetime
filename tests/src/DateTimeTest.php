<?php

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testImmutability()
    {

    }

    public function testMicroseconds()
    {

    }

    public function testToString()
    {
        $dateTime = DateTime::fromString('2016-05-12 22:37:46');

        self::assertEquals('2016-05-12T22:37:46+00:00', $dateTime->toString());
        self::assertEquals('2016-05-12T22:37:46+00:00', sprintf('%s', $dateTime));
    }

    public function testJsonSerialize()
    {
        $dateTime = DateTime::now();

        self::assertEquals('"' . $dateTime->toString() . '"', json_encode($dateTime));
    }
}