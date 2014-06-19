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
}

class FakeResponseClientStub extends FakeResponseClient
{
    protected function log(&$message, $pattern = null, $replacement = null)
    {

    }
}
