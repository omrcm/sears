<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears;

use AntiMattr\Sears\Exception\IntegrationException;
use AntiMattr\Sears\Model\ObjectFactory;
use AntiMattr\Sears\RequestHandler\RequestHandlerFactory;
use AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface;
use Buzz\Message\Factory\Factory as MessageFactory;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 * Sears Marketplace doesn't provide Sandbox testing
 * Use this client to functionally test your integration
 */
class FakeResponseClient extends AbstractClient
{
    /** @var string */
    private $content = '';

    /** @var array */
    private $headers = array();

    /** @var Buzz\Message\Factory\Factory */
    private $messageFactory;

    /** @var AntiMattr\Sears\Model\ObjectFactory */
    private $objectFactory;

    /** @var AntiMattr\Sears\RequestHandler\RequestHandlerFactory */
    private $requestHandlerFactory;

    /** @var AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface */
    private $responseHandler;

    public function __construct(
        MessageFactory $messageFactory,
        ObjectFactory $objectFactory,
        RequestHandlerFactory $requestHandlerFactory,
        ResponseHandlerInterface $responseHandler,
        LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        $this->messageFactory = $messageFactory;
        $this->objectFactory = $objectFactory;
        $this->requestHandlerFactory = $requestHandlerFactory;
        $this->responseHandler = $responseHandler;
    }

    /**
     * @param string $content
     */
    public function setContent($content = '')
    {
        $this->content = $content;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers = array())
    {
        $this->headers = $headers;
    }

    /**
     * @param  string                                      $status
     * @param  array                                       $headers
     * @return Doctrine\Common\Collections\ArrayCollection $collection
     */
    public function findPurchaseOrdersByStatus($status = 'New')
    {
        $resource = sprintf(
            '/SellerPortal/api/oms/purchaseorder/v4?email=%s&password=%s&status=%s',
            'xxxxxx',
            'yyyyyy',
            $status
        );

        $request = $this->messageFactory->createRequest('GET', $resource, 'http://www.example.com');
        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $requestString = $request->__toString();
        $responseString = $response->__toString();
        $this->log($requestString);
        $this->log($responseString);

        $collection = $this->objectFactory->getInstance('\Doctrine\Common\Collections\ArrayCollection');
        $this->responseHandler->bindCollection($response, $collection);

        $this->reset();

        return $collection;
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function cancelOrders(Collection $collection)
    {
        $handler = $this->requestHandlerFactory->createRequestHandler('cancelOrders');
        $resource = sprintf(
            '/SellerPortal/api/oms/order/cancel/v1?email=%s&password=%s',
            'xxxxxx',
            'yyyyyy'
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, 'http://www.example.com');

        $requestString = $request->__toString();
        $this->log($requestString);

        $handler->bindCollection($request, $collection);

        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $this->reset();
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function returnOrders(Collection $collection)
    {
        $handler = $this->requestHandlerFactory->createRequestHandler('returnOrders');
        $resource = sprintf(
            '/SellerPortal/api/oms/dss/orderreturn/v1?email=%s&password=%s',
            'xxxxxx',
            'yyyyyy'
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, 'http://www.example.com');

        $handler->bindCollection($request, $collection);

        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $this->reset();
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updateInventory(Collection $collection)
    {
        $handler = $this->requestHandlerFactory->createRequestHandler('updateInventory');
        $resource = sprintf(
            '/SellerPortal/api/inventory/dss/v1?email=%s&password=%s',
            'xxxxxx',
            'yyyyyy'
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, 'http://www.example.com');

        $integrationException = null;
        try {
            $handler->bindCollection($request, $collection);
        } catch (IntegrationException $e) {
            $integrationException = $e;
        }
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $this->reset();

        if ($integrationException) {
            throw $integrationException;
        }
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updatePricing(Collection $collection)
    {
        $handler = $this->requestHandlerFactory->createRequestHandler('updatePricing');
        $resource = sprintf(
            '/SellerPortal/api/pricing/dss/v2?email=%s&password=%s',
            'xxxxxx',
            'yyyyyy'
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, 'http://www.example.com');

        $integrationException = null;
        try {
            $handler->bindCollection($request, $collection);
        } catch(IntegrationException $e) {
            $integrationException = $e;
        }
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $this->reset();

        if ($integrationException) {
            throw $integrationException;
        }
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updateProducts(Collection $collection)
    {
        $handler = $this->requestHandlerFactory->createRequestHandler('updateProducts');
        $resource = sprintf(
            '/SellerPortal/api/catalog/dss/v4?email=%s&password=%s',
            'xxxxxx',
            'yyyyyy'
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, 'http://www.example.com');

        $integrationException = null;
        try {
            $handler->bindCollection($request, $collection);
        } catch (IntegrationException $e) {
            $integrationException = $e;
        }

        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $this->reset();

        if ($integrationException) {
            throw $integrationException;
        }
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updateShipments(Collection $collection)
    {
        $handler = $this->requestHandlerFactory->createRequestHandler('updateShipments');
        $resource = sprintf(
            '/SellerPortal/api/oms/asn/v5?email=%s&password=%s',
            'xxxxxx',
            'yyyyyy'
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, 'http://www.example.com');

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();
        $response->addHeader('1.0 200 OK');

        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $this->reset();
    }

    private function reset()
    {
        $this->content = '';
        $this->headers = array();
    }
}
