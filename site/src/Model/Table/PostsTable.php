<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Model\Table;

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

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('PostStatuses', [
            'foreignKey' => 'post_status_id',
        ]);
        $this->belongsTo('Eyecatches', [
            'className' => 'Images',
            'foreignKey' => 'eyecatch_id'
        ]);
        $this->belongsTo('Thumbs', [
            'className' => 'Images',
            'foreignKey' => 'thumb_id'
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
        return $rules;
    }

    // *********************************************************
    // * User-defined public functions
    // *********************************************************
    /**
     * Get the latest post.
     *
     * @return SiteApp\Model\Entity\Post|null
     */
    public function getLatest()
    {
        return $this->find()
            ->contain([
                'PostCategories',
                'Eyecatches'
            ])
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL'
            ])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC'
            ])
            ->first();
    }

    /**
     * Get next post
     *
     * @param SiteApp\Model\Entity\Post $post Standard post.
     * @return SiteApp\Model\Entity\Post|null
     */
    public function getNext($post)
    {
        return $this->find()
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL',
                'OR' => [
                    // Date is forward.
                    'Posts.date >' => $post->date,
                    // Same date and modified is forward.
                    'AND' => [
                        'Posts.date' => $post->date,
                        'Posts.modified >' => $post->modified,
                    ],
                ]
            ])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC'
            ])
            ->first();
    }

    /**
     * Get previous post
     *
     * @param SiteApp\Model\Entity\Post $post Standard post.
     * @return SiteApp\Model\Entity\Post|null
     */
    public function getPrev($post)
    {
        return $this->find()
            ->where([
                'Posts.post_status_id' => POST_STATUS_PUBLISHED,
                'Posts.deleted IS NULL',
                'OR' => [
                    // Date is older.
                    'Posts.date <' => $post->date,
                    // Same date and modified older.
                    'AND' => [
                        'Posts.date' => $post->date,
                        'Posts.modified <' => $post->modified,
                    ],
                ]
            ])
            ->order([
                'Posts.date' => 'DESC',
                'Posts.modified' => 'DESC'
            ])
            ->first();
    }
}
