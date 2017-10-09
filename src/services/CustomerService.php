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

use Craft;
use craft\base\Component;

use endurant\donationsfree\records\Customer as CustomerRecord;
use endurant\donationsfree\models\Customer;
use endurant\donationsfree\models\Log;

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
class CustomerService extends Component
{
    // Public Methods
    // =========================================================================

    public function saveCustomer(Customer $customer) 
    {
        $customerRecord = new CustomerRecord();
        $customer->setAttributes($customer->getAttributes());

        if (!$customerRecord->save()) {
            Craft::$app->logService->customerLog($customerRecord->getErrors(), $customerRecord->__toString(), __METHOD__, Log::DB_CULPRIT);
            return null;
        } 

        return $customerRecord; 
    }
}
