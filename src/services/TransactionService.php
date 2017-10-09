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

use endurant\donationsfree\records\Transaction as TransactionRecord;
use endurant\donationsfree\models\Transaction;
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
class TransactionService extends Component
{
    // Public Methods
    // =========================================================================

    public function saveTransaction(Transaction $transaction)  
    {
        $transactionRecord = new TransactionRecord();
        $transactionRecord->setAttributes($transaction->getAttributes);

        if (!$transactionRecord->save()) {
            Craft::$app->logService->transactionLog($transactionRecord->getErrors(), $transactionRecord->__toString(), __METHOD__, Log::DB_CULPRIT);
            return null;
        } 

        return $transactionRecord;
    }
}
