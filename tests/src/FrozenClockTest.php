<?php

declare(strict_types=1);

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateTime;
use Pauci\DateTime\FrozenClock;
use PHPUnit\Framework\TestCase;

final class FrozenClockTest extends TestCase
{
    public function testItIsFrozen(): void
    {
        $clock = new FrozenClock();
        $now = $clock->now();

        self::assertSame($now, $clock->now());
    }

    public function testItCanBeInitialized(): void
    {
        $now = new DateTime();
        $clock = new FrozenClock($now);

        self::assertSame($now, $clock->now());
    }

    public function testItCanBeOverriden(): void
    {
        $now = new DateTime();

        $clock = new FrozenClock();
        $clock->set($now);

        self::assertSame($now, $clock->now());
    }

    public function testItCanBeModified(): void
    {
        $clock = new FrozenClock();

        $now = $clock->now();
        $clock->modify('+1 day');
        $nextDay = $clock->now();

        self::assertEquals('P1D', $nextDay->diff($now)->toString());
    }

    public function testItFailsToModify(): void
    {
        $clock = new FrozenClock();

        $this->expectError();
        $this->expectErrorMessage('DateTimeImmutable::modify(): Failed to parse time string (foo) at position 0 (f): The timezone could not be found in the database');

        $clock->modify('foo');
    }
}
