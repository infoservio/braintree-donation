<?php
namespace endurant\donationsfree\components\logger;

interface ILogger
{
    public function record(array $errors, string $meesage, string $method, array $culprit);
}