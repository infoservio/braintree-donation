<?php

namespace endurant\braintreedonation\models\forms;

use craft\base\Model;

class DonateForm extends Model
{
    public $fixedAmount;
    public $amount;
    public $projectId;
    public $projectName;

    public function rules() 
    {
        return [
            [['projectName'], 'string', 'max' => 49, 'message' => 'Project Name cannot be more than 50 characters.'],
            [['amount', 'fixedAmount'], 'double', 'min' => 0.1],
            [['projectId'], 'integer']
        ];
    }
}