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

use AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface;
use Buzz\Client\Curl;
use Buzz\Message\Factory\Factory as MessageFactory;
use Psr\Log\LoggerInterface;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class Client
{
    /** @var Buzz\Client\Curl */
    private $buzz;

    /** @var Buzz\Message\Factory\Factory */
    private $messageFactory;

    /** @var AntiMattr\Sears\ResponseHandler\ResponseHandlerInterface */
    private $responseHandler;

    /** @var Psr\Log\LoggerInterface */
    private $logger;

    public function __construct(
        Curl $buzz,
        MessageFactory $messageFactory,
        ResponseHandlerInterface $responseHandler,
        LoggerInterface $logger = null)
    {
        $this->buzz = $buzz;
        $this->messageFactory = $messageFactory;
        $this->responseHandler = $responseHandler;
        $this->logger = $logger;
    }

    /**
     * @return todo
     */
    public function findPurchaseOrders()
    {
        // TODO the stuf
    }
}
