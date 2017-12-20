<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\braintreedonation\services;

use endurant\braintreedonation\BraintreeDonation;

use craft\base\Component;

/**
 * Log Service
 *
 * @author    endurant
 * @package   Braintreedonation
 * @since     1.0.0
 */
class LogService extends Component
{
    private $_donationLogger;

    public function __construct()
    {
        parent::__construct();
        $this->_donationLogger = BraintreeDonation::$PLUGIN->donationLogger;
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
