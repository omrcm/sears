<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\Model;

use AntiMattr\Sears\Exception\IntegrationException;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class OrderCancellation extends AbstractOrderState
{
    public function __construct()
    {
        $this->reason = self::REASON_OTHER;
        $this->status = self::STATUS_CANCELED;
    }

    /**
     * @return array
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function toArray()
    {
        $required = array(
            'purchaseOrderId'   => $this->getPurchaseOrderId(),
            'purchaseOrderDate' => $this->getPurchaseOrderDate()->format('Y-m-d'),
            'lineItemNumber'    => $this->getLineItemNumber(),
            'productId'         => $this->getProductId(),
            'status'            => $this->getStatus(),
            'reason'            => $this->getReason(),
        );

        $missing = array_filter($required, function($item){
            return (null === $item) ? true : false;
        });

        if (count($missing) > 0) {
            $message = sprintf(
                'Order Cancellation requires: %s.',
                implode(", ", array_keys($missing))
            );
            throw new IntegrationException($message);
        }

        return array(
            'header' => array(
                'po-number' => $required['purchaseOrderId'],
                'po-date'   => $required['purchaseOrderDate'],
            ),
            'detail' => array(
                'line-number' => $required['lineItemNumber'],
                'item-id'     => $required['productId'],
                'cancel'      => array(
                    'line-status'   => $required['status'],
                    'cancel-reason' => $required['reason']
                )
            )
        );
    }
}
