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

use endurant\donationsfree\models\Customer;
use endurant\donationsfree\models\Address;
use endurant\donationsfree\models\Card;
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
class BraintreeService extends Component
{
    // Public Methods
    // =========================================================================

    public function createCustomer(Customer &$customer) 
    {
        $result = DonationsFree::$plugin->braintreeHttpClient->createCustomer($customer);

        if (!$result->success) {
            
            throw new \endurant\donationsfree\errors\BraintreeDonationsPluginException(
                $result->errors->deepAll(), 
                $result->message,
                 __METHOD__, 
                 Log::CUSTOMER_LOGS
            );
        }

        $customer->customerId = $result->customer->id;
        return $result;
    }

    public function createAddress(Customer $customer, Address $address) 
    {
        $result = DonationsFree::$plugin->braintreeHttpClient->createAddress($customer, $address);

        if (!$result->success) {
            
            throw new \endurant\donationsfree\errors\BraintreeDonationsPluginException(
                $result->errors->deepAll(), 
                $result->message,
                 __METHOD__, 
                 Log::ADDRESS_LOGS
            );
        }

        return $result;
    }

    public function createCard(Customer $customer, Card &$card, string $paymentMethodNonce) 
    {
        $result = DonationsFree::$plugin->braintreeHttpClient->createCard($customer, $paymentMethodNonce);
        
        if (!$result->success) {
            
            throw new \endurant\donationsfree\errors\BraintreeDonationsPluginException(
                $result->errors->deepAll(), 
                $result->message,
                 __METHOD__, 
                 Log::CARD_LOGS
            );
        }

        $card->tokenId = $result->creditCardDetails->token;
        $card->bin = $result->creditCardDetails->last4;
        $card->cardType = $result->creditCardDetails->cardType;
        $card->expirationDate = $result->creditCardDetails->expirationDate;
        $card->cardholderName = $result->creditCardDetails->cardholderName;
        $card->customerLocation = $result->creditCardDetails->customerLocation;

        return $result;
    }

    public function createTransaction(Customer $customer, Transaction &$transaction) 
    {
        $result = DonationsFree::$plugin->braintreeHttpClient->createTransaction($customer, $transaction);

        if (!$result->success) {
            
            throw new \endurant\donationsfree\errors\BraintreeDonationsPluginException(
                $result->errors->deepAll(), 
                $result->message,
                 __METHOD__, 
                 Log::TRANSACTION_LOGS
            );
        }

        $transaction->success = true;
        $transaction->type = $result->type;
        $transaction->amount = $result->amount;
        $transaction->status = $result->status;
        $transaction->createdAt = $result->createdAt;
        $transaction->updatedAt = $result->updatedAt;
        $transaction->transactionDetails = json_encode($result->transaction);
        $transaction->transactionErrors = json_encode($result->errors->deepAll());
        $transaction->transactionErrorMessage = $result->message;

        return $result;
    }
}
