<?php

namespace AntiMattr\Tests\Sears\Exception;

use AntiMattr\Sears\Exception\IntegrationException;
use AntiMattr\Tests\AntiMattrTestCase;

class IntegrationExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = new IntegrationException();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\Sears\Exception\AbstractSearsException', $this->exception);
    }
}
