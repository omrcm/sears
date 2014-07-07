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

use AntiMattr\Sears\Exception\IntegrationException;
use Buzz\Message\Request;
use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class OrderCancellationRequestHandler extends AbstractRequestHandler
{
    /**
     * @param  Buzz\Message\Request                           $request
     * @param  Doctrine\Common\Collections\Collection         $collection
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function bindCollection(Request $request, Collection $collection)
    {
        $element = $this->xmlBuilder
            ->setRoot('order-cancel-feed')
            ->setNamespace('http://seller.marketplace.sears.com/oms/v1')
            ->setSchemaLocation('http://seller.marketplace.sears.com/oms/v1 order-cancel.xsd ')
            ->create();

        // Hold all IntegrationExceptions until the end
        $exceptions = array();

        foreach ($collection as $orderCancellation) {
            try {
                $this->xmlBuilder->addChild($element, 'order-cancel', $orderCancellation->toArray());
            } catch(IntegrationException $e) {
                $orderId      = $orderCancellation->getPurchaseOrderId();
                $message      = $e->getMessage();
                $exceptions[] = $this->exceptionMessageForOrder($orderId, $message);

            }
        }

        $xml = $element->asXML();
        $request->setContent($xml);

        if (count($exceptions) > 0) {
            throw new IntegrationException(json_encode($exceptions));
        }
    }
}
