<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\services;

use endurant\donationsfree\DonationsFree;
use endurant\donationsfree\models\Customer;

use Craft;
use craft\base\Component;

/**
 * Donate Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class BraintreeService extends Component
{
    // Public Methods
    // =========================================================================

    public function createCustomer(Customer $customer) 
    {
        
    }

    public function createAddress(Customer $customer) 
    {
        
    }

    public function createCard(Customer $customer) 
    {
        
    }

    public function createTransaction(Customer $customer) 
    {
        
    }
}
