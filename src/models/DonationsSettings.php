<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation\models;

use endurant\braintreedonation\Donationsfree;

use Craft;
use craft\base\Model;
use endurant\braintreedonation\records\DonationsSettings as DonationsSettingsRecord;

/**
 * Card Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class DonationsSettings extends Model
{
    // Public Properties
    // =========================================================================
    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $name;
    public $value;

    public static function getSettingsArr()
    {
        $settings = DonationsSettingsRecord::find()->all();
        $settingsArr = [];

        foreach ($settings as $value) {
            $settingsArr[$value->name] = $value->value;
        }

        return $settingsArr;
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'value'], 'string'],
            [['name', 'value'], 'required']
        ];
    }
}
