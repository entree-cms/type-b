<?php
namespace AdminApp\Controller\Component;

use Cake\Controller\Component;

class UtilityComponent extends Component
{
    /**
     * Convert array into string
     *
     * @param array $arr The array of strings.
     * @param string $sep Separator string.
     * @return string
     */
    public function arrToStr($arr, $sep = "\n")
    {
        $outputs = [];
        foreach ($arr as $child) {
            if (is_string($child)) {
                $outputs[] = $child;
            } elseif (is_array($child)) {
                $outputs[] = $this->arrToStr($child, $sep);
            }
        }

        return implode($sep, $outputs);
    }

    /**
     * Maker error message HTML
     *
     * @param string $mainMsg The main message.
     * @param string $subMsg The sub message.
     * @return string
     */
    public function makeErrorMsg($mainMsg, $subMsg = null)
    {
        $msg = '<p class="header">' . h($mainMsg) . '</p>';
        if (is_string($subMsg) && $subMsg !== '') {
            $msg .= '<p>' . h($subMsg) . '</p>';
        }

        return $msg;
    }

    /**
     * Get the only allowed key from the array.
     *
     * @param array $arr Raw array.
     * @param array $keys The keys to pick up.
     * @return array
     */
    public function pickupAllowed($arr, $keys)
    {
        foreach ($arr as $key => $value) {
            if (!in_array($key, $keys)) {
                unset($arr[$key]);
            }
        }

        return $arr;
    }
}
