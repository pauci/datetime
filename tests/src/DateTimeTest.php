<?php

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public static function testNow()
    {
        $dateTime = DateTime::now();
        self::assertInstanceOf(DateTime::class, $dateTime);

        $phpDateTime = new \DateTime();
        $diff = $phpDateTime->getTimestamp() - $dateTime->getTimestamp();
        self::assertGreaterThanOrEqual(0, $diff);
        self::assertLessThanOrEqual(1, $diff);
    }

    public function testMicrosecondsNow()
    {
        $dateTime1 = DateTime::microsecondsNow();
        self::assertInstanceOf(DateTime::class, $dateTime1);

        $dateTime2 = DateTime::microsecondsNow();
        $diff = $dateTime2->format('U.u') - $dateTime1->format('U.u');
        self::assertGreaterThan(0, $diff);
        self::assertLessThan(1, $diff);

        $phpDateTime = new \DateTime();
        self::assertEquals($phpDateTime->getTimezone(), $dateTime1->getTimezone());
    }

    public function testCreateFromFormat()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2016-05-16 14:09:10');
        self::assertInstanceOf(DateTime::class, $dateTime);

        self::assertEquals('2016-05-16T14:09:10.000000+02:00', (string) $dateTime);
    }

    public function testComparison()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = DateTime::fromString('2016-05-12 22:37:46.000000', new \DateTimeZone('Europe/Bratislava'));

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
        $dateTime = DateTime::fromString('2016-05-12 22:37:46.123456-05:00');

        self::assertEquals('2016-05-12T22:37:46.123456-05:00', $dateTime->toString());
        self::assertEquals('2016-05-12T22:37:46.123456-05:00', sprintf('%s', $dateTime));
    }

    public function testJsonSerialize()
    {
        $dateTime = DateTime::now();

        self::assertEquals('"' . $dateTime->toString() . '"', json_encode($dateTime));
    }

    public function testSerialize()
    {
        $dateTime = DateTime::now();

        $serialized = serialize($dateTime);
        $unserializedDateTime = unserialize($serialized);

        self::assertEquals($dateTime, $unserializedDateTime);
        self::assertEquals($dateTime->getTimezone(), $unserializedDateTime->getTimezone());
    }
}