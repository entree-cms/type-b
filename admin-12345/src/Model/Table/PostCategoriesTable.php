<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostCategories Model
 */
class PostCategoriesTable extends Table
{
    /**
     * Length list
     */
    const LEN_LIST = [
        'name' => 30,
        'url_name' => 50,
        'description' => 800,
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('post_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PostCategories', [
            'foreignKey' => 'post_category_id'
        ]);
        $this->hasMany('PostCategories', [
            'foreignKey' => 'post_category_id'
        ]);
        $this->belongsToMany('Posts', [
            'foreignKey' => 'post_category_id',
            'targetForeignKey' => 'post_id',
            'joinTable' => 'posts_post_categories'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        // Set custom provider
        $validator
            ->setProvider('custom', 'AdminApp\Model\Validation\CustomValidator');

        // ID
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        // Name
        $field = 'name';
        $name = __d('post_categories', 'Name');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

        // Description
        $field = 'description';
        $name = __d('post_categories', 'Description');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->allowEmptyString('description');

        // URL Name
        $field = 'url_name';
        $name = __d('post_categories', 'URL Name');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name))
            ->add($field, [
                'validChars' => [
                    'provider' => 'custom',
                    'rule' => ['validChars', '/'],
                    'message' => __('{0} can not be used.', '"/"')
                ],
                'isUnique' => [
                    'provider' => 'table',
                    'rule' => 'validateUnique',
                    'message' => __('This {0} is already in use.', $name)
                ]
            ]);

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['post_category_id'], 'PostCategories'));
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }

    // *********************************************************
    // * User-defined public functions
    // *********************************************************
    /**
     * Delete post categories
     *
     * @param array $ids Post category id that will be deleted.
     * @return int The deleted rows.
     */
    public function deletePostCategories($ids)
    {
        foreach ($ids as $key => $id) {
            if (!is_numeric($id)) {
                unset($ids[$key]);
            }
        }

        $conn = ConnectionManager::get('default');
        $conn->begin();

        // Delete categories
        $this->updateAll(
            ['post_category_id' => null, 'modified' => Time::now()],
            ['post_category_id IN' => $ids]
        );
        $deletedQty = $this->updateAll(
            ['deleted' => Time::now()],
            ['id IN' => $ids]
        );

        $conn->commit();

        return $deletedQty;
    }

    /**
     * Get list
     *
     * @return array Category list
     */
    public function getList()
    {
        return $this->find('list')
            ->where(['deleted IS NULL'])
            ->order(['name' => 'ASC'])
            ->toArray();
    }

    /**
     * Get categories
     *
     * @return array Categories
     */
    public function getPostCategories()
    {
        $categories = $this->find()
            ->where(['deleted IS NULL'])
            ->order(['name' => 'ASC'])
            ->toArray();
        $categories = $this->sortCategories($categories);

        return $categories;
    }

    // *********************************************************
    // * Private functions
    // *********************************************************
    /**
     * Sort the category.
     *
     * Parent, in the order of the child.
     *
     * @param array $categories Categories.
     * @return array Sorted categories.
     */
    private function sortCategories($categories)
    {
        $sorted = $this->pickupChildren($categories);

        return $sorted;
    }

    /**
     * Pickup child categories.
     *
     * @param array $categories Categories.
     * @param int $parentId Parent category id.
     * @param int $level Depth to pickup.
     * @return array Child categories.
     */
    private function pickupChildren(&$categories, $parentId = null, $level = 1)
    {
        $children = [];
        $nextLevel = $level + 1;
        foreach ($categories as $i => $category) {
            if (!isset($categories[$i])) {
                continue;
            }
            $thisParentId = $category->post_category_id;
            if ($thisParentId !== $parentId) {
                continue;
            }
            $category->level = $level;
            $children[] = $category;
            unset($categories[$i]);
            // Get children
            $postCategoryId = $category->id;
            $thisChildren = $this->pickupChildren($categories, $postCategoryId, $nextLevel);
            if (count($children) > 0) {
                $children = array_merge($children, $thisChildren);
            }
        }

        return $children;
    }
}
