<?php

namespace Pauci\DateTime;

interface DateTimeInterface extends \DateTimeInterface, \JsonSerializable
{
    /**
     * @return DateTimeInterface
     */
    public function inDefaultTimezone();

    /**
     * @return string
     */
    public function toString();
}
