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

use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
abstract class AbstractClient
{
    /** @var Psr\Log\LoggerInterface */
    protected $logger;

    /**
     * @param  string                                                   $id
     * @return Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     */
    abstract public function findPurchaseOrdersById($id);

    /**
     * @param  string                                                   $status
     * @return Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     */
    abstract public function findPurchaseOrdersByStatus($status);

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    abstract public function cancelOrders(Collection $collection);

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    abstract public function returnOrders(Collection $collection);

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    abstract public function updateInventory(Collection $collection);

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    abstract public function updatePricing(Collection $collection);

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    abstract public function updateProducts(Collection $collection);

    /**
     * @param  Doctrine\Common\Collections\Collection                   $collection
     * @throws AntiMattr\Sears\Exception\Connection\ConnectionException
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    abstract public function updateShipments(Collection $collection);

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

    /** 
     * @param Request $request
     */
    protected function updateHeaders($request)
    {
        $content = $request->getContent();
        $contentLength = strlen($content);
        $request->addHeader('Content-Length: '. $contentLength);
        $request->addHeader('Content-Type: application/xml;charset=UTF-8');        
    }   
}
