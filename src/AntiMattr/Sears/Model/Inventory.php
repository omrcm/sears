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
class Inventory implements RequestSerializerInterface
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

    /**
     * @return array
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function toArray()
    {
        $productId = $this->getProductId();
        $quantity = $this->getQuantity();
        $threshold = $this->getThreshold();
        $updatedAt = $this->getUpdatedAt();

        if (null === $productId || null === $quantity || null === $threshold || null === $updatedAt) {
            throw new IntegrationException('ProductID, Quantity, Threshold and UpdatedAt are required');
        }

        return array(
            '_attributes' => array(
                'item-id' => $productId
            ),
            'quantity' => $quantity,
            'low-inventory-threshold' => $threshold,
            'inventory-timestamp' => $updatedAt->format('Y-m-d\TH:i:s')
        );
    }
}
