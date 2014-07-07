<?php

namespace AntiMattr\Tests;

abstract class AntiMattrTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildMock($class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /*
     * Returns DateTime with timezone set. If timezone is not set, you'll get the following error:
     * Exception: DateTime::__construct(): It is not safe to rely on the system's timezone settings.
     * You are *required* to use the date.timezone setting or the date_default_timezone_set() function.
     */
    protected function newDateTime($time = null)
    {
        $time = $time ? : 'now';
        return new \DateTime($time, new \DateTimeZone('UTC'));
    }
}
