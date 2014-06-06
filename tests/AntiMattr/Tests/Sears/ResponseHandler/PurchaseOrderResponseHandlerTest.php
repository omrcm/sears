<?php

namespace AntiMattr\Tests\Sears\ResponseHandler;

use AntiMattr\Sears\ResponseHandler\PurchaseOrderResponseHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Response;

class PurchaseOrderResponseHandlerTest extends AntiMattrTestCase
{
    private $responseHandler;

    protected function setUp()
    {
        $this->responseHandler = new PurchaseOrderResponseHandlerStub();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface', $this->responseHandler);
    }

    /**
     * @expectedException AntiMattr\Sears\Exception\Http\BadRequestException
     */
    public function testBindThrowsBadRequestException()
    {
        $response = $this->buildMock('Buzz\Message\Response');
        $object = $this->getMock('AntiMattr\Sears\Model\PurchaseOrder');
        $content = new \stdClass();
        $content->foo = 'bar';
        $this->responseHandler->setContent($content);

        $exception = $this->buildMock('AntiMattr\Sears\Exception\Http\BadRequestException');

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $processor = $this->responseHandler->bind($response, $object);
    }

    public function testBind()
    {
        $response = $this->buildMock('Buzz\Message\Response');
        $object = $this->getMock('AntiMattr\Sears\Model\PurchaseOrder');
        $content = new \stdClass();
        $content->foo = 'bar';
        $this->responseHandler->setContent($content);

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $processor = $this->responseHandler->bind($response, $object);
    }
}

class PurchaseOrderResponseHandlerStub extends PurchaseOrderResponseHandler
{
    private $content;

    public function setContent($content)
    {
        $this->content = $content;
    }

    protected function getContent(Response $response)
    {
        return $this->content;
    }
}
