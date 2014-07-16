<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Model\Product;
use AntiMattr\Sears\RequestHandler\ProductRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use Doctrine\Common\Collections\ArrayCollection;

class ProductRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_catalog_import_v7_dss-item.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = new XMLBuilder();
        $this->requestHandler = new ProductRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = new Request();
        $collection = new ArrayCollection();

        $item1 = new Product();
        $item1->setId('5316cf5c1b0ba0252e000d04');
        $item1->setTitle('Abstract Print Leggings');
        $item1->setDescription('Abstract Print Leggings');
        $item1->setUpc('61680699des8832');
        $item1->setClassification('2611');
        $item1->setModel('BOUJIBR-8B63');
        $item1->setCost('26');
        $item1->setMsrp('30');
        $item1->setEffectiveStartDate(new \DateTime('2014-07-15', new \DateTimeZone('UTC')));
        $item1->setBrand('Bouji Broad');
        $item1->setLength('11');
        $item1->setWidth('10');
        $item1->setHeight('1');
        $item1->setWeight('1');
        $item1->setImage('http://cdn5.opensky.com/boujibroad/product/abstract-print-leggings-1/images/ce16190/7312cc8/generous/abstract-print-leggings-1.jpg');
        $item1->setWarranty(FALSE);
        $item1->setCountry('CN');

        $item2 = new Product();
        $item2->setId('533b99011c0ba0f340000420');
        $item2->setTitle('Blue Jean Swarovski Skull Lava Rock Beaded Bracelet');
        $item2->setDescription('Swarovski Black Beaded Bracelet');
        $item2->setUpc('616806998849');
        $item2->setClassification('2611');
        $item2->setModel('BOUJIBR-2F37');
        $item2->setCost('60');
        $item2->setMsrp('65');
        $item2->setEffectiveStartDate(new \DateTime('2014-07-15', new \DateTimeZone('UTC')));
        $item2->setBrand('Bouji Broad');
        $item2->setLength('9');
        $item2->setWidth('6');
        $item2->setHeight('2');
        $item2->setWeight('0.5');
        $item2->setImage('http://cdn1.opensky.com/boujibroad/product/bouji-broad-exclusive-men-s-blue-jean-swarovski-skull-lava-rock-beaded-bracelet/images/90593b1/4808293/behemoth/bouji-broad-exclusive-men-s-blue-jean-swarovski-skull-lava-rock-beaded-bracelet.jpg');
        $item2->setWarranty(FALSE);
        $item2->setCountry('US');

        $collection->add($item1);
        $collection->add($item2);

        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }
}
