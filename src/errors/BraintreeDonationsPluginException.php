<?php

namespace endurant\donationsfree\errors;

use endurant\donationsfree\models\Log;

class BraintreeDonationsPluginException extends DonationsPluginException
{
    protected $culprit = Log::BRAINTREE_CULPRIT;
    
    public function __construct(array $errors, string $message, string $method, string $category) {
        parent::__construct($errors, $message, $method, $category);
    }
}