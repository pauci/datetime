<?php

declare(strict_types=1);

namespace Pauci\DateTime;

use Psr\Clock\ClockInterface as PsrClockInterface;

interface ClockInterface extends PsrClockInterface
{
    public function now(): DateTime;
}
