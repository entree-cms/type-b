<?php
/**
 * @copyright Copyright (c) Akihiro Aoyagi
 * @since     1.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace AdminApp\Model\Validation;

use Cake\Validation\Validator;

class CustomValidator extends Validator
{
    /**
     * Not in list
     *
     * @param mixed $value The searched value.
     * @param array $list The array through which to search.
     * @return bool
     */
    public static function notInList($value, $list)
    {
        return !in_array($value, $list, true);
    }

    /**
     * Valid chars
     *
     * @param string $value The string search in.
     * @param string $char Forbidden char.
     * @return bool
     */
    public static function validChars($value, $char)
    {
        return (strpos($value, $char) === false);
    }
}
