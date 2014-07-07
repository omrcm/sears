<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Model\Shipment;
use AntiMattr\Sears\RequestHandler\ShipmentRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use DateTime;
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
        $this->xmlBuilder = new XMLBuilder();
        $this->requestHandler = new ShipmentRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = new Request();
        $collection = new ArrayCollection();
        $item = new Shipment();

        $item->setId('00601780002');
        $item->setPurchaseOrderId('0060180');
        $item->setPurchaseOrderDate($this->newDateTime('2009-09-26'));
        $item->setTrackingNumber('UPS1XXX');
        $item->setShipAt($this->newDateTime('2001-01-01'));
        $item->setCarrier('UPS');
        $item->setMethod('GROUND');
        $item->setLineItemNumber('1');
        $item->setProductId('AB12345678912345456789123456789CD');
        $item->setQuantity('1');
        $collection->add($item);

        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }

}
