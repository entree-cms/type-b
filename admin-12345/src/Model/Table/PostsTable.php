<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Model\Table;

use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 */
class PostsTable extends Table
{
    /**
     * Length list
     */
    const LEN_LIST = [
        'url_name' => 50,
        'title' => 50,
        'body' => 4000,
        'abstract' => 255,
        'thumb_alt' => 255,
        'eyecatch_alt' => 255,
    ];

    /**
     * Prohibited URL Names
     */
    const NG_URL_NAMES = [
        'archive',
        'category',
        'contacts',
        'images',
        'list',
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

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Eyecatches', [
            'className' => 'Images',
            'foreignKey' => 'eyecatch_id'
        ]);
        $this->belongsTo('Thumbs', [
            'className' => 'Images',
            'foreignKey' => 'thumb_id'
        ]);
        $this->belongsTo('PostStatuses', [
            'foreignKey' => 'post_status_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);

        $this->belongsToMany('PostCategories', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'post_category_id',
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

        // Date
        $field = 'date';
        $name = __d('posts', 'Date');
        $validator
            ->dateTime($field, 'ymd', __('Please enter {0}', $name))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyDateTime($field, false, __('Please enter {0}', $name));

        // URL Name
        $field = 'url_name';
        $name = __d('posts', 'URL Name');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name))
            ->add($field, [
                'notInList' => [
                    'provider' => 'custom',
                    'rule' => ['notInList', self::NG_URL_NAMES],
                    'message' => __('This {0} can not be used.', $name)
                ],
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

        // Title
        $field = 'title';
        $name = __d('posts', 'Title');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

        // Abstract
        $field = 'abstract';
        $name = __d('posts', 'Abstract');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->allowEmptyString('abstract');

        // Body
        $field = 'body';
        $name = __d('posts', 'Body');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

        // Eyecatch alt
        $field = 'eyecatch_alt';
        $name = __d('posts', 'Eyecatch alt');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->allowEmptyString($field);

        // Eyecatch alt
        $field = 'thumb_alt';
        $name = __d('posts', 'Thumbnail alt');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->allowEmptyString($field);

        // Deleted
        $validator
            ->allowEmptyDate('deleted');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['post_status_id'], 'PostStatuses'));
        $rules->add($rules->existsIn(['eyecatch_id'], 'Eyecatches'));
        $rules->add($rules->existsIn(['thumb_id'], 'Thumbs'));

        return $rules;
    }

    // *********************************************************
    // * User-defined public functions
    // *********************************************************
    /**
     * Delete posts.
     *
     * @param array $ids Posts id that will be deleted.
     * @return int The deleted rows.
     */
    public function deletePosts($ids)
    {
        foreach ($ids as $key => $id) {
            if (!is_numeric($id)) {
                unset($ids[$key]);
            }
        }

        return $this->updateAll(
            ['deleted' => Time::now()],
            ['id IN' => $ids]
        );
    }
}
