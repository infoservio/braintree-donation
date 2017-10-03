<?php
namespace endurant\donationsFree\models;

use craft\base\Model;

class Settings extends Model
{
    public $sum = 100;
    public $bar = 'defaultBarValue';

    public function rules()
    {
        return [
            ['sum', 'integer'],
            [['sum', 'bar'], 'required'],
            // ...
        ];
    }
}