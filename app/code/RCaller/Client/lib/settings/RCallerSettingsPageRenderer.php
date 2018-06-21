<?php

namespace rcaller\lib\settings;

use rcaller\lib\client\RCallerClient;
use rcaller\lib\dao\credentials\CredentialsManager;
use rcaller\lib\ui\RCallerFormHelper;

class RCallerSettingsPageRenderer
{
    /**
     * @var CredentialsManager
     */
    private $credentialsManager;
    /**
     * @var RCallerClient
     */
    private $rCallerClient;
    /**
     * @var RCallerFormHelper
     */
    private $rCallerFormHelper;

    /**
     * RCallerSettingsPageRenderer constructor.
     * @param $credentialsManager
     * @param $rCallerClient
     * @param $rCallerFormHelper
     */
    public function __construct($credentialsManager, $rCallerClient, $rCallerFormHelper)
    {
        $this->credentialsManager = $credentialsManager;
        $this->rCallerClient = $rCallerClient;
        $this->rCallerFormHelper = $rCallerFormHelper;
    }


    public function renderSettingsPage()
    {
        $content = $this->getDefaultView();
        echo $content;
    }

    /**
     * @param $checkCredentialsStatus
     * @param $username
     * @param $password
     * @return string
     */
    private function renderSettingsPageInternal($checkCredentialsStatus, $username, $password)
    {
        return $this->rCallerFormHelper->renderSettingsTitle() . $this->renderSettingsForm($username, $password) . $this->rCallerFormHelper->renderCheckCredentialsStatus($checkCredentialsStatus);
    }

    /**
     * @param $username
     * @param $password
     * @return string
     */
    private function renderSettingsForm($username, $password)
    {
        return "
    <form method=\"post\">
        " . $this->rCallerFormHelper->renderUserNameField($username) . $this->rCallerFormHelper->renderPasswordField($password)
            . $this->rCallerFormHelper->renderCheckCredentialsButton() .
            $this->rCallerFormHelper->renderSaveButton() . "
    </form> 
    ";
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        $checkCredentialsStatus = $this->rCallerFormHelper->processFormSubmission();
        $username = $this->credentialsManager->getUserName();
        $password = $this->credentialsManager->getPassword();
        $content = $this->renderSettingsPageInternal($checkCredentialsStatus, $username, $password);
        return $content;
    }

}