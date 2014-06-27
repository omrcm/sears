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
class PricingRequestHandler extends AbstractRequestHandler
{
    /**
     * @param  Buzz\Message\Request                           $request
     * @param  Doctrine\Common\Collections\Collection         $collection
     * @throws AntiMattr\Sears\Exception\IntegrationException
     */
    public function bindCollection(Request $request, Collection $collection)
    {
        $element = $this->xmlBuilder
            ->setRoot('dss-pricing-feed')
            ->setNamespace('http://seller.marketplace.sears.com/pricing/v2')
            ->setSchemaLocation('http://seller.marketplace.sears.com/pricing/v2 dss-seller-pricing.xsd ')
            ->create();

        $parent = $element->addChild('dss-pricing');

        foreach ($collection as $pricing) {
            $this->xmlBuilder->addChild($parent, 'item', $pricing->toArray());
        }

        $xml = $element->asXML();
        $request->setContent($xml);
    }
}