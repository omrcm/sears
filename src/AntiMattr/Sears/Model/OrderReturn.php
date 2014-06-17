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
     */
    public function toArray()
    {
        return array(
            'dss-order-adjustment' => array(
                'oa-header' => array(
                    'po-number' => $this->getPurchaseOrderId(),
                    'po-date' => $this->getPurchaseOrderDate()->format('Y-m-d')
                ),
                'oa-detail' => array(
                    'sale-adjustment' => array(
                        'line-number' => $this->getLineItemNumber(),
                        'item-id' => $this->getLineItemId(),
                        'return' => array(
                            'return-unique-id' => $this->getId(),
                            'return-reason' => $this->getReason(),
                            'return-date' => $this->getCreatedAt()->format('Y-m-d'),
                            'quantity' => $this->getQuantity(),
                            'internal-memo' => $this->getMemo(),
                        )
                    )
                )
            )
        );
    }
}
