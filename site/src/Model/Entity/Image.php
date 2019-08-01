<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace SiteApp\Model\Entity;

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
        '*' => false
    ];

    /**
     * Get Fullpath
     *
     * @return string
     */
    protected function _getFullpath()
    {
        return UP_IMG_DIR . str_replace('/', DS, $this->_properties['path']);
    }

    /**
     * Get image src
     *
     * @return string
     */
    protected function _getSrc()
    {
        return Router::url(['controller' => 'images', 'action' => 'show', $this->_properties['name']]);
    }
}
