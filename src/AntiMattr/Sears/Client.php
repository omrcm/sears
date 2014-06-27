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

use AntiMattr\Sears\Exception\Connection\ConnectionException;
use AntiMattr\Sears\Model\ObjectFactory;
use AntiMattr\Sears\RequestHandler\RequestHandlerFactory;
use AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface;
use Buzz\Client\Curl;
use Buzz\Exception\ClientException;
use Buzz\Message\Factory\Factory as MessageFactory;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class Client extends AbstractClient
{
    /** @var Buzz\Client\Curl */
    private $buzz;

    /** @var string */
    private $email;

    /** @var string */
    private $host;

    /** @var Buzz\Message\Factory\Factory */
    private $messageFactory;

    /** @var AntiMattr\Sears\Model\ObjectFactory */
    private $objectFactory;

    /** @var string */
    private $password;

    /** @var AntiMattr\Sears\RequestHandler\RequestHandlerFactory */
    private $requestHandlerFactory;

    /** @var AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface */
    private $responseHandler;

    public function __construct(
        $host,
        $email,
        $password,
        Curl $buzz,
        MessageFactory $messageFactory,
        ObjectFactory $objectFactory,
        RequestHandlerFactory $requestHandlerFactory,
        ResponseHandlerInterface $responseHandler,
        LoggerInterface $logger = null)
    {
        $this->buzz = $buzz;
        $this->email = $email;
        $this->host = $host;
        $this->logger = $logger;
        $this->messageFactory = $messageFactory;
        $this->objectFactory = $objectFactory;
        $this->password = $password;
        $this->requestHandlerFactory = $requestHandlerFactory;
        $this->responseHandler = $responseHandler;
    }

    /**
     * @param  string                                                   $status
     * @return Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     */
    public function findPurchaseOrdersByStatus($status = 'New')
    {
        $resource = sprintf(
            '/SellerPortal/api/oms/purchaseorder/v4?email=%s&password=%s&status=%s',
            $this->email,
            $this->password,
            $status
        );

        $request = $this->messageFactory->createRequest('GET', $resource, $this->host);
        $response = $this->messageFactory->createResponse();

        $requestString = $request->__toString();
        $this->log($requestString);

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $responseString = $response->__toString();
        $this->log($responseString);

        $collection = $this->objectFactory->getInstance('\Doctrine\Common\Collections\ArrayCollection');
        $this->responseHandler->bindCollection($response, $collection);

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
            $this->email,
            $this->password
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, $this->host);

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $responseString = $response->__toString();
        $this->log($responseString);
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
            $this->email,
            $this->password
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, $this->host);

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $responseString = $response->__toString();
        $this->log($responseString);
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
            $this->email,
            $this->password
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, $this->host);

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $responseString = $response->__toString();
        $this->log($responseString);
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
            $this->email,
            $this->password
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, $this->host);

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $responseString = $response->__toString();
        $this->log($responseString);
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
            $this->email,
            $this->password
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, $this->host);

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }
        
        $responseString = $response->__toString();
        $this->log($responseString);
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
            $this->email,
            $this->password
        );

        $request = $this->messageFactory->createRequest('PUT', $resource, $this->host);

        $handler->bindCollection($request, $collection);
        $requestString = $request->__toString();
        $this->log($requestString);

        $response = $this->messageFactory->createResponse();

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $responseString = $response->__toString();
        $this->log($responseString);
    }
}
