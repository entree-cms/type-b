<?php
namespace SiteApp\View\Cell;

use Cake\View\Cell;

/**
 * Archives cell.
 */
class ArchivesCell extends Cell
{
    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->loadModel('Posts');
        $query = $this->Posts->find('list', ['keyField' => 'ym', 'valueField' => 'count']);
        $monthList = $query
            ->select([
                'ym' => $query->func()->date_format(['Posts.date' => 'identifier', "'%Y%m'" => 'literal']),
                'count' => $query->func()->count('*')
            ])
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL',
            ])
            ->group(['ym'])
            ->order(['ym' => 'DESC'])
            ->toArray();
        $this->set(compact('monthList'));
    }
}
