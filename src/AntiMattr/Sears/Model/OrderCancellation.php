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
     */
    public function toArray()
    {
        return array(
            'order-cancel' => array(
                'header' => array(
                    'po-number' => $this->getPurchaseOrderId(),
                    'po-date' => $this->getPurchaseOrderDate()->format('Y-m-d')
                ),
                'detail' => array(
                    'line-number' => $this->getLineItemNumber(),
                    'item-id' => $this->getLineItemId(),
                    'cancel' => array(
                        'line-status' => $this->getStatus(),
                        'cancel-reason' => $this->getReason()
                    )
                )
            )
        );
    }
}
