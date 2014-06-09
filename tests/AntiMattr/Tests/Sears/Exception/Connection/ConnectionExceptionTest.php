<?php

namespace AntiMattr\Tests\Sears\Exception\Connection;

use AntiMattr\Tests\AntiMattrTestCase;

class ConnectionExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = $this->buildMock('AntiMattr\Sears\Exception\Connection\ConnectionException');
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\Sears\Exception\IntegrationException', $this->exception);
    }
}
