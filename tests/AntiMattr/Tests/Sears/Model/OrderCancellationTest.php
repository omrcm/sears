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
        $this->orderCancellation->toArray();
    }

}
