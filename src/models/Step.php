<?php

namespace infoservio\donateelite\models;

use craft\base\Model;

/**
 * Step Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    infoservio
 * @package   Donationsfree
 * @since     1.0.0
 */
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