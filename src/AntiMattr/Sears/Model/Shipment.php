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

use AntiMattr\Sears\Exception\IntegrationException;
use DateTime;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class Shipment implements IdentifiableInterface, RequestHandlerInterface
{
    const CARRIER_UPS = 'UPS';
    const CARRIER_FDE = 'FDE';
    const CARRIER_OTH = 'OTH';
    const CARRIER_USPS = 'USPS';

    const METHOD_GROUND = 'GROUND';
    const METHOD_PRIORITY = 'PRIORITY';
    const METHOD_EXPRESS = 'EXPRESS';
    const METHOD_PICKUP = 'PICKUP';

    protected static $carriers = array(
        self::CARRIER_UPS,
        self::CARRIER_FDE,
        self::CARRIER_OTH,
        self::CARRIER_USPS
    );

    protected static $methods = array(
        self::METHOD_GROUND,
        self::METHOD_PRIORITY,
        self::METHOD_EXPRESS,
        self::METHOD_PICKUP,
    );

    /** @var string */
    protected $carrier;

    /** @var string */
    protected $id;

    /** @var int */
    protected $lineItemNumber;

    /** @var string */
    protected $method;

    /** @var string */
    protected $productId;

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

    public function __construct()
    {
        $this->carrier = self::CARRIER_UPS;
        $this->method = self::METHOD_GROUND;
    }

    /**
     * @return string $carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param  string                                          $carrier
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function setCarrier($carrier)
    {
        if (!in_array($carrier, self::$carriers)) {
            throw new IntegrationException(sprintf('Invalid carrier %s for shipment.', $carrier));
        }
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
     * @param  string                                          $method
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function setMethod($method)
    {
        if (!in_array($method, self::$methods)) {
            throw new IntegrationException(sprintf('Invalid method %s for shipment.', $method));
        }
        $this->method = $method;
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
