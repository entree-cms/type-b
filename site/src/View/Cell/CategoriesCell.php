<?php
namespace SiteApp\View\Cell;

use Cake\View\Cell;

/**
 * Categories cell.
 */
class CategoriesCell extends Cell
{
    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        // Post counts
        $this->loadModel('Posts');
        $this->loadModel('PostsPostCategories');
        $query = $this->PostsPostCategories->find('list', [
            'keyField' => 'post_category_id',
            'valueField' => 'count'
        ]);
        $countList = $query
            ->select([
                'PostsPostCategories.post_category_id',
                'count' => $query->func()->count('*')
            ])
            ->where([
                'post_id IN' => $this->Posts->find()
                    ->select('id')
                    ->where([
                        'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                        'Posts.deleted IS NULL',
                    ])
            ])
            ->group(['post_category_id'])
            ->toArray();
        $this->set(compact('countList'));

        // Categories
        $categories = [];
        if (count($countList) > 0) {
            $this->loadModel('PostCategories');
            $categories = $this->PostCategories->find()
                ->where([
                    'PostCategories.id IN' => array_keys($countList),
                    'PostCategories.deleted IS NULL'
                ])
                ->all();
        }
        $this->set(compact('categories'));
    }
}
