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
 * Customer Record
 *
 * @property integer $id
 * @property string $customerId
 * @property integer $addressId
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Customer extends ActiveRecord
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
        return '{{donations_customer}}';
    }

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'addressId'], 'integer'],
            [['customerId', 'firstName', 'lastName', 'phone'], 'string'],
            ['email', 'email'],
            [['customerId', 'firstName', 'lastName', 'email', 'phone', 'addressId'], 'required']
        ];
    }
}
