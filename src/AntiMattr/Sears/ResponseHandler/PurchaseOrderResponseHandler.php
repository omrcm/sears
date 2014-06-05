<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\ResponseHandler;

use AntiMattr\Sears\Exception\Http\BadRequestException;
use AntiMattr\Sears\Model\IdentifiableInterface;
use AntiMattr\Sears\Model\ShippingDetail;
use Buzz\Message\Response;
use DateTime;
use SimpleXMLElement;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class PurchaseOrderResponseHandler implements ResponseHandlerInterface
{
    private $mappings = array(
        "customer-order-confirmation-number" => "orderId",
        "customer-email" => "email",
        "po-number" => "id",
        "unit" => "unit",
        "site" => "site",
        "channel" => "channel",
        "location-id" => "locationId",
        "customer-name" => "name",
        "order-total-sell-price" => "total",
        "total-commission" => "commission",
        "total-shipping-handling" => "shippingHandling",
        "balance-due" => "balance",
        "sale-tax" => "tax",
        "po-status" => "status"
    );

    /**
     * @param Buzz\Message\Response               $response
     * @param AntiMattr\Sears\Model\PurchaseOrder $purchaseOrder
     */
    public function bind(Response $response, IdentifiableInterface $purchaseOrder)
    {
        $content = $this->getContent($response);
        $status = $response->getStatusCode();

        if (200 !== $status) {
            throw new BadRequestException();
        }

        // Bind Basic Properties
        foreach ($content as $key => $value) {
            if (!isset($this->mappings->{$key})) {
                continue;
            }
            call_user_func_array(
                array($purchaseOrder, sprintf('set%s', ucfirst($this->mappings->{$key}))),
                array($value)
            );
        }

        // Build Purchase Order Date
        if (isset($content->{"po-date"})) {
            $createdAt = $this->createDateTime();
            $modify = $content->{"po-date"};
            if (isset($content->{"po-time"})) {
                $modify = $modify ." ". $content->{"po-time"});
            } else {
                $modify = $modify ." 00:00:00";
            }
            $purchaseOrderDate->modify($modify);
            $purchaseOrder->setCreatedAt($createdAt);
        }

        // Build Expected Ship Date Date
        if (isset($content->{"expected-ship-date"})) {
            $shipDate = $this->createDateTime();
            $modify = $content->{"expected-ship-date"}." 23:59:59";
            $shipDate->modify($modify);
            $purchaseOrder->setShipAt($shipDate);
        }

        if (isset($content->{"shipping-detail"})) {
            $shippingDetail = $this->createShippingDetail();
            $shippingMap = array(
                "ship-to-name" => "name",
                "address" => "streetAddress",
                "city" => "locality",
                "state" => "region",
                "zipcode" => "postalCode",
                "phone" => "phone",
                "shipping-method" => "method"
            );
            foreach ($content->{"shipping-detail"} as $key => $value) {
                if (!isset($shippingMap->{$key})) {
                    continue;
                }
                call_user_func_array(
                    array($shippingDetail, sprintf('set%s', ucfirst($shippingMap->{$key}))),
                    array($value)
                );
            }
        }
    }

    /**
     * @param  Buzz\Message\Response $response
     * @return stdClass              $xml
     */
    protected function getContent(Response $response)
    {
        $element = new SimpleXMLElement($response->getContent());

        return json_decode(json_encode($element));
    }

    /**
     * @return DateTime
     */
    protected function createDateTime()
    {
        return new DateTime();
    }

    /**
     * @return AntiMattr\Sears\Model\ShippingDetail
     */
    protected function createShippingDetail()
    {
        return new ShippingDetail();
    }
}
