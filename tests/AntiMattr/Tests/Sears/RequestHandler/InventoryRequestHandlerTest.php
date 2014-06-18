<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\RequestHandler\InventoryRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use Doctrine\Common\Collections\ArrayCollection;

class InventoryRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_inventory_import_v1_dss-inventory.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = $this->buildMock('AntiMattr\Sears\Format\XMLBuilder');
        $this->requestHandler = new InventoryRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = $this->buildMock('Buzz\Message\Request');
        $collection = new ArrayCollection();
        $item = $this->buildMock('AntiMattr\Sears\Model\Inventory');
        $collection->add($item);
        $simpleXMLElement = $this->getMock('Iterator', array('count', 'current', 'next', 'key', 'valid', 'rewind', 'asXML'));

        $item->expects($this->once())
            ->method('toArray');

        $this->xmlBuilder->expects($this->once())
            ->method('setRoot')
            ->with('dss-inventory-feed')
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
