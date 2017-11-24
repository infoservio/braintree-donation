<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\services;

use craft\base\Component;
use endurant\donationsfree\records\DonationsSettings;
use endurant\donationsfree\records\Step;

/**
 * Donate Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class StepService extends Component
{
    public function update(array $post)
    {
        $steps = Step::find()->all();

        foreach ($steps as $step) {
            if(isset($post[$step->name])) {
                $step->order = $post[$step->name];
                $step->save();
            }
        }
    }
}
