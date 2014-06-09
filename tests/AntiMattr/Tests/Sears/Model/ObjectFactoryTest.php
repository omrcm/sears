<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\ObjectFactory;
use AntiMattr\Tests\AntiMattrTestCase;

class ObjectFactoryTest extends AntiMattrTestCase
{
    private $factory;

    protected function setUp()
    {
        $this->factory = new ObjectFactory();
    }

    public function testGetInstance()
    {
        $this->assertNotNull($this->factory->getInstance('\stdClass'));
        $this->assertNull($this->factory->getInstance('AntiMattr\Sears\Model\NotAType'));
        $this->assertNotNull($this->factory->getInstance('AntiMattr\Sears\Model\PurchaseOrder'));
        $this->assertNotNull($this->factory->getInstance('Doctrine\Common\Collections\ArrayCollection'));
    }
}
