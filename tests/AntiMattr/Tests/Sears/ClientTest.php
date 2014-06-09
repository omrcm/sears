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
    private $password;
    private $responseHandler;

    protected function setUp()
    {
        $this->buzz = $this->buildMock('Buzz\Client\Curl');
        $this->email = 'foo@bar.com';
        $this->host = 'https://example.com';
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->messageFactory = $this->buildMock('Buzz\Message\Factory\Factory');
        $this->password = 'yyyyyy';
        $this->responseHandler = $this->getMock('AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface');
        $this->client = new ClientStubLog(
            $this->host,
            $this->email,
            $this->password,
            $this->buzz,
            $this->messageFactory,
            $this->responseHandler,
            $this->logger
        );
    }

    /**
     * @dataProvider provideLogMessages
     */
    public function testLog($rawMessage, $expectedMessage)
    {
        $this->logger->expects($this->once())
            ->method('debug')
            ->with($expectedMessage);

        $this->client->doLog($rawMessage);
    }

    public function provideLogMessages()
    {
        return array(
            array(
                'https://example.com/resource?email=foo@bar.com&password=yyyyyy&status=New',
                'https://example.com/resource?email=xxxxxx&password=yyyyyy&status=New'
            )
        );
    }
}

class ClientStubLog extends Client
{
    public function doLog(&$message)
    {
        $this->log($message);
    }
}
