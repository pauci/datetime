<?php

declare(strict_types=1);

namespace Pauci\DateTime;

interface DateIntervalInterface extends \Stringable, \JsonSerializable
{
    public function toString(): string;
}
