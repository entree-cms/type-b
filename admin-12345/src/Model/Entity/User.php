<?php
namespace AdminApp\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'email' => true,
        'first_name' => true,
        'last_name' => true,
        'nickname' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
        'articles' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * Get full name.
     *
     * @return string Full name.
     */
    protected function _getName()
    {
        $firstName = (string)$this->_properties['first_name'];
        $lastName = (string)$this->_properties['last_name'];
        if ($firstName !== '' && $lastName !== '') {
            $name = "{$firstName} {$lastName}";
        } else {
            $name = "{$firstName}{$lastName}";
        }

        return $name;
    }

    /**
     * Set Password.
     *
     * @param string $password Raw password strings.
     * @return string Hashed password.
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
