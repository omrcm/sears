<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\Inventory;
use AntiMattr\Tests\AntiMattrTestCase;

class InventoryTest extends AntiMattrTestCase
{
    private $inventory;

    protected function setUp()
    {
        $this->inventory = new Inventory();
    }

    public function testConstructor()
    {
        $this->assertNull($this->inventory->getUpdatedAt());
        $this->assertNull($this->inventory->getThreshold());
        $this->assertNull($this->inventory->getQuantity());
        $this->assertNull($this->inventory->getProductId());
    }

    public function testSettersAndGetters()
    {
        $updatedAt = new \DateTime();
        $this->inventory->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $this->inventory->getUpdatedAt());

        $thresholdString = 8.8;
        $this->inventory->setThreshold($thresholdString);
        $this->assertSame(8, $this->inventory->getThreshold());

        $thresholdString = '100.333';
        $this->inventory->setThreshold($thresholdString);
        $this->assertSame(100, $this->inventory->getThreshold());

        $id = 'id';
        $this->inventory->setProductId($id);
        $this->assertSame($id, $this->inventory->getProductId());

        $quantity = 7.1;
        $this->inventory->setQuantity($quantity);
        $this->assertSame(7, $this->inventory->getQuantity());

        $quantityString = '7.999';
        $this->inventory->setQuantity($quantityString);
        $this->assertSame(7, $this->inventory->getQuantity());
    }
}
