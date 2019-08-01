<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 *
 * ---------------------------------------------------------
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Page title
     */
    private $pageDescription;
    private $pageTitle = '';
    private $siteInfo;

    /**
     * Login user
     */
    protected $isLogin;
    protected $loginUser;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        // Site info
        $this->siteInfo = Configure::read('Site');
        $this->set('siteInfo', $this->siteInfo);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * beforeRender callback.
     *
     * @param Event $event The Controller.beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        // Page title
        $pageTitle = __($this->siteInfo['title']);
        if ($this->pageTitle !== '') {
            $pageTitle = "{$this->pageTitle}{$this->siteInfo['titleSeparator']}{$pageTitle}";
        }
        $this->set(compact('pageTitle'));

        // Page description
        $this->set('pageDescription', $this->pageDescription);
    }

    /**
     * Load models
     *
     * @param string|array|null $modelClass Name of model class to load.
     * @param string|array|null $modelType The type of repository to load.
     * @return \Cake\Datasource\RepositoryInterface|bool
     */
    public function loadModel($modelClass = null, $modelType = null)
    {
        $res = false;
        if (is_array($modelClass)) {
            foreach ($modelClass as $model) {
                if (is_string($model)) {
                    $res = parent::loadModel($model);
                }
            }
        } elseif (is_string($modelClass) || $modelClass === null) {
            $res = parent::loadModel($modelClass, $modelType);
        }

        return $res;
    }

    // *********************************************************
    // * User-defined functions
    // *********************************************************
    /**
     * Set page description
     *
     * @param string $pageDescription Description of page.
     * @return null|false
     */
    protected function setPageDescription($pageDescription)
    {
        if (!is_string($pageDescription)) {
            return false;
        }
        $this->pageDescription = $pageDescription;
    }

    /**
     * Set page title
     *
     * @param string $pageTitle Title of page.
     * @return null|false
     */
    protected function setPageTitle($pageTitle)
    {
        if (!is_string($pageTitle)) {
            return false;
        }
        $this->pageTitle = $pageTitle;
    }
}
