<?php

namespace AntiMattr\Tests\Sears;

use AntiMattr\Sears\FakeResponseClient;
use AntiMattr\Tests\AntiMattrTestCase;

class FakeResponseClientTest extends AntiMattrTestCase
{
    private $client;
    private $logger;
    private $messageFactory;
    private $objectFactory;
    private $requestHandlerFactory;
    private $responseHandler;

    protected function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->messageFactory = $this->buildMock('Buzz\Message\Factory\Factory');
        $this->objectFactory = $this->buildMock('AntiMattr\Sears\Model\ObjectFactory');
        $this->requestHandlerFactory = $this->buildMock('AntiMattr\Sears\RequestHandler\RequestHandlerFactory');
        $this->responseHandler = $this->getMock('AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface');
        $this->client = new FakeResponseClientStub(
            $this->messageFactory,
            $this->objectFactory,
            $this->requestHandlerFactory,
            $this->responseHandler,
            $this->logger
        );
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\AbstractClient', $this->client);
    }

    public function testFindPurchaseOrdersByStatus()
    {
        $response = $this->buildMock('Buzz\Message\Response');

        $content = '<xml>content</xml>';
        $headers = array('key' => 'value');

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('setContent')
            ->with($content);

        $response->expects($this->once())
            ->method('addHeaders')
            ->with($headers);

        $collection = $this->buildMock('Doctrine\Common\Collections\ArrayCollection');

        $this->objectFactory->expects($this->once())
            ->method('getInstance')
            ->with('\Doctrine\Common\Collections\ArrayCollection')
            ->will($this->returnValue($collection));

        $this->client->setContent($content);
        $this->client->setHeaders($headers);

        $this->client->findPurchaseOrdersByStatus('New');
    }

    public function testCancelOrders()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');
        $handler = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('cancelOrders')
            ->will($this->returnValue($handler));

        $content = '<xml>content</xml>';
        $headers = array('key' => 'value');

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('setContent')
            ->with($content);

        $response->expects($this->once())
            ->method('addHeaders')
            ->with($headers);

        $this->client->setContent($content);
        $this->client->setHeaders($headers);

        $this->client->cancelOrders($collection);
    }

    public function testReturnOrders()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');
        $handler = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('returnOrders')
            ->will($this->returnValue($handler));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $this->client->returnOrders($collection);
    }

    public function testUpdateInventory()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');
        $handler = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateInventory')
            ->will($this->returnValue($handler));

        $content = '<xml>content</xml>';
        $headers = array('key' => 'value');

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('setContent')
            ->with($content);

        $response->expects($this->once())
            ->method('addHeaders')
            ->with($headers);

        $this->client->setContent($content);
        $this->client->setHeaders($headers);

        $this->client->updateInventory($collection);
    }        

    public function testUpdateProducts()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');
        $handler = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateProducts')
            ->will($this->returnValue($handler));

        $content = '<xml>content</xml>';
        $headers = array('key' => 'value');

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('setContent')
            ->with($content);

        $response->expects($this->once())
            ->method('addHeaders')
            ->with($headers);

        $this->client->setContent($content);
        $this->client->setHeaders($headers);

        $this->client->updateProducts($collection);
    }

    public function testUpdateShipments()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');
        $handler = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateShipments')
            ->will($this->returnValue($handler));

        $content = '<xml>content</xml>';
        $headers = array('key' => 'value');

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('setContent')
            ->with($content);

        $response->expects($this->once())
            ->method('addHeaders')
            ->with($headers);

        $this->client->setContent($content);
        $this->client->setHeaders($headers);

        $this->client->updateShipments($collection);
    }     
}

class FakeResponseClientStub extends FakeResponseClient
{
    protected function log(&$message, $pattern = null, $replacement = null)
    {

    }
}
