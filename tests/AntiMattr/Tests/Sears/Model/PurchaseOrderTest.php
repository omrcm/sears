<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\PurchaseOrder;
use AntiMattr\Tests\AntiMattrTestCase;

class PurchaseOrderTest extends AntiMattrTestCase
{
    private $purchaseOrder;

    protected function setUp()
    {
        $this->purchaseOrder = new PurchaseOrder();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\IdentifiableInterface', $this->purchaseOrder);
        $this->assertNull($this->purchaseOrder->getChannel());
        $this->assertNull($this->purchaseOrder->getCreatedAt());
        $this->assertNull($this->purchaseOrder->getEmail());
        $this->assertNull($this->purchaseOrder->getId());
        $this->assertNull($this->purchaseOrder->getLocationId());
        $this->assertNull($this->purchaseOrder->getOrderId());
        $this->assertNull($this->purchaseOrder->getShipAt());
        $this->assertNull($this->purchaseOrder->getShippingDetail());
        $this->assertNull($this->purchaseOrder->getSite());
        $this->assertNull($this->purchaseOrder->getUnit());
    }

    public function testSettersAndGetters()
    {
        $channel = 'channel';
        $this->purchaseOrder->setChannel($channel);
        $this->assertEquals($channel, $this->purchaseOrder->getChannel());

        $createdAt = $this->buildMock('DateTime');
        $this->purchaseOrder->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->purchaseOrder->getCreatedAt());

        $email = 'foo@bar.com';
        $this->purchaseOrder->setEmail($email);
        $this->assertEquals($email, $this->purchaseOrder->getEmail());

        $id = 'xxxxxx';
        $this->purchaseOrder->setId($id);
        $this->assertEquals($id, $this->purchaseOrder->getId());

        $locationId = 'yyyyyy';
        $this->purchaseOrder->setLocationId($locationId);
        $this->assertEquals($locationId, $this->purchaseOrder->getLocationId());

        $orderId = 'zzzzzz';
        $this->purchaseOrder->setOrderId($orderId);
        $this->assertEquals($orderId, $this->purchaseOrder->getOrderId());

        $shipAt = $this->buildMock('DateTime');
        $this->purchaseOrder->setShipAt($shipAt);
        $this->assertEquals($shipAt, $this->purchaseOrder->getShipAt());

        $shippingDetail = $this->buildMock('AntiMattr\Sears\Model\ShippingDetail');
        $this->purchaseOrder->setShippingDetail($shippingDetail);
        $this->assertEquals($shippingDetail, $this->purchaseOrder->getShippingDetail());

        $site = 'sears.com';
        $this->purchaseOrder->setSite($site);
        $this->assertEquals($site, $this->purchaseOrder->getSite());

        $unit = 'unit';
        $this->purchaseOrder->setUnit($unit);
        $this->assertEquals($unit, $this->purchaseOrder->getUnit());
    }
}
