<?php

namespace AntiMattr\Tests\Sears\Exception;

use AntiMattr\Sears\Exception\ClientException;
use AntiMattr\Tests\AntiMattrTestCase;

class ClientExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = new ClientException();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\Sears\Exception\AbstractSearsException', $this->exception);
    }
}
