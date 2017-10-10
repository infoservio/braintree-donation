<?php

namespace endurant\donationsfree\errors;

use yii\base\Exception;
use endurant\donationsfree\models\Log;


class DbDonationsPluginException extends DonationsPluginException
{
    protected $culprit = Log::DB_CULPRIT;
}