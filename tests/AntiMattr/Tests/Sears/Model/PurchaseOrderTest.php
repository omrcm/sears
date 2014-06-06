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
        $this->assertNull($this->purchaseOrder->getBalance());
        $this->assertNull($this->purchaseOrder->getChannel());
        $this->assertNull($this->purchaseOrder->getCommission());
        $this->assertNull($this->purchaseOrder->getCreatedAt());
        $this->assertNull($this->purchaseOrder->getEmail());
        $this->assertNull($this->purchaseOrder->getId());
        $this->assertNotNull($this->purchaseOrder->getItems());
        $this->assertNull($this->purchaseOrder->getLocationId());
        $this->assertNull($this->purchaseOrder->getName());
        $this->assertNull($this->purchaseOrder->getOrderId());
        $this->assertNull($this->purchaseOrder->getShipAt());
        $this->assertNotNull($this->purchaseOrder->getShippingDetail());
        $this->assertNull($this->purchaseOrder->getShippingHandling());
        $this->assertNull($this->purchaseOrder->getSite());
        $this->assertNull($this->purchaseOrder->getStatus());
        $this->assertNull($this->purchaseOrder->getUnit());
        $this->assertNull($this->purchaseOrder->getTotal());
    }

    public function testSettersAndGetters()
    {
        $balance = 100.00;
        $this->purchaseOrder->setBalance($balance);
        $this->assertEquals($balance, $this->purchaseOrder->getBalance());

        $channel = 'channel';
        $this->purchaseOrder->setChannel($channel);
        $this->assertEquals($channel, $this->purchaseOrder->getChannel());

        $commission = 'commission';
        $this->purchaseOrder->setCommission($commission);
        $this->assertEquals($commission, $this->purchaseOrder->getCommission());

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

        $name = 'Matt Fitz';
        $this->purchaseOrder->setName($name);
        $this->assertEquals($name, $this->purchaseOrder->getName());

        $orderId = 'zzzzzz';
        $this->purchaseOrder->setOrderId($orderId);
        $this->assertEquals($orderId, $this->purchaseOrder->getOrderId());

        $shipAt = $this->buildMock('DateTime');
        $this->purchaseOrder->setShipAt($shipAt);
        $this->assertEquals($shipAt, $this->purchaseOrder->getShipAt());

        $shippingDetail = $this->buildMock('AntiMattr\Sears\Model\ShippingDetail');
        $this->purchaseOrder->setShippingDetail($shippingDetail);
        $this->assertEquals($shippingDetail, $this->purchaseOrder->getShippingDetail());

        $shippingHandling = 100.00;
        $this->purchaseOrder->setShippingHandling($shippingHandling);
        $this->assertEquals($shippingHandling, $this->purchaseOrder->getShippingHandling());

        $site = 'sears.com';
        $this->purchaseOrder->setSite($site);
        $this->assertEquals($site, $this->purchaseOrder->getSite());

        $status = 'status';
        $this->purchaseOrder->setStatus($status);
        $this->assertEquals($status, $this->purchaseOrder->getStatus());

        $tax = 10.00;
        $this->purchaseOrder->setTax($tax);
        $this->assertEquals($tax, $this->purchaseOrder->getTax());

        $total = 100.00;
        $this->purchaseOrder->setTotal($total);
        $this->assertEquals($total, $this->purchaseOrder->getTotal());

        $unit = 'unit';
        $this->purchaseOrder->setUnit($unit);
        $this->assertEquals($unit, $this->purchaseOrder->getUnit());
    }
}
