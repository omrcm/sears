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
class Pricing implements  RequestSerializerInterface
{
    /** @var float */
    protected $cost;

    /** @var DateTime */
    protected $effectiveStartDate;

    /** @var float */
    protected $msrp;

    /** @var string */
    protected $productId;

    /**
     * @param float $cost
     */
    public function setCost($cost)
    {
        if (!is_numeric($cost)) {
            return;
        }

        $this->cost = (float) $cost;
    }

    /**
     * @return float $cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param DateTime $startDate
     */
    public function setEffectiveStartDate(DateTime $startDate)
    {
        $this->effectiveStartDate = $startDate;
    }

    /**
     * @return DateTime $effectiveStartDate
     */
    public function getEffectiveStartDate()
    {
        return $this->effectiveStartDate;
    }

    /**
     * @param float $msrp
     */
    public function setMsrp($msrp)
    {
        if (!is_numeric($msrp)) {
            return;
        }

        $this->msrp = (float) $msrp;
    }

    /**
     * @return float $msrp
     */
    public function getMsrp()
    {
        return $this->msrp;
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
     * @return array
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function toArray()
    {
        $required = array(
            'id'                   => $this->getProductId(),
            'cost'                 => $this->getCost(),
            'msrp'                 => $this->getMsrp(),
            'effective-start-date' => $this->getEffectiveStartDate() ? $this->getEffectiveStartDate()->format('Y-m-d') : null,
        );

        $missing = array_filter($required, function($item){
            return (null === $item) ? true : false;
        });

        if (count($missing) > 0) {
            $message = sprintf(
                'Pricing requires: %s.',
                implode(", ", array_keys($missing))
            );
            throw new IntegrationException($message);
        }

        return array(
            'item-id' => $required['id'],
            'item-prices' => array(
                'item-price' => array(
                    'cost'                 => $required['cost'],
                    'msrp'                 => $required['msrp'],
                    'effective-start-date' => $required['effective-start-date'],
                )
            ),
        );
    }
}
