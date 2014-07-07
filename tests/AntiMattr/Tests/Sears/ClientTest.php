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
    private $requestHandlerFactory;
    private $responseHandler;

    protected function setUp()
    {
        $this->buzz                  = $this->buildMock('Buzz\Client\Curl');
        $this->email                 = 'foo@bar.com';
        $this->host                  = 'https://example.com';
        $this->logger                = $this->getMock('Psr\Log\LoggerInterface');
        $this->messageFactory        = $this->buildMock('Buzz\Message\Factory\Factory');
        $this->objectFactory         = $this->buildMock('AntiMattr\Sears\Model\ObjectFactory');
        $this->password              = 'yyyyyy';
        $this->requestHandlerFactory = $this->buildMock('AntiMattr\Sears\RequestHandler\RequestHandlerFactory');
        $this->responseHandler       = $this->getMock('AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface');

        $this->client = new ClientStub(
            $this->host,
            $this->email,
            $this->password,
            $this->buzz,
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

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');       

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->findPurchaseOrdersByStatus('New');
    }

    public function testFindPurchaseOrdersByStatusSucceeds()
    {
        $request = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response = $this->buildMock('Buzz\Message\Response');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));    

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

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testCancelOrdersThrowsConnectionException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('cancelOrders')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');    

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->cancelOrders($collection);
    }

    /**
     * If RequestHandler throws an IntegrationException, Client should only throw that error
     * AFTER it has completed the request. This allows successfully-serialized data to go through.
     *
     * @expectedException AntiMattr\Sears\Exception\IntegrationException
     */
    public function testCancelOrdersThrowsIntegrationException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');
        $exception  = $this->buildMock('AntiMattr\Sears\Exception\IntegrationException');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('cancelOrders')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $handler->expects($this->once())
            ->method('bindCollection')
            ->will($this->throwException($exception));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->cancelOrders($collection);
    }

    public function testCancelOrdersSucceeds()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('cancelOrders')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));    

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->cancelOrders($collection);
    }

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testReturnOrdersThrowsConnectionException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('returnOrders')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');       

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->returnOrders($collection);
    }

    /**
     * If RequestHandler throws an IntegrationException, Client should only throw that error
     * AFTER it has completed the request. This allows successfully-serialized data to go through.
     *
     * @expectedException AntiMattr\Sears\Exception\IntegrationException
     */
    public function testReturnOrdersThrowsIntegrationException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');
        $exception  = $this->buildMock('AntiMattr\Sears\Exception\IntegrationException');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('returnOrders')
            ->will($this->returnValue($handler));

        $handler->expects($this->once())
            ->method('bindCollection')
            ->will($this->throwException($exception));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->returnOrders($collection);
    }

    public function testReturnOrdersSucceeds()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('returnOrders')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));    

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->returnOrders($collection);
    }

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testUpdateInventoryThrowsConnectionException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateInventory')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');    

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->updateInventory($collection);
    }

    /**
     * If RequestHandler throws an IntegrationException, Client should only throw that error
     * AFTER it has completed the request. This allows successfully-serialized data to go through.
     *
     * @expectedException AntiMattr\Sears\Exception\IntegrationException
     */
    public function testUpdateInventoryThrowsIntegrationException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');
        $exception  = $this->buildMock('AntiMattr\Sears\Exception\IntegrationException');


        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateInventory')
            ->will($this->returnValue($handler));

        $handler->expects($this->once())
            ->method('bindCollection')
            ->will($this->throwException($exception));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updateInventory($collection);
    }

    public function testUpdateInventorySucceeds()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateInventory')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));    

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updateInventory($collection);
    } 

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testUpdatePricingThrowsConnectionException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updatePricing')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');    

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->updatePricing($collection);
    }

    /**
     * If RequestHandler throws an IntegrationException, Client should only throw that error
     * AFTER it has completed the request. This allows successfully-serialized data to go through.
     *
     * @expectedException AntiMattr\Sears\Exception\IntegrationException
     */
    public function testUpdatePricingThrowsIntegrationException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');
        $exception  = $this->buildMock('AntiMattr\Sears\Exception\IntegrationException');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updatePricing')
            ->will($this->returnValue($handler));

        $handler->expects($this->once())
            ->method('bindCollection')
            ->will($this->throwException($exception));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updatePricing($collection);
    }

    public function testUpdatePricingSucceeds()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updatePricing')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));    

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updatePricing($collection);
    } 

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testUpdateProductsThrowsConnectionException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateProducts')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');    

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->updateProducts($collection);
    }

    /**
     * If RequestHandler throws an IntegrationException, Client should only throw that error
     * AFTER it has completed the request. This allows successfully-serialized data to go through.
     *
     * @expectedException AntiMattr\Sears\Exception\IntegrationException
     */
    public function testUpdateProductsThrowsIntegrationException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');
        $exception  = $this->buildMock('AntiMattr\Sears\Exception\IntegrationException');


        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateProducts')
            ->will($this->returnValue($handler));

        $handler->expects($this->once())
            ->method('bindCollection')
            ->will($this->throwException($exception));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updateProducts($collection);
    }

    public function testUpdateProductsSucceeds()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateProducts')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updateProducts($collection);
    } 

    /**
     * @expectedException AntiMattr\Sears\Exception\Connection\ConnectionException
     */
    public function testUpdateShipmentsThrowsConnectionException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateShipments')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $response->expects($this->never())
            ->method('__toString');    

        $clientException = $this->buildMock('\Buzz\Exception\ClientException');

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response)
            ->will($this->throwException($clientException));

        $this->client->updateShipments($collection);
    }

    /**
     * If RequestHandler throws an IntegrationException, Client should only throw that error
     * AFTER it has completed the request. This allows successfully-serialized data to go through.
     *
     * @expectedException AntiMattr\Sears\Exception\IntegrationException
     */
    public function testUpdateShipmentsThrowsIntegrationException()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');
        $exception  = $this->buildMock('AntiMattr\Sears\Exception\IntegrationException');


        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateShipments')
            ->will($this->returnValue($handler));

        $handler->expects($this->once())
            ->method('bindCollection')
            ->will($this->throwException($exception));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updateShipments($collection);
    }

    public function testUpdateShipmentsSucceeds()
    {
        $collection = $this->getMock('Doctrine\Common\Collections\Collection');        
        $request    = $this->buildMock('Buzz\Message\Form\FormRequest');
        $response   = $this->buildMock('Buzz\Message\Response');
        $handler    = $this->buildMock('AntiMattr\Sears\RequestHandler\AbstractRequestHandler');

        $this->messageFactory->expects($this->once())
            ->method('createRequest')
            ->will($this->returnValue($request));

        $this->requestHandlerFactory->expects($this->once())
            ->method('createRequestHandler')
            ->with('updateShipments')
            ->will($this->returnValue($handler));

        $request->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(''));  

        $this->messageFactory->expects($this->once())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $this->buzz->expects($this->once())
            ->method('send')
            ->with($request, $response);

        $this->client->updateShipments($collection);
    }
}

class ClientStub extends Client
{
    protected function log(&$message, $pattern = null, $replacement = null)
    {

    }
}
