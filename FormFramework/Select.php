<?php

class Select {
  /** @var Option[] $options */
  public array $options = [];

  function __construct(
    public ?string $name,
  ) {
  }

  function getHtml() {
    $html = sprintf('<select name="%s">', $this->name);
    foreach($this->options as $option) {
      $html .= $option->getHtml();
    }
    $html .= '</select> ';
    return $html;
  }
}
