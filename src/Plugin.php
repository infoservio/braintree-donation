<?php

namespace endurant\donationsFree;

use Craft;
use endurant\donationsFree\models\Settings;

class Plugin extends \craft\base\Plugin
{
    public function init()
    {
        parent::init();
    }

    /**
     * @return Settings
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return string
     */
    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('donations-free/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}