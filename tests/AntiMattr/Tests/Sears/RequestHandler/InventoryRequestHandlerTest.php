<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Model\Inventory;
use AntiMattr\Sears\RequestHandler\InventoryRequestHandler;
use AntiMattr\Tests\AntiMattrTestCase;
use Buzz\Message\Request;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class InventoryRequestHandlerTest extends AntiMattrTestCase
{
    private $requestHandler;

    private static $xml;

    public static function setUpBeforeClass()
    {
        self::$xml = file_get_contents(dirname(__DIR__).'/Resources/fixtures/rest_inventory_import_v1_dss-inventory.xml');
    }

    public static function tearDownAfterClass()
    {
        self::$xml = NULL;
    }

    protected function setUp()
    {
        $this->xmlBuilder = new XMLBuilder();
        $this->requestHandler = new InventoryRequestHandler($this->xmlBuilder);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\RequestHandler\AbstractRequestHandler', $this->requestHandler);
    }

    public function testBindCollection()
    {
        $request = new Request();
        $collection = new ArrayCollection();

        $item1 = new Inventory();
        $item1->setProductId('770011');
        $item1->setQuantity('5');
        $item1->setThreshold('3');
        $item1->setUpdatedAt(new DateTime('2001-12-31T12:00:00'));
        $item2 = new Inventory();
        $item2->setProductId('770077');
        $item2->setQuantity('10');
        $item2->setThreshold('7');
        $item2->setUpdatedAt(new DateTime('2001-12-31T12:00:00'));
        $item3 = new Inventory();
        $item3->setProductId('990099');
        $item3->setQuantity('10');
        $item3->setThreshold('5');
        $item3->setUpdatedAt(new DateTime('2001-12-31T12:00:00'));
        $collection->add($item1);
        $collection->add($item2);
        $collection->add($item3);

        $this->requestHandler->bindCollection($request, $collection);

        $content = $request->getContent();

        $this->assertXmlStringEqualsXmlString(self::$xml, $content);
    }
}
