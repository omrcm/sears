<?php

namespace AntiMattr\Tests\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\RequestHandler\RequestHandlerFactory;
use AntiMattr\Tests\AntiMattrTestCase;

class RequestHandlerFactoryTest extends AntiMattrTestCase
{
    private $factory;
    private $xmlBuilder;

    protected function setUp()
    {
        $this->xmlBuilder = $this->buildMock('AntiMattr\Sears\Format\XMLBuilder');
        $this->factory = new RequestHandlerFactoryStub();
        $this->factory->setXMLBuilder($this->xmlBuilder);
    }

    /**
     * @dataProvider provideHandlerType
     */
    public function testCreateRequestHandler($type, $classname)
    {
        $handler = $this->factory->createRequestHandler($type);
        $this->assertInstanceOf($classname, $handler);
    }

    public function provideHandlerType()
    {
        return array(
            array('updateInventory', '\AntiMattr\Sears\RequestHandler\InventoryRequestHandler'),
            array('cancelOrders', '\AntiMattr\Sears\RequestHandler\OrderCancellationRequestHandler'),
            array('returnOrders', '\AntiMattr\Sears\RequestHandler\OrderReturnRequestHandler'),
            array('updatePricing', '\AntiMattr\Sears\RequestHandler\PricingRequestHandler'),
            array('updateProducts', '\AntiMattr\Sears\RequestHandler\ProductRequestHandler'),
            array('updateShipments', '\AntiMattr\Sears\RequestHandler\ShipmentRequestHandler')
        );
    }
}

class RequestHandlerFactoryStub extends RequestHandlerFactory
{
    private $xmlBuilder;

    public function setXMLBuilder($xmlBuilder)
    {
        $this->xmlBuilder = $xmlBuilder;
    }

    protected function createXMLBuilder()
    {
        return $this->xmlBuilder;
    }
}
