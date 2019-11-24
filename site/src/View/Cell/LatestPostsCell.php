<?php
namespace SiteApp\View\Cell;

use Cake\View\Cell;

/**
 * Latest posts cell.
 */
class LatestPostsCell extends Cell
{
    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->loadModel('Posts');
        $posts = $this->Posts->find()
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL'
            ])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC',
            ])
            ->limit(5)
            ->all();
        $this->set(compact('posts'));
    }
}
