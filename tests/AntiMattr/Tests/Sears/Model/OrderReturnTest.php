<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\OrderReturn;
use AntiMattr\Tests\AntiMattrTestCase;

class OrderReturnTest extends AntiMattrTestCase
{
    private $orderReturn;

    protected function setUp()
    {
        $this->orderReturn = new OrderReturn();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\AbstractOrderState', $this->orderReturn);
        $this->assertEquals(OrderReturn::REASON_ADJUSTMENT, $this->orderReturn->getReason());
        $this->assertEquals(OrderReturn::STATUS_RETURNED, $this->orderReturn->getStatus());
    }

    public function testSettersAndGetters()
    {
        $id = 'id';
        $this->orderReturn->setId($id);
        $this->assertSame($id, $this->orderReturn->getId());

        $createdAt = new \DateTime();
        $this->orderReturn->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $this->orderReturn->getCreatedAt());

        $quantity = '3';
        $this->orderReturn->setQuantity($quantity);
        $this->assertSame(3, $this->orderReturn->getQuantity());
    }

    /**
     * @expectedException \AntiMattr\Sears\Exception\IntegrationException
     */
    public function testToArrayThrowsIntegrationException()
    {
        $this->orderReturn->toArray();
    }

    public function testToArray()
    {
        $id = 'id';
        $this->orderReturn->setId($id);
        $this->assertSame($id, $this->orderReturn->getId());

        $purchaseId = 'purchaseId';
        $this->orderReturn->setPurchaseOrderId($purchaseId);
        $this->assertSame($purchaseId, $this->orderReturn->getPurchaseOrderId());

        $createdAt = new \DateTime();
        $this->orderReturn->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $this->orderReturn->getCreatedAt());

        $purchaseOrderDate = new \DateTime();
        $this->orderReturn->setPurchaseOrderDate($purchaseOrderDate);
        $this->assertSame($purchaseOrderDate, $this->orderReturn->getPurchaseOrderDate());

        $lineItemNumber = '3';
        $this->orderReturn->setLineItemNumber($lineItemNumber);
        $this->assertSame(3, $this->orderReturn->getLineItemNumber());

        $quantity = '8';
        $this->orderReturn->setQuantity($quantity);
        $this->assertSame(8, $this->orderReturn->getQuantity());

        $productId = 'productId';
        $this->orderReturn->setProductId($productId);
        $this->assertSame($productId, $this->orderReturn->getProductId());

        $reason = OrderReturn::REASON_ADJUSTMENT;
        $this->orderReturn->setReason($reason);
        $this->assertSame($reason, $this->orderReturn->getReason());

        $status = OrderReturn::STATUS_RETURNED;
        $this->orderReturn->setStatus($status);
        $this->assertSame($status, $this->orderReturn->getStatus());

        $memo = 'memo';
        $this->orderReturn->setMemo($memo);
        $this->assertSame($memo, $this->orderReturn->getMemo());

        $array = $this->orderReturn->toArray();
        $this->assertInternalType('array', $array);
    }

}
