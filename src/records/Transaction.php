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
 * Transaction Record
 *
 * @property integer $id
 * @property string $transactionId
 * @property string $type
 * @property integer $cardId
 * @property integer $amount
 * @property integer $projectId
 * @property string $projectName
 * @property boolean $success
 * @property string $transactionDetails
 * @property string $transactionErrors
 * @property string $transactionErrorMessage
 * @property string $createdAt
 * @property string $updatedAt
 */
class Transaction extends ActiveRecord
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
        return '{{%donations_transaction}}';
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
            [['id', 'cardId', 'amount', 'status', 'projectId', 'projectName'], 'integer'],
            [['transactionId', 'type', 'transactionDetails', 'transactionErrors', 'transactionErrorMessage'], 'string'],
            [['id', 'cardId', 'amount', 'status', 'transactionId'], 'required']
        ];
    }
}
