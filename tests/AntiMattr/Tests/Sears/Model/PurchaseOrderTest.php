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
        $this->assertSame($balance, $this->purchaseOrder->getBalance());

        $balanceString = '100.56';
        $this->purchaseOrder->setBalance($balanceString);
        $this->assertSame(100.56, $this->purchaseOrder->getBalance());

        $channel = 'channel';
        $this->purchaseOrder->setChannel($channel);
        $this->assertSame($channel, $this->purchaseOrder->getChannel());

        $commission = 66.00;
        $this->purchaseOrder->setCommission($commission);
        $this->assertSame($commission, $this->purchaseOrder->getcommission());

        $commissionString = '66.56';
        $this->purchaseOrder->setCommission($commissionString);
        $this->assertSame(66.56, $this->purchaseOrder->getcommission());

        $createdAt = $this->buildMock('DateTime');
        $this->purchaseOrder->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $this->purchaseOrder->getCreatedAt());

        $email = 'foo@bar.com';
        $this->purchaseOrder->setEmail($email);
        $this->assertSame($email, $this->purchaseOrder->getEmail());

        $id = 'xxxxxx';
        $this->purchaseOrder->setId($id);
        $this->assertSame($id, $this->purchaseOrder->getId());

        $locationId = 'yyyyyy';
        $this->purchaseOrder->setLocationId($locationId);
        $this->assertSame($locationId, $this->purchaseOrder->getLocationId());

        $name = 'Matt Fitz';
        $this->purchaseOrder->setName($name);
        $this->assertSame($name, $this->purchaseOrder->getName());

        $orderId = 'zzzzzz';
        $this->purchaseOrder->setOrderId($orderId);
        $this->assertSame($orderId, $this->purchaseOrder->getOrderId());

        $shipAt = $this->buildMock('DateTime');
        $this->purchaseOrder->setShipAt($shipAt);
        $this->assertSame($shipAt, $this->purchaseOrder->getShipAt());

        $shippingDetail = $this->buildMock('AntiMattr\Sears\Model\ShippingDetail');
        $this->purchaseOrder->setShippingDetail($shippingDetail);
        $this->assertSame($shippingDetail, $this->purchaseOrder->getShippingDetail());

        $shippingHandling = 100.00;
        $this->purchaseOrder->setShippingHandling($shippingHandling);
        $this->assertSame($shippingHandling, $this->purchaseOrder->getShippingHandling());

        $shippingHandlingString = '900.11';
        $this->purchaseOrder->setShippingHandling($shippingHandlingString);
        $this->assertSame(900.11, $this->purchaseOrder->getShippingHandling());

        $site = 'sears.com';
        $this->purchaseOrder->setSite($site);
        $this->assertSame($site, $this->purchaseOrder->getSite());

        $status = 'status';
        $this->purchaseOrder->setStatus($status);
        $this->assertSame($status, $this->purchaseOrder->getStatus());

        $tax = 10.00;
        $this->purchaseOrder->setTax($tax);
        $this->assertSame($tax, $this->purchaseOrder->getTax());

        $taxString = '10.999999';
        $this->purchaseOrder->setTax($taxString);
        $this->assertSame(10.999999, $this->purchaseOrder->getTax());

        $total = 100.00;
        $this->purchaseOrder->setTotal($total);
        $this->assertSame($total, $this->purchaseOrder->getTotal());

        $totalString = '88.44';
        $this->purchaseOrder->setTotal($totalString);
        $this->assertSame(88.44, $this->purchaseOrder->getTotal());

        $unit = 'unit';
        $this->purchaseOrder->setUnit($unit);
        $this->assertSame($unit, $this->purchaseOrder->getUnit());
    }
}
