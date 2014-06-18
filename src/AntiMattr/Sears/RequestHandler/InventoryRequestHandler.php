<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\RequestHandler;

use AntiMattr\Sears\Model\Inventory;
use Buzz\Message\Request;
use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class InventoryRequestHandler extends AbstractRequestHandler
{
    /**
     * @param Buzz\Message\Request                   $request
     * @param Doctrine\Common\Collections\Collection $collection
     */
    public function bindCollection(Request $request, Collection $collection)
    {
        $data = array();
        foreach ($collection as $inventory) {
            $data[] = $inventory->toArray();
        }

        $element = $this->xmlBuilder
            ->setRoot('dss-inventory-feed')
            ->setData($data)
            ->create();

        $xml = $element->asXML();
        $request->setContent($xml);
    }
}
