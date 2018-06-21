<?php

namespace rcaller\lib\ui;

use rcaller\lib\client\RCallerClient;
use rcaller\lib\dao\credentials\CredentialsManager;

class RCallerFormHelper
{
    const SETTINGS_FORM_USERNAME = "rcaller_username";
    const SETTINGS_FORM_PASSWORD = "rcaller_password";

    /**
     * @var CredentialsManager
     */
    private $credentialsManager;
    /**
     * @var RCallerClient
     */
    private $rCallerClient;

    /**
     * RCallerFormHelper constructor.
     * @param $credentialsManager
     * @param $rCallerClient
     */
    public function __construct($credentialsManager, $rCallerClient)
    {
        $this->credentialsManager = $credentialsManager;
        $this->rCallerClient = $rCallerClient;
    }


    public function renderSettingsTitle()
    {
        return "<div>Configure RCaller credentials</div>";
    }

    public function renderUserNameField($username)
    {
        return "<input id=\"" . self::SETTINGS_FORM_USERNAME . "\" name=\"" . self::SETTINGS_FORM_USERNAME . "\" type=\"text\" size=\"25\"
               value=\"" . htmlspecialchars($username) . "\">";
    }

    public function renderUserNameLabel()
    {
        return "<label for=\"" . self::SETTINGS_FORM_USERNAME . "\">UserName:</label>";
    }

    public function renderPasswordField($password)
    {
        return "<input name=\"" . self::SETTINGS_FORM_PASSWORD . "\" type=\"password\" size=\"25\"
               value=\"" . htmlspecialchars($password) . "\">";
    }

    public function renderPasswordLabel()
    {
        return "<label for=\"" . self::SETTINGS_FORM_PASSWORD . "\">Password:</label>";
    }

    public function renderCheckCredentialsButton()
    {
        return "<input type=\"submit\" name=\"checkCredentials\" value=\"Check credentials\">";
    }

    public function renderSaveButton()
    {
        return "<input type=\"submit\" name=\"save\" value=\"Save\">";
    }

    public function renderCheckCredentialsStatus($checkCredentialsStatus)
    {
        if (!empty($checkCredentialsStatus)) {
            return "<div>RCaller credentials status: " . $checkCredentialsStatus . "</div>";
        } else {
            return "";
        }
    }

    /**
     * @return mixed
     */
    private function isCheckCredentialsRequest()
    {
        return $_POST["checkCredentials"];
    }

    /**
     * @return mixed
     */
    private function isSaveSettingsRequest()
    {
        return $_POST["save"];
    }

    /**
     * @return bool
     */
    private function shouldHandlePost()
    {
        return $this->isCheckCredentialsRequest() || $this->isSaveSettingsRequest();
    }

    /**
     * @return bool
     */
    private function isPostMethod()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    private function doCheckCredentials()
    {
        $userName = $_POST[self::SETTINGS_FORM_USERNAME];
        $password = $_POST[self::SETTINGS_FORM_PASSWORD];
        $responseCode = $this->rCallerClient->checkRCallerCredentials($userName, $password);
        return $this->processResponse($responseCode);
    }

    private function doSaveSettings()
    {
        $userName = $_POST[self::SETTINGS_FORM_USERNAME];
        $password = $_POST[self::SETTINGS_FORM_PASSWORD];
        $this->credentialsManager->storeCredentials($userName, $password);
    }

    /**
     * @return string
     */
    public function processFormSubmission()
    {
        $checkCredentialsStatus = "";
        if ($this->isPostMethod() && $this->shouldHandlePost()) {
            if ($this->isCheckCredentialsRequest()) {
                $checkCredentialsStatus = $this->doCheckCredentials();
                if ($checkCredentialsStatus === "success") {
                    $this->doSaveSettings();
                }
            } else if ($this->isSaveSettingsRequest()) {
                $this->doSaveSettings();
            }
        }
        return $checkCredentialsStatus;
    }

    /**
     * @param $httpCode int
     * @return string
     */
    private function processResponse($httpCode)
    {
        if ($httpCode === 200) {
            $checkCredentialsResult = "success";
        } else if ($httpCode === 401) {
            $checkCredentialsResult = "bad credentials";
        } else if ($httpCode == 403) {
            $checkCredentialsResult = "You have negative balance, so the requests to rcaller will not be sent";
        } else {
            $checkCredentialsResult = "unknown error";
        }
        return $checkCredentialsResult;
    }

}
