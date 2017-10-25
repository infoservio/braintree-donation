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

use endurant\donationsFree\models\Log;

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
class LogService extends Component
{
    private $_donationLogger;

    public function __construct()
    {
        parent::__construct();
        $this->_donationLogger = DonationsFree::$PLUGIN->donationLogger;
    }

    // Public Methods
    // =========================================================================
    public function setCategory(string $category)
    {
        $this->_donationLogger->setCategory($category);
    }

    public function log(array $errors, string $message, string $method, array $culprit)
    {
        return $this->_donationLogger->record($errors, $message, $method, $culprit);
    }
}
