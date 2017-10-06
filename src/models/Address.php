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

use endurant\donationsfree\records\Country as CountryRecord;

/**
 * Customer Model
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
class Address extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $countryId;
    public $company;
    public $region;
    public $city;
    public $postalCode;
    public $streetAddress;
    public $extendedAddress;

    // Public Methods
    // =========================================================================
    
    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'postalCode', 'countryId'], 'integer'],
            [['company', 'countryCode', 'region', 'city', 'streetAddress', 'extendedAddress'], 'string'],
            [['company', 'countryId', 'streetAddress', 'extendedAddress'], 'required']
        ];
    }

    public function getCountry() 
    {
        return CountryRecord::find()->where(['id' => $this->countryId])->one();
    }

    public static function init(array $params) 
    {
        $address = new self();
        
        $address->countryId = $params->countryId;
        $address->company = $params->company;
        $address->region = $params->region;
        $address->city = $params->city;
        $address->postalCode = $params->postalCode;
        $address->streetAddress = $params->streetAddress;
        $address->extendedAddress = $params->extendedAddress;

        return $address;
    }
}
