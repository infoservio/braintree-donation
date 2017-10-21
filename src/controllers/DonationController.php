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

use endurant\donationsfree\DonationsFree;

use Craft;
use craft\web\Controller;
use endurant\donationsfree\assetbundles\donationsfree\DonationsFreeAsset;

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
class DonationController extends Controller
{
    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'pay', 'donate'];

    // Private Properties
    // =========================================================================

    private $donateForm = null;

    // Public Methods
    // =========================================================================

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/donations-free/donate
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $view = $this->getView();
        $view->registerAssetBundle(DonationsFreeAsset::class);
        $view->setTemplatesPath(__DIR__ . '/../templates/donation');
        return $view->renderTemplate('index');
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/donations-free/donate/do-something
     *
     * @return mixed
     */
    public function actionPay()
    {
        $this->requirePostRequest();

        try {
            // DonationsFree::$plugin->donateService->donate($params);
        } catch(\endurant\doantionsfree\errors\DonationsPluginException $e) {

        }
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/donations-free/donate/do-something
     *
     * @return mixed
     */
    public function actionDonate()
    {
        $this->requirePostRequest();

        $this->donateForm = new DonateForm();
        $this->donateForm->setAttributes(Craft::$app->request->post());

        if (!$this->donateForm->validate()) {
            return $this->donateForm->getErrors();
        }

        return $this->redirect('/actions/donations-free/donation/index');
    }
}
