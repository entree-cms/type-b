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
 * Contacts Model
 */
class ContactsTable extends Table
{
    /**
     * Length list
     */
    const LEN_LIST = [
        'note' => 800
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

        $this->setTable('contacts');
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
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        // Note
        $field = 'note';
        $name = __d('contacts', 'Note');
        $length = self::LEN_LIST[$field];
        $validator
            ->scalar($field, __('Please enter {0}', $name))
            ->maxLength($field, $length, __('Please enter {0} characters or less', $length))
            ->requirePresence($field, 'create', __('Please enter {0}', $name))
            ->allowEmptyString($field, false, __('Please enter {0}', $name));

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
        return $rules;
    }
}
