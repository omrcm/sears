<?php

namespace AntiMattr\Tests\Sears;

use AntiMattr\Sears\AbstractClient;
use AntiMattr\Tests\AntiMattrTestCase;

class AbstractClientTest extends AntiMattrTestCase
{
    private $client;
    private $logger;

    protected function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->client = new AbstractClientStub(
            $this->logger
        );
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('AntiMattr\Sears\AbstractClient', $this->client);
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

class AbstractClientStub extends AbstractClient
{
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function findPurchaseOrdersByStatus($status = '')
    {
        return;
    }

    public function doLog(&$message)
    {
        $this->log($message);
    }
}
