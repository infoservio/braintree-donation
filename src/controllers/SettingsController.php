<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\controllers;

use Craft;
use craft\web\Controller;
use endurant\donationsfree\DonationsFree;
use endurant\donationsfree\models\DonationsSettings;
use endurant\donationsfree\records\Field;
use endurant\donationsfree\records\Step;

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
            DonationsFree::$PLUGIN->pluginService->updatePluginSettings($post);
            return $this->redirect('donations-free/settings');
        }

        $settings = DonationsSettings::getSettingsArr();
        return $this->renderTemplate('donations-free/settings/index', [
            'settings' => $settings
        ]);
    }

    public function actionFields()
    {
        $fields = Field::find()->all();
        if ($post = Craft::$app->request->post()) {
            foreach ($post as $key => $value) {
                $field = Field::find()->where(['name' => $key])->one();
                $field->required = +$value;
                $field->save();
            }

            $fields = Field::find()->all();

            return $this->renderTemplate('donations-free/settings/fields', [
                'fields' => $fields
            ]);
        }

        return $this->renderTemplate('donations-free/settings/fields', [
            'fields' => $fields
        ]);
    }

    public function actionSteps()
    {
        if ($post = Craft::$app->request->post()) {
            DonationsFree::$PLUGIN->stepService->update($post);
        }

        $steps = Step::find()->all();

        return $this->renderTemplate('donations-free/settings/steps', [
            'steps' => $steps
        ]);
    }

    public function actionSend()
    {
        $this->requirePostRequest();
    }
}
