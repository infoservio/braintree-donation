<?php
/**
 * donate-elite plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

use PHPUnit\Framework\TestCase;

use endurant\donateelite\models\Customer;
use endurant\donateelite\models\Address;
use endurant\donateelite\models\Card;
use endurant\donateelite\models\Transaction;
use endurant\donateelite\components\httpClient\braintree\BraintreeHttpClient;

class BraintreeServiceTest extends TestCase
{
    var $customer = null,
        $address = null,
        $card = null,
        $transaction = null;

    public function setUp()
    {
        $json = json_decode(file_get_contents('https://randomuser.me/api/'));
        $user = $json->results[0];

        $this->customer = new Customer();
        $this->customer->firstName = $user->name->first;
        $this->customer->lastName = $user->name->last;
        $this->customer->email = $user->email;
        $this->customer->phone = $user->phone;

        $this->address = new Address();
        $this->address->city = $user->location->city;
        $this->address->streetAddress = $user->location->street;
        $this->address->postalCode = $user->location->postcode;
        $this->address->stateId = $user->location->state;
        $this->address->countryId = 32;
        $this->address->company = $user->login->username;

        $this->card = new Card();

        $this->transaction = new Transaction();
        $this->transaction->amount = 50;
        $this->transaction->projectId = 1;
    }

    /**
     * @group braintreeService
     */
    public function testSuccessfullyCreatingBraintreeCustomerAddressCardTransaction()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->assertTrue($resultCustomer->success);
        $this->customer->customerId = $resultCustomer->customer->id;

        $resultAddress = $braintreeService->createAddress($this->customer, $this->address);
        $this->assertTrue($resultAddress->success);

        $resultCard = $braintreeService->createCard($this->customer, 'fake-valid-nonce');
        $this->assertTrue($resultCard->success);

        $this->card->tokenId = $resultCard->paymentMethod->token;
        $this->card->bin = $resultCard->paymentMethod->last4;
        $this->card->cardType = $resultCard->paymentMethod->cardType;
        $this->card->expirationDate = $resultCard->paymentMethod->expirationDate;
        $this->card->cardholderName = $resultCard->paymentMethod->cardholderName;
        $this->card->customerLocation = $resultCard->paymentMethod->customerLocation;

        $resultTransaction = $braintreeService->createTransaction($this->customer, $this->transaction);
        $this->assertTrue($resultTransaction->success);

        $this->transaction->success = true;
        $this->transaction->transactionId = $resultTransaction->transaction->id;
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeCustomerWithoutFirstName()
    {
        $braintreeService = new BraintreeHttpClient();
        $this->customer->firstName = null;
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->assertTrue($resultCustomer->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeCustomerWithoutEmail()
    {
        $braintreeService = new BraintreeHttpClient();
        $this->customer->email = null;
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->assertTrue($resultCustomer->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeCustomerWithoutLastName()
    {
        $braintreeService = new BraintreeHttpClient();
        $this->customer->lastName = null;
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->assertTrue($resultCustomer->success);
    }

    /**
     * @expectedException Throwable
     * @group braintreeService
     */
    public function testCreatingBraintreeAddressWithoutCustomerId()
    {
        $braintreeService = new BraintreeHttpClient();
        $braintreeService->createAddress($this->customer, $this->address);
    }

    /**
     * @expectedException Error
     * @group braintreeService
     */
    public function testCreatingBraintreeAddressWithoutCountryId()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $this->address->countryId = null;
        $resultAddress = $braintreeService->createAddress($this->customer, $this->address);
        $this->assertTrue($resultAddress->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeAddressWithoutCity()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $this->address->city = null;
        $resultAddress = $braintreeService->createAddress($this->customer, $this->address);
        $this->assertTrue($resultAddress->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeAddressWithoutStreetAddress()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $this->address->streetAddress = null;
        $resultAddress = $braintreeService->createAddress($this->customer, $this->address);
        $this->assertTrue($resultAddress->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeAddressWithoutPostalCode()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $this->address->postalCode = null;
        $resultAddress = $braintreeService->createAddress($this->customer, $this->address);
        $this->assertTrue($resultAddress->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeAddressWithoutRegion()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $this->address->stateId = null;
        $resultAddress = $braintreeService->createAddress($this->customer, $this->address);
        $this->assertTrue($resultAddress->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeCardWithoutCustomerId()
    {
        $braintreeService = new BraintreeHttpClient();
        $this->customer->customerId = null;
        $result = $braintreeService->createCard($this->customer, 'fake-valid-nonce');
        $this->assertFalse($result->success);
    }

    /**
     * @expectedException TypeError
     * @group braintreeService
     */
    public function testCreatingBraintreeCardWithoutPaymentNonce()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $braintreeService->createCard($this->customer, null);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeCardWitEmptyPaymentNonce()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $result = $braintreeService->createCard($this->customer, '');
        $this->assertFalse($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeTransactionWithoutCustomerId()
    {
        $braintreeService = new BraintreeHttpClient();
        $this->customer->customerId = null;
        $result = $braintreeService->createTransaction($this->customer, $this->transaction);
        $this->assertFalse($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreatingBraintreeTransactionWithoutAmount()
    {
        $braintreeService = new BraintreeHttpClient();
        $resultCustomer = $braintreeService->createCustomer($this->customer);
        $this->customer->customerId = $resultCustomer->customer->id;

        $this->transaction->amount = -100;
        $result = $braintreeService->createTransaction($this->customer, $this->transaction);
        $this->assertFalse($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionValidNoBillingAddress()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-valid-no-billing-address-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionValidNoIndicators()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-valid-no-indicators-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionValidPaypalOneTime()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-paypal-one-time-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidProcessorDeclinedVisa()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-processor-declined-visa-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidProcessorDeclinedMastercard()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-processor-declined-mastercard-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidProcessorDeclinedAmex()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-processor-declined-amex-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidProcessorDeclinedDiscover()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-processor-declined-discover-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidProcessorDeclinedDinersclub()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-processor-declined-dinersclub-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidProcessorDeclinedJcb()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-processor-failure-jcb-nonce');
        $this->assertTrue($result->success);
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionLuhnInvalid()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-luhn-invalid-nonce');
        $this->assertFalse($result->success);
        print $result;
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionNoValidConsumed()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-consumed-nonce');
        $this->assertFalse($result->success);
        print $result;
    }

    /**
     * @group braintreeService
     */
    public function testCreateTransactionGatewayRejectedFraud()
    {
        $result = (new BraintreeHttpClient())->createTestTransaction('fake-gateway-rejected-fraud-nonce');
        $this->assertTrue($result->success);
    }
}
