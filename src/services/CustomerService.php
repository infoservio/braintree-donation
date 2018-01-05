<?php
/**
 * donate-elite plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donateelite\services;

use craft\base\Component;

use infoservio\donateelite\errors\DbDonationsPluginException;
use infoservio\donateelite\records\Customer as CustomerRecord;
use infoservio\donateelite\models\Customer;
use infoservio\donateelite\models\Log;

/**
 * Customer Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class CustomerService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Customer $model
     * @return CustomerRecord
     * @throws DbDonationsPluginException
     */
    public function save(Customer $model)
    {
        $record = new CustomerRecord();
        $record->setAttributes($model->getAttributes(), false);

        if (!$record->save()) {
            
            throw new DbDonationsPluginException(
                $record->errors,
                json_encode($record->toArray()),
                 __METHOD__, 
                 Log::CUSTOMER_LOGS
            );
        } 

        return $record;
    }
}
