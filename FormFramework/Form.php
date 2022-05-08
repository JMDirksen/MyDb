<?php
class Form {
  public array $elements;

  function __construct(public Method $method = Method::POST) {
  }

  function getHtml() {
    echo sprintf('<form method="%s">', $this->method->value);
    foreach ($this->elements as $element) {
      echo $element->getHtml();
    }
    echo sprintf('</form>');
  }
}

enum Method: string {
  case POST = 'POST';
  case GET = 'GET';
}
