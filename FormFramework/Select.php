<?php

class Select {
  function __construct(
    public ?string $name,
    public array $options = [],
    public ?string $selected = null,
  ) {
  }

  function getHtml() {
    $html = sprintf('<select name="%s">', $this->name);
    foreach ($this->options as $option) {
      $selected = ($option[0] == $this->selected) ? ' selected' : '';
      $html .= sprintf(
        '<option value="%s"%s>%s</option>',
        $option[0],
        $selected,
        $option[1],
      );
    }
    $html .= '</select> ';
    return $html;
  }
}
