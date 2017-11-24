<?php

namespace endurant\donationsfree\records;

use craft\db\ActiveRecord;

/**
 * Step Record
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $order
 * @property string $dateCreated
 * @property string $dateUpdated
 * @property string $uid
 */
class Step extends ActiveRecord
{
    public static function tableName()
    {
        return '{{donations_step}}';
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
            [['id', 'order'], 'integer'],
            [['title', 'name'], 'string'],
            [['name', 'title', 'order'], 'required']
        ];
    }
}