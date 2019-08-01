<?php
namespace AdminApp\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostCategory Entity
 */
class PostCategory extends Entity
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
        'post_category_id' => true,
        'name' => true,
        'description' => true,
        'url_name' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
    ];
}
