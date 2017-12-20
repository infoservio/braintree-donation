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
use infoservio\braintreedonation\records\Transaction as TransactionRecord;
use infoservio\braintreedonation\models\Transaction;
use infoservio\braintreedonation\models\Log;

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
