<?php

declare(strict_types=1);

namespace Pauci\DateTime;

class FrozenClock implements ClockInterface
{
    private DateTime $now;

    public function __construct(DateTime $now = null)
    {
        $this->now = $now ?? new DateTime();
    }

    public function set(DateTime $now): void
    {
        $this->now = $now;
    }

    public function modify(string $modifier): void
    {
        $now = $this->now->modify($modifier);
        \assert($now instanceof DateTime);

        $this->now = $now;
    }

    public function now(): DateTime
    {
        return $this->now;
    }
}
