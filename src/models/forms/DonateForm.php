<?php

namespace endurant\donationsfree\models\forms;

use craft\base\Model;

class DonateForm extends Model
{
    public $amount;
    public $projectId;
    public $projectName;

    public function rules() 
    {
        return [
            'projectName' => [['projectName'], 'string', 'max' => 50, 'message' => 'Project Name cannot be more than 50 characters.'],
            [['amount', 'projectId'], 'integer', 'integerOnly' => true, 'min' => 0],
            [['amount', 'projectId'], 'required']
        ];
    }
}