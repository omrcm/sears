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

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class Pricing implements  RequestSerializerInterface
{
    /** @var float */
    protected $cost;

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
        $data = array(
            'item-id' => $this->getProductId(),
            'cost'    => $this->getCost()
        );

        if ($msrp = $this->getMsrp()) {
            $data['msrp'] = $msrp;
        }

        $missing = array_filter($data, function($item){
            return (null === $item) ? true : false;
        });

        if (count($missing) > 0) {
            $message = sprintf(
                'Pricing requires: %s.',
                implode(", ", array_keys($missing))
            );
            throw new IntegrationException($message);
        }

        return $data;
    }
}
