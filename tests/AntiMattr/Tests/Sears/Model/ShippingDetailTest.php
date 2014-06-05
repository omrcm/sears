<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\ShippingDetail;
use AntiMattr\Tests\AntiMattrTestCase;

class ShippingDetailTest extends AntiMattrTestCase
{
    private $shippingDetail;

    protected function setUp()
    {
        $this->shippingDetail = new ShippingDetail();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\IdentifiableInterface', $this->shippingDetail);
        $this->assertNull($this->shippingDetail->getId());
        $this->assertNull($this->shippingDetail->getName());
        $this->assertNull($this->shippingDetail->getStreetAddress());
        $this->assertNull($this->shippingDetail->getLocality());
        $this->assertNull($this->shippingDetail->getRegion());
        $this->assertNull($this->shippingDetail->getPostalCode());
        $this->assertNull($this->shippingDetail->getCountry());
        $this->assertNull($this->shippingDetail->getPhone());
        $this->assertNull($this->shippingDetail->getMethod());
    }

    public function testSettersAndGetters()
    {
        $id = 'xxxxxx';
        $this->shippingDetail->setId($id);
        $this->assertEquals($id, $this->shippingDetail->getId());

        $name = 'Matt Fitzgerald';
        $this->shippingDetail->setName($name);
        $this->assertEquals($name, $this->shippingDetail->getName());

        $streetAddress = '100 Main Street';
        $this->shippingDetail->setStreetAddress($streetAddress);
        $this->assertEquals($streetAddress, $this->shippingDetail->getStreetAddress());

        $locality = 'Chicago';
        $this->shippingDetail->setLocality($locality);
        $this->assertEquals($locality, $this->shippingDetail->getLocality());

        $region = 'IL';
        $this->shippingDetail->setRegion($region);
        $this->assertEquals($region, $this->shippingDetail->getRegion());

        $postalCode = '60600';
        $this->shippingDetail->setPostalCode($postalCode);
        $this->assertEquals($postalCode, $this->shippingDetail->getPostalCode());

        $phone = '555555555';
        $this->shippingDetail->setPhone($phone);
        $this->assertEquals($phone, $this->shippingDetail->getPhone());

        $method = 'Ground';
        $this->shippingDetail->setMethod($method);
        $this->assertEquals($method, $this->shippingDetail->getMethod());
    }
}
