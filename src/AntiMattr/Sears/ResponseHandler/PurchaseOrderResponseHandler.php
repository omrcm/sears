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
use AntiMattr\Sears\Model\LineItem;
use AntiMattr\Sears\Model\PurchaseOrder;
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
        "sales-tax" => "tax",
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

    private $lineItemMap = array(
        "line-number" => "number",
        "item-id" => "productId",
        "item-name" => "productName",
        "handling-instructions" => "handlingInstructions",
        "handling-ind" => "handlingInd",
        "selling-price-each" => "pricePerUnit",
        "commission" => "commissionPerUnit",
        "order-quantity" => "quantity",
        "shipping-and-handling" => "shippingHandling"
    );

    /**
     * @param  Buzz\Message\Response                              $response
     * @param  Doctrine\Common\Collections\Collection             $collection
     * @throws AntiMattr\Sears\Exception\Http\BadRequestException
     */
    public function bindCollection(Response $response, Collection $collection)
    {
        $content = $this->getContent($response);
        $status = $response->getStatusCode();

        if (200 !== $status) {
            throw new BadRequestException('Response Status Code '. $status);
        }

        if (!isset($content->{"purchase-order"})) {
            return;
        }

        // Sometimes there is only one order
        $purchaseOrders = $content->{"purchase-order"};
        if (!is_array($purchaseOrders)) {
            $purchaseOrders = array($purchaseOrders);
        }

        foreach ($purchaseOrders as $iteration) {

            $purchaseOrder = $this->createPurchaseOrder();

            // Bind Basic Properties
            foreach ($iteration as $key => $value) {
                if (!isset($this->mappings[$key])) {
                    continue;
                }

                call_user_func_array(
                    array($purchaseOrder, sprintf('set%s', ucfirst($this->mappings[$key]))),
                    array($value)
                );
            }

            // Build Purchase Order Date
            if (isset($iteration->{"po-date"})) {
                $modify = $iteration->{"po-date"};
                if (isset($iteration->{"po-time"})) {
                    $modify = $modify ." ". $iteration->{"po-time"};
                } else {
                    $modify = $modify ." 23:59:59";
                }
                $modify = $modify ." CST";

                $createdAt = $this->createDateTime($modify);
                $purchaseOrder->setCreatedAt($createdAt);
            }

            // Build Ship At Date
            if (isset($iteration->{"expected-ship-date"})) {
                $modify = $iteration->{"expected-ship-date"}." 23:59:59 CST";
                $shipDate = $this->createDateTime($modify);
                $purchaseOrder->setShipAt($shipDate);
            }

            // Build Ship Detail
            if (isset($iteration->{"shipping-detail"})) {
                $shippingDetail = $purchaseOrder->getShippingDetail();
                foreach ($iteration->{"shipping-detail"} as $key => $value) {
                    if (!isset($this->shippingMap[$key])) {
                        continue;
                    }
                    call_user_func_array(
                        array($shippingDetail, sprintf('set%s', ucfirst($this->shippingMap[$key]))),
                        array($value)
                    );
                }
                $hash = $shippingDetail->getHash();
                $shippingDetail->setId($hash);
                $purchaseOrder->setShippingDetail($shippingDetail);
            }

            // Build Line Items
            if (isset($iteration->{"po-line"})) {
                $items = $purchaseOrder->getItems();
                if (is_array($iteration->{"po-line"})) {
                    foreach ($iteration->{"po-line"} as $line) {
                        $lineItem = $this->buildLineItem($purchaseOrder, $line);
                        if (null !== $lineItem) {
                            $items->add($lineItem);
                        }
                    }
                } else {
                    $line = $iteration->{"po-line"};
                    $lineItem = $this->buildLineItem($purchaseOrder, $line);
                    if (null !== $lineItem) {
                        $items->add($lineItem);
                    }
                }
            }

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
     * @param string
     * @return DateTime
     */
    protected function createDateTime($string = null)
    {
        return new DateTime($string, new \DateTimeZone('CST'));
    }

    /**
     * @return AntiMattr\Sears\Model\LineItem
     */
    protected function createLineItem()
    {
        return new LineItem();
    }

    /**
     * @return AntiMattr\Sears\Model\PurchaseOrder
     */
    protected function createPurchaseOrder()
    {
        return new PurchaseOrder();
    }

    /**
     * @param AntiMattr\Sears\Model\PurchaseOrder
     * @param stdClass         
     * @return AntiMattr\Sears\Model\LineItem
     */
    protected function buildLineItem(PurchaseOrder $purchaseOrder, $line)
    {
        if (!isset($line->{"po-line-header"})) {
            continue;
        }
        $lineItem = $this->createLineItem();
        $lineItem->setPurchaseOrder($purchaseOrder);
        foreach ($line->{"po-line-header"} as $key => $value) {
            if (!isset($this->lineItemMap[$key])) {
                continue;
            }
            call_user_func_array(
                array($lineItem, sprintf('set%s', ucfirst($this->lineItemMap[$key]))),
                array($value)
            );
        }
        return $lineItem;
    }    
}
