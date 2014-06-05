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
class PurchaseOrder implements IdentifiableInterface
{
    /** @var string */
    protected $channel;

    /** @var DateTime */
    protected $createdAt;

    /** @var string */
    protected $email;

    /** @var string */
    protected $id;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $orderId;

    /** @var string */
    protected $unit;

    /** @var DateTime */
    protected $shipAt;

    /** @var AntiMattr\Sears\Model\ShippingDetail */
    protected $shippingDetail;

    /** @var string */
    protected $site;

    /**
     * @return string $channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return string $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return string $locationId
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param string $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return string $orderId
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
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
     * @return AntiMattr\Sears\Model\ShippingDetail $shippingDetail
     */
    public function getShippingDetail()
    {
        return $this->shippingDetail;
    }

    /**
     * @param AntiMattr\Sears\Model\ShippingDetail $shippingDetail
     */
    public function setShippingDetail(ShippingDetail $shippingDetail)
    {
        $this->shippingDetail = $shippingDetail;
    }

    /**
     * @return string $site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return string $unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

}
