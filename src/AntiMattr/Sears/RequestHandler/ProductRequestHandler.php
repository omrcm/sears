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

use AntiMattr\Sears\Exception\IntegrationException;
use Buzz\Message\Request;
use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class ProductRequestHandler extends AbstractRequestHandler
{
    /**
     * @param  Buzz\Message\Request                           $request
     * @param  Doctrine\Common\Collections\Collection         $collection
     * @throws AntiMattr\Sears\Exception\IntegrationException
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

        $exceptions = array();

        foreach ($collection as $product) {
            try {
                $this->xmlBuilder->addChild($parent, 'item', $product->toArray());
            } catch (IntegrationException $e) {
                $productId    = $product->getId();
                $message      = $e->getMessage();
                $exceptions[] = $this->exceptionMessageForProduct($productId, $message);
            }
        }

        if (count($exceptions) > 0) {
            throw new IntegrationException(json_encode($exceptions));
        }

        $xml = $element->asXML();
        $request->setContent($xml);
    }
}
