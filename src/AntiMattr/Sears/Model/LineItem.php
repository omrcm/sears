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
class LineItem implements IdentifiableInterface
{

    /** @var string */
    protected $commissionPerUnit;

    /** @var string */
    protected $handlingInd;

    /** @var string */
    protected $handlingInstructions;

    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $number;

    /** @var string */
    protected $pricePerUnit;

    /** @var string */
    protected $quantity;

    /** @var string */
    protected $shippingHandling;

    /**
     * @return string $commissionPerUnit
     */
    public function getCommissionPerUnit()
    {
        return $this->commissionPerUnit;
    }

    /**
     * @param string $commissionPerUnit
     */
    public function setCommissionPerUnit($commissionPerUnit)
    {
        $this->commissionPerUnit = $commissionPerUnit;
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
     * @return string $pricePerUnit
     */
    public function getPricePerUnit()
    {
        return $this->pricePerUnit;
    }

    /**
     * @param string $pricePerUnit
     */
    public function setPricePerUnit($pricePerUnit)
    {
        $this->pricePerUnit = $pricePerUnit;
    }

    /**
     * @return string $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
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
}
