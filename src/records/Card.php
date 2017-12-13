<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation\records;

use endurant\braintreedonation\Donationsfree;

use Craft;
use craft\db\ActiveRecord;

/**
 * Card Record
 *
 * @property integer $id
 * @property string $tokenId
 * @property integer $customerId
 * @property integer $bin
 * @property string $last4
 * @property string $cardType
 * @property string $expirationDate
 * @property string $cardholderName
 * @property string $customerLocation
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Card extends ActiveRecord
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
        return '{{donations_card}}';
    }

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'customerId'], 'integer'],
            ['cardholderName', 'string'],
            ['cardType', 'string', 'max' => 32],
            ['tokenId', 'string', 'max' => 36],
            ['expirationDate', 'string', 'length' => 7],
            ['customerLocation', 'string', 'length' => 2],
            ['last4', 'string', 'length' => 4],
            [['tokenId', 'customerId'], 'required']
        ];
    }
}
