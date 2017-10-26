<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\records;

use endurant\donationsfree\Donationsfree;

use Craft;
use craft\db\ActiveRecord;

/**
 * Country Record
 *
 * @property integer $id
 * @property string $name
 * @property string $alpha2
 * @property string $alpha3
 * @property integer $countryCode
 * @property string $region
 * @property string $subRegion
 * @property integer $regionCode
 * @property integer $subRegionCode
 */
class Country extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================
    const DEFAULT_COUNTRY_ID = 236;
    /**
     * Declares the name of the database table associated with this AR class.
     * By default this method returns the class name as the table name by calling [[Inflector::camel2id()]]
     * with prefix [[Connection::tablePrefix]]. For example if [[Connection::tablePrefix]] is `tbl_`,
     * `Customer` becomes `tbl_customer`, and `OrderItem` becomes `tbl_order_item`. You may override this method
     * if the table is not named after this convention.
     *
     * By convention, tables created by plugins should be prefixed with the plugin
     * name and an underscore.
     *
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{donations_country}}';
    }

    public static function getCountryById(int $id)
    {
        return self::find()->where(['id' => $id])->one();
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
            [['id', 'countryCode', 'regionCode', 'subRegionCode'], 'integer'],
            [['name', 'region', 'subRegion'], 'string'],
            ['alpha2', 'string', 'length' => 2],
            ['alpha3', 'string', 'length' => 3],
            [['name', 'alpha2', 'alpha3', 'countryCode', 'region', 'subRegion', 'regionCode', 'subRegionCode'], 'required']
        ];
    }
}
