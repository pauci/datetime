<?php
declare(strict_types=1);

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateInterval;
use PHPUnit\Framework\TestCase;

class DateIntervalTest extends TestCase
{
    public static function dateIntervalStrings(): array
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
     */
    public function testFromDateInterval(string $intervalSpec, array $parts): void
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
     * Test for extreme case when diff between winter and daylight saving time returns interval with negative hour
     */
    public function testFromDateIntervalWithNegativeHour(): void
    {
        if (PHP_VERSION_ID >= 80100) {
            self::markTestSkipped();
        }
        $phpDate1 = new \DateTimeImmutable('2016-11-22 11:00:00');
        $phpDate2 = new \DateTimeImmutable('2016-08-22 12:00:00');
        $phpInterval = $phpDate1->diff($phpDate2);

        $interval = DateInterval::fromDateInterval($phpInterval);

        self::assertEquals('P2M30DT23H', (string) $interval);
    }

    /**
     * @dataProvider dateIntervalStrings
     */
    public function testFromString(string $intervalSpec, array $parts): void
    {
        $interval = DateInterval::fromString($intervalSpec);

        self::assertEquals($parts[0], $interval->y);
        self::assertEquals($parts[1], $interval->m);
        self::assertEquals($parts[2], $interval->d);
        self::assertEquals($parts[3], $interval->h);
        self::assertEquals($parts[4], $interval->i);
        self::assertEquals($parts[5], $interval->s);
    }

    /**
     * @dataProvider dateIntervalStrings
     */
    public function testToString(string $intervalSpec, array $parts): void
    {
        $interval = DateInterval::fromParts($parts[0], $parts[1], $parts[2], $parts[3], $parts[4], $parts[5]);

        self::assertEquals($intervalSpec, (string) $interval);
    }

    /**
     * @dataProvider dateIntervalStrings
     */
    public function testJsonEncode(string $intervalSpec, array $parts): void
    {
        $interval = DateInterval::fromParts($parts[0], $parts[1], $parts[2], $parts[3], $parts[4], $parts[5]);

        self::assertEquals('"' . $intervalSpec . '"', json_encode($interval));
    }
}