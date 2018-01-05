<?php
/**
 * donate-elite plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donateelite\services;

use infoservio\donateelite\DonateElite;

use craft\base\Component;

use infoservio\donateelite\errors\DbDonationsPluginException;
use infoservio\donateelite\models\Customer;
use infoservio\donateelite\models\Address;
use infoservio\donateelite\models\Card;
use infoservio\donateelite\models\Transaction;
use infoservio\mailmanager\MailManager;

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
     * @throws \endurant\donateelite\errors\BraintreeDonationsPluginException
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

        $braintreeService = DonateElite::$PLUGIN->braintree;

        $braintreeService->createCustomer($customer);
        $braintreeService->createAddress($customer, $address);
        $braintreeService->createCard($customer, $card, $params['nonce']);
        $braintreeService->createTransaction($customer, $transaction);

        // sending email
        MailManager::$PLUGIN->mail->send($customer->email, 'success-donation');

        try {
            $address = DonateElite::$PLUGIN->address->save($address);
            $customer->addressId = $address->id;
            $customer = DonateElite::$PLUGIN->customer->save($customer);
            $card->customerId = $customer->id;
            $card = DonateElite::$PLUGIN->card->save($card);
            $transaction->cardId = $card->id;
            $transaction = DonateElite::$PLUGIN->transaction->save($transaction);

        } catch(DbDonationsPluginException $e) {
           
        }
    }
}
