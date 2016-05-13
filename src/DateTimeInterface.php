<?php

namespace Pauci\DateTime;

interface DateTimeInterface extends \DateTimeInterface, \JsonSerializable
{
    /**
     * @return string
     */
    public function toString();
}
