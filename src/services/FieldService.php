<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\braintreedonation\services;

use craft\base\Component;

use infoservio\braintreedonation\records\Field as FieldRecord;

/**
 * Field Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class FieldService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param array $post
     */
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

    /**
     * @param array $post
     * @return array
     */
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
