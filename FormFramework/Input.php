<?php
class Input {

  function __construct(
    public string $type,
    public ?string $name = null,
    public ?string $value = null,
    public ?string $placeholder = null,
    ) {
  }

  function getHtml() {
    $name = (isset($this->name)) ? sprintf(' name="%s"', $this->name) : null;
    $placeholder = (isset($this->placeholder)) ? sprintf(' placeholder="%s"', $this->placeholder) : null;
    $value = (isset($this->value)) ? sprintf(' value="%s"', $this->value) : null;
    return sprintf(
      '<input type="%s"%s%s%s>',
      $this->type,
      $name,
      $placeholder,
      $value,
    );
  }
}
