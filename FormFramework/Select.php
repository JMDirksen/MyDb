<?php

namespace FormFramework;

class Select
{
    public array $options;

    function __construct(
        public ?string $name,
        public null|string|array $selected = null,
        public ?string $label = null,
        public bool $multiple = false,
    ) {
    }

    function getHtml()
    {
        $html = '';
        if (isset($this->label)) $html .= sprintf('<label>%s ', $this->label);
        $multiple = ($this->multiple) ? ' multiple' : '';
        $html .= sprintf('<select name="%s"%s>', $this->name, $multiple);
        foreach ($this->options as $option) {
            if (gettype($this->selected) == 'array') {
                $selected = (in_array($option[0], $this->selected)) ? ' selected' : '';
            } else {
                $selected = ($option[0] == $this->selected) ? ' selected' : '';
            }
            $title = (isset($option[2])) ? sprintf(' title="%s"', $option[2]) : '';
            $html .= sprintf(
                '<option value="%s"%s%s>%s</option>',
                $option[0],
                $title,
                $selected,
                htmlspecialchars($option[1], double_encode: false),
            );
        }
        $html .= '</select> ';
        if (isset($this->label)) $html .= '</label>';
        return $html;
    }
}
