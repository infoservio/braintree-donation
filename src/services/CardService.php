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
use endurant\braintreedonation\records\Card as CardRecord;
use endurant\braintreedonation\models\Card;
use endurant\braintreedonation\models\Log;

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
class CardService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Donationsfree::$plugin->donate->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (BraintreeDonation::$PLUGIN->getSettings()->someAttribute) {
        }

        return $result;
    }

    public function saveCard(Card $card)
    {
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($card->getAttributes(), false);

        if (!$cardRecord->save()) {

            throw new DbDonationsPluginException(
                $cardRecord->errors,
                json_encode($cardRecord->toArray()),
                __METHOD__,
                Log::CARD_LOGS
            );
        }

        return $cardRecord;
    }
}
