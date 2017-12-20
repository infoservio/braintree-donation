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

use infoservio\braintreedonation\BraintreeDonation;

use craft\base\Component;

use infoservio\braintreedonation\errors\BraintreeDonationsPluginException;
use infoservio\braintreedonation\models\Customer;
use infoservio\braintreedonation\models\Address;
use infoservio\braintreedonation\models\Card;
use infoservio\braintreedonation\models\Transaction;
use infoservio\braintreedonation\models\Log;

/**
 * Braintree Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class BraintreeService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Customer $customer
     * @return \Braintree\Customer
     * @throws BraintreeDonationsPluginException
     */
    public function createCustomer(Customer &$customer)
    {
        $result = BraintreeDonation::$PLUGIN->braintreeHttpClient->createCustomer($customer);

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

    /**
     * @param Customer $customer
     * @param Address $address
     * @return \Braintree\Address
     * @throws BraintreeDonationsPluginException
     */
    public function createAddress(Customer $customer, Address $address)
    {
        $result = BraintreeDonation::$PLUGIN->braintreeHttpClient->createAddress($customer, $address);

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

    /**
     * @param Customer $customer
     * @param Card $card
     * @param string $paymentMethodNonce
     * @return mixed
     * @throws BraintreeDonationsPluginException
     */
    public function createCard(Customer $customer, Card &$card, string $paymentMethodNonce)
    {
        $result = BraintreeDonation::$PLUGIN->braintreeHttpClient->createCard($customer, $paymentMethodNonce);

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

    /**
     * @param Customer $customer
     * @param Transaction $transaction
     * @return array
     * @throws BraintreeDonationsPluginException
     */
    public function createTransaction(Customer $customer, Transaction &$transaction)
    {
        $result = BraintreeDonation::$PLUGIN->braintreeHttpClient->createTransaction($customer, $transaction);

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
