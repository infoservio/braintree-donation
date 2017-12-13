<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation\models;

use endurant\braintreedonation\Donationsfree;

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
class Country extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public $id;
    public $name;
    public $alpha2;
    public $alpha3;
    public $countryCode;
    public $region;
    public $subRegion;
    public $regionCode;
    public $subRegionCode;


    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'countryCode', 'regionCode', 'subRegionCode'], 'integer'],
            [['name', 'region', 'subRegion'], 'string'],
            ['alpha2', 'string', 'length' => 2],
            ['alpha3', 'string', 'length' => 3],
            [['name', 'alpha2', 'alpha3', 'countryCode', 'region', 'subRegion', 'regionCode', 'subRegionCode'], 'required']
        ];
    }
}
