<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Model\Table;

use Cake\i18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table
{
    /**
     * length list
     */
    const LEN_LIST = [
        'username' => '255',
        'password' => '255',
        'email' => '255',
        'first_name' => '100',
        'last_name' => '100',
        'nickname' => '100',
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Articles', [
            'foreignKey' => 'user_id'
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
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        // Username
        $field = 'username';
        $name = __d('users', 'Username');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

        // Password
        $field = 'password';
        $name = __d('users', 'Password');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

        // Nickname
        $field = 'nickname';
        $name = __d('users', 'Nickname');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

        // First name
        $field = 'first_name';
        $name = __d('users', 'first_name');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->allowEmptyString($field, true);

        // Last name
        $field = 'last_name';
        $name = __d('users', 'last_name');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->allowEmptyString($field, true);

        // E-mail
        $field = 'email';
        $name = __d('users', 'email');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->allowEmptyString($field, true);

        // Deleted
        $validator
            ->allowEmptyString('deleted', true);

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
     * Delete post categories
     *
     * @param array $ids User id that will be deleted.
     * @return int The deleted rows.
     */
    public function deleteUsers($ids)
    {
        foreach ($ids as $key => $id) {
            if (!is_numeric($id)) {
                unset($ids[$key]);
            }
        }
        // Delete users
        return $this->updateAll(
            ['deleted' => Time::now()],
            ['id IN' => $ids]
        );
    }
}
