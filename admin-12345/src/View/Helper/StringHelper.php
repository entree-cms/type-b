<?php
namespace AdminApp\View\Helper;

use Cake\View\Helper;

class StringHelper extends Helper
{
    /**
     * Omit after the specified number of characters
     *
     * @param string $str Base string
     * @param int $len Number of characters
     * @return string
     */
    public function omit($str, $len)
    {
        $output = $str;
        if (mb_strlen($str) > $len) {
            $output = mb_substr($str, 0, $len) . ' ...';
        }

        return $output;
    }
}
