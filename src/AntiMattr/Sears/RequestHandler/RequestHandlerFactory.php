<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use AntiMattr\Sears\Exception\IntegrationException;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class RequestHandlerFactory
{
    /**
     * @param  $string
     * @return AntiMattr\Sears\RequestHandler\AbstractRequestHandler
     */
    public function createRequestHandler($type)
    {
        $xmlBuilder = $this->createXMLBuilder();
        switch ($type) {
            case 'updateInventory':
                return new InventoryRequestHandler($xmlBuilder);
            break;
            case 'cancelOrders':
                return new OrderCancellationRequestHandler($xmlBuilder);
            break;
            case 'returnOrders':
                return new OrderReturnRequestHandler($xmlBuilder);
            break;
            case 'updateProducts':
                return new ProductRequestHandler($xmlBuilder);
            break;
            case 'updateShipments':
                return new ShipmentRequestHandler($xmlBuilder);
            break;
            default:
                throw new IntegrationException($type . ' is not a valid request handler');
        }
    }

    protected function createXMLBuilder()
    {
        return new XMLBuilder();
    }
}
