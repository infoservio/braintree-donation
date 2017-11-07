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
 * Address Record
 *
 * @property integer $id
 * @property integer $countryId
 * @property string $company
 * @property string $stateId
 * @property string $city
 * @property string $postalCode
 * @property string $streetAddress
 * @property string $extendedAddress
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Address extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

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
        return '{{donations_address}}';
    }

    public function rules()
    {
        return [
            [['id', 'postalCode', 'countryId'], 'integer'],
            [['company', 'city', 'streetAddress', 'extendedAddress'], 'string'],
            [['countryId', 'city', 'postalCode', 'streetAddress'], 'required']
        ];
    }

    public function beforeSave($insert)
    {
        if (intval($this->stateId)) {
            $this->stateId = strval($this->stateId);
        }

        return parent::beforeSave($insert);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'countryId']);
    }
}
