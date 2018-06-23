<?php

namespace RCaller\Client\Observer;


use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use PHPUnit\Framework\Exception;
use rcaller\adapter\MagentoAdaptedIOC;
use rcaller\adapter\RCallerAdapterImport;
use rcaller\lib\RCallerImport;


$om = \Magento\Framework\App\ObjectManager::getInstance();
$reader = $om->get('Magento\Framework\Module\Dir\Reader');
$moduleDir = $reader->getModuleDir("", "RCaller_Client");
include_once $moduleDir . "/lib/RCallerImport.php";
include_once $moduleDir . "/adapter/RCallerAdapterImport.php";
RCallerImport::importRCallerLib();
RCallerAdapterImport::importAdapter();

class SendOrderToRCallerObserver implements ObserverInterface
{
    public function __construct()
    {
    }

    public function execute(Observer $observer)
    {
        $orders = $this->extractOrders(
            $observer->getEvent()
        );

        if (null === $orders) {
            return;
        }

        foreach ($orders as $order) {
            $this->sendOrderToRCaller($order);
        }
    }

    /**
     *
     * @param OrderInterface $order
     * @return void
     */
    private function sendOrderToRCaller($order)
    {
        $address = $this->resolveAddressFromOrder($order);

        $externalOrderId = $order->getId();
        $total = $order->getGrandTotal() . "";
        $entries = $this->getOrderEntries($order);
        $addressLine = $this->getAddressAsString($address);
        $phone = $address->getTelephone();
        $customerName = $this->getCustomerName($address);
        $currency = $order->getOrderCurrencyCode();

        $client = MagentoAdaptedIOC::getIOC()->getRCallerClient();
        $client->sendOrderToRCaller($externalOrderId, $total, $entries, $addressLine, $phone, $customerName, $currency);
    }


    /**
     * @param $address
     * @return string
     */
    private function getCustomerName($address)
    {
        return $address->getStoredData()["firstname"] . " " . $address->getStoredData()["lastname"];
    }

    /**
     * @param OrderInterface $order
     * @return array
     */
    private function getOrderEntries($order)
    {
        $result = array();
        foreach ($order->getItems() as $entry) {
            if ($this->isEndVariant($entry)) {
                array_push($result, $entry);
            }
        }
        return $result;
    }

    /**
     * @param OrderItemInterface $entry
     * @return boolean
     */
    private function isEndVariant($entry)
    {
        return !$entry->getHasChildren();
    }


    /**
     * @param OrderAddressInterface $address
     * @return string
     */
    private function getAddressAsString($address)
    {
        $city = $address->getCity();
        $street = $address->getStreet();
        return 'г. ' . $city . ', ул. ' . $street[0];
    }

    /**
     * @param $errorMessage
     */
    private function logAndThrowException($errorMessage)
    {
        error_log($errorMessage);
        new Exception($errorMessage);
    }

    private function extractOrders(Event $event)
    {
        $order = $event->getData('order');
        if (null !== $order) {
            return [$order];
        }

        return $event->getData('orders');
    }

    private function resolveAddressFromOrder($order)
    {
        $shippingAddress = $order->getShippingAddress();
        if ($shippingAddress != null) {
            return $shippingAddress;
        } else {
            $billingAddress = $order->getBillingAddress();
            if ($billingAddress != null) {
                return $billingAddress;
            }
        }
        $errorMessage = "Can not extract customer phone from shipping or billing address";
        throw $this->logAndThrowException($errorMessage);

    }
}