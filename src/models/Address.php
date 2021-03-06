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

use infoservio\donateelite\records\Country as CountryRecord;
use infoservio\donateelite\records\State as StateRecord;

/**
 * Customer Model
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
    public $stateId;
    public $city;
    public $postalCode;
    public $streetAddress;
    public $extendedAddress;

    // Public Static Methods
    // =========================================================================

    /**
     * @param array $params
     * @return Address
     */
    public static function create(array $params)
    {
        $address = new self();

        $address->countryId = $params['countryId'];
        $address->company = $params['company'];
        $address->stateId = $params['state'] ? $params['state'] : $params['stateId'];
        $address->city = $params['city'];
        $address->postalCode = $params['postalCode'];
        $address->streetAddress = $params['streetAddress'];
        $address->extendedAddress = $params['extendedAddress'];

        return $address;
    }

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'countryId'], 'integer'],
            [['company', 'city', 'streetAddress', 'extendedAddress', 'postalCode'], 'string'],
            [['countryId', 'city', 'postalCode', 'streetAddress'], 'required']
        ];
    }

    public function getCountry()
    {
        return CountryRecord::getCountryById($this->countryId);
    }

    public function getStateName()
    {
        if ($this->stateId && !is_string($this->stateId)) {
            $state = StateRecord::getStateById($this->stateId);
            return $state->name;
        }
        return $this->stateId;
    }
}
