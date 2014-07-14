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
 * @author Cara Warner <warnercara@gmail.com>
 */
class VariationItem implements RequestSerializerInterface
{
    /** @var float */
    protected $cost;

    /** @var string */
    protected $country;

    /** @var DateTime */
    protected $effectiveStartDate;

    /** @var string */
    protected $id;

    /** @var string */
    protected $image;

    /** @var float */
    protected $msrp;

    /** @var string */
    protected $sellerTags;

    /** @var string */
    protected $upc;

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
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string $country
     */
    public function getCountry()
    {
        return (!isset($this->country)) ? 'US' : $this->country;
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
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
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
     * @param string $sellerTags
     */
    public function setSellerTags($sellerTags)
    {
        $this->sellerTags = $sellerTags;
    }

    /**
     * @return array $sellerTags
     */
    public function getSellerTags()
    {
        return $this->sellerTags;
    }

    /**
     * @param string $upc
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;
    }

    /**
     * @return string $upc
     */
    public function getUpc()
    {
        return $this->upc;
    }

    public function toArray()
    {
        $required = array(
            'id'        => $this->getId(),
            'upc'       => $this->getUpc(),
            'cost'      => $this->getCost(),
            'msrp'      => $this->getMsrp(),
            'startDate' => $this->getEffectiveStartDate()->format('Y-m-d'),
            'image'     => $this->getImage(),
            'country'   => $this->getCountry(),
        );

        // Raise exception if any required parameters are missing
        $missing = array_filter($required, function($item){
            return (null === $item) ? true : false;
        });

        if (count($missing) > 0) {
            $message = sprintf(
                'Variation item requires: %s.',
                implode(", ", array_keys($missing))
            );
            throw new IntegrationException($message);
        }

        // Prepare complex arguments
        $tags = array();
        foreach ($this->getSellerTags() as $sellerTag) {
            $tags[] = array('seller-tag' => $sellerTag);
        }

        $attributes = array(); //TODO

        // Serialize. The order of XML elements must match the sequence laid out in the XSD.
        return array(
            'upc'                   => $required['upc'],
            'item-prices'           => array(
                'item-price'        => array(
                    'cost'          => $required['cost'],
                    'msrp'          => $required['msrp'],
                    'effective-start-date' => $required['effective-start-date'],
                )
            ),
            'image-url'             => $required['image'],
            'variation-attributes'  => $attributes,
            'country-of-origin'     => array(
                'country-code'      => $required['country']
            ),
            'seller-tags'           => $tags,
        );
    }

}
