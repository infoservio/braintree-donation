<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\braintreedonation\records;

use craft\db\ActiveRecord;

/**
 * Address Record
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $required
 * @property integer $show
 * @property integer $canHide
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Field extends ActiveRecord
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
        return '{{donations_field}}';
    }

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'show', 'required', 'canHide'], 'integer'],
            [['name', 'title'], 'string'],
            [['name', 'title'], 'required']
        ];
    }
}
