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
 * Images Model
 */
class ImagesTable extends Table
{
    /**
     * length list
     */
    const LEN_LIST = [
        'name' => '100',
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

        $this->setTable('images');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
        $field = 'id';
        $validator
            ->integer($field)
            ->allowEmptyString($field, 'create');

        // File name
        $field = 'name';
        $name = __d('images', 'File name');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name))
            ->add($field, [
                'isUnique' => [
                    'provider' => 'table',
                    'rule' => 'validateUnique',
                    'message' => __('This {0} is already in use.', $name),
                    'last' => true,
                ]
            ]);

        // Image file
        $field = 'mime';
        $validator
            ->inList($field, ['image/jpeg', 'image/png'], 'You can update jpeg or png.');

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
     * Get images
     *
     * @param int $limit The maximum number of rows.
     * @param int|null $page The page number.
     * @return Cake\ORM\ResultSet
     */
    public function getImages($limit, $page = null)
    {
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        }
        $offset = $limit * ((int)$page - 1);

        return $this->find()
            ->order(['created' => 'DESC'])
            ->offset($offset)
            ->limit($limit)
            ->all();
    }
}
