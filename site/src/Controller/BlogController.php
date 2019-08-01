<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Controller;

use Cake\Http\Exception\NotFoundException;
use SiteApp\Controller\AppController;

/**
 * Blog Controller
 */
class BlogController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Posts');
    }

    // *********************************************************
    // * Actions
    // *********************************************************
    /**
     * Archive
     *
     * @param string $ym YYYYmm
     * @return \Cake\Http\Response|void
     */
    public function archive($ym)
    {
        if (strlen($ym) !== 6) {
            throw new NotFoundException;
        }
        $query = $this->Posts->find()
            ->contain([
                'PostCategories',
                'Thumbs'
            ])
            ->where([
                "DATE_FORMAT(date, '%Y%m') = :ym",
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL',
            ])
            ->bind(':ym', $ym, 'string');
        try {
            // $this->paginate['limit'] = 1;
            $posts = $this->paginate($query);
        } catch (NotFoundException $e) {
            return $this->redirect(['action' => $this->request->action]);
        }

        if (count($posts) === 0) {
            throw new NotFoundException;
        }
        $this->set(compact('posts'));

        // Page Title
        $y = substr($ym, 0, 4);
        $m = substr($ym, 4, 2);
        $title = __d('posts', 'Posts') . ' (' . __d('posts', '{1}/{0}', [$y, $m]) . ')';
        $this->setPageTitle($title);
    }

    /**
     * Category
     *
     * @param string $urlName URL Name.
     * @return \Cake\Http\Response|void
     */
    public function category($urlName = null)
    {
        $this->loadModel([
            'PostsPostCategories',
            'PostCategories'
        ]);

        if (!is_string($urlName) || $urlName === '') {
            throw new NotFoundexception;
        }

        $category = $this->PostCategories->findByUrlName($urlName)->first();
        if (!$category) {
            throw new NotFoundexception;
        }

        $query = $this->Posts->find()
            ->contain(['PostCategories'])
            ->where([
                'Posts.id IN' => $this->PostsPostCategories->findByPostCategoryId($category->id)->select('post_id'),
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL',
            ])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC'
            ]);
        try {
            $posts = $this->paginate($query);
        } catch (NotFoundException $e) {
            return $this->redirect(['action' => $this->request->action]);
        }
        $this->set(compact('posts'));

        // Page Title
        $this->setPageTitle(__d('posts', 'Category'));
    }

    /**
     * Detail
     *
     * @param string $urlName URL Name.
     * @return \Cake\Http\Response|void
     */
    public function detail($urlName = null)
    {
        $this->loadModel([
            'Posts'
        ]);

        if (!is_string($urlName) || $urlName === '') {
            throw new NotFoundexception;
        }

        $post = $this->Posts->findByUrlName($urlName)
            ->contain([
                'Eyecatches',
                'PostCategories',
            ])
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL'
            ])
            ->first();
        if (!$post) {
            throw new NotFoundException;
        }
        $this->set(compact('post'));

        // Prev / Next post.
        $prevPost = $this->Posts->getPrev($post);
        $nextPost = $this->Posts->getNext($post);
        $this->set(compact('prevPost', 'nextPost'));

        // Page title
        $this->setPageTitle($post->title);

        // Page description
        $this->setPageDescription($post->abstract);
    }

    /**
     * Index
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $query = $this->Posts->find()
            ->contain([
                'PostCategories',
                'Thumbs'
            ])
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL',
            ])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC'
            ]);
        try {
            $posts = $this->paginate($query);
        } catch (NotFoundException $e) {
            return $this->redirect(['action' => $this->request->action]);
        }
        $this->set(compact('posts'));

        // Page title
        $this->setPageTitle(__d('posts', 'Posts'));
    }
}
