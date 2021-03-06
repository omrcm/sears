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
abstract class AbstractOrderState implements RequestSerializerInterface
{
    const STATUS_CANCELED = 'Canceled';
    const STATUS_RETURNED = 'Returned';

    const REASON_DISCONTINUED = 'DISCONTINUED-ITEM';
    const REASON_OUT_OF_STOCK = 'OUT-OF-STOCK';
    const REASON_CUSTOMER = 'CUSTOMER-CHANGED-THEIR-MIND';
    const REASON_WRONG_ITEM = 'WRONG-ITEM-WAS-ORDERED';
    const REASON_LEAD_TIME = 'LEAD-TIME-IS-TOO-LONG';
    const REASON_COMPETITOR = 'ITEM-FOUND-SOMEWHERE-ELSE';
    const REASON_SHIPMENT = 'INVALID-METHOD-SHIPMENT';
    const REASON_SKU = 'INVALID-ITEM-SKU';
    const REASON_OTHER = 'OTHER';
    const REASON_ADJUSTMENT = 'GENERAL-ADJUSTMENT';

    protected static $reasons = array(
        self::REASON_DISCONTINUED,
        self::REASON_OUT_OF_STOCK,
        self::REASON_CUSTOMER,
        self::REASON_WRONG_ITEM,
        self::REASON_LEAD_TIME,
        self::REASON_COMPETITOR,
        self::REASON_SHIPMENT,
        self::REASON_SKU,
        self::REASON_OTHER,
        self::REASON_ADJUSTMENT
    );

    protected static $statuses = array(
        self::STATUS_CANCELED,
        self::STATUS_RETURNED
    );

    /** @var int */
    protected $lineItemNumber;

    /** @var string */
    protected $productId;

    /** @var DateTime */
    protected $purchaseOrderDate;

    /** @var string */
    protected $purchaseOrderId;

    /** @var string */
    protected $status;

    /** @var string */
    protected $reason;

    public function __construct()
    {
        $this->reason = self::REASON_OTHER;
        $this->status = self::STATUS_CANCELED;
    }

    /**
     * @param string $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return string $productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $lineItemNumber
     */
    public function setLineItemNumber($lineItemNumber)
    {
        $this->lineItemNumber = (int) $lineItemNumber;
    }

    /**
     * @return int $lineItemNumber
     */
    public function getLineItemNumber()
    {
        return $this->lineItemNumber;
    }

    /**
     * @return \DateTime $purchaseOrderDate
     */
    public function getPurchaseOrderDate()
    {
        return $this->purchaseOrderDate;
    }

    /**
     * @param \DateTime $purchaseOrderDate
     */
    public function setPurchaseOrderDate(DateTime $purchaseOrderDate)
    {
        $this->purchaseOrderDate = $purchaseOrderDate;
    }

    /**
     * @return string $purchaseOrderId
     */
    public function getPurchaseOrderId()
    {
        return $this->purchaseOrderId;
    }

    /**
     * @param string $purchaseOrderId
     */
    public function setPurchaseOrderId($purchaseOrderId)
    {
        $this->purchaseOrderId = $purchaseOrderId;
    }

    /**
     * @param  string                                          $reason
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function setReason($reason)
    {
        if (!in_array($reason, self::$reasons)) {
            throw new IntegrationException(sprintf('Invalid reason %s for order.', $reason));
        }

        $this->reason = $reason;
    }

    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param  string                                          $status
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function setStatus($status)
    {
        if (!in_array($status, self::$statuses)) {
            throw new IntegrationException(sprintf('Invalid status %s for order.', $status));
        }

        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
