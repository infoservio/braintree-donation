<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\braintreedonation\services;

use craft\base\Component;

use infoservio\braintreedonation\errors\DbDonationsPluginException;
use infoservio\braintreedonation\records\Address as AddressRecord;
use infoservio\braintreedonation\models\Address;
use infoservio\braintreedonation\models\Log;

/**
 * Address Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class AddressService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Address $model
     * @return AddressRecord
     * @throws DbDonationsPluginException
     */
    public function save(Address $model)
    {
        $record = new AddressRecord();
        $record->setAttributes($model->getAttributes(), false);

        if (!$record->save()) {

            throw new DbDonationsPluginException(
                $record->errors,
                json_encode($record->toArray()),
                __METHOD__,
                Log::ADDRESS_LOGS
            );
        }

        return $record;
    }
}
