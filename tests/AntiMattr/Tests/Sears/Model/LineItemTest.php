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
        $this->assertNull($this->lineItem->getCommissionPerUnit());
        $this->assertNull($this->lineItem->getHandlingInd());
        $this->assertNull($this->lineItem->getHandlingInstructions());
        $this->assertNull($this->lineItem->getProductId());
        $this->assertNull($this->lineItem->getProductName());
        $this->assertNull($this->lineItem->getNumber());
        $this->assertNull($this->lineItem->getPricePerUnit());
        $this->assertNull($this->lineItem->getQuantity());
        $this->assertNull($this->lineItem->getShippingHandling());
    }

    public function testSettersAndGetters()
    {
        $commission = 100.00;
        $this->lineItem->setCommissionPerUnit($commission);
        $this->assertSame($commission, $this->lineItem->getCommissionPerUnit());

        $commissionString = '100.333';
        $this->lineItem->setCommissionPerUnit($commissionString);
        $this->assertSame(100.333, $this->lineItem->getCommissionPerUnit());

        $handlingInd = 'foo';
        $this->lineItem->setHandlingInd($handlingInd);
        $this->assertSame($handlingInd, $this->lineItem->getHandlingInd());

        $handlingInstructions = 'foo';
        $this->lineItem->setHandlingInstructions($handlingInstructions);
        $this->assertSame($handlingInstructions, $this->lineItem->getHandlingInstructions());

        $id = 'id';
        $this->lineItem->setProductId($id);
        $this->assertSame($id, $this->lineItem->getProductId());

        $name = 'name';
        $this->lineItem->setProductName($name);
        $this->assertSame($name, $this->lineItem->getProductName());

        $number = 'number';
        $this->lineItem->setNumber($number);
        $this->assertSame($number, $this->lineItem->getNumber());

        $price = 100.00;
        $this->lineItem->setPricePerUnit($price);
        $this->assertSame($price, $this->lineItem->getPricePerUnit());

        $priceString = '100.77';
        $this->lineItem->setPricePerUnit($priceString);
        $this->assertSame(100.77, $this->lineItem->getPricePerUnit());

        $quantity = 7.1;
        $this->lineItem->setQuantity($quantity);
        $this->assertSame(7, $this->lineItem->getQuantity());

        $quantityString = '7.999';
        $this->lineItem->setQuantity($quantityString);
        $this->assertSame(7, $this->lineItem->getQuantity());

        $shippingHandling = 100.00;
        $this->lineItem->setShippingHandling($shippingHandling);
        $this->assertSame($shippingHandling, $this->lineItem->getShippingHandling());

        $shippingHandlingString = '99.22222';
        $this->lineItem->setShippingHandling($shippingHandlingString);
        $this->assertSame(99.22222, $this->lineItem->getShippingHandling());
    }
}
