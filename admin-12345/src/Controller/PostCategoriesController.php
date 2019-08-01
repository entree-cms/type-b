<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Controller;

use AdminApp\Controller\AppController;

/**
 * PostCategories Controller
 */
class PostCategoriesController extends AppController
{
    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Add method
     *
     * @return \Cake\Http\Response|void
     */
    public function add()
    {
        $defaults = [];
        $errors = [];

        if ($this->request->is('post')) {
            $postData = $this->normalizePost();
            $category = $this->PostCategories->newEntity($postData);
            if ($this->PostCategories->save($category)) {
                $this->Flash->success(__d('post_categories', 'The category has been saved.'));

                return $this->redirect(['action' => 'edit', $category->id]);
            }
            // Error
            $errors = $category->errors();
            $this->setFlashError($errors);
            $defaults = $this->request->getData();
        }
        $this->set(compact('defaults', 'errors'));

        $this->setLists();

        $this->setPageTitle(__d('post_categories', 'Add New Category'));
    }

    /**
     * Edit method
     *
     * @param string $postCategoryId The post category id.
     * @return \Cake\Http\Response|void
     */
    public function edit($postCategoryId)
    {
        $category = $this->PostCategories->get($postCategoryId);

        $errors = [];

        if ($this->request->is('post')) {
            $postData = $this->normalizePost();
            $category = $this->PostCategories->patchEntity($category, $postData);
            if ($this->PostCategories->save($category)) {
                $this->Flash->success(__d('post_categories', 'The category has been updated.'));

                return $this->redirect(['action' => 'edit', $category->id]);
            }
            // Error
            $errors = $category->errors();
            $this->setFlashError($errors);
            $defaults = $this->request->getData();
        } else {
            $defaults = $category->toArray();
        }
        $this->set(compact('defaults', 'errors'));

        $this->setLists();

        $this->setPageTitle(__d('post_categories', 'Edit Category'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $categories = $this->PostCategories->getPostCategories();
        $this->set(compact('categories'));

        // Delete
        if ($this->request->getData('action') === 'delete') {
            $postCategoryIds = $this->request->getData('post_category_id');
            if (is_array($postCategoryIds) && count($postCategoryIds) > 0) {
                $rowNum = $this->PostCategories->deletePostCategories($postCategoryIds);
                if ($rowNum > 0) {
                    $this->Flash->success(__d('posts', 'The post has been deleted.'));

                    return $this->redirect(['action' => $this->request->action, '?' => $this->request->query]);
                }
            }
            $this->Flash->warning(__d('posts', 'Please choose posts.'));
        }

        $this->setPageTitle(__d('post_categories', 'Categories'));
    }

    // *********************************************************
    // * Ajax
    // *********************************************************
    /**
     * Add new category
     *
     * @return void
     */
    public function ajaxAdd()
    {
        $name = $this->request->getData('category');
        $category = $this->Categories->newEntity(compact('name'));
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
            'name',
            'url_name',
            'post_category_id',
            'description'
        ];

        // Remove not allowed field
        $postData = $this->request->getData();
        $normalized = $this->Utility->pickupAllowed($postData, $allowedFields);

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
            __d('post_categories', 'The category could not be saved.'),
            $subMsg
        );
        $this->Flash->error($msg);
    }

    /**
     * Set list variables for form.
     *
     * @return void
     */
    private function setLists()
    {
        $postCategoryList = $this->PostCategories->getList();
        $this->set(compact('postCategoryList'));
    }
}
