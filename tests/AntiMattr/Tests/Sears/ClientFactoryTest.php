<?php

namespace AntiMattr\Tests\Sears;

use AntiMattr\Sears\ClientFactory;
use AntiMattr\Tests\AntiMattrTestCase;

class ClientFactoryTest extends AntiMattrTestCase
{
    private $factory;

    protected function setUp()
    {
        $this->client = $this->buildMock('AntiMattr\Sears\Client');
        $this->fakeResponseClient = $this->buildMock('AntiMattr\Sears\FakeResponseClient');
        $this->factory = new ClientFactory(
            $this->client,
            $this->fakeResponseClient
        );
    }

    public function testGetClient()
    {
        $alias = 'default';
        $client = $this->factory->getClient($alias, 'AntiMattr\Sears\Client');
        $this->assertInstanceOf('AntiMattr\Sears\AbstractClient', $client);

        $alias = 'test';
        $client = $this->factory->getClient($alias, 'AntiMattr\Sears\FakeResponseClient');
        $this->assertInstanceOf('AntiMattr\Sears\AbstractClient', $client);
    }

    public function testGetClientFromMemory()
    {
        $alias = 'foo';
        $client1 = $this->factory->getClient($alias, 'AntiMattr\Sears\Client');

        $alias = 'bar';
        $client2 = $this->factory->getClient($alias, 'AntiMattr\Sears\Client');

        $this->assertNotSame($client1, $client2);

        $alias = 'foo';
        $client3 = $this->factory->getClient($alias, 'AntiMattr\Sears\Client');

        $this->assertSame($client1, $client3);
    }

}
