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
use DateTime;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class OrderReturn extends AbstractOrderState implements IdentifiableInterface
{
    /** @var DateTime */
    protected $createdAt;

    /** @var string */
    protected $id;

    /** @var string */
    protected $memo;

    /** @var int */
    protected $quantity;

    public function __construct()
    {
        $this->reason = self::REASON_ADJUSTMENT;
        $this->status = self::STATUS_RETURNED;
    }

    /**
     * @param DateTime
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param int
     */
    public function setQuantity($quantity)
    {
        if (!is_numeric($quantity)) {
            return;
        }

        $this->quantity = (int) $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
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
        $id = $this->getId();
        $reason = $this->getReason();
        $createdAt = $this->getCreatedAt();
        $quantity = $this->getQuantity();
        $memo = $this->getMemo();

        if (null === $purchaseOrderId || null === $purchaseOrderDate || null === $lineItemNumber ||
            null === $productId || null === $id || null === $reason ||
            null === $createdAt || null === $quantity || null === $memo) {
            throw new IntegrationException('PurchaseOrderID, PurchaseOrderDate, LineItemNumber, ProductID, ID, Reason, CreatedAt, Quantity and Memo are required');
        }

        return array(
            'dss-order-adjustment' => array(
                'oa-header' => array(
                    'po-number' => $purchaseOrderId,
                    'po-date' => $purchaseOrderDate->format('Y-m-d')
                ),
                'oa-detail' => array(
                    'sale-adjustment' => array(
                        'line-number' => $lineItemNumber,
                        'item-id' => $productId,
                        'return' => array(
                            'return-unique-id' => $id,
                            'return-reason' => $reason,
                            'return-date' => $createdAt->format('Y-m-d'),
                            'quantity' => $quantity,
                            'internal-memo' => $memo,
                        )
                    )
                )
            )
        );
    }
}
