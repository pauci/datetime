<?php

namespace Pauci\DateTime\Test;

use Pauci\DateTime\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testImmutability()
    {

    }

    public function testMicroseconds()
    {

    }

    public function testToString()
    {
        $dateTime = new DateTime('2016-05-12 22:37:46');

        self::assertEquals('2016-05-12T22:37:46+00:00', (string) $dateTime);
    }

    public function testJsonSerialize()
    {
        
    }
}