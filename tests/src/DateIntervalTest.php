<?php

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateInterval;

class DateIntervalTest extends \PHPUnit_Framework_TestCase
{
    public static function dateIntervalStrings()
    {
        return [
            ['P11Y12M13DT14H15M16S', [11, 12, 13, 14, 15, 16]],
            ['P11Y12M13D', [11, 12, 13, 0, 0, 0]],
            ['PT14H15M16S', [0, 0, 0, 14, 15, 16]],
            ['P11YT16S', [11, 0, 0, 0, 0, 16]],
            ['P12MT15M', [0, 12, 0, 0, 15, 0]],
            ['P13DT14H', [0, 0, 13, 14, 0, 0]],
            ['P10M', [0, 10, 0, 0, 0, 0]],
            ['PT10M', [0, 0, 0, 0, 10, 0]],
            ['P0D', [0, 0, 0, 0, 0, 0]],
        ];
    }

    /**
     * @dataProvider dateIntervalStrings
     * @param string $intervalSpec
     * @param array $parts
     */
    public function testFromDateInterval($intervalSpec, array $parts)
    {
        $interval = DateInterval::fromDateInterval(new \DateInterval($intervalSpec));

        self::assertInstanceOf(DateInterval::class, $interval);

        self::assertEquals($parts[0], $interval->y);
        self::assertEquals($parts[1], $interval->m);
        self::assertEquals($parts[2], $interval->d);
        self::assertEquals($parts[3], $interval->h);
        self::assertEquals($parts[4], $interval->i);
        self::assertEquals($parts[5], $interval->s);
    }

    /**
     * @dataProvider dateIntervalStrings
     * @param string $intervalSpec
     * @param array $parts
     */
    public function testFromString($intervalSpec, array $parts)
    {
        $interval = DateInterval::fromString($intervalSpec);

        self::assertInstanceOf(DateInterval::class, $interval);

        self::assertEquals($parts[0], $interval->y);
        self::assertEquals($parts[1], $interval->m);
        self::assertEquals($parts[2], $interval->d);
        self::assertEquals($parts[3], $interval->h);
        self::assertEquals($parts[4], $interval->i);
        self::assertEquals($parts[5], $interval->s);
    }

    /**
     * @dataProvider dateIntervalStrings
     * @param string $intervalSpec
     * @param array $parts
     */
    public function testToString($intervalSpec, array $parts)
    {
        $interval = DateInterval::fromParts($parts[0], $parts[1], $parts[2], $parts[3], $parts[4], $parts[5]);

        self::assertInstanceOf(DateInterval::class, $interval);

        self::assertEquals($intervalSpec, (string) $interval);
    }

    /**
     * @dataProvider dateIntervalStrings
     * @param string $intervalSpec
     * @param array $parts
     */
    public function testJsonEncode($intervalSpec, array $parts)
    {
        $interval = DateInterval::fromParts($parts[0], $parts[1], $parts[2], $parts[3], $parts[4], $parts[5]);

        self::assertEquals('"' . $intervalSpec . '"', json_encode($interval));
    }
}