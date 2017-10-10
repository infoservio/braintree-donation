<?php

namespace endurant\donationsfree\errors;

use yii\base\Exception;
use endurant\donationsfree\DonationsFree;

class DonationsPluginException extends Exception
{
    public $message;
    public $method;
    public $errors;

    protected $culprit;

    private $logService;

    public function __constructor(array $errors, string $message, string $method, string $category) 
    {
        parent::__construct();
        $this->errors = $errors;
        $this->message = $message;
        $this->method = $method;

        $this->$logService = DonationsFree::$plugin->logService;
        $this->log($category);
    }

    private function log(string $category)
    {
        $this->$logService->setCategory($category);
        $this->$logService->log($this->errors, $this->message, $this->method, $this->culprit);
    }
}