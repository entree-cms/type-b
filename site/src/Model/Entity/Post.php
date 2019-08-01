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
    ];

    /**
     * Get abstract
     *
     * @return string
     */
    protected function _getAbstract()
    {
        if (!isset($this->_properties['abstract'])
            || $this->_properties['abstract'] === ''
        ) {
            $strlen = 100;
            $body = (isset($this->_properties['body'])) ? $this->_properties['body'] : '';
            $body = strip_tags($body);
            $body = mb_substr($body, 0, $strlen);
            if (mb_strlen($this->_properties['body']) > $strlen) {
                $body .= ' ...';
            }

            return $body;
        }

        return $this->_properties['abstract'];
    }

    /**
     * Get categories text
     *
     * @return string
     */
    protected function _getCategories()
    {
        $output = '';
        if (isset($this->_properties['post_categories'])) {
            $categories = '';
            foreach ($this->_properties['post_categories'] as $category) {
                $categories .= '<li>' . h($category->name) . '</li>';
            }
            $output = "<ul>{$categories}</ul>";
        }

        return $output;
    }

    /**
     * Get URL
     *
     * @return string
     */
    protected function _getUrl()
    {
        return Router::url(['controller' => 'Blog', 'action' => 'detail', $this->_properties['url_name']]);
    }
}
