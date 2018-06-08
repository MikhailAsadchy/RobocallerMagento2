<?php

namespace RCaller\Client\Service;


use Magento\Framework\App\ObjectManager;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Variable\Model\Variable;
use PHPUnit\Framework\Exception;

class RCallerSender
{
    public function __construct()
    {
    }

    /**
     * Creates Signifyd case for single order with online payment method.
     *
     * @param OrderInterface $order
     * @return void
     */
    public function sendOrderToRCaller($order)
    {
        try {
            $data = array(
                'price' => $order->getGrandTotal() . "",
                'entries' => $this->getEntriesAsString($order),
                'customerAddress' => $this->getShippingOrBillingAddress($order),
                'customerPhone' => $this->getPhoneFromBillingOrShippingAddress($order),
                'customerName' => $this->getCustomerName($order),
                'priceCurrency' => $order->getOrderCurrencyCode(),
                'channel' => "MAGENTO");
            $variable = ObjectManager::getInstance()->get(Variable::class);

            $username = $variable->loadByCode('rcaller_username')->getValue('plain');
            $password = $variable->loadByCode('rcaller_password')->getValue('plain');

            $this->sendOrderToRCallerInternal($data, $username, $password);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

    }

    // todo make private access

    /**
     * @param $data
     * @param $username
     * @param $password
     * @return int
     */
    public function sendOrderToRCallerInternal($data, $username, $password)
    {
        $rcallerConfig = parse_ini_file("rcaller-config.ini");
        $curl = curl_init($rcallerConfig["rcaller.url"]);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $rcallerConfig["rcaller.connectionTimeOut"]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode;
    }

    /**
     * @param OrderInterface $order
     * @return string
     */
    private function getCustomerName($order)
    {
        return $order->getCustomerLastname() . " " . $order->getCustomerFirstname() . " " . $order->getCustomerMiddlename();
    }

    /**
     * @param OrderInterface $order
     * @return string
     */
    private function getEntriesAsString($order)
    {
        $entriesAsStrings = [];
        foreach ($order->getItems() as $entry) {
            if ($this->isEndVariant($entry)) {
                $entryAsString = $entry->getName() . " " . $entry->getQtyOrdered() . " шт.";
                array_push($entriesAsStrings, $entryAsString);
            }
        }

        return join(" | ", $entriesAsStrings);
    }

    /**
     * @param Magento\Sales\Api\Data\OrderItemInterface $entry
     * @return boolean
     */
    private function isEndVariant($entry) {
        return !$entry->getHasChildren();
    }

    /**
     * @param OrderInterface $order
     * @return string
     */
    private function getShippingOrBillingAddress($order)
    {
        $shippingAddress = $this->getAddressAsString($order->getShippingAddress());

        if (!empty($shippingAddress)) {
            return $shippingAddress;
        } else {
            $billingAddress = $this->getAddressAsString($order->getBillingAddress());
            if (!empty($billingAddress)) {
                return $billingAddress;
            }
        }
        $errorMessage = "Can not extract address line from shipping or billing address";
        $this->logAndThrowException($errorMessage);
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
     * @param OrderInterface $order
     * @return string
     */
    private function getPhoneFromBillingOrShippingAddress($order)
    {
        $phoneFromShipping = $order->getShippingAddress()->getTelephone();

        if (!empty($phoneFromShipping)) {
            return $phoneFromShipping;
        } else {
            $phoneFromBilling = $order->getBillingAddress()->getTelephone();
            if (!empty($phoneFromBilling)) {
                return $phoneFromBilling;
            }
        }
        $errorMessage = "Can not extract customer phone from shipping or billing address";
        $this->logAndThrowException($errorMessage);
    }

    /**
     * @param $errorMessage
     */
    private function logAndThrowException($errorMessage)
    {
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }

}