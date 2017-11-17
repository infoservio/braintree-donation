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

use endurant\donationsfree\errors\BraintreeDonationsPluginException;
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
        $result = DonationsFree::$PLUGIN->braintreeHttpClient->createCustomer($customer);

        if (!$result->success) {

            throw new BraintreeDonationsPluginException(
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
        $result = DonationsFree::$PLUGIN->braintreeHttpClient->createAddress($customer, $address);

        if (!$result->success) {

            throw new BraintreeDonationsPluginException(
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
        $result = DonationsFree::$PLUGIN->braintreeHttpClient->createCard($customer, $paymentMethodNonce);

        if (!$result->success) {

            throw new BraintreeDonationsPluginException(
                $result->errors->deepAll(),
                $result->message,
                __METHOD__,
                Log::CARD_LOGS
            );
        }

        $paymentMethod = $result->paymentMethod;

        $card->tokenId = $paymentMethod->token;
        $card->bin = isset($paymentMethod->bin) ? $paymentMethod->bin : null;
        $card->last4 = isset($paymentMethod->last4) ? $paymentMethod->last4 : '';
        $card->cardType = isset($paymentMethod->cardType) ? $paymentMethod->cardType : null;
        $card->expirationDate = isset($paymentMethod->expirationDate) ? $paymentMethod->expirationDate : null;
        $card->cardholderName = isset($paymentMethod->cardholderName) ? $paymentMethod->cardholderName : null;
        $card->customerLocation = isset($paymentMethod->customerLocation) ? $paymentMethod->customerLocation : null;

        return $result;
    }

    public function createTransaction(Customer $customer, Transaction &$transaction)
    {
        $result = DonationsFree::$PLUGIN->braintreeHttpClient->createTransaction($customer, $transaction);

        if (!$result->success) {

            throw new BraintreeDonationsPluginException(
                $result->errors->deepAll(),
                $result->message,
                __METHOD__,
                Log::TRANSACTION_LOGS
            );
        }

        $transaction->transactionId = $result->transaction->id;
        $transaction->type = $result->transaction->type;
        $transaction->amount = $result->transaction->amount;
        $transaction->status = $result->transaction->status;
        $transaction->transactionDetails = json_encode($result->transaction);
        $transaction->transactionErrors =
            (isset($result->transaction->errors)) ?
                json_encode($result->transaction->errors->deepAll()) :
                null;
        $transaction->transactionErrorMessage =
            (isset($result->transaction->message)) ?
                $result->transaction->message :
                null;

        return $result;
    }
}
