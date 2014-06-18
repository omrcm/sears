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
class Product implements IdentifiableInterface, RequestSerializerInterface
{
    /** @var string */
    protected $brand;

    /** @var string */
    protected $classification;

    /** @var float */
    protected $cost;

    /** @var string */
    protected $country;

    /** @var string */
    protected $description;

    /** @var float */
    protected $height;

    /** @var string */
    protected $id;

    /** @var string */
    protected $image;

    /** @var float */
    protected $length;

    /** @var string */
    protected $model;

    /** @var string */
    protected $title;

    /** @var string */
    protected $upc;

    /** @var boolean */
    protected $warranty;

    /** @var float */
    protected $weight;

    /** @var float */
    protected $width;

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

    /**
     * @param bool $warranty
     */
    public function setWarranty($warranty)
    {
        $this->warranty = (bool) $warranty;
    }

    /**
     * @return bool $warranty
     */
    public function getWarranty()
    {
        return (!isset($this->warranty)) ? true : $this->warranty;
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
     * @return array
     * @throws \AntiMattr\Sears\Exception\IntegrationException
     */
    public function toArray()
    {
        $brand = $this->getBrand();
        $classification = $this->getClassification();
        $cost = $this->getCost();
        $country = $this->getCountry();
        $description = $this->getDescription();
        $height = $this->getHeight();
        $id = $this->getId();
        $image = $this->getImage();
        $length = $this->getLength();
        $model = $this->getModel();
        $title = $this->getTitle();
        $upc = $this->getUpc();
        $warranty = $this->getWarranty();
        $weight = $this->getWeight();
        $width = $this->getWidth();

        if (null === $brand || null === $classification || null === $cost ||
            null === $country || null === $description || null === $height ||
            null === $id || null === $image || null === $length ||
            null === $model || null === $title || null === $upc ||
            null === $warranty || null === $weight || null === $width) {
            throw new IntegrationException('brand, classification, cost, country, description, height, id, image, length, model, title, upc, warranty, weight and width are required');
        }

        return array(
           '_attributes' => array(
                'item-id' => $id
            ),
            'title' => $title,
            'short-desc' => $description,
            'upc' => $upc,
            'item-class' => array(
                '_attributes' => array(
                    'id' => $classification
                )
            ),
            'model-number' => $model,
            'cost' => $cost,
            'brand' => $brand,
            'shipping-length' => $length,
            'shipping-width' => $width,
            'shipping-height' => $height,
            'shipping-weight' => $weight,
            'image-url' => array(
                'url' => $image
            ),
            'no-warranty-available' => !$warranty,
            'country-of-origin' => array(
                'country-code' => $country
            )
        );
    }
}
