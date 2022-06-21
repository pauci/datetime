<?php

declare(strict_types=1);

namespace Pauci\DateTime\Test;

use Pauci\DateTime\SystemClock;
use PHPUnit\Framework\TestCase;

final class SystemClockTest extends TestCase
{
    public function testItWorks(): void
    {
        $clock = new SystemClock();
        $now = $clock->now();

        self::assertNotSame($now, $clock->now());
    }
}
