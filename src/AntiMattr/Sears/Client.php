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

    /** @var AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface */
    private $responseHandler;

    public function __construct(
        $host,
        $email,
        $password,
        Curl $buzz,
        MessageFactory $messageFactory,
        ObjectFactory $objectFactory,
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

        $this->log($request);

        try {
            $this->buzz->send($request, $response);
        } catch (ClientException $e) {
            $subject = $e->getMessage();
            throw new ConnectionException($subject);
        }

        $this->log($response);

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
        return;
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function returnOrders(Collection $collection)
    {
        return;
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updateInventory(Collection $collection)
    {
        return;
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updateProducts(Collection $collection)
    {
        return;
    }

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function updateShipments(Collection $collection)
    {
        return;
    }
}
