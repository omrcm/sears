<?php

/*
 * This file is part of the AntiMattr Payment Library, a library by Matthew Fitzgerald.
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
class Shipment implements IdentifiableInterface, RequestHandlerInterface
{
    /** @var string */
    protected $carrier;

    /** @var string */
    protected $id;

    /** @var string */
    protected $lineItemId;

    /** @var int */
    protected $lineItemNumber;

    /** @var string */
    protected $method;

    /** @var DateTime */
    protected $purchaseOrderDate;

    /** @var string */
    protected $purchaseOrderId;

    /** @var int */
    protected $quantity;

    /** @var DateTime */
    protected $shipAt;

    /** @var string */
    protected $trackingNumber;

    /**
     * @return string $carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param string $carrier
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    }

    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $lineItemId
     */
    public function setLineItemId($lineItemId)
    {
        $this->lineItemId = $lineItemId;
    }

    /**
     * @return string $lineItemId
     */
    public function getLineItemId()
    {
        return $this->lineItemId;
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
     * @return string $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
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
     * @return DateTime $shipAt
     */
    public function getShipAt()
    {
        return $this->shipAt;
    }

    /**
     * @param DateTime $shipAt
     */
    public function setShipAt(DateTime $shipAt)
    {
        $this->shipAt = $shipAt;
    }

    /**
     * @return string $trackingNumber
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * @param string $trackingNumber
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'shipment' => array(
                'header' => array(
                    'asn-number' => $this->getId(),
                    'po-number' => $this->getPurchaseOrderId(),
                    'po-date' => $this->getPurchaseOrderDate()->format('Y-m-d')
                ),
                'detail' => array(
                    'tracking-number' => $this->getTrackingNumber(),
                    'ship-date' => $this->getShipAt()->format('Y-m-d'),
                    'shipping-carrier' => $this->getCarrier(),
                    'shipping-method' => $this->getMethod(),
                    'package-detail' => array(
                        'line-number' => $this->getLineItemNumber(),
                        'item-id' => $this->getLineItemId(),
                        'quantity' => $this->getQuantity()
                    )
                )
            )
        );
    }
}
