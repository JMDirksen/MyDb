<?php
class Option {
  function __construct(
    public string $value,
    public string $label,
    public ?string $selectedValue = null,
    public bool $selected = false,
  ) {
  }

  function getHtml() {
    $selected = ($this->value == $this->selectedValue || $this->selected) ? ' selected' : '';
    return sprintf(
      '<option value="%s"%s>%s</option>',
      $this->value,
      $selected,
      $this->label,
    );
  }
}
