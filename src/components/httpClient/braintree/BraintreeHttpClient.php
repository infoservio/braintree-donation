<?php

namespace endurant\donationsfree\components\httpClient\braintree;

use braintree\braintree_php\Braintree\Configuration as BraintreeConfiguration;
use braintree\braintree_php\Braintree\Customer as BraintreeCustomer;
use braintree\braintree_php\Braintree\Address as BraintreeAddress;
use braintree\braintree_php\Braintree\PaymentMethod as BraintreeCard;
use braintree\braintree_php\Braintree\Transaction as BraintreeTransaction;

use endurant\donationsfree\models\Customer;
use endurant\donationsfree\models\Address;
use endurant\donationsfree\models\Card;
use endurant\donationsfree\models\Transaction;

class BraintreeHttpClient extends Component
{
    private $settings;

    function __constructor() 
    {
        $this->settings = DonationsFree::$plugin->getSettings();

        // Configuration of Braintree
        BraintreeConfiguration::environment($this->settings->btEnvironment);
        BraintreeConfiguration::merchantId($this->settings->btMerchantId);
        BraintreeConfiguration::publicKey($this->settings->btPublicKey);
        BraintreeConfiguration::privateKey($this->settings->btPrivateKey);
    }

    // Public Methods
    // =========================================================================

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
        $result = BraintreeAddress::create([
            'customerId'        => $customer->customerId,
            'company'           => $address->company,
            'streetAddress'     => $address->streetAddress,
            'extendedAddress'   => $address->extendedAddress,
            'locality'          => $address->city,
            'region'            => $address->region,
            'postalCode'        => $address->postalCode,
            'countryName'       => $address->country->name,
            'countryCodeAlpha2' => $address->country->code
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
}
