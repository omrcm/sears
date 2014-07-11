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
use Doctrine\Common\Collections\Collection;

/**
 * @author Cara Warner <warnercara@gmail.com>
 */
class VariationGroup implements IdentifiableInterface, RequestSerializerInterface
{
    /** @var string */
    protected $brand;

    /** @var string */
    protected $classification;

    /** @var string */
    protected $description;

    /** @var float */
    protected $height;

    /** @var string */
    protected $id;

    /** @var float */
    protected $length;

    /** @var string */
    protected $model;

    /** @var string */
    protected $title;

    /** @var float */
    protected $weight;

    /** @var float */
    protected $width;

    /**
     * @var
     */
    protected $variationItems;

    /**
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string $brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $classification
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;
    }

    /**
     * @return string $classification
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        if (!is_numeric($height)) {
            return;
        }

        $this->height = (float) $height;
    }

    /**
     * @return float $height
     */
    public function getHeight()
    {
        return $this->height;
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
     * @param float $length
     */
    public function setLength($length)
    {
        if (!is_numeric($length)) {
            return;
        }

        $this->length = (float) $length;
    }

    /**
     * @return string $length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return string $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        if (!is_numeric($weight)) {
            return;
        }

        $this->weight = (float) $weight;
    }

    /**
     * @return float $weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        if (!is_numeric($width)) {
            return;
        }

        $this->width = (float) $width;
    }

    /**
     * @return float $width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param Collection $items
     */
    public function setVariationItems(Collection $items)
    {
        $this->variationItems = $items;
    }

    /**
     * @return Collection $items
     */
    public function getVariationItems()
    {
        return $this->variationItems;
    }

    public function toArray()
    {
        $required = array(
            'title'           => $this->getTitle(),
            'description'     => $this->getDescription(),
            'classification'  => $this->getClassification(),
            'model'           => $this->getModel(),
            'brand'           => $this->getBrand(),
            'length'          => $this->getLength(),
            'width'           => $this->getWidth(),
            'height'          => $this->getHeight(),
            'weight'          => $this->getWeight(),
        );

        // Raise exception if any required parameters are missing
        $missing = array_filter($required, function($item){
            return (null === $item) ? true : false;
        });

        if (count($missing) > 0) {
            $message = sprintf(
                'Variation group requires: %s.',
                implode(", ", array_keys($missing))
            );
            throw new IntegrationException($message);
        }

        $variationItems = array(); // TODO

        // Serialize. The order of XML elements must match the sequence laid out in the XSD.
        return array(
            '_attributes'       => array(
                'variation-group-id' => $required['id']
            ),
            'title'             => $required['title'],
            'short-desc'        => $required['short-desc'],
            'item-class'        => array(
                '_attributes'   => array(
                    'id'        => $required['item-class-id']
                )
            ),
            'model-number'      => $required['model-number'],
            'brand'             => $required['brand'],
            'shipping-length'   => $required['shipping-length'],
            'shipping-width'    => $required['shipping-width'],
            'shipping-height'   => $required['shipping-height'],
            'shipping-weight'   => $required['shipping-weight'],
            'variation-items'   => $variationItems
        );
    }

}
