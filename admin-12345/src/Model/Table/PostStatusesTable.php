<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostStatuses Model
 */
class PostStatusesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('post_statuses');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');
    }

    // *********************************************************
    // * User-defined public functions
    // *********************************************************
    /**
     * Get list
     *
     * @return array
     */
    public function getList()
    {
        $list = $this->find('list')
            ->order('`rank`')
            ->toArray();
        foreach ($list as $i => $value) {
            $list[$i] = __d('post_statuses', $value);
        }

        return $list;
    }
}
