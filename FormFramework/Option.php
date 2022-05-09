<?php
class Option {
  function __construct(
    public string $value,
    public string $label,
    public ?string $selectedValue = null,
  ) {
  }

  function getHtml() {
    $selected = ($this->value == $this->selectedValue) ? ' selected' : '';
    return sprintf(
      '<option value="%s"%s>%s</option>',
      $this->value,
      $selected,
      $this->label,
    );
  }
}
