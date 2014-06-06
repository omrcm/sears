<?php

namespace AntiMattr\Tests\Sears\ResponseHandler;

use AntiMattr\Sears\ResponseHandler\PurchaseOrderResponseHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Response;

class PurchaseOrderResponseHandlerTest extends AntiMattrTestCase
{
    private $responseHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_oms_export_v4_purchase-order.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->responseHandler = new PurchaseOrderResponseHandler();
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
        $content = self::$xml;
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($content));

        $exception = $this->buildMock('AntiMattr\Sears\Exception\Http\BadRequestException');

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $this->responseHandler->bind($response, $object);
    }

    public function testBind()
    {
        $response = $this->buildMock('Buzz\Message\Response');
        $object = $this->getMock('AntiMattr\Sears\Model\PurchaseOrder');
        $content = self::$xml;
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($content));

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $this->responseHandler->bind($response, $object);
    }
}
