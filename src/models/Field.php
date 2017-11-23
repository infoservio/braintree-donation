<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\models;

use endurant\donationsfree\Donationsfree;

use Craft;
use craft\base\Model;

/**
 * Card Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    endurant
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

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'show', 'required'], 'integer'],
            [['name', 'title'], 'string'],
            [['name', 'title'], 'required']
        ];
    }
}
