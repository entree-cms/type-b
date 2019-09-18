<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Controller;

use AdminApp\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Posts Controller
 */
class PostsController extends AppController
{
    /**
     * The number of rows per page in index action.
     */
    const POST_LIMIT = 10;

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
        // Default values
        $defaults = [
            'date_now' => '1',
            'post_status_id' => POST_STATUS_PUBLISHED,
        ];
        $errors = [];

        // Save
        if ($this->request->is('post')) {
            $postData = $this->normalizePost();
            $post = $this->Posts->newEntity($postData);
            if ($this->Posts->save($post)) {
                // Success
                $this->Flash->success(__d('posts', 'The post has been saved.'));

                return $this->redirect(['action' => 'edit', $post->id]);
            }
            // Error
            $errors = $post->errors();
            $this->setFlashError($errors);
            $defaults = $this->request->getData();
        }
        $this->set(compact('errors'));

        $defaults = $this->normalizeDefaults($defaults);
        $this->set(compact('defaults'));

        $this->setLists();

        $this->setPageTitle(__d('posts', 'Add New Post'));
    }

    /**
     * Edit method
     *
     * @param string $postId The post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($postId)
    {
        $post = $this->Posts->get($postId, [
            'contain' => ['PostCategories']
        ]);
        $this->set('post', clone $post);

        $errors = [];
        if ($this->request->is('post')) {
            $postData = $this->normalizePost();
            $post = $this->Posts->patchEntity($post, $postData, ['associated' => [
                'PostCategories'
            ]]);
            if ($this->Posts->save($post)) {
                // Success
                $this->Flash->success(__d('posts', 'The post has been updated.'));

                return $this->redirect(['action' => 'edit', $post->id]);
            }
            // Error
            $errors = $post->errors();
            $this->setFlashError($errors);
            $defaults = $this->request->getData();
        } else {
            $defaults = $post->toArray();
            $categoryIds = array_column($defaults['post_categories'], 'id');
            $defaults['post_categories'] = ['_ids' => $categoryIds];
            $defaults['date'] = explode(' ', $post->date->i18nFormat('yyyy.MM.dd HH:mm'));
        }
        $this->set(compact('errors'));

        $defaults = $this->normalizeDefaults($defaults);
        $this->set(compact('defaults'));

        $this->setLists();

        $this->setPageTitle(__d('posts', 'Edit Post'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // Delete
        if ($this->request->is('post')) {
            $postIds = $this->request->getData('post_id');
            if (is_array($postIds) && count($postIds) > 0) {
                $rowNum = $this->Posts->deletePosts($postIds);
                if ($rowNum > 0) {
                    $this->Flash->success(__d('posts', 'The post has been deleted.'));

                    return $this->redirect(['action' => $this->request->action, '?' => $this->request->query]);
                }
            }
            $this->Flash->warning(__d('posts', 'Please choose posts.'));
        }

        // Get posts
        $query = $this->Posts->find()
            ->select([
                'Posts.id',
                'Posts.date',
                'Posts.title',
                'Posts.url_name',
                'Posts.modified',
                'PostStatuses.name',
                'Users.nickname',
            ])
            ->contain([
                'PostCategories' => function ($q) {
                    return $q->select(['name']);
                },
                'PostStatuses',
                'Users'
            ])
            ->where(['Posts.deleted IS NULL'])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC'
            ]);
        $posts = [];
        try {
            $this->paginate = ['limit' => self::POST_LIMIT];
            $posts = $this->paginate($query);
        } catch (NotFoundException $e) {
            $paging = $this->request->getParam('paging');
            $lastPage = $paging['Posts']['pageCount'];
            $getParams = ($lastPage > 1) ? ['page' => $lastPage] : [];
            return $this->redirect(['?' => $getParams]);
        }
        $this->set(compact('posts'));

        $this->setPageTitle(__d('posts', 'Posts'));
    }

    // *********************************************************
    // * Private functions
    // *********************************************************
    /**
     * Normalize default values.
     *
     * @param array $defaults Default values.
     * @return array
     */
    private function normalizeDefaults($defaults)
    {
        $this->loadModel('Images');

        // Date
        if (isset($defaults['date_now']) && $defaults['date_now'] === '1') {
            $defaults['date'] = [date('Y-m-d'), '00:00'];
        }

        // Category ID
        if (!isset($defaults['post_categories']['_ids'])) {
            $defaults['post_categories']['_ids'] = [];
        }

        // Eyecatch src
        $eyecatchSrc = '';
        if (isset($defaults['eyecatch_id']) && is_numeric($defaults['eyecatch_id'])) {
            $image = $this->Images->findById($defaults['eyecatch_id'])->first();
            $eyecatchSrc = $image->src;
        }
        $defaults['eyecatchSrc'] = $eyecatchSrc;

        // Thumbnail src
        $thumbSrc = '';
        if (isset($defaults['thumb_id']) && is_numeric($defaults['thumb_id'])) {
            $image = $this->Images->findById($defaults['thumb_id'])->first();
            $thumbSrc = $image->src;
        }
        $defaults['thumbSrc'] = $thumbSrc;

        return $defaults;
    }

    /**
     * Normalized post data.
     *
     * @return array
     */
    private function normalizePost()
    {
        $this->loadComponent('Utility');

        $allowedFields = [
            'abstract',
            'body',
            'date',
            'date_now',
            'eyecatch_alt',
            'eyecatch_id',
            'post_categories',
            'post_status_id',
            'thumb_alt',
            'thumb_id',
            'title',
            'url_name',
        ];

        // Remove not allowed field
        $postData = $this->request->getData();
        $normalized = $this->Utility->pickupAllowed($postData, $allowedFields);

        // UserID
        if ($this->request->action === 'add') {
            $normalized['user_id'] = $this->loginUser['id'];
        }

        // Date
        if ($this->request->getData('date_now') === '1') {
            $normalized['date'] = date('Y-m-d H:i:00');
        } else {
            $normalized['date'] = implode(' ', $this->request->getData('date'));
        }

        // Post categories
        if (!isset($postData['post_categories']['_ids']) || !is_array($postData['post_categories']['_ids'])) {
            $normalized['post_categories']['_ids'] = [];
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
            __d('posts', 'The post could not be saved.'),
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
        $this->loadModel([
            'PostCategories',
            'PostStatuses',
        ]);

        // Post status list
        $postStatusList = $this->PostStatuses->getList();
        $this->set(compact('postStatusList'));

        // Post categories
        $postCategories = $this->PostCategories->getPostCategories();
        $this->set(compact('postCategories'));
    }
}
