<?php
/**
 * donate-elite plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donateelite;

use infoservio\donateelite\components\httpClient\braintree\BraintreeHttpClient;
use infoservio\donateelite\components\logger\Logger;
use infoservio\donateelite\components\parser\CsvParser;
use infoservio\donateelite\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\web\UrlManager;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use infoservio\donateelite\services\AddressService;
use infoservio\donateelite\services\BraintreeService;
use infoservio\donateelite\services\CardService;
use infoservio\donateelite\services\CustomerService;
use infoservio\donateelite\services\DonationService;
use infoservio\donateelite\services\BraintreeDonationSettingsService;
use infoservio\donateelite\services\FieldService;
use infoservio\donateelite\services\LogService;
use infoservio\donateelite\services\PluginService;
use infoservio\donateelite\services\StepService;
use infoservio\donateelite\services\TransactionService;
use yii\base\Event;

/**
 * @property AddressService $address
 * @property BraintreeService $braintree
 * @property CardService $card
 * @property CustomerService $customer
 * @property DonationService $donation
 * @property BraintreeDonationSettingsService $donationSetting
 * @property FieldService $field
 * @property LogService $log
 * @property PluginService $plugin
 * @property StepService $step
 * @property TransactionService $transaction
 * @property BraintreeHttpClient $braintreeHttpClient
 * @property Logger $donationLogger
 * @property CsvParser $csvParser
 *
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class DonateElite extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * DonationsFree::$plugin
     *
     * @var DonateElite
     */
    public static $PLUGIN;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * Donationsfree::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$PLUGIN = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                    $this->hasCpSection = true;
                    $this->hasCpSettings = true;
                }
            }
        );

        Event::on(Cp::class, Cp::EVENT_REGISTER_CP_NAV_ITEMS, function(RegisterCpNavItemsEvent $event) {
            if (\Craft::$app->user->identity->admin) {
//                $event->navItems['donate-elite'] = [
//                    'label' => 'Donations Manager',
//                    'url' => 'donate-elite/settings'
//                ];
            }
        });

        // Register our site routes
//        Event::on(
//            UrlManager::class,
//            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
//            function (RegisterUrlRulesEvent $event) {
//                $event->rules['donate-elite/donation/pay'] = '/actions/donate-elite/donation/pay';
//            }
//        );

        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['donate-elite'] = 'donate-elite/settings/settings';
                $event->rules['donate-elite/settings'] = 'donate-elite/settings/settings';
                $event->rules['donate-elite/fields'] = 'donate-elite/settings/fields';
                $event->rules['donate-elite/steps'] = 'donate-elite/settings/steps';
                $event->rules['donate-elite/donation-form'] = 'donate-elite/settings/donation-form';
            }
        );

        Craft::info(
            Craft::t(
                'donate-elite',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

//    public function getCpNavItem()
//    {
//        $item = parent::getCpNavItem();
//        $item['subnav'] = [
//            'settings' => ['label' => 'Settings Manager', 'url' => 'donate-elite/settings'],
//            'fields' => ['label' => 'Fields Manager', 'url' => 'donate-elite/fields'],
//            'steps' => ['label' => 'Steps Manager', 'url' => 'donate-elite/steps'],
//        ];
//        return $item;
//    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'donate-elite/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}