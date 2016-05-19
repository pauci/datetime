<?php

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateInterval;
use Pauci\DateTime\DateTimeImmutable;

class DateTimeImmutableTest extends \PHPUnit_Framework_TestCase
{
    public static function testNow()
    {
        $dateTime = DateTimeImmutable::now();
        self::assertInstanceOf(DateTimeImmutable::class, $dateTime);

        $phpDateTime = new \DateTime();
        $diff = $phpDateTime->getTimestamp() - $dateTime->getTimestamp();
        self::assertGreaterThanOrEqual(0, $diff);
        self::assertLessThanOrEqual(1, $diff);
    }

    public function testMicrosecondsNow()
    {
        $dateTime1 = DateTimeImmutable::microsecondsNow();
        self::assertInstanceOf(DateTimeImmutable::class, $dateTime1);

        $dateTime2 = DateTimeImmutable::microsecondsNow();
        $diff = $dateTime2->format('U.u') - $dateTime1->format('U.u');
        self::assertGreaterThan(0, $diff);
        self::assertLessThan(1, $diff);

        $phpDateTime = new \DateTime();
        self::assertEquals($phpDateTime->getTimezone(), $dateTime1->getTimezone());
    }

    public function testCreateFromFormat()
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2016-05-16 14:09:10');
        self::assertInstanceOf(DateTimeImmutable::class, $dateTime);

        self::assertEquals('2016-05-16T14:09:10.000000+02:00', (string) $dateTime);
    }

    public function testFromTimestamp()
    {
        $dateTime = DateTimeImmutable::fromTimestamp(1463490311);

        self::assertEquals('2016-05-17T15:05:11.000000+02:00', (string) $dateTime);
    }

    public function testFromDateTime()
    {
        $phpDateTime = new \DateTime('2016-05-16 14:32:51.678991');
        $dateTime = DateTimeImmutable::fromDateTime($phpDateTime);

        self::assertInstanceOf(DateTimeImmutable::class, $dateTime);
        self::assertEquals('2016-05-16T14:32:51.678991+02:00', (string) $dateTime);
    }

    public function testComparison()
    {
        $dateTime1 = DateTimeImmutable::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = DateTimeImmutable::fromString(
            '2016-05-12 22:37:46.000000',
            new \DateTimeZone('Europe/Bratislava')
        );

        self::assertTrue($dateTime1 == $dateTime2);
        self::assertFalse($dateTime1 != $dateTime2);

        $dateTime3 = DateTimeImmutable::fromString('2017-01-10 12:20:11');
        $dateTime4 = DateTimeImmutable::fromString('2015-02-22 14:33:54');

        self::assertTrue($dateTime3 > $dateTime4);
        self::assertFalse($dateTime3 <= $dateTime4);

        $dateTime5 = DateTimeImmutable::fromString('2016-05-12 22:37:46.000001');
        $dateTime6 = DateTimeImmutable::fromString('2016-05-12 22:37:46');

        self::assertTrue($dateTime5 > $dateTime6);
        self::assertFalse($dateTime5 <= $dateTime6);
    }

    public function testAdd()
    {
        $dateTime = DateTimeImmutable::fromString('2016-05-12 22:37:46+02:00');
        $interval = new DateInterval('P1D');

        $dateTime = $dateTime->add($interval);

        self::assertInstanceOf(DateTimeImmutable::class, $dateTime);
        self::assertEquals('2016-05-13T22:37:46.000000+02:00', (string) $dateTime);
    }

    public function testSub()
    {
        $dateTime = DateTimeImmutable::fromString('2016-05-12 22:37:46+02:00');
        $interval = new DateInterval('P1D');

        $dateTime = $dateTime->sub($interval);

        self::assertInstanceOf(DateTimeImmutable::class, $dateTime);
        self::assertEquals('2016-05-11T22:37:46.000000+02:00', (string) $dateTime);
    }

    public function testDiff()
    {
        $dateTime1 = DateTimeImmutable::fromString('2017-01-10 12:20:11');
        $dateTime2 = DateTimeImmutable::fromString('2015-02-22 14:33:54');

        $interval = $dateTime1->diff($dateTime2);
        self::assertInstanceOf(DateInterval::class, $interval);
        self::assertEquals('P1Y10M15DT21H46M17S', (string) $interval);
    }

    public function testToString()
    {
        $dateTime = DateTimeImmutable::fromString('2016-05-12 22:37:46.123456-05:00');

        self::assertEquals('2016-05-12T22:37:46.123456-05:00', $dateTime->toString());
        self::assertEquals('2016-05-12T22:37:46.123456-05:00', sprintf('%s', $dateTime));
    }

    public function testJsonSerialize()
    {
        $dateTime = DateTimeImmutable::now();

        self::assertEquals('"' . $dateTime->toString() . '"', json_encode($dateTime));
    }

    public function testSerialize()
    {
        $dateTime = DateTimeImmutable::now();

        $serialized = serialize($dateTime);
        $unserializedDateTime = unserialize($serialized);

        self::assertEquals($dateTime, $unserializedDateTime);
        self::assertEquals($dateTime->getTimezone(), $unserializedDateTime->getTimezone());
    }
}