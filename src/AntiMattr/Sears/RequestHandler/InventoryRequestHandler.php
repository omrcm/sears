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
class InventoryRequestHandler extends AbstractRequestHandler
{
    /**
     * @param  Buzz\Message\Request                           $request
     * @param  Doctrine\Common\Collections\Collection         $collection
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function bindCollection(Request $request, Collection $collection)
    {
        $element = $this->xmlBuilder
            ->setRoot('dss-inventory-feed')
            ->setNamespace('http://seller.marketplace.sears.com/inventory/v1')
            ->setSchemaLocation('http://seller.marketplace.sears.com/inventory/v1 dss-inventory.xsd ')
            ->create();

        $parent = $element->addChild('dss-inventory');

        // Hold all IntegrationExceptions until the end
        $exceptions = array();

        foreach ($collection as $inventory) {
            try {
                $this->xmlBuilder->addChild($parent, 'item', $inventory->toArray());
            } catch (IntegrationException $e) {
                $productId    = $inventory->getProductId();
                $message      = $e->getMessage();
                $exceptions[] = $this->exceptionMessageForProduct($productId, $message);
            }
        }

        $xml = $element->asXML();
        $request->setContent($xml);

        if (count($exceptions) > 0) {
            throw new IntegrationException(json_encode($exceptions));
        }
    }
}
