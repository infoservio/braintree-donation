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
class Card extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $tokenId;
    public $customerId;
    public $bin;
    public $last4;
    public $cardType;
    public $expirationDate;
    public $cardholderName;
    public $customerLocation;

    // Public Methods
    // =========================================================================

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
