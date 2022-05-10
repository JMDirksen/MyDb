<?php

class Select {
  function __construct(
    public ?string $name,
    public array $options = [],
    public ?string $selected = null,
    public ?string $label = null,
  ) {
  }

  function getHtml() {
    $html = '';
    if (isset($this->label)) $html .= sprintf('<label>%s ', $this->label);
    $html .= sprintf('<select name="%s">', $this->name);
    foreach ($this->options as $option) {
      $selected = ($option[0] == $this->selected) ? ' selected' : '';
      $title = (isset($option[2])) ? sprintf(' title="%s"',$option[2]) : '';
      $html .= sprintf(
        '<option value="%s"%s%s>%s</option>',
        $option[0],
        $title,
        $selected,
        $option[1],
      );
    }
    $html .= '</select> ';
    if (isset($this->label)) $html .= '</label>';
    return $html;
  }
}
