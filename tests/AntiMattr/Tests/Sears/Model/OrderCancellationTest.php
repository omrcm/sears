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
        $this->assertInstanceOf('AntiMattr\Sears\Model\AbstractOrderState', $this->orderCancellation);
        $this->assertEquals(OrderCancellation::REASON_OTHER, $this->orderCancellation->getReason());
        $this->assertEquals(OrderCancellation::STATUS_CANCELED, $this->orderCancellation->getStatus());
    }

    /**
     * @expectedException \AntiMattr\Sears\Exception\IntegrationException
     */
    public function testToArrayThrowsIntegrationException()
    {
        $this->orderCancellation->setPurchaseOrderDate($this->newDateTime());
        $this->orderCancellation->toArray();
    }

    public function testToArray()
    {
        $purchaseId = 'purchaseId';
        $this->orderCancellation->setPurchaseOrderId($purchaseId);
        $this->assertSame($purchaseId, $this->orderCancellation->getPurchaseOrderId());

        $purchaseOrderDate = $this->newDateTime();
        $this->orderCancellation->setPurchaseOrderDate($purchaseOrderDate);
        $this->assertSame($purchaseOrderDate, $this->orderCancellation->getPurchaseOrderDate());

        $lineItemNumber = '3';
        $this->orderCancellation->setLineItemNumber($lineItemNumber);
        $this->assertSame(3, $this->orderCancellation->getLineItemNumber());

        $productId = 'productId';
        $this->orderCancellation->setProductId($productId);
        $this->assertSame($productId, $this->orderCancellation->getProductId());

        $reason = OrderCancellation::REASON_SKU;
        $this->orderCancellation->setReason($reason);
        $this->assertSame($reason, $this->orderCancellation->getReason());

        $status = OrderCancellation::STATUS_CANCELED;
        $this->orderCancellation->setStatus($status);
        $this->assertSame($status, $this->orderCancellation->getStatus());

        $array = $this->orderCancellation->toArray();
        $this->assertInternalType('array', $array);
    }
}
