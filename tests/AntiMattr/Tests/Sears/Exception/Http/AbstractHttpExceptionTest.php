<?php

namespace AntiMattr\Tests\Sears\Exception\Http;

use AntiMattr\Tests\AntiMattrTestCase;

class AbstractHttpExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = $this->buildMock('AntiMattr\Sears\Exception\Http\AbstractHttpException');
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\Sears\Exception\IntegrationException', $this->exception);
    }
}
