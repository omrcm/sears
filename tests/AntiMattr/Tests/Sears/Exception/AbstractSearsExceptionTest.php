<?php

namespace AntiMattr\Tests\Sears\Exception;

use AntiMattr\Sears\Exception\AbstractSearsException;
use AntiMattr\Tests\AntiMattrTestCase;

class AbstractSearsExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = new AbstractSearsExceptionStub();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\RuntimeException', $this->exception);
    }
}

class AbstractSearsExceptionStub extends AbstractSearsException
{
}
