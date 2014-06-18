<?php

/*
 * This file is part of the AntiMattr Payment Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\Format;

use SimpleXMLElement;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class XMLBuilder
{
    /**
     * @var array
     */
    private $data = array();

    /**
     * @var string
     */
    private $encoding = 'UTF-8';

    /**
     * @var string
     */
    private $root = 'root';

    /**
     * @var string
     */
    private $version = '1.0';

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return \SimpleXMLElement $element
     */
    public function create()
    {
        $definition = sprintf(
            '<?xml version="%s" encoding="%s"?><%s/>',
            $this->version,
            $this->encoding,
            $this->root
        );
        $element = new SimpleXMLElement($definition);
        $this->arrayToXml($this->data, $element);

        return $element;
    }

    /**
     * @param  array             $data
     * @param  \SimpleXMLElement $element
     * @return \SimpleXMLElement $element
     */
    private function arrayToXml(array $data, SimpleXMLElement $element)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $element->addChild("$key");
                    $this->arrayToXml($value, $subnode);
                } else {
                    $subnode = $element->addChild("item$key");
                    $this->arrayToXml($value, $subnode);
                }
            } else {
                $element->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }
}
