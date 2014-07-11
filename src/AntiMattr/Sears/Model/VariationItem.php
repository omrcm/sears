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
    protected $image;

    /** @var float */
    protected $msrp;

    /** @var string */
    protected $sellerTags;

    /** @var string */
    protected $upc;

    /**
     *
     */
    protected $variationAttributes;

    public function toArray()
    {
        $required = array(
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

        // Serialize. The order of XML elements must match the sequence laid out in the XSD.
        return array(

        );
    }

}
