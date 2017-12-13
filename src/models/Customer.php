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
 * Customer Model
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
class Customer extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $customerId;
    public $addressId;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;

    // Public Methods
    // =========================================================================

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

    public static function create(array $params)
    {
        $customer = new self();
        $customer->firstName = $params['firstName'];
        $customer->lastName = $params['lastName'];
        $customer->email = $params['email'];
        $customer->phone = $params['phone'];

        return $customer;
    }
}
