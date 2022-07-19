<?php

namespace FormFramework;

class Form
{
    public array $elements;
    public string $other;

    function __construct(
        public string $method = 'POST',
        public ?string $action = null,
        public string $enctype = 'application/x-www-form-urlencoded',
    ) {
    }

    function getHtml(bool $tabled = false): string
    {
        $action = (isset($this->action)) ? sprintf(' action="%s"', $this->action) : null;
        $other = (isset($this->other)) ? sprintf(' %s', $this->other) : null;

        $html = sprintf(
            '<form method="%s" enctype="%s"%s%s>',
            $this->method,
            $this->enctype,
            $action,
            $other,
        );
        if ($tabled) $html .= '<table>';
        foreach ($this->elements as $element) {
            $html .= $element->getHtml($tabled);
        }
        if ($tabled) $html .= '</table>';
        $html .= sprintf('</form>');
        return $html;
    }
}
