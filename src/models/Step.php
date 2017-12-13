<?php

namespace endurant\braintreedonation\models;

use craft\base\Model;

class Step extends Model
{
    public $id;
    public $name;
    public $title;
    public $order;

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['title', 'name'], 'string'],
            [['name', 'title', 'order'], 'required']
        ];
    }
}