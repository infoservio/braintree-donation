<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation\services;

use endurant\braintreedonation\BraintreeDonation;

use Craft;
use craft\base\Component;

use endurant\braintreedonation\errors\DbDonationsPluginException;
use endurant\braintreedonation\records\Transaction as TransactionRecord;
use endurant\braintreedonation\models\Transaction;
use endurant\braintreedonation\models\Log;

/**
 * Transaction Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class TransactionService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Transaction $model
     * @return TransactionRecord
     * @throws DbDonationsPluginException
     */
    public function save(Transaction $model)
    {
        $record = new TransactionRecord();
        $record->setAttributes($model->getAttributes(), false);

        if (!$record->save()) {

            throw new DbDonationsPluginException(
                $record->errors,
                json_encode($record->toArray()),
                __METHOD__,
                Log::TRANSACTION_LOGS
            );
        }

        return $record;
    }
}
