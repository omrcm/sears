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
class Inventory implements RequestHandlerInterface
{
    /** @var string */
    protected $productId;

    /** @var int */
    protected $quantity;

    /** @var int */
    protected $threshold;

    /** @var DateTime */
    protected $updatedAt;

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'item' => array(
                'quantity' => $this->getQuantity(),
                'low-inventory-threshold' => $this->getThreshold(),
                'inventory-timestamp' => $this->getUpdatedAt()->format('Y-m-d\TH:i:s')
            )
        );
    }

    /**
     * @return string $productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return int $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        if (!is_numeric($quantity)) {
            return;
        }

        $this->quantity = (int) $quantity;
    }

    /**
     * @return int $threshold
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param int $threshold
     */
    public function setThreshold($threshold)
    {
        if (!is_numeric($threshold)) {
            return;
        }

        $this->threshold = (int) $threshold;
    }

    /**
     * @return DateTime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
