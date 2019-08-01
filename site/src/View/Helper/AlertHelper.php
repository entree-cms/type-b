<?php
namespace SiteApp\View\Helper;

use Cake\View\Helper;

class AlertHelper extends Helper
{
    /**
     * Render error alert
     *
     * @param array $messages Error messages.
     * @param bool $escape If this parameter is true, message will be escaped.
     * @param string $sep Separator string.
     * @return void
     */
    public function error($messages, $escape = true, $sep = '<br>')
    {
        $message = $this->toStrFromArr($messages, $escape, $sep);
        if ($message !== '') {
            echo '<div class="alert alert-sm alert-danger">' . $message . '</div>';
        }
    }

    // *****************************************************
    // * Private functions
    // *****************************************************
    /**
     * Convert to string from array
     *
     * @param array $strings Strings
     * @param bool $escape If this parameter is true, strings will be escaped.
     * @param string $sep Separator string.
     * @return string
     */
    private function toStrFromArr($strings, $escape, $sep)
    {
        $outputs = [];
        if (is_array($strings)) {
            foreach ($strings as $string) {
                $output = '';
                if (is_string($string) && $string !== '') {
                    $output = ($escape === true) ? h($string) : $string;
                } elseif (is_array($string)) {
                    $output = $this->toStrFromAry($string, $escape, $sep);
                }
                if ($output !== '') {
                    $outputs[] = $output;
                }
            }
        }

        return implode($sep, $outputs);
    }
}
