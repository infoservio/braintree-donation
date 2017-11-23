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

use endurant\donationsfree\records\Field as FieldRecord;
use endurant\donationsfree\models\Field;

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
class FieldService extends Component
{
    // Public Methods
    // =========================================================================

    public function update(Field $field)
    {
        $fieldRecord = new FieldRecord();
        $fieldRecord->setAttributes($field->getAttributes(), false);

        if (!$fieldRecord->update()) {
            return ['success' => false, 'errors' => $fieldRecord->getErrors()];
        }

        return ['success' => true, 'settings' => $fieldRecord];
    }
}
