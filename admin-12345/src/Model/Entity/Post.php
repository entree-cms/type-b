<?php
namespace AdminApp\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 */
class Post extends Entity
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
        'user_id' => true,
        'post_status_id' => true,
        'url_name' => true,
        'date' => true,
        'title' => true,
        'abstract' => true,
        'body' => true,
        'eyecatch_id' => true,
        'eyecatch_alt' => true,
        'thumb_id' => true,
        'thumb_alt' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
        'post_categories' => true,
    ];
}
