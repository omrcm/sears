<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Model\Pricing;
use AntiMattr\Sears\RequestHandler\PricingRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use Doctrine\Common\Collections\ArrayCollection;

class PricingRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_pricing_import_v3_dss-seller-pricing.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = new XMLBuilder();
        $this->requestHandler = new PricingRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = new Request();
        $collection = new ArrayCollection();

        $item1 = new Pricing();
        $item1->setProductId('A24467');
        $item1->setCost(30.00);
        $item1->setMsrp(32.00);
        $item1->setEffectiveStartDate($this->newDateTime('2013-07-10'));
        
        $item2 = new Pricing();
        $item2->setProductId('A24468');
        $item2->setCost(30.00);
        $item2->setMsrp(32.00);
        $item2->setEffectiveStartDate($this->newDateTime('2013-07-10'));        

        $item3 = new Pricing();
        $item3->setProductId('A24469');
        $item3->setCost(40.00);
        $item3->setMsrp(42.00);
        $item3->setEffectiveStartDate($this->newDateTime('2013-07-10'));        

        $collection->add($item1);
        $collection->add($item2);
        $collection->add($item3);

        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }
}
