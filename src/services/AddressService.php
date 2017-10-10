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

use endurant\donationsfree\records\Address as AddressRecord;
use endurant\donationsfree\models\Address;
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
class AddressService extends Component
{
    // Public Methods
    // =========================================================================

    public function saveAddress(Address $address) 
    {
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($address->getAttributes);

        if (!$addressRecord->save()) {
            
            throw new \endurant\donationsfree\errors\DbDonationsPluginException(
                $addressRecord->getErrors(), 
                $addressRecord->__toString(),
                 __METHOD__, 
                 Log::ADDRESS_LOGS
            );
        }

        return $addressRecord;
    }
}
