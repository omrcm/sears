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
use Psr\Log\LoggerInterface;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class Client
{
    /** @var Buzz\Client\Curl */
    private $buzz;

    /** @var string */
    private $email;

    /** @var string */
    private $host;

    /** @var Psr\Log\LoggerInterface */
    private $logger;

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
     * @param  string                                        $status
     * @return Doctrine\Common\Collections\ArrayCollection   $collection
     * @throws AntiMattr\Sears\Exception\ConnectionException
     */
    public function findPurchaseOrdersByStatus($status)
    {
        $resource = sprintf(
            '/SellerPortal/api/oms/purchaseorder/v4?email=%s&password=%s&status=',
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
        $this->responseHandler->bind($response, $collection);

        return $collection;
    }

    /**
     * @param string $message
     * @param mixed  $pattern
     * @param mixed  $replacement
     */
    protected function log(&$message, $pattern = array('/email=(.*[^&])&password=(.*[^&])&/'), $replacement = array('email=xxxxxx&password=yyyyyy&'))
    {
        if (null !== $this->logger) {

            if (null !== $pattern && null !== $replacement) {
                $message = preg_replace($pattern, $replacement, $message);
            }

            $this->logger->debug($message);
        }
    }
}
