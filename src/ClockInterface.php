<?php

declare(strict_types=1);

namespace Pauci\DateTime;

interface ClockInterface
{
    public function now(): DateTimeInterface;
}
