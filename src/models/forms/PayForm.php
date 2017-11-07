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
    public $stateId;
    public $city;
    public $postalCode;
    public $streetAddress;
    public $extendedAddress;

    public function rules() 
    {
        return [
            [['firstName', 'lastName', 'phone', 'email', 'company', 'stateId', 'city'], 'string', 'max' => 49 ],
            [['streetAddress', 'extendedAddress'], 'string', 'max' => 100 ],
            [['email'], 'email'],
            [['countryId', 'postalCode'], 'integer', 'min' => 1],
            [['firstName', 'lastName', 'phone', 'countryId', 'email', 'stateId', 'city', 'streetAddress', 'postalCode'], 'required']
        ];
    }
}