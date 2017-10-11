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

    public function donate(array $params) 
    {
        $customer = Customer::init($params);
        $address = Address::init($params);
        $card = new Card();
        $transaction = new Transaction();

        $braintreeService = DonationsFree::$plugin->braintreeService;

        $braintreeService->createCustomer($customer);
        $braintreeService->createAddress($customer, $address);
        $braintreeService->createCard($customer, $card, $params->nonce);
        $braintreeService->createTransaction($customer, $transaction);

        $transaction = Craft::$app->db->beginTransaction();
        try {
            $address = DonationsFree::$plugin->addressService->saveAddress($address);
            $customer->addressId = $address->id;
            $customer = DonationsFree::$plugin->customerService->saveCustomer($customer);
            $card->customerId = $customer->id;
            $card = DonationsFree::$plugin->cardService->saveCard($card);
            $transaction->cardId = $card->id;
            $transaction = DonationsFree::$plugin->transactionService->saveTransaction($card);

            $transaction->commit();
        } catch(\endurant\donationsfree\errors\DbDonationsPluginException $e) {
            $transaction->rollback();
        }
    }
}