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

use endurant\braintreedonation\DonationsFree;

use Craft;
use craft\base\Component;

use endurant\braintreedonation\errors\DbDonationsPluginException;
use endurant\braintreedonation\records\Transaction as TransactionRecord;
use endurant\braintreedonation\models\Transaction;
use endurant\braintreedonation\models\Log;

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
class TransactionService extends Component
{
    // Public Methods
    // =========================================================================

    public function saveTransaction(Transaction $transaction)
    {
        $transactionRecord = new TransactionRecord();
        $transactionRecord->setAttributes($transaction->getAttributes(), false);

        if (!$transactionRecord->save()) {

            throw new DbDonationsPluginException(
                $transactionRecord->errors,
                json_encode($transactionRecord->toArray()),
                __METHOD__,
                Log::TRANSACTION_LOGS
            );
        }

        return $transactionRecord;
    }
}
