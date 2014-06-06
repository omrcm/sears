<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\LineItem;
use AntiMattr\Tests\AntiMattrTestCase;

class LineItemTest extends AntiMattrTestCase
{
    private $lineItem;

    protected function setUp()
    {
        $this->lineItem = new LineItem();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\IdentifiableInterface', $this->lineItem);
        $this->assertNull($this->lineItem->getCommissionPerUnit());
        $this->assertNull($this->lineItem->getHandlingInd());
        $this->assertNull($this->lineItem->getHandlingInstructions());
        $this->assertNull($this->lineItem->getId());
        $this->assertNull($this->lineItem->getName());
        $this->assertNull($this->lineItem->getNumber());
        $this->assertNull($this->lineItem->getPricePerUnit());
        $this->assertNull($this->lineItem->getQuantity());
        $this->assertNull($this->lineItem->getShippingHandling());
    }

    public function testSettersAndGetters()
    {
        $commission = 100.00;
        $this->lineItem->setCommissionPerUnit($commission);
        $this->assertEquals($commission, $this->lineItem->getCommissionPerUnit());

        $handlingInd = 'foo';
        $this->lineItem->setHandlingInd($handlingInd);
        $this->assertEquals($handlingInd, $this->lineItem->getHandlingInd());

        $handlingInstructions = 'foo';
        $this->lineItem->setHandlingInstructions($handlingInstructions);
        $this->assertEquals($handlingInstructions, $this->lineItem->getHandlingInstructions());

        $id = 'id';
        $this->lineItem->setId($id);
        $this->assertEquals($id, $this->lineItem->getId());

        $name = 'name';
        $this->lineItem->setName($name);
        $this->assertEquals($name, $this->lineItem->getName());

        $number = 'number';
        $this->lineItem->setNumber($number);
        $this->assertEquals($number, $this->lineItem->getNumber());

        $price = 100.00;
        $this->lineItem->setPricePerUnit($price);
        $this->assertEquals($price, $this->lineItem->getPricePerUnit());

        $quantity = 7;
        $this->lineItem->setQuantity($quantity);
        $this->assertEquals($quantity, $this->lineItem->getQuantity());

        $shippingHandling = 100.00;
        $this->lineItem->setShippingHandling($shippingHandling);
        $this->assertEquals($shippingHandling, $this->lineItem->getShippingHandling());
    }
}
