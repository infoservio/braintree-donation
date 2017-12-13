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

use craft\base\Component;

use endurant\braintreedonation\records\BraintreeDonationSettings as DonationsSettingsRecord;
use endurant\braintreedonation\models\BraintreeDonationSettings;

/**
 * Donate Service
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class BraintreeDonationSettingsService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param BraintreeDonationSettings $model
     * @return array
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function update(BraintreeDonationSettings $model)
    {
        $record = new DonationsSettingsRecord();
        $record->setAttributes($model->getAttributes(), false);

        if (!$record->update()) {
            return ['success' => false, 'errors' => $record->getErrors()];
        }

        return ['success' => true, 'settings' => $record];
    }
}
