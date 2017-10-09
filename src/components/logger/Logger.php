<?php
namespace endurant\donationsfree\components\logger;

use endurant\donationsfree\DonationsFree;
use endurant\donationsfree\records\Log as LogRecord;
use endurant\donationsfree\models\Log;
use endurant\donationsfree\components\Settings;
/**
 * General Logger
 */
class Logger implements ILogger
{
    protected $category;
    protected $processId;

    public function __construct()
    {
        $this->category = 'dontaions-free-logs';
        $this->processId = Settings::createProcessID();
    }

    public function setCategory(string $categoty)
    {
        $this->$category = $category;
    } 

    /**
     * This method can record all types f.e. (file, database, email)
     * @param $errors
     * @param $message
     * @param $method
     */
    public function record($errors, $message, $method, array $culprit)
    {
        $result = null;
        if(is_array($errors)) {
            $result['file'] = $this->recordToFile($errors, $message, $method, $culprit);
            $result['db'] = $this->recordToDatabase($errors, $message, $method, $culprit);
        }

        return $result;
    }

    /**
     * This method can record only in file
     * @param $errors
     * @param $message
     * @param $method
     */
    public function recordToFile($errors, $message, $method, $culprit)
    {
        $logMessage = $this->formLogMessage($errors, $message, $method, $culprit->name);
        return DonationsFree::log($logMessage, LogLevel::Error);
    }

    /**
     * This method is used to form log message in readable format
     * @param $errros
     * @param $message
     * @param $method
     * @return string
     */
    protected function formLogMessage($errors, $message, $method, string $culprit)
    {
        $logMessage = PHP_EOL;
        $logMessage .= "CATEGORY: " . $this->category . PHP_EOL;
        $logMessage .= "PID: " . $this->processId . PHP_EOL;
        $logMessage .= "CULPRIT: " . $culprit . PHP_EOL;
        $logMessage .= "METHOD: " . $method . PHP_EOL;
        $logMessage .= "MESSAGE ERROR: " . $message . PHP_EOL;
        $logMessage .= "ERRORS: " . json_encode($errors) . PHP_EOL;
        return $logMessage;
    }

    /**
     * This method can record only in database
     * @param $messages
     * @param $level
     * @param $method
     */
    public function recordToDatabase($errors, $message, $method, number $culprit)
    {
        $log = new Log();
        $log->pid = $this->processId;
        $log->culprit = $culprit->id;
        $log->category = $this->category;
        $log->method = $method;
        $log->message = $message;
        $log->errors = json_encode($errors);
        
        $logRecord = new LogRecord();
        $logRecord->setAttributes($log->getAttributes());

        if (!$log->validate() && !$logRecord->save()) {
            return [$log->getErrors(), $logRecord->getErrors()];
        }

        return true;
    }
}