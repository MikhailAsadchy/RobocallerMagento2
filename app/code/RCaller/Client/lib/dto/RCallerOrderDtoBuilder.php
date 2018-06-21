<?php
namespace rcaller\lib\dto;
use rcaller\lib\adapterInterfaces\ChannelNameProvider;
use rcaller\lib\dto\formatter\EntryAsStringFormatter;

class RCallerOrderDtoBuilder
{
    /**
     * @var ChannelNameProvider
     */
    private $channelNameProvider;
    /**
     * @var EntryAsStringFormatter
     */
    private $entryAsStringFormatter;

    public function __construct($channelNameProvider, $entryAsStringFormatter)
    {
        $this->channelNameProvider = $channelNameProvider;
        $this->entryAsStringFormatter = $entryAsStringFormatter;
    }

    public function buildOrderDto($externalOrderId, $price, $entries, $customerAddress, $customerPhone, $customerName, $priceCurrency)
    {
        $entriesAsString = $this->entryAsStringFormatter->getEntriesAsString($entries);

        $data = array(
            'price' => $price,
            'entries' => $entriesAsString,
            'customerPhone' => $customerPhone,
            'priceCurrency' => $priceCurrency,
            'channel' => $this->channelNameProvider->getChannelName());
        $data = $this->addOptionalFields($data, $externalOrderId, $customerAddress, $customerName);
        return $data;
    }

    private function addOptionalFields($data, $externalOrderId, $customerAddress, $customerName)
    {
        $data = $this->addOptionalField($data, 'externalOrderId', $externalOrderId);
        $data = $this->addOptionalField($data, 'customerAddress', $customerAddress);
        $data = $this->addOptionalField($data, 'customerName', $customerName);
        return $data;
    }

    /**
     * @param $data
     * @param $name
     * @param $value
     * @return mixed
     */
    private function addOptionalField($data, $name, $value)
    {
        if (!empty($value)) {
            $data[$name] = $value;
        }

        return $data;
    }

}

