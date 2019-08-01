<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Controller;

use AdminApp\Controller\AppController;

/**
 * Dashboard controller
 */
class DashboardController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Posts');
        $recentlyPosts = $this->Posts->find()
            ->contain([
                'PostCategories',
                'PostStatuses',
                'Users'
            ])
            ->where('Posts.deleted IS NULL')
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC',
            ])
            ->limit(3)
            ->all();
        $this->set(compact('recentlyPosts'));

        $this->setPageTitle(__('Dashboard'));
    }
}
