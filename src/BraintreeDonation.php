<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\braintreedonation;

use infoservio\braintreedonation\components\httpClient\braintree\BraintreeHttpClient;
use infoservio\braintreedonation\components\logger\Logger;
use infoservio\braintreedonation\components\parser\CsvParser;
use infoservio\braintreedonation\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\web\UrlManager;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use infoservio\braintreedonation\services\AddressService;
use infoservio\braintreedonation\services\BraintreeService;
use infoservio\braintreedonation\services\CardService;
use infoservio\braintreedonation\services\CustomerService;
use infoservio\braintreedonation\services\DonationService;
use infoservio\braintreedonation\services\BraintreeDonationSettingsService;
use infoservio\braintreedonation\services\FieldService;
use infoservio\braintreedonation\services\LogService;
use infoservio\braintreedonation\services\PluginService;
use infoservio\braintreedonation\services\StepService;
use infoservio\braintreedonation\services\TransactionService;
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
class BraintreeDonation extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * DonationsFree::$plugin
     *
     * @var BraintreeDonation
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
//                $event->navItems['braintree-donation'] = [
//                    'label' => 'Donations Manager',
//                    'url' => 'braintree-donation/settings'
//                ];
            }
        });

        // Register our site routes
//        Event::on(
//            UrlManager::class,
//            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
//            function (RegisterUrlRulesEvent $event) {
//                $event->rules['braintree-donation/donation/pay'] = '/actions/braintree-donation/donation/pay';
//            }
//        );

        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['braintree-donation'] = 'braintree-donation/settings/settings';
                $event->rules['braintree-donation/settings'] = 'braintree-donation/settings/settings';
                $event->rules['braintree-donation/fields'] = 'braintree-donation/settings/fields';
                $event->rules['braintree-donation/steps'] = 'braintree-donation/settings/steps';
                $event->rules['braintree-donation/donation-form'] = 'braintree-donation/settings/donation-form';
            }
        );

        Craft::info(
            Craft::t(
                'braintree-donation',
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
//            'settings' => ['label' => 'Settings Manager', 'url' => 'braintree-donation/settings'],
//            'fields' => ['label' => 'Fields Manager', 'url' => 'braintree-donation/fields'],
//            'steps' => ['label' => 'Steps Manager', 'url' => 'braintree-donation/steps'],
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
            'braintree-donation/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}