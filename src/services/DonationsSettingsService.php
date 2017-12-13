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

use endurant\braintreedonation\DonationsFree;

use Craft;
use craft\base\Component;

use endurant\braintreedonation\records\DonationsSettings as DonationsSettingsRecord;
use endurant\braintreedonation\models\DonationsSettings;

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
class DonationsSettingsService extends Component
{
    // Public Methods
    // =========================================================================

    public function update(DonationsSettings $settings)
    {
        $settingsRecord = new DonationsSettingsRecord();
        $settingsRecord->setAttributes($settings->getAttributes(), false);

        if (!$settingsRecord->update()) {
            return ['success' => false, 'errors' => $settingsRecord->getErrors()];
        }

        return ['success' => true, 'settings' => $settingsRecord];
    }
}
