<?php

namespace RCaller\Client\Observer;


use RCaller\Client\Service\RCallerSender;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;

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
     * Creates Signifyd case for single order with online payment method.
     *
     * @param OrderInterface $order
     * @return void
     */
    private function sendOrderToRCaller($order)
    {
        $sender = new RCallerSender(); // inject dependency
        $sender->sendOrderToRCaller($order);
    }

    private function extractOrders(Event $event)
    {
        $order = $event->getData('order');
        if (null !== $order) {
            return [$order];
        }

        return $event->getData('orders');
    }
}