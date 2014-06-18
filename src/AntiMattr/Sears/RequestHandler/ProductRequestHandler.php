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

use Buzz\Message\Request;
use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class ProductRequestHandler extends AbstractRequestHandler
{
    /**
     * @param Buzz\Message\Request                   $request
     * @param Doctrine\Common\Collections\Collection $collection
     */
    public function bindCollection(Request $request, Collection $collection)
    {
        $element = $this->xmlBuilder
            ->setRoot('catalog-feed')
            ->setNamespace('http://seller.marketplace.sears.com/catalog/v5')
            ->setSchemaLocation('http://seller.marketplace.sears.com/catalog/v5 ../../../../../rest/catalog/import/v5/dss-item.xsd ')
            ->create();

        $grandParent = $element->addChild('dss-catalog');
        $parent = $grandParent->addChild('items');

        foreach ($collection as $product) {
            $this->xmlBuilder->addChild($parent, 'item', $product->toArray());
        }

        $xml = $element->asXML();
        $request->setContent($xml);
    }
}
