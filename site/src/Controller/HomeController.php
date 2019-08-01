<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Controller;

use SiteApp\Controller\AppController;

/**
 * Home Controller
 */
class HomeController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Posts');

        $post = $this->Posts->getLatest();
        $this->set(compact('post'));
    }
}
