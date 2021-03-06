<?php

namespace AntiMattr\Tests\Sears\ResponseHandler;

use AntiMattr\Sears\ResponseHandler\PurchaseOrderResponseHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Response;
use Doctrine\Common\Collections\ArrayCollection;

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
    public function testBindCollectionThrowsBadRequestException()
    {
        $response = $this->buildMock('Buzz\Message\Response');
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $content = self::$xml;
        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($content));

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $this->responseHandler->bindCollection($response, $collection);
    }

    public function testBindFindsNoPurchaseOrders()
    {
        $response = $this->buildMock('Buzz\Message\Response');
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/api_oms_purchaseorder_v4.xml');

        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($xml));

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $this->responseHandler->bindCollection($response, $collection);

        $this->assertEquals(0, $collection->count());
    }

    public function testBind()
    {
        $response = $this->buildMock('Buzz\Message\Response');
        $collection = new ArrayCollection();
        $content = self::$xml;

        $response->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue($content));

        $response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $this->responseHandler->bindCollection($response, $collection);

        $count = $collection->count();

        $this->assertEquals(2, $count);

        $purchaseOrder1 = $collection[0];
        $purchaseOrder2 = $collection[1];

        foreach ($collection as $purchaseOrder) {
            $this->assertInstanceOf('AntiMattr\Sears\Model\PurchaseOrder', $purchaseOrder);
        }
        $this->assertEquals(15.15, $purchaseOrder1->getBalance());
        $this->assertEquals('FBM', $purchaseOrder1->getChannel());
        $this->assertEquals(5.10, $purchaseOrder1->getCommission());
        $this->assertEquals('2011-10-01 20:45:48 CST', $purchaseOrder1->getCreatedAt()->format('Y-m-d H:i:s e'));
        $this->assertEquals('masked-email@seller.sears.com', $purchaseOrder1->getEmail());
        $this->assertEquals('1410048', $purchaseOrder1->getId());
        $this->assertEquals('27', $purchaseOrder1->getLocationId());
        $this->assertEquals('John1 Sender', $purchaseOrder1->getName());
        $this->assertEquals('657402988', $purchaseOrder1->getOrderId());
        $this->assertEquals('2011-10-05 23:59:59 CST', $purchaseOrder1->getShipAt()->format('Y-m-d H:i:s e'));
        $this->assertEquals(6.25, $purchaseOrder1->getShippingHandling());
        $this->assertEquals('sears', $purchaseOrder1->getSite());
        $this->assertEquals('New', $purchaseOrder1->getStatus());
        $this->assertEquals(3.45, $purchaseOrder1->getTax());
        $this->assertEquals(15, $purchaseOrder1->getTotal());
        $this->assertEquals('9301', $purchaseOrder1->getUnit());

        $shippingDetail = $purchaseOrder1->getShippingDetail();

        $this->assertNotNull($shippingDetail);
        $this->assertEquals('US', $shippingDetail->getCountry());
        $this->assertEquals('5b3c127ecadf3c6bf5123d55d057c24b', $shippingDetail->getId());
        $this->assertEquals('city', $shippingDetail->getLocality());
        $this->assertEquals('Ground', $shippingDetail->getMethod());
        $this->assertEquals('John1 Receiver', $shippingDetail->getName());
        $this->assertEquals('phone', $shippingDetail->getPhone());
        $this->assertEquals('zipcode', $shippingDetail->getPostalCode());
        $this->assertEquals('NY', $shippingDetail->getRegion());
        $this->assertEquals('address', $shippingDetail->getStreetAddress());

        $items1 = $purchaseOrder1->getItems();
        $count1 = $items1->count();

        $this->assertEquals(1, $count1);

        $items = $purchaseOrder2->getItems();
        $count = $items->count();

        $this->assertEquals(2, $count);

        $item1 = $items[0];

        foreach ($items as $item) {
            $this->assertInstanceOf('AntiMattr\Sears\Model\LineItem', $item);
            $this->assertSame($purchaseOrder2, $item->getPurchaseOrder());
        }

        $this->assertEquals(3, $item->getNumber());
        $this->assertEquals('53a25d48cea2248b2300003f', $item->getProductId());
        $this->assertEquals('item name', $item->getProductName());
        $this->assertEquals('None', $item->getHandlingInstructions());
        $this->assertEquals('p', $item->getHandlingInd());
        $this->assertEquals(25.00, $item->getPricePerUnit());
        $this->assertEquals(3.75, $item->getCommissionPerUnit());
        $this->assertEquals(2, $item->getQuantity());
        $this->assertEquals(6.25, $item->getShippingHandling());
    }
}
