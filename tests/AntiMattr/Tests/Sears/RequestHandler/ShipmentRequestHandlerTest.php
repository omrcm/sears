<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\RequestHandler\ShipmentRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use Doctrine\Common\Collections\ArrayCollection;

class ShipmentRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_oms_import_v5_asn.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = $this->buildMock('AntiMattr\Sears\Format\XMLBuilder');
        $this->requestHandler = new ShipmentRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = $this->buildMock('Buzz\Message\Request');
        $collection = new ArrayCollection();
        $item = $this->buildMock('AntiMattr\Sears\Model\Shipment');
        $collection->add($item);
        $simpleXMLElement = $this->getMock('Iterator', array('count', 'current', 'next', 'key', 'valid', 'rewind', 'asXML'));

        $item->expects($this->once())
            ->method('toArray');

        $this->xmlBuilder->expects($this->once())
            ->method('setRoot')
            ->with('shipment-feed')
            ->will($this->returnValue($this->xmlBuilder));

        $this->xmlBuilder->expects($this->once())
            ->method('setData')
            ->will($this->returnValue($this->xmlBuilder));

        $this->xmlBuilder->expects($this->once())
            ->method('setData')
            ->will($this->returnValue($this->xmlBuilder));

        $this->xmlBuilder->expects($this->once())
            ->method('create')
            ->will($this->returnValue($simpleXMLElement));

        $simpleXMLElement->expects($this->once())
            ->method('asXML')
            ->will($this->returnValue(self::$xml));

        $request->expects($this->once())
            ->method('setContent')
            ->with(self::$xml);

        $this->requestHandler->bindCollection($request, $collection);
    }

}
