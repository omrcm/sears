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

use AntiMattr\Sears\Model\ObjectFactory;
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

    /** @var AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface */
    private $responseHandler;

    public function __construct(
        MessageFactory $messageFactory,
        ObjectFactory $objectFactory,
        ResponseHandlerInterface $responseHandler,
        LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        $this->messageFactory = $messageFactory;
        $this->objectFactory = $objectFactory;
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
        $response = $this->messageFactory->createResponse();
        if (!empty($this->headers)) {
            $response->addHeaders($this->headers);
        }

        if ('' != $this->content) {
            $response->setContent($this->content);
        }

        $this->log($response);

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
        $this->reset();

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
        $this->reset();

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
        $this->reset();

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
        $this->reset();

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
        $this->reset();

        return;
    }

    private function reset()
    {
        $this->content = '';
        $this->headers = array();
    }
}
