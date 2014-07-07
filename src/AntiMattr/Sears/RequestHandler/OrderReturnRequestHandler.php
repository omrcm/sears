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
use DateTime;
use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class OrderReturnRequestHandler extends AbstractRequestHandler
{
    /** @var DateTime */
    protected $createdAt;

    /**
     * @param  Buzz\Message\Request                           $request
     * @param  Doctrine\Common\Collections\Collection         $collection
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function bindCollection(Request $request, Collection $collection)
    {
        $createdAt = $this->getCreatedAt();

        if (null === $createdAt) {
            throw new IntegrationException('CreatedAt is required');
        }

        $element = $this->xmlBuilder
            ->setRoot('dss-order-adjustment-feed')
            ->setNamespace('http://seller.marketplace.sears.com/oms/v1')
            ->setSchemaLocation('http://seller.marketplace.sears.com/oms/v1 dss-order-return-v1.xsd ')
            ->create();

        $element->addChild('date-time-stamp', $this->getCreatedAt()->format('Y-m-d\TH:i:s'));

        // Hold all IntegrationExceptions until the end
        $exceptions = array();

        foreach ($collection as $orderReturn) {
            try {
                $this->xmlBuilder->addChild($element, 'dss-order-adjustment', $orderReturn->toArray());
            } catch(IntegrationException $e) {
                $orderId      = $orderReturn->getPurchaseOrderId();
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

    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
