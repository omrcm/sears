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
    /** @var string */
    protected $id;

    /** @var DateTime */
    protected $createdAt;

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
}
