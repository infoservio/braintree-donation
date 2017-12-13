<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation\services;

use craft\base\Component;
use endurant\braintreedonation\records\BraintreeDonationSettings;
use endurant\braintreedonation\records\Step;

/**
 * Step Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class StepService extends Component
{
    /**
     * @param array $post
     */
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
