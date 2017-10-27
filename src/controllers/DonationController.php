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

use Braintree\ClientToken;
use endurant\donationsfree\DonationsFree;

use Craft;
use craft\web\Controller;
use craft\helpers\ArrayHelper;
use endurant\donationsfree\DonationsFreeAssetBundle;
use endurant\donationsfree\errors\DonationsPluginException;
use endurant\donationsfree\models\forms\DonateForm;
use endurant\donationsfree\records\Country;
use endurant\donationsfree\records\State;

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
        if ($params = Craft::$app->request->post()) {
            return json_encode(['rest']);
        }

        $countries = ArrayHelper::toArray(Country::find()->all());
        $states = ArrayHelper::toArray(State::find()->all());
        $defaultCountryId = Country::DEFAULT_COUNTRY_ID;
        $amount = Craft::$app->session->get('donation')['amount'];
        $amount = ($amount) ? $amount : 50;
        $projectId = Craft::$app->session->get('donation')['projectId'];
        $projectName = Craft::$app->session->get('donation')['projectName'];

        $view = $this->getView();

        $view->setTemplatesPath($this->getViewPath());
        $view->resolveTemplate('index');

        // Include all the JS and CSS stuff
        $view->registerAssetBundle(DonationsFreeAssetBundle::class);

        return $this->renderTemplate('index', [
            'amount' => $amount,
            'defaultCountryId' => $defaultCountryId,
            'countries' => $countries,
            'states' => $states,
            'btAuthorization' => DonationsFree::$PLUGIN->braintreeHttpClient->generateToken(),
            'projectId' => $projectId,
            'projectName' => $projectName
        ]);
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

        $view = $this->getView();

        $view->setTemplatesPath($this->getViewPath());
        $view->resolveTemplate('index');

        // Include all the JS and CSS stuff
        $view->registerAssetBundle(DonationsFreeAssetBundle::class);

        try {
            DonationsFree::$PLUGIN->donationService->donate(Craft::$app->request->post());
        } catch (DonationsPluginException $e) {
            return $this->renderTemplate('error', [
                'errorText' => $e->getMessage(),
                'baseUrl' => Craft::$app->session->get('baseUrl')
            ]);
        } catch (\Exception $e) {
            return $this->renderTemplate('error', [
                'errorText' => $e->getMessage(),
                'baseUrl' => Craft::$app->session->get('baseUrl')
            ]);
        } catch (\Error $e) {
            return $this->renderTemplate('error', [
                'errorText' => $e->getMessage(),
                'baseUrl' => Craft::$app->session->get('baseUrl')
            ]);
        }

        return $this->renderTemplate('success', [
            'successText' => DonationsFree::$PLUGIN->getSettings()->successText,
            'baseUrl' => Craft::$app->session->get('baseUrl') ? Craft::$app->session->get('baseUrl') : '/'
        ]);
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

        $donateForm = new DonateForm();
        $donateForm->setAttributes(Craft::$app->request->post());

        if (!$donateForm->validate()) {
            return $donateForm->getErrors();
        }

        Craft::$app->session->set('donation', $donateForm);
        Craft::$app->session->set('baseUrl', Craft::$app->request->baseUrl);

        return $this->redirect('/actions/donations-free/donation/index');
    }
}
