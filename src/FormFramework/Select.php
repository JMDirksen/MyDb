<?php

namespace FormFramework;

class Select
{
    // $options = [['value', 'Name', 'Tooltip']]
    public array $options = [];

    function __construct(
        public ?string $name,
        public null|string|array $selected = null,
        public ?string $label = null,
        public bool $multiple = false,
        public ?string $onchange = null,
    ) {
    }

    function getHtml()
    {
        $html = '';
        if (isset($this->label)) $html .= sprintf('<label>%s ', $this->label);
        $multiple = ($this->multiple) ? ' multiple' : '';
        $onchange = ($this->onchange) ? sprintf(' onchange="%s"', $this->onchange) : null;
        $html .= sprintf('<select name="%s"%s%s>', $this->name, $multiple, $onchange);
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
