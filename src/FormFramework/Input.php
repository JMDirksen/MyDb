<?php

namespace FormFramework;

class Input
{
    function __construct(
        public string $type,
        public ?string $name = null,
        public ?string $value = null,
        public ?string $placeholder = null,
        public ?string $label = null,
        public ?bool $checked = null,
        public ?bool $required = null,
        public bool $autofocus = false,
        public ?string $accept = null,
        public ?string $onclick = null,
        public ?string $onchange = null,
    ) {
    }

    function getHtml(bool $tabled = false): string
    {
        $name = (isset($this->name)) ? sprintf(' name="%s"', $this->name) : null;
        $placeholder = (isset($this->placeholder)) ? sprintf(' placeholder="%s"', $this->placeholder) : null;
        $value = (isset($this->value)) ? sprintf(' value="%s"', $this->value) : null;
        $required = ($this->required) ? ' required' : null;
        $autofocus = ($this->autofocus) ? ' autofocus' : null;
        $accept = ($this->accept) ? sprintf(' accept="%s"', $this->accept) : null;
        $onclick = ($this->onclick) ? sprintf(' onclick="%s"', $this->onclick) : null;
        $onchange = ($this->onchange) ? sprintf(' onchange="%s"', $this->onchange) : null;

        $html = '';
        if ($tabled) $html .= sprintf('<tr><th>%s</th><td>', $this->label);
        elseif (isset($this->label)) $html .= sprintf('<label>%s ', $this->label);
        switch ($this->type) {

            case 'checkbox':
                $checked = ($this->checked) ? ' checked' : null;
                $value = ($this->checked) ? '1' : '0';
                $js = sprintf(
                    'document.getElementsByName(\'%s\')[0].value = this.checked ? 1 : 0;',
                    $this->name,
                );
                $html .= sprintf(
                    '<input type="checkbox"%s onchange="%s %s"%s%s> ',
                    $checked,
                    $js,
                    $this->onchange,
                    $autofocus,
                    $onclick,
                ) .
                    sprintf(
                        '<input type="hidden"%s value="%s">',
                        $name,
                        $value,
                    );
                break;

            default:
                $html .= sprintf(
                    '<input type="%s"%s%s%s%s%s%s%s%s> ',
                    $this->type,
                    $name,
                    $placeholder,
                    $value,
                    $required,
                    $autofocus,
                    $accept,
                    $onclick,
                    $onchange,
                );
        }
        if ($tabled) $html .= '</td></tr>';
        elseif (isset($this->label)) $html .= '</label> ';
        return $html;
    }
}
