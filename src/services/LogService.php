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

use endurant\donationsFree\models\Log;

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
class LogService extends Component
{
    // Public Methods
    // =========================================================================

    public function addressLog(array $errors, string $message, string $method, array $culprit) 
    {
        $donationLogger = Craft::$app->donationLogger;
        $donationLogger->setCategory(Log::ADDRESS_LOGS);
        $result = $donationLogger->record($errors, $message, $method, $culprit);

        return $result;
    }

    public function customerLog(array $errors, string $message, string $method, array $culprit) 
    {
        $donationLogger = Craft::$app->donationLogger;
        $donationLogger->setCategory(Log::CUSTOMER_LOGS);
        $result = $donationLogger->record($errors, $message, $method, $culprit);

        return $result;
    }

    public function cardLog(array $errors, string $message, string $method, array $culprit) 
    {
        $donationLogger = Craft::$app->donationLogger;
        $donationLogger->setCategory(Log::CARD_LOGS);
        $result = $donationLogger->record($errors, $message, $method, $culprit);

        return $result;
    }

    public function transactionLog(array $errors, string $message, string $method, array $culprit) 
    {
        $donationLogger = Craft::$app->donationLogger;
        $donationLogger->setCategory(Log::TRANSACTION_LOGS);
        $result = $donationLogger->record($errors, $message, $method, $culprit);

        return $result;
    }
}
