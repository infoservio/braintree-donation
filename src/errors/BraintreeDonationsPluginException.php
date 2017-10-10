<?php

namespace endurant\donationsfree\errors;

use yii\base\Exception;
use endurant\donationsfree\models\Log;

class BraintreeDonationsPluginException extends DonationsPluginException
{
    protected $culprit = Log::BRAINTREE_CULPRIT;
}