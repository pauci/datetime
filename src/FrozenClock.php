<?php

declare(strict_types=1);

namespace Pauci\DateTime;

class FrozenClock implements ClockInterface
{
    private DateTimeInterface $now;

    public function __construct(DateTimeInterface $now = null)
    {
        $this->now = $now ?? new DateTime();
    }

    public function set(DateTimeInterface $now): void
    {
        $this->now = $now;
    }

    public function modify(string $modifier): void
    {
        $now = $this->now->modify($modifier);
        \assert($now instanceof DateTime);

        $this->now = $now;
    }

    public function now(): DateTimeInterface
    {
        return $this->now;
    }
}
