<?php

namespace AntiMattr\Tests\Sears\Model;

use AntiMattr\Sears\Model\Product;
use AntiMattr\Tests\AntiMattrTestCase;

class ProductTest extends AntiMattrTestCase
{
    private $product;

    protected function setUp()
    {
        $this->product = new Product();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\Model\IdentifiableInterface', $this->product);
        $this->assertInstanceOf('AntiMattr\Sears\Model\RequestSerializerInterface', $this->product);
        $this->assertNull($this->product->getBrand());
        $this->assertNull($this->product->getClassification());
        $this->assertNull($this->product->getCost());
        $this->assertNotNull($this->product->getCountry());
        $this->assertNull($this->product->getDescription());
        $this->assertNull($this->product->getHeight());
        $this->assertNull($this->product->getId());
        $this->assertNull($this->product->getImage());
        $this->assertNull($this->product->getLength());
        $this->assertNull($this->product->getModel());
        $this->assertNull($this->product->getTitle());
        $this->assertNull($this->product->getUpc());
        $this->assertTrue($this->product->getWarranty());
        $this->assertNull($this->product->getWeight());
        $this->assertNull($this->product->getWidth());
    }

    public function testSettersAndGetters()
    {
        $brand = 'brand';
        $this->product->setBrand($brand);
        $this->assertSame($brand, $this->product->getBrand());

        $classification = 'classification';
        $this->product->setClassification($classification);
        $this->assertSame($classification, $this->product->getClassification());

        $cost = 100.00;
        $this->product->setCost($cost);
        $this->assertSame($cost, $this->product->getCost());

        $costString = '100.56';
        $this->product->setCost($costString);
        $this->assertSame(100.56, $this->product->getCost());

        $country = 'CA';
        $this->product->setCountry($country);
        $this->assertSame($country, $this->product->getCountry());

        $description = 'description';
        $this->product->setDescription($description);
        $this->assertSame($description, $this->product->getDescription());

        $height = 70.00;
        $this->product->setHeight($height);
        $this->assertSame($height, $this->product->getHeight());

        $heightString = '70.56';
        $this->product->setHeight($heightString);
        $this->assertSame(70.56, $this->product->getHeight());

        $id = 'xxxxxx';
        $this->product->setId($id);
        $this->assertSame($id, $this->product->getId());

        $image = 'http://www.example.com/sample.gif';
        $this->product->setImage($image);
        $this->assertSame($image, $this->product->getImage());

        $length = 50.00;
        $this->product->setLength($length);
        $this->assertSame($length, $this->product->getLength());

        $lengthString = '50.56';
        $this->product->setLength($lengthString);
        $this->assertSame(50.56, $this->product->getLength());

        $model = 'model';
        $this->product->setModel($model);
        $this->assertSame($model, $this->product->getModel());

        $title = 'title';
        $this->product->setTitle($title);
        $this->assertSame($title, $this->product->getTitle());

        $upc = 'upc';
        $this->product->setUpc($upc);
        $this->assertSame($upc, $this->product->getUpc());

        $warranty = false;
        $this->product->setWarranty($warranty);
        $this->assertFalse($this->product->getWarranty());

        $weight = 10.00;
        $this->product->setWeight($weight);
        $this->assertSame($weight, $this->product->getWeight());

        $weightString = '50.56';
        $this->product->setWeight($weightString);
        $this->assertSame(50.56, $this->product->getWeight());

        $width = 20.00;
        $this->product->setWidth($width);
        $this->assertSame($width, $this->product->getWidth());

        $widthString = '20.56';
        $this->product->setWidth($widthString);
        $this->assertSame(20.56, $this->product->getWidth());

        $array = $this->product->toArray();
        $this->assertInternalType('array', $array);
    }

}
