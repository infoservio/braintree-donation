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
 * Card Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class CardService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Card $model
     * @return CardRecord
     * @throws DbDonationsPluginException
     */
    public function save(Card $model)
    {
        $record = new CardRecord();
        $record->setAttributes($model->getAttributes(), false);

        if (!$record->save()) {

            throw new DbDonationsPluginException(
                $record->errors,
                json_encode($record->toArray()),
                __METHOD__,
                Log::CARD_LOGS
            );
        }

        return $record;
    }
}
