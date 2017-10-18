<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\models;

use endurant\donationsfree\Donationsfree;

use Craft;
use craft\base\Model;

/**
 * Transaction Model
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
class Transaction extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $transactionId;
    public $type;
    public $cardId;
    public $amount;
    public $status;
    public $projectId;
    public $projectName;
    public $success;
    public $transactionDetails;
    public $transactionErrors;
    public $transactionErrorMessage;
    public $createdAt;
    public $updatedAt;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'cardId', 'amount', 'status', 'projectId', 'projectName', 'success'], 'integer'],
            [['transactionId', 'type', 'transactionDetails', 'transactionErrors', 'transactionErrorMessage'], 'string'],
            [['id', 'cardId', 'amount', 'status', 'success', 'transactionId'], 'required']
        ];
    }
}
