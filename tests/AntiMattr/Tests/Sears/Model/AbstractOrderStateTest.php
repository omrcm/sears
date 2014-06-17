<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\AbstractOrderState;
use AntiMattr\Tests\AntiMattrTestCase;

class AbstractOrderStateTest extends AntiMattrTestCase
{
    private $orderState;

    protected function setUp()
    {
        $this->orderState = new AbstractOrderStateStub();
    }

    public function testConstructor()
    {
        $this->assertNull($this->orderState->getPurchaseOrderId());
        $this->assertNull($this->orderState->getPurchaseOrderDate());
        $this->assertNull($this->orderState->getLineItemNumber());
        $this->assertNull($this->orderState->getLineItemId());
        $this->assertNotNull($this->orderState->getReason());
        $this->assertNotNull($this->orderState->getStatus());
    }

    public function testSettersAndGetters()
    {
        $purchaseId = 'purchaseId';
        $this->orderState->setPurchaseOrderId($purchaseId);
        $this->assertSame($purchaseId, $this->orderState->getPurchaseOrderId());

        $purchaseOrderDate = new \DateTime();
        $this->orderState->setPurchaseOrderDate($purchaseOrderDate);
        $this->assertSame($purchaseOrderDate, $this->orderState->getPurchaseOrderDate());

        $lineItemNumber = '3';
        $this->orderState->setLineItemNumber($lineItemNumber);
        $this->assertSame(3, $this->orderState->getLineItemNumber());

        $lineItemId = 'lineItemId';
        $this->orderState->setLineItemId($lineItemId);
        $this->assertSame($lineItemId, $this->orderState->getLineItemId());

        $reason = AbstractOrderState::REASON_SKU;
        $this->orderState->setReason($reason);
        $this->assertSame($reason, $this->orderState->getReason());

        $status = AbstractOrderState::STATUS_CANCELED;
        $this->orderState->setStatus($status);
        $this->assertSame($status, $this->orderState->getStatus());
    }
}

class AbstractOrderStateStub extends AbstractOrderState
{
    public function toArray()
    {
        return;
    }
}
