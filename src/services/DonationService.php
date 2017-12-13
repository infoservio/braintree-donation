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

use endurant\braintreedonation\BraintreeDonation;

use Craft;
use craft\base\Component;

use endurant\braintreedonation\errors\DbDonationsPluginException;
use endurant\braintreedonation\models\Customer;
use endurant\braintreedonation\models\Address;
use endurant\braintreedonation\models\Card;
use endurant\braintreedonation\models\Transaction;

/**
 * Donation Service
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
class DonationService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param array $params
     * @throws \endurant\braintreedonation\errors\BraintreeDonationsPluginException
     */
    public function donate(array $params)
    {
        $customer = Customer::create($params);
        $address = Address::create($params);
        $card = new Card();
        $transaction = new Transaction();
        $transaction->amount = intval($params['amount']);
        $transaction->projectId = intval($params['projectId']);
        $transaction->projectName = $params['projectName'];

        $braintreeService = BraintreeDonation::$PLUGIN->braintree;

        $braintreeService->createCustomer($customer);
        $braintreeService->createAddress($customer, $address);
        $braintreeService->createCard($customer, $card, $params['nonce']);
        $braintreeService->createTransaction($customer, $transaction);

       try {
            $address = BraintreeDonation::$PLUGIN->address->saveAddress($address);
            $customer->addressId = $address->id;
            $customer = BraintreeDonation::$PLUGIN->customer->saveCustomer($customer);
            $card->customerId = $customer->id;
            $card = BraintreeDonation::$PLUGIN->card->saveCard($card);
            $transaction->cardId = $card->id;
            $transaction = BraintreeDonation::$PLUGIN->transaction->saveTransaction($transaction);

       } catch(DbDonationsPluginException $e) {
           
       }
    }
}
