<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\OrderCancellation;
use AntiMattr\Tests\AntiMattrTestCase;

class OrderCancellationTest extends AntiMattrTestCase
{
    private $orderCancellation;

    protected function setUp()
    {
        $this->orderCancellation = new OrderCancellation();
    }

    public function testConstructor()
    {
        $this->assertNull($this->orderCancellation->getPurchaseOrderId());
        $this->assertNull($this->orderCancellation->getPurchaseOrderDate());
        $this->assertNull($this->orderCancellation->getLineItemNumber());
        $this->assertNull($this->orderCancellation->getLineItemId());
        $this->assertNotNull($this->orderCancellation->getReason());
        $this->assertNotNull($this->orderCancellation->getStatus());
    }

    public function testSettersAndGetters()
    {
        $purchaseId = 'purchaseId';
        $this->orderCancellation->setPurchaseOrderId($purchaseId);
        $this->assertSame($purchaseId, $this->orderCancellation->getPurchaseOrderId());

        $purchaseOrderDate = new \DateTime();
        $this->orderCancellation->setPurchaseOrderDate($purchaseOrderDate);
        $this->assertSame($purchaseOrderDate, $this->orderCancellation->getPurchaseOrderDate());

        $lineItemNumber = '3';
        $this->orderCancellation->setLineItemNumber($lineItemNumber);
        $this->assertSame(3, $this->orderCancellation->getLineItemNumber());

        $lineItemId = 'lineItemId';
        $this->orderCancellation->setLineItemId($lineItemId);
        $this->assertSame($lineItemId, $this->orderCancellation->getLineItemId());

        $reason = OrderCancellation::REASON_SKU;
        $this->orderCancellation->setReason($reason);
        $this->assertSame($reason, $this->orderCancellation->getReason());

        $status = OrderCancellation::STATUS_CANCELED;
        $this->orderCancellation->setStatus($status);
        $this->assertSame($status, $this->orderCancellation->getStatus());
    }
}
