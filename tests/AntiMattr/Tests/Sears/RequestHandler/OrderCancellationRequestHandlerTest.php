<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Model\OrderCancellation;
use AntiMattr\Sears\RequestHandler\OrderCancellationRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class OrderCancellationRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_oms_import_v1_order-cancel.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = new XMLBuilder();
        $this->requestHandler = new OrderCancellationRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = new Request();
        $collection = new ArrayCollection();

        $item = new OrderCancellation();
        $item->setPurchaseOrderId('7654321');
        $item->setPurchaseOrderDate($this->newDateTime('2012-12-01'));
        $item->setLineItemNumber('4');
        $item->setProductId('EXTPRODID000111');
        $item->setStatus('Canceled');
        $item->setReason('INVALID-METHOD-SHIPMENT');
        $collection->add($item);

        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }

}
