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

use endurant\braintreedonation\DonationsFree;

use Craft;
use craft\base\Component;

use endurant\braintreedonation\records\Field as FieldRecord;
use endurant\braintreedonation\models\Field;

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
class FieldService extends Component
{
    // Public Methods
    // =========================================================================

    public function update(array $post)
    {
        $arr = $this->getArrFromPost($post);
        foreach ($arr as $key => $value) {
            $field = FieldRecord::find()->where(['name' => $key])->one();
            $field->required = +$value['required'];
            if (isset($value['show'])) {
                $field->show = +$value['show'];
            }
            $field->save();
        }
    }

    private function getArrFromPost(array $post)
    {
        $arr = [];
        foreach ($post as $key => $value) {
            $keys = explode('-', $key);
            if (isset($arr[$keys[0]])) {
                $arr[$keys[0]][$keys[1]] = $value;
            } else {
                $arr[$keys[0]] = [$keys[1] => $value];
            }
        }
        return $arr;
    }
}
