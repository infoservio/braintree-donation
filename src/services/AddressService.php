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

use craft\base\Component;

use endurant\donationsfree\records\Address as AddressRecord;
use endurant\donationsfree\models\Address;
use endurant\donationsfree\models\Log;
use endurant\donationsfree\errors\DbDonationsPluginException;

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
        $addressRecord->setAttributes($address->getAttributes(), false);

        if (!$addressRecord->save()) {

            throw new DbDonationsPluginException(
                $addressRecord->errors,
                json_encode($addressRecord->toArray()),
                __METHOD__,
                Log::ADDRESS_LOGS
            );
        }

        return $addressRecord;
    }
}
