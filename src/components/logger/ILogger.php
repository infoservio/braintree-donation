<?php
namespace endurant\braintreedonation\components\logger;

interface ILogger
{
    public function record(array $errors, string $message, string $method, array $culprit);
}