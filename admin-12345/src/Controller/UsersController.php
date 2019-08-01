<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Controller;

use AdminApp\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $defaults = [];
        $errors = [];

        if ($this->request->is('post')) {
            $postData = $this->normalizePost();
            $user = $this->Users->newEntity($postData);
            if ($this->Users->save($user)) {
                // Success
                $this->Flash->success(__d('users', 'The user has been saved.'));

                return $this->redirect(['action' => 'edit', $user->id]);
            }
            // Error
            $errors = $user->errors();
            $this->setFlashError($errors);
            $defaults = $this->request->getData();
        }
        $this->set(compact('defaults', 'errors'));

        $this->setPageTitle(__d('users', 'Add New User'));
    }

    /**
     * Edit method
     *
     * @param string $userId The user id.
     * @return \Cake\Http\Response|null Redirects on successful save, renders view otherwise.
     */
    public function edit($userId)
    {
        $user = $this->Users->get($userId, [
            'conditions' => ['deleted IS NULL']
        ]);

        $defaults = [];
        $errors = [];
        if ($this->request->is('post')) {
            $postData = $this->normalizePost();
            $user = $this->Users->patchEntity($user, $postData);
            if ($this->Users->save($user)) {
                // Success
                $this->Flash->success(__d('users', 'The user has been updated.'));

                return $this->redirect(['action' => 'edit', $user->id]);
            }
            // Error
            $errors = $user->errors();
            $this->setFlashError($errors);
            $defaults = $this->request->getData();
        } else {
            $defaults = $user->toArray();
        }
        $this->set(compact('defaults', 'errors'));

        $this->setPageTitle(__d('users', 'Edit User'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // Delete
        if ($this->request->getData('action') === 'delete') {
            $userIds = $this->request->getData('user_id');
            if (is_array($userIds) && count($userIds) > 0) {
                $rowNum = $this->Users->deleteUsers($userIds);
                if ($rowNum > 0) {
                    $this->Flash->success(__d('users', 'The user has been deleted.'));

                    return $this->redirect(['action' => $this->request->action, '?' => $this->request->query]);
                }
            }
            $this->Flash->warning(__d('users', 'Please choose users.'));
        }

        $query = $this->Users->find()
            ->where(['deleted IS NULL']);
        $users = $this->paginate($query);
        $this->set(compact('users'));

        $this->setPageTitle(__d('users', 'Users'));
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        if ($this->isLogin) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__d('users', 'Invalid username or password, try again'));
        }
    }

    /**
     * Logout method
     *
     * @return Cake\Http\Response
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    // *********************************************************
    // * Private functions
    // *********************************************************
    /**
     * Normalized post data.
     *
     * @return array
     */
    private function normalizePost()
    {
        $this->loadComponent('Utility');

        $allowedFields = [
            'username',
            'password',
            'nickname',
            'first_name',
            'last_name',
            'email'
        ];

        // Remove not allowed field
        $postData = $this->request->getData();
        $normalized = $this->Utility->pickupAllowed($postData, $allowedFields);

        if ($this->request->getParam('action') === 'edit') {
            if (isset($normalized['password']) && $normalized['password'] === '') {
                unset($normalized['password']);
            }
        }

        return $normalized;
    }

    /**
     * Set flash error message.
     *
     * @param array $errors Error messages.
     * @return void
     */
    private function setFlashError($errors)
    {
        $subMsg = (count($errors) > 0) ? __('Please check your entries.') : null;
        $msg = $this->Utility->makeErrorMsg(
            __d('users', 'The user could not be saved.'),
            $subMsg
        );
        $this->Flash->error($msg);
    }
}
