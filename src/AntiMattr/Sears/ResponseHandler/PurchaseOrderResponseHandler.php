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
use AntiMattr\Sears\Model\PurchaseOrder;
use AntiMattr\Sears\Model\ShippingDetail;
use Buzz\Message\Response;
use DateTime;
use Doctrine\Common\Collections\Collection;
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

    private $shippingMap = array(
        "ship-to-name" => "name",
        "address" => "streetAddress",
        "city" => "locality",
        "state" => "region",
        "zipcode" => "postalCode",
        "phone" => "phone",
        "shipping-method" => "method"
    );

    /**
     * @param Buzz\Message\Response                  $response
     * @param Doctrine\Common\Collections\Collection $collection
     */
    public function bind(Response $response, Collection $collection)
    {
        $previous = $this->doTimezoneChange();

        $content = $this->getContent($response);
        $status = $response->getStatusCode();
        if (200 !== $status) {
            $this->revertTimezoneChange($previous);
            throw new BadRequestException();
        }

        if (!isset($content->{"purchase-order"})) {
            $this->revertTimezoneChange($previous);

            return;
        }

        foreach ($content->{"purchase-order"} as $iteration) {

            $purchaseOrder = $this->createPurchaseOrder();

            // Bind Basic Properties
            foreach ($iteration as $key => $value) {
                if (!isset($this->mappings->{$key})) {
                    continue;
                }
                call_user_func_array(
                    array($purchaseOrder, sprintf('set%s', ucfirst($this->mappings->{$key}))),
                    array($value)
                );
            }

            // Build Purchase Order Date
            if (isset($iteration->{"po-date"})) {
                $createdAt = $this->createDateTime();
                $modify = $iteration->{"po-date"};
                if (isset($iteration->{"po-time"})) {
                    $modify = $modify ." ". $content->{"po-time"};
                } else {
                    $modify = $modify ." 23:59:59";
                }
                $modify = $modify ." CST";

                $createdAt->modify($modify);
                $purchaseOrder->setCreatedAt($createdAt);
            }

            // Build Ship At Date
            if (isset($iteration->{"expected-ship-date"})) {
                $shipDate = $this->createDateTime();
                $modify = $content->{"expected-ship-date"}." 23:59:59 CST";
                $shipDate->modify($modify);
                $purchaseOrder->setShipAt($shipDate);
            }

            // Build Ship Detail
            if (isset($iteration->{"shipping-detail"})) {
                $shippingDetail = $this->createShippingDetail();
                foreach ($iteration->{"shipping-detail"} as $key => $value) {
                    if (!isset($this->shippingMap->{$key})) {
                        continue;
                    }
                    call_user_func_array(
                        array($shippingDetail, sprintf('set%s', ucfirst($this->shippingMap->{$key}))),
                        array($value)
                    );
                }
            }

            $this->revertTimezoneChange($previous);
            $collection->add($purchaseOrder);
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
     * @return AntiMattr\Sears\Model\PurchaseOrder
     */
    protected function createPurchaseOrder()
    {
        return new PurchaseOrder();
    }

    /**
     * @return AntiMattr\Sears\Model\ShippingDetail
     */
    protected function createShippingDetail()
    {
        return new ShippingDetail();
    }

    /**
     * Sears API Implies all dates are CST
     * @return string | null $timezone
     */
    protected function doTimezoneChange()
    {
        try {
            $previous = date_default_timezone_get();
        } catch (\Exception $e) {
            // Do nothing
        }

        try {
            date_default_timezone_set("America/Chicago");
        } catch (\Exception $e) {
            // Do nothing
        }

        return $previous;
    }

    /**
     * @param string | null $timezone
     */
    protected function revertTimezoneChange($timezone = 'UTC')
    {
        try {
            date_default_timezone_set($timezone);
        } catch (\Exception $e) {
            // Do nothing
        }
    }
}
