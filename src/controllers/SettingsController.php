<?php
/**
 * braintree-donation plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\braintreedonation\controllers;

use Craft;
use craft\web\Controller;
use endurant\braintreedonation\BraintreeDonation;
use endurant\braintreedonation\models\BraintreeDonationSettings;
use endurant\braintreedonation\records\Field;
use endurant\braintreedonation\records\Step;

/**
 * Donate Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    endurant
 * @package   Donationsfree
 * @since     1.0.0
 */
class SettingsController extends Controller
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSettings()
    {
        if ($post = Craft::$app->request->post()) {
            BraintreeDonation::$PLUGIN->plugin->updatePluginSettings($post);
            return $this->redirect('braintree-donation/settings');
        }

        $settings = BraintreeDonationSettings::getSettingsArr();
        return $this->renderTemplate('braintree-donation/settings/index', [
            'settings' => $settings
        ]);
    }

    public function actionFields()
    {
        if ($post = Craft::$app->request->post()) {
            BraintreeDonation::$PLUGIN->field->update($post);
        }

        $fields = Field::find()->all();

        return $this->renderTemplate('braintree-donation/settings/fields', [
            'fields' => $fields
        ]);
    }

    public function actionSteps()
    {
        if ($post = Craft::$app->request->post()) {
            BraintreeDonation::$PLUGIN->step->update($post);
        }

        $steps = Step::find()->orderBy('order asc')->all();

        return $this->renderTemplate('braintree-donation/settings/steps', [
            'steps' => $steps
        ]);
    }

    public function actionDonationForm()
    {
        return $this->renderTemplate('braintree-donation/settings/donation-form');
    }
}
