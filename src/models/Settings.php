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

/**
 * Donationsfree Settings Model
 *
 * This is a model used to define the plugin's settings.
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
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $btEnvironment = 'sandbox';
    public $btMerchantId = '5qgymkb253ndj9yh';
    public $btPublicKey = 'wpg443bzspqx8drp';
    public $btPrivateKey = 'a0adccfd375d9ed363d1819c3c59b8f7';
    public $btAuthorization = 'sandbox_55kjsy7h_5qgymkb253ndj9yh';

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
            [['btEnvironment', 'btMerchantId', 'btPublicKey', 'btPrivateKey', 'btAuthorization'], 'string'],
            [['btEnvironment', 'btMerchantId', 'btPublicKey', 'btPrivateKey', 'btAuthorization'], 'required'],
        ];
    }
}
