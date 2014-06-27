<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\Pricing;
use AntiMattr\Tests\AntiMattrTestCase;

class PricingTest extends AntiMattrTestCase
{
    private $pricing;

    protected function setUp()
    {
        $this->pricing = new Pricing();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\RequestSerializerInterface', $this->pricing);
        $this->assertNull($this->pricing->getCost());
        $this->assertNull($this->pricing->getMsrp());
        $this->assertNull($this->pricing->getProductId());
    }

    public function testSettersAndGetters()
    {
        $cost = 100.00;
        $this->pricing->setCost($cost);
        $this->assertSame($cost, $this->pricing->getCost());

        $costString = '100.56';
        $this->pricing->setCost($costString);
        $this->assertSame(100.56, $this->pricing->getCost());

        $msrp = 90.00;
        $this->pricing->setMsrp($msrp);
        $this->assertSame($msrp, $this->pricing->getMsrp());

        $msrpString = '90.56';
        $this->pricing->setMsrp($msrpString);
        $this->assertSame(90.56, $this->pricing->getMsrp());

        $id = 'xxxxxx';
        $this->pricing->setProductId($id);
        $this->assertSame($id, $this->pricing->getProductId());

        $array = $this->pricing->toArray();
        $this->assertInternalType('array', $array);
    }

    /**
     * @expectedException \AntiMattr\Sears\Exception\IntegrationException    
     */
    public function testToArrayThrowsIntegrationException()
    {
        $msrp = 90.00;
        $this->pricing->setMsrp($msrp);
        
        $this->pricing->toArray();
    }
}
