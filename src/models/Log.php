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

use endurant\braintreedonation\BraintreeDonation;

use Craft;
use craft\base\Model;

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
class Log extends Model
{
    // Public Properties
    // =========================================================================
    const ADDRESS_LOGS = 'donations-address-logs';
    const CARD_LOGS = 'donations-card-logs';
    const CUSTOMER_LOGS = 'donations-customer-logs';
    const TRANSACTION_LOGS = 'donations-transaction-logs';

    const BRAINTREE_CULPRIT = ['id' => 1, 'name' => 'braintree'];
    const DB_CULPRIT = ['id' => 2, 'name' => 'db'];
    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $pid;
    public $culprit;
    public $category;
    public $method;
    public $errors;
    public $message;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'culprit'], 'integer'],
            [['method', 'errors', 'message', 'category'], 'string'],
            [['pid', 'method', 'errors', 'message'], 'required']
        ];
    }
}
