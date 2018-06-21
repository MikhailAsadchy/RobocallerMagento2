<?php

namespace rcaller\lib\plugin;

use rcaller\lib\adapterInterfaces\EventService;
use rcaller\lib\adapterInterfaces\Logger;
use rcaller\lib\adapterInterfaces\OptionRepository;
use rcaller\lib\client\RCallerClient;
use rcaller\lib\constants\RCallerConstants;

class RCallerPluginManager
{
    /**
     * @var OptionRepository
     */
    private $optionRepository;
    /**
     * @var EventService
     */
    private $eventService;
    /**
     * @var RCallerClient
     */
    private $rCallerClient;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * RCallerPluginManager constructor.
     * @param OptionRepository $optionRepository
     * @param EventService $eventService
     * @param RCallerClient $rCallerClient
     * @param Logger $logger
     */
    public function __construct(OptionRepository $optionRepository, EventService $eventService, RCallerClient $rCallerClient, Logger $logger)
    {
        $this->optionRepository = $optionRepository;
        $this->eventService = $eventService;
        $this->rCallerClient = $rCallerClient;
        $this->logger = $logger;
    }

    public function addOptions()
    {
        $this->optionRepository->addOrUpdateOption(RCallerConstants::USER_NAME_OPTION, RCallerConstants::OPTION_PLACE_HOLDER);
        $this->optionRepository->addOrUpdateOption(RCallerConstants::PASSWORD_OPTION, RCallerConstants::OPTION_PLACE_HOLDER);
    }

    public function removeOptions()
    {
        $this->optionRepository->removeOption(RCallerConstants::USER_NAME_OPTION);
        $this->optionRepository->removeOption(RCallerConstants::PASSWORD_OPTION);
    }

    public function subscribePlaceOrderEvent()
    {
        $this->eventService->subscribePlaceOrderEvent($this->rCallerClient, $this->logger);
    }

    public function unsubscribePlaceOrderEvent()
    {
        $this->eventService->unsubscribePlaceOrderEvent();
    }
}
