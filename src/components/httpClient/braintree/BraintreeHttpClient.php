<?php

namespace infoservio\donateelite\components\httpClient\braintree;

use infoservio\donateelite\DonateElite;
use yii\base\Component;

use Braintree\ClientToken as BraintreeClientToken;
use Braintree\Configuration as BraintreeConfiguration;
use Braintree\Customer as BraintreeCustomer;
use Braintree\Address as BraintreeAddress;
use Braintree\PaymentMethod as BraintreeCard;
use Braintree\Transaction as BraintreeTransaction;

use infoservio\donateelite\models\Customer;
use infoservio\donateelite\models\Address;
use infoservio\donateelite\models\Transaction;

class BraintreeHttpClient extends Component
{
    private $_channel = 'endure_SP_BT';
    private $_settings;

    function __construct()
    {
        parent::__construct();
        $this->_settings = DonateElite::$PLUGIN->getSettings();

        // Configuration of Braintree
        BraintreeConfiguration::environment($this->_settings->btEnvironment);
        BraintreeConfiguration::merchantId($this->_settings->btMerchantId);
        BraintreeConfiguration::publicKey($this->_settings->btPublicKey);
        BraintreeConfiguration::privateKey($this->_settings->btPrivateKey);
    }

    // Public Methods
    // =========================================================================

    public function generateToken()
    {
        return BraintreeClientToken::generate();
    }

    public function createCustomer(Customer $customer)
    {
        $result = BraintreeCustomer::create([
            'firstName' => $customer->firstName,
            'lastName' => $customer->lastName,
            'email' => $customer->email,
            'phone' => $customer->phone
        ]);

        return $result;
    }

    public function createAddress(Customer $customer, Address $address)
    {
        $country = $address->getCountry();
        $result = BraintreeAddress::create([
            'customerId'        => $customer->customerId,
            'company'           => ($address->company) ? $address->company : '',
            'streetAddress'     => $address->streetAddress,
            'extendedAddress'   => $address->extendedAddress,
            'locality'          => $address->city,
            'region'            => ($stateName = $address->getStateName()) ? $stateName : null,
            'postalCode'        => $address->postalCode,
            'countryName'       => ($country) ? $country->name : null,
            'countryCodeAlpha2' => ($country) ? $country->alpha2 : null
        ]);

        return $result;
    }

    public function createCard(Customer $customer, string $paymentMethodNonce)
    {
        $result = BraintreeCard::create([
            'customerId' => $customer->customerId,
            'paymentMethodNonce' => $paymentMethodNonce
        ]);

        return $result;
    }

    public function createTransaction(Customer $customer, Transaction $transaction)
    {
        $result = BraintreeTransaction::sale([
            'channel' => $this->_channel,
            'amount' => $transaction->amount,
            'customerId' => $customer->customerId,
            'options' => [
                'storeInVaultOnSuccess' => true,
                'submitForSettlement' => true
            ],
            'customFields' => [
                'projectid' => $transaction->projectId,
                'projectname' => $transaction->projectName
            ]
        ]);

        return $result;
    }

    public function createTestTransaction($nonce)
    {
        $result = BraintreeTransaction::sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        return $result;
    }
}
