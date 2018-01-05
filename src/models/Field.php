<?php
/**
 * donate-elite plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace infoservio\donateelite\models;

use craft\base\Model;
use infoservio\donateelite\records\Field as FieldRecord;

/**
 * Card Model
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
class Field extends Model
{
    // Public Properties
    // =========================================================================
    const FIELD_NOT_REQURIED = ['id' => 0, 'name' => 'not required'];
    const FIELD_REQUIRED = ['id' => 1, 'name' => 'required'];

    const FIELD_NOT_SHOW = ['id' => 0, 'name' => 'not show'];
    const FIELD_SHOW = ['id' => 1, 'name' => 'show'];

    const FIELD_CANNOT_HIDE = ['id' => 0, 'name' => 'cannot hide'];
    const FIELD_CAN_HIDE = ['id' => 1, 'name' => 'can hide'];
    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $name;
    public $title;
    public $required;
    public $show;
    public $canHide;

    // Public Static Methods
    // =========================================================================

    public static function getFieldsArr()
    {
        $fields = FieldRecord::find()->all();
        $resultArr = [];
        foreach ($fields as $field) {
            $resultArr[$field->name] = $field->getAttributes(['required', 'show']);
        }

        return $resultArr;
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'show', 'required', 'canHide'], 'integer'],
            [['name', 'title'], 'string'],
            [['name', 'title'], 'required']
        ];
    }
}
