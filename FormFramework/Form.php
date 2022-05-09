<?php
class Form {
  public array $elements;

  function __construct(
    public Method $method = Method::POST,
    public ?string $action = null,
  ) {
  }

  function getHtml(bool $tabled = false): string {
    $action = (isset($this->action)) ? sprintf(' action="%s"', $this->action) : null;

    $html = sprintf(
      '<form method="%s"%s>',
      $this->method->value,
      $action,
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

enum Method: string {
  case POST = 'POST';
  case GET = 'GET';
}
