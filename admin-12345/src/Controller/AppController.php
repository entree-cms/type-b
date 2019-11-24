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
namespace AdminApp\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Application Controller
 */
class AppController extends Controller
{
    private $pageTitle = '';
    private $siteInfo;

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
        $this->loadComponent('Auth', [
            'authError' => '<div class="text-center">' . __('Please login again.') . '</div>',
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth'
                ]
            ]
        ]);

        // Login user and login flag
        $this->loginUser = $this->Auth->user();
        $this->isLogin = (bool)$this->loginUser;
        $this->set([
            'loginUser' => $this->loginUser,
            'isLogin' => $this->isLogin
        ]);

        // Site info
        $this->siteInfo = Configure::read('Site');
        $this->set('siteInfo', $this->siteInfo);

        // Site URL
        $baseSite = Configure::read('App.baseSite');
        $siteUrl = preg_replace("/\/+$/", '', $baseSite);
        $this->set(compact('siteUrl'));

        // Switch Layout
        $action = $this->request->getParam('action');
        if (preg_match('/^ajax[A-Z]/', $action)) {
            $this->viewBuilder()->setLayout(false);
            $this->autoRender = false;
        } elseif (preg_match('/^sub[A-Z]/', $action)) {
            $this->viewBuilder()->setLayout('subwindow');
        } elseif ($this->isLogin === false) {
            $this->viewBuilder()->setLayout('1col');
        }
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
     * Set page title
     *
     * @param string $pageTitle The page title.
     * @return bool
     */
    protected function setPageTitle($pageTitle)
    {
        if (!is_string($pageTitle)) {
            return false;
        }
        $this->pageTitle = $pageTitle;

        return true;
    }
}
