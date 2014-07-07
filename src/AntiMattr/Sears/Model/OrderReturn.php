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
        $required = array(
            'id'                 => $this->getId(),
            'createdAt'          => $this->getCreatedAt()->format('Y-m-d'),
            'purchaseOrderId'    => $this->getPurchaseOrderId(),
            'purchaseOrderDate'  => $this->getPurchaseOrderDate()->format('Y-m-d'),
            'lineItemNumber'     => $this->getLineItemNumber(),
            'productId'          => $this->getProductId(),
            'quantity'           => $this->getQuantity(),
            'reason'             => $this->getReason(),
            'memo'               => $this->getMemo(),
        );

        $missing = array_filter($required, function($item) {
            return (null === $item) ? true : false;
        });

        if (count($missing) > 0) {
            $message = sprintf(
                'Order return requires: $s.',
                implode(", ", array_keys($missing))
            );
            throw new IntegrationException($message);
        }

        return array(
            'oa-header' => array(
                'po-number' => $required['purchaseOrderId'],
                'po-date'   => $required['purchaseOrderDate'],
            ),
            'oa-detail' => array(
                'sale-adjustment' => array(
                    'line-number' => $required['lineItemNumber'],
                    'item-id'     => $required['productId'],
                    'return'      => array(
                        'return-unique-id'  => $required['id'],
                        'return-reason'     => $required['reason'],
                        'return-date'       => $required['createdAt'],
                        'quantity'          => $required['quantity'],
                        'internal-memo'     => $required['memo'],
                    )
                )
            )
        );
    }
}
