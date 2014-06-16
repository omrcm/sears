<?php

namespace AntiMattr\Tests\Sears;

use AntiMattr\Sears\Client;
use AntiMattr\Tests\AntiMattrTestCase;

class ClientTest extends AntiMattrTestCase
{
    private $buzz;
    private $client;
    private $email;
    private $host;
    private $logger;
    private $messageFactory;
    private $objectFactory;
    private $password;
    private $responseHandler;

    protected function setUp()
    {
        $this->buzz = $this->buildMock('Buzz\Client\Curl');
        $this->email = 'foo@bar.com';
        $this->host = 'https://example.com';
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->messageFactory = $this->buildMock('Buzz\Message\Factory\Factory');
        $this->objectFactory = $this->buildMock('AntiMattr\Sears\Model\ObjectFactory');
        $this->password = 'yyyyyy';
        $this->responseHandler = $this->getMock('AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface');
        $this->client = new ClientStub(
            $this->host,
            $this->email,
            $this->password,
            $this->buzz,
            $this->messageFactory,
            $this->objectFactory,
            $this->responseHandler,
            $this->logger
        );
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\AbstractClient', $this->client);
    }

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testFindPurchaseOrdersByStatusThrowsConnectionException()
    {
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->findPurchaseOrdersByStatus('New');
    }

    public function testFindPurchaseOrdersByStatus()
    {
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $collection = $this->buildMock('Doctrine\Common\Collections\ArrayCollection');

        $this->objectFactory->expects($this->once())
            ->method('getInstance')
            ->with('\Doctrine\Common\Collections\ArrayCollection')
            ->will($this->returnValue($collection));

        $this->client->findPurchaseOrdersByStatus('New');
    }
}

class ClientStub extends Client
{
    protected function log(&$message, $pattern = null, $replacement = null)
    {

    }
}
