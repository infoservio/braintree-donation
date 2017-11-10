<?php
namespace endurant\donationsfree\components\logger;

use Craft;
use endurant\donationsfree\records\Log as LogRecord;
use endurant\donationsfree\models\Log;
use endurant\donationsfree\components\Settings;
use PHPUnit\Framework\Error\Error;
use Psr\Log\LogLevel;
use yii\db\Exception;

/**
 * General Logger
 */
class Logger implements ILogger
{
    private $category;
    private $processId;

    public function __construct()
    {
        $this->category = 'donations-free-logs';
        $this->processId = Settings::createProcessID();
    }

    public function setCategory(string $category)
    {
        $this->category = $category;
    }

    /**
     * This method can record all types f.e. (file, database, email)
     * @param $errors
     * @param $message
     * @param $method
     */
    public function record(array $errors, string $message, string $method, array $culprit)
    {
        $result = null;
        if(is_array($errors)) {
            $result['file'] = $this->recordToFile($errors, $message, $method, $culprit);
            $result['db'] = $this->recordToDatabase($errors, $message, $method, $culprit['id']);
        }

        return $result;
    }

    /**
     * This method can record only in file
     * @param $errors
     * @param $message
     * @param $method
     */
    public function recordToFile(array $errors, string $message, string $method, array $culprit)
    {
        $logMessage = $this->formLogMessage($errors, $message, $method, $culprit['name']);

        try {
            Craft::$app->getLog()->logger->log($logMessage, LogLevel::ERROR);
        } catch (Error $e) {
            return false;
        }

        return true;
    }

    /**
     * This method is used to form log message in readable format
     * @param $errros
     * @param $message
     * @param $method
     * @return string
     */
    protected function formLogMessage(array $errors, string $message, string $method, string $culprit)
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
    public function recordToDatabase(array $errors, string $message, string $method, int $culprit)
    {
        $log = new Log();
        $log->pid = $this->processId;
        $log->culprit = intval($culprit);
        $log->category = $this->category;
        $log->method = $method;
        $log->message = $message;
        $log->errors = json_encode($errors);

        $logRecord = new LogRecord();
        $logRecord->setAttributes($log->getAttributes());

        if (!$logRecord->save()) {
            return json_encode([$log->getErrors(), $logRecord->getErrors()]);
        }

        return json_encode($logRecord->getAttributes());
    }
}