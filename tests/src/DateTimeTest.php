<?php
declare(strict_types=1);

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateInterval;
use Pauci\DateTime\DateTime;
use Pauci\DateTime\DateTimeFactory;
use Pauci\DateTime\Exception\InvalidTimeStringException;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFactory()
    {
        $defaultFactory = DateTime::getFactory();

        self::assertInstanceOf(DateTimeFactory::class, $defaultFactory);
    }

    public function testSetFactory()
    {
        $setFactory = new DateTimeFactory();
        DateTime::setFactory($setFactory);
        $getFactory = DateTime::getFactory();

        self::assertSame($setFactory, $getFactory);
    }

    public function testNow()
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

    public function testFromString()
    {
        $dateTime = DateTime::fromString('2017-12-02 02:20:03');

        self::assertInstanceOf(DateTime::class, $dateTime);
        self::assertEquals('2017-12-02T02:20:03+01:00', (string) $dateTime);
    }

    public function testFromInvalidString()
    {
        $this->expectException(InvalidTimeStringException::class);
        $this->expectExceptionMessage('Failed to parse time string (?) at position 0 (?): Unexpected character');

        DateTime::fromString('?');
    }

    public function testCreateFromFormat()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2016-05-16 14:09:10');

        self::assertInstanceOf(DateTime::class, $dateTime);
        self::assertEquals('2016-05-16T14:09:10+02:00', (string) $dateTime);
    }

    public function testCreateFromFormatWithTimeZone()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2016-05-16 14:09:10', new \DateTimeZone('utc'));

        self::assertInstanceOf(DateTime::class, $dateTime);
        self::assertEquals('2016-05-16T14:09:10+00:00', (string) $dateTime);
    }

    public function testCreateFromInvalidFormat()
    {
        $this->expectException(InvalidTimeStringException::class);
        $this->expectExceptionMessage('Failed to parse time string "2016-05-16 14:09:10" formatted as "invalid"');

        DateTime::createFromFormat('invalid', '2016-05-16 14:09:10', new \DateTimeZone('utc'));
    }

    public function testCreateFromMutable()
    {
        $dateTime = DateTime::createFromMutable(new \DateTime('2016-05-16 14:09:10'));

        self::assertInstanceOf(DateTime::class, $dateTime);
        self::assertEquals('2016-05-16T14:09:10+02:00', (string) $dateTime);

        $dateTime = DateTime::createFromMutable(new \DateTime('2016-05-16 14:09:10-04:00'));

        self::assertEquals('2016-05-16T14:09:10-04:00', (string) $dateTime);
    }

    public function testFromTimestamp()
    {
        $dateTime = DateTime::fromTimestamp(1463490311);
        self::assertEquals('2016-05-17T15:05:11+02:00', (string) $dateTime);

        $dateTimeTz = DateTime::fromTimestamp(1463490311, new \DateTimeZone('+0400'));
        self::assertEquals('2016-05-17T17:05:11+04:00', (string) $dateTimeTz);
    }

    public function testFromFloatTimestamp()
    {
        $dateTime = DateTime::fromFloatTimestamp(1512148033.000005);
        self::assertEquals('2017-12-01T18:07:13.000005+01:00', (string) $dateTime);

        $dateTimeTz = DateTime::fromFloatTimestamp(1512148033.876000, new \DateTimeZone('-0300'));
        self::assertEquals('2017-12-01T14:07:13.876000-03:00', (string) $dateTimeTz);

        $dateTimeNeg = DateTime::fromFloatTimestamp(-1, new \DateTimeZone('GMT'));
        self::assertEquals('1969-12-31T23:59:59+00:00', (string) $dateTimeNeg);

        $dateTimeNegFract = DateTime::fromFloatTimestamp(-0.000001, new \DateTimeZone('GMT'));
        self::assertEquals('1969-12-31T23:59:59.999999+00:00', (string) $dateTimeNegFract);
    }

    public function testFromDateTime()
    {
        $phpDateTime = new \DateTime('2016-05-16 14:32:51.678991');
        $dateTime = DateTime::fromDateTime($phpDateTime);

        self::assertInstanceOf(DateTime::class, $dateTime);
        self::assertEquals('2016-05-16T14:32:51.678991+02:00', (string) $dateTime);
    }

    public function testComparison()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = DateTime::fromString(
            '2016-05-12 22:37:46.000000',
            new \DateTimeZone('Europe/Bratislava')
        );

        self::assertEquals($dateTime1, $dateTime2);

        $dateTime3 = DateTime::fromString('2017-01-10 12:20:11');
        $dateTime4 = DateTime::fromString('2015-02-22 14:33:54');

        self::assertTrue($dateTime3 > $dateTime4);
        self::assertFalse($dateTime3 <= $dateTime4);

        $dateTime5 = DateTime::fromString('2016-05-12 22:37:46.000001');
        $dateTime6 = DateTime::fromString('2016-05-12 22:37:46');

        self::assertTrue($dateTime5 > $dateTime6);
        self::assertFalse($dateTime5 <= $dateTime6);
    }

    public function testAdd()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $interval = new DateInterval('P1D');

        $dateTime2 = $dateTime1->add($interval);

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2016-05-13T22:37:46+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testSub()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $interval = new DateInterval('P1D');

        $dateTime2 = $dateTime1->sub($interval);

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2016-05-11T22:37:46+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testModify()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = $dateTime1->modify('+1 day');

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2016-05-13T22:37:46+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testSetDate()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = $dateTime1->setDate(2011, 10, 22);

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2011-10-22T22:37:46+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testSetISODate()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = $dateTime1->setISODate(2011, 42, 6);

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2011-10-22T22:37:46+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testSetTime()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = $dateTime1->setTime(12, 10, 15);

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2016-05-12T12:10:15+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testSetTimestamp()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = $dateTime1->setTimestamp(1463490311);

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2016-05-17T15:05:11+02:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testSetTimezone()
    {
        $dateTime1 = DateTime::fromString('2016-05-12 22:37:46+02:00');
        $dateTime2 = $dateTime1->setTimezone(new \DateTimeZone('America/New_York'));

        self::assertInstanceOf(DateTime::class, $dateTime2);
        self::assertEquals('2016-05-12T16:37:46-04:00', (string) $dateTime2);

        // Immutability check
        self::assertEquals('2016-05-12T22:37:46+02:00', (string) $dateTime1);
    }

    public function testDiff()
    {
        $dateTime1 = DateTime::fromString('2017-01-10 12:20:11');
        $dateTime2 = DateTime::fromString('2015-02-22 14:33:54');

        $interval = $dateTime1->diff($dateTime2);

        self::assertInstanceOf(DateInterval::class, $interval);
        self::assertEquals('P1Y10M15DT21H46M17S', (string) $interval);
    }

    public function testInDefaultTimezone()
    {
        $dateTime = DateTime::fromString('2016-05-12T22:37:46.123456-05:00')->inDefaultTimezone();

        self::assertEquals('2016-05-13T05:37:46.123456+02:00', (string) $dateTime);
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
        $unserializedDateTime = unserialize($serialized, ['allowed_classes' => [DateTime::class]]);

        self::assertEquals($dateTime, $unserializedDateTime);
        self::assertEquals($dateTime->getTimezone(), $unserializedDateTime->getTimezone());
    }
}