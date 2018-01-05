<?php
/**
 * donate-elite plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donateelite\services;

use craft\base\Component;
use infoservio\donateelite\records\BraintreeDonationSettings;

/**
 * Plugin Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class PluginService extends Component
{
    /**
     * @param array $post
     */
    public function updatePluginSettings(array $post)
    {
        $settings = BraintreeDonationSettings::find()->all();

        foreach ($settings as $setting) {

            foreach ($post as $k => $v) {
                if ($setting->name == $k) {
                    $setting->value = $v;
                    $setting->save();
                }
            }
        }
    }
}
