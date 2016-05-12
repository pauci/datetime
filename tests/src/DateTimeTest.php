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

    public function testComparison()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46');
        $dateTime2 = DateTime::fromString('2016-05-12 22:37:46.000000');

        self::assertTrue($dateTime1 == $dateTime2);
        self::assertFalse($dateTime1 != $dateTime2);

        $dateTime3 = DateTime::fromString('2017-01-10 12:20:11');
        $dateTime4 = DateTime::fromString('2015-02-22 14:33:54');

        self::assertTrue($dateTime3 > $dateTime4);
        self::assertFalse($dateTime3 <= $dateTime4);

        $dateTime5 = DateTime::fromString('2016-05-12 22:37:46.000001');
        $dateTime6 = DateTime::fromString('2016-05-12 22:37:46');

        self::assertTrue($dateTime5 > $dateTime6);
        self::assertFalse($dateTime5 <= $dateTime6);
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