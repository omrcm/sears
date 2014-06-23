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

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class LineItem
{

    /** @var float */
    protected $commissionPerUnit;

    /** @var string */
    protected $handlingInd;

    /** @var string */
    protected $handlingInstructions;

    /** @var string */
    protected $number;

    /** @var float */
    protected $pricePerUnit;

    /** @var string */
    protected $productId;

    /** @var string */
    protected $productName;

    /** @var AntiMattr\Sears\Model\PurchaseOrder */
    protected $purchaseOrder;

    /** @var int */
    protected $quantity;

    /** @var float */
    protected $shippingHandling;

    /**
     * @return float $commissionPerUnit
     */
    public function getCommissionPerUnit()
    {
        return $this->commissionPerUnit;
    }

    /**
     * @param float $commissionPerUnit
     */
    public function setCommissionPerUnit($commissionPerUnit)
    {
        if (!is_numeric($commissionPerUnit)) {
            return;
        }

        $this->commissionPerUnit = (float) $commissionPerUnit;
    }

    /**
     * @return string $handlingInd
     */
    public function getHandlingInd()
    {
        return $this->handlingInd;
    }

    /**
     * @param string $handlingInd
     */
    public function setHandlingInd($handlingInd)
    {
        $this->handlingInd = $handlingInd;
    }

    /**
     * @return string $handlingInstructions
     */
    public function getHandlingInstructions()
    {
        return $this->handlingInstructions;
    }

    /**
     * @param string $handlingInstructions
     */
    public function setHandlingInstructions($handlingInstructions)
    {
        $this->handlingInstructions = $handlingInstructions;
    }

    /**
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return float $pricePerUnit
     */
    public function getPricePerUnit()
    {
        return $this->pricePerUnit;
    }

    /**
     * @param float $pricePerUnit
     */
    public function setPricePerUnit($pricePerUnit)
    {
        if (!is_numeric($pricePerUnit)) {
            return;
        }

        $this->pricePerUnit = (float) $pricePerUnit;
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
     * @return string $productName
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return AntiMattr\Sears\Model\PurchaseOrder
     */
    public function getPurchaseOrder()
    {
        return $this->purchaseOrder;
    }

    /**
     * @param AntiMattr\Sears\Model\PurchaseOrder $purchaseOrder
     */
    public function setPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
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

        $this->quantity = (int) floor((float) $quantity);
    }

    /**
     * @return float $shippingHandling
     */
    public function getShippingHandling()
    {
        return $this->shippingHandling;
    }

    /**
     * @param float $shippingHandling
     */
    public function setShippingHandling($shippingHandling)
    {
        if (!is_numeric($shippingHandling)) {
            return;
        }

        $this->shippingHandling = (float) $shippingHandling;
    }
}
