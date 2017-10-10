<?php

namespace endurant\donationsfree\models\forms;

use craft\base\Model;

class PayForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $countryId;
    public $company;
    public $region;
    public $city;
    public $postalCode;
    public $streetAddress;
    public $extendedAddress;

    public function rules() 
    {
        return [
            [['firstName', 'lastName', 'phone', 'email', 'company', 'region', 'city'], 'string', 'max' => 50 ],
            [['streetAddress', 'extendedAddress'], 'string', 'max' => 100 ],
            [['countryId'], 'integer', 'integerOnly' => true, 'min' => 0],
            [['postalCode'], 'integer', 'integerOnly' => true, 'length' => 5],
            [['firstName', 'lastName', 'phone', 'email', 'company', 'region', 'city', 'streetAddress', 'extendedAddress', 'postalCode'], 'required']
        ];
    }
}