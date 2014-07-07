<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Model\OrderReturn;
use AntiMattr\Sears\RequestHandler\OrderReturnRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class OrderReturnRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_oms_import_v1_dss-order-return-v1.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = new XMLBuilder();
        $this->requestHandler = new OrderReturnRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    /**
     * @expectedException \AntiMattr\Sears\Exception\IntegrationException
     */
    public function testBindCollectionWithoutCreatedAtThrowsIntegrationException()
    {
        $request = new Request();
        $collection = new ArrayCollection();
        $item = new OrderReturn();
        $collection->add($item);

        $item->setPurchaseOrderId('1379156');
        $item->setPurchaseOrderDate($this->newDateTime('2014-02-05'));
        $item->setLineItemNumber('2');
        $item->setProductId('DNA02218-66');
        $item->setId('1111222345');
        $item->setReason('GENERAL-ADJUSTMENT');
        $item->setCreatedAt($this->newDateTime('2013-07-10'));
        $item->setQuantity('1');
        $item->setMemo('Wrong shipping method');

        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }

    public function testBindCollection()
    {
        $request = new Request();
        $collection = new ArrayCollection();
        $item = new OrderReturn();

        $item->setPurchaseOrderId('1379156');
        $item->setPurchaseOrderDate($this->newDateTime('2014-02-05'));
        $item->setLineItemNumber('2');
        $item->setProductId('DNA02218-66');
        $item->setId('1111222345');
        $item->setReason('GENERAL-ADJUSTMENT');
        $item->setCreatedAt($this->newDateTime('2013-07-10'));
        $item->setQuantity('1');
        $item->setMemo('Wrong shipping method');
        $collection->add($item);

        $this->requestHandler->setCreatedAt($this->newDateTime('2013-07-10T21:01:41'));
        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }

}
