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
}
