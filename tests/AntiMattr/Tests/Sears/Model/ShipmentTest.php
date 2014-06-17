<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\Shipment;
use AntiMattr\Tests\AntiMattrTestCase;

class ShipmentTest extends AntiMattrTestCase
{
    private $shipment;

    protected function setUp()
    {
        $this->shipment = new Shipment();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\IdentifiableInterface', $this->shipment);
        $this->assertInstanceOf('AntiMattr\Sears\Model\RequestHandlerInterface', $this->shipment);
        $this->assertNull($this->shipment->getPurchaseOrderId());
        $this->assertNull($this->shipment->getPurchaseOrderDate());
        $this->assertNull($this->shipment->getLineItemNumber());
        $this->assertNull($this->shipment->getLineItemId());
        $this->assertNull($this->shipment->getCarrier());
        $this->assertNull($this->shipment->getMethod());
        $this->assertNull($this->shipment->getId());
        $this->assertNull($this->shipment->getTrackingNumber());
        $this->assertNull($this->shipment->getQuantity());
    }

    public function testSettersAndGetters()
    {
        $purchaseId = 'purchaseId';
        $this->shipment->setPurchaseOrderId($purchaseId);
        $this->assertSame($purchaseId, $this->shipment->getPurchaseOrderId());

        $purchaseOrderDate = new \DateTime();
        $this->shipment->setPurchaseOrderDate($purchaseOrderDate);
        $this->assertSame($purchaseOrderDate, $this->shipment->getPurchaseOrderDate());

        $lineItemNumber = '3';
        $this->shipment->setLineItemNumber($lineItemNumber);
        $this->assertSame(3, $this->shipment->getLineItemNumber());

        $lineItemId = 'lineItemId';
        $this->shipment->setLineItemId($lineItemId);
        $this->assertSame($lineItemId, $this->shipment->getLineItemId());

        $carrier = 'UPS';
        $this->shipment->setCarrier($carrier);
        $this->assertEquals($carrier, $this->shipment->getCarrier());

        $method = 'Ground';
        $this->shipment->setMethod($method);
        $this->assertEquals($method, $this->shipment->getMethod());

        $shipAt = new \DateTime();
        $this->shipment->setShipAt($shipAt);
        $this->assertSame($shipAt, $this->shipment->getShipAt());

        $quantity = '3';
        $this->shipment->setQuantity($quantity);
        $this->assertSame(3, $this->shipment->getQuantity());
    }
}
