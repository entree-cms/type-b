<?php
namespace AdminApp\View\Helper;

use Cake\View\Helper;

class FormPlusHelper extends Helper
{
    /**
     * Generate <option> tags
     *
     * @param array $options Values for dropdown and default value.
     * @return string Option tags.
     */
    public function options($options)
    {
        $options += [
            'options' => [],
            'default' => null
        ];

        $outputs = [];
        foreach ($options['options'] as $value => $label) {
            $selected = ($value === $options['default']) ? ' selected="selected"' : '';
            $value = h($value);
            $label = h($label);
            $outputs[] = "<option value=\"{$value}\"{$selected}>{$label}</option>";
        }

        return implode('', $outputs);
    }
}
