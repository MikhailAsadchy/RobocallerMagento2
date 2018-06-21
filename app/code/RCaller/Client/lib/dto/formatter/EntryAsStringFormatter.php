<?php
namespace rcaller\lib\dto\formatter;
use rcaller\lib\adapterInterfaces\OrderEntryFieldResolver;

class EntryAsStringFormatter
{
    /**
     * @var OrderEntryFieldResolver
     */
    private $orderEntryFieldResolver;

    const ORDER_ENTRY_DELIMITER = " | ";

    public function __construct($orderEntryFieldResolver)
    {
        $this->orderEntryFieldResolver = $orderEntryFieldResolver;
    }

    public function getEntriesAsString($entries)
    {
        $entriesAsStrings = [];
        foreach ($entries as $item) {
            $name = $this->orderEntryFieldResolver->getName($item);
            $quantity = intval($this->orderEntryFieldResolver->getQuantity($item));
            $unit = $this->orderEntryFieldResolver->getUnit($item);
            $entryString = $name . " " . $quantity . " " . $unit . ".";
            array_push($entriesAsStrings, $entryString);
        }
        return join(self::ORDER_ENTRY_DELIMITER, $entriesAsStrings);
    }
}

