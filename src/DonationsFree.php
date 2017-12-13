<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation;

use endurant\braintreedonation\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\web\UrlManager;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 *
 * @property Plugin $plugin
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class DonationsFree extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * DonationsFree::$plugin
     *
     * @var DonationsFree
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