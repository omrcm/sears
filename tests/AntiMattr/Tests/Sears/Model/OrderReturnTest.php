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

}
