<?php

namespace AntiMattr\Tests\Sears\Exception\Http;

use AntiMattr\Tests\AntiMattrTestCase;

class BadRequestExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = $this->buildMock('AntiMattr\Sears\Exception\Http\BadRequestException');
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\Sears\Exception\Http\AbstractHttpException', $this->exception);
    }
}
