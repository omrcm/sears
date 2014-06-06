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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class PurchaseOrder implements IdentifiableInterface
{
    /** @var string */
    protected $balance;

    /** @var string */
    protected $channel;

    /** @var string */
    protected $commission;

    /** @var DateTime */
    protected $createdAt;

    /** @var string */
    protected $email;

    /** @var string */
    protected $id;

    /** @var Doctrine\Common\Collections\ArrayCollection */
    protected $items;

    /** @var string */
    protected $locationId;

    /** @var string */
    protected $name;

    /** @var string */
    protected $orderId;

    /** @var DateTime */
    protected $shipAt;

    /** @var AntiMattr\Sears\Model\ShippingDetail */
    protected $shippingDetail;

    /** @var string */
    protected $shippingHandling;

    /** @var string */
    protected $site;

    /** @var string */
    protected $status;

    /** @var string */
    protected $tax;

    /** @var string */
    protected $total;

    /** @var string */
    protected $unit;

    public function __construct()
    {
        $this->shippingDetail = new ShippingDetail();
        $this->items = new ArrayCollection();
    }

    /**
     * @return string $balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param string $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

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
     * @return string $commission
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param string $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
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
     * @return Doctrine\Common\Collections\ArrayCollection $items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Doctrine\Common\Collections\ArrayCollection $items
     */
    public function setItems($items)
    {
        $this->items = $item;
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
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return string $shippingHandling
     */
    public function getShippingHandling()
    {
        return $this->shippingHandling;
    }

    /**
     * @param string $shippingHandling
     */
    public function setShippingHandling($shippingHandling)
    {
        $this->shippingHandling = $shippingHandling;
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
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return string $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param string $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
