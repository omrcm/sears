<?php

namespace AntiMattr\Tests;

use AntiMattr\TestCase\AntiMattrTestCase as BaseTestCase;

abstract class AntiMattrTestCase extends BaseTestCase
{
    /*
     * Returns DateTime with timezone set. If timezone is not set, you'll get the following error:
     * Exception: DateTime::__construct(): It is not safe to rely on the system's timezone settings.
     * You are *required* to use the date.timezone setting or the date_default_timezone_set() function.
     */
    protected function newDateTime($time = null)
    {
        $time = $time ? : 'now';
        return new \DateTime($time, new \DateTimeZone('CST'));
    }
}
