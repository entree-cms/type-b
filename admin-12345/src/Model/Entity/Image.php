<?php
namespace AdminApp\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Image Entity
 */
class Image extends Entity
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
        'name' => true,
        'alt' => true,
        'path' => true,
        'mime' => true,
        'width' => true,
        'height' => true,
        'size' => true,
        'created' => true,
        'modified' => true
    ];

    /**
     * Get Fullpath
     *
     * @return string The full path of image.
     */
    protected function _getFullpath()
    {
        return UP_IMG_DIR . str_replace('/', DS, $this->_properties['path']);
    }

    /**
     * Get image src
     *
     * @return string URL of image.
     */
    protected function _getSrc()
    {
        return Configure::read('App.baseApp') . "/images/{$this->_properties['name']}";
    }
}
