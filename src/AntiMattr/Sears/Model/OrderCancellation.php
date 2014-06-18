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
        $purchaseOrderId = $this->getPurchaseOrderId();
        $purchaseOrderDate = $this->getPurchaseOrderDate();
        $lineItemNumber = $this->getLineItemNumber();
        $productId = $this->getProductId();
        $status = $this->getStatus();
        $reason = $this->getReason();

        if (null === $purchaseOrderId || null === $purchaseOrderDate || null === $lineItemNumber ||
            null === $productId || null === $status || null === $reason) {
            throw new IntegrationException('PurchaseOrderID, PurchaseOrderDate, LineItemNumber, ProductID, Status and Reason are required');
        }

        return array(
            'header' => array(
                'po-number' => $purchaseOrderId,
                'po-date' => $purchaseOrderDate->format('Y-m-d')
            ),
            'detail' => array(
                'line-number' => $lineItemNumber,
                'item-id' => $productId,
                'cancel' => array(
                    'line-status' => $status,
                    'cancel-reason' => $reason
                )
            )
        );
    }
}
