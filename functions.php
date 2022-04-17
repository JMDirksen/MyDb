<?php

function redirect($url = "") {
  header("Location: $url");
  die();
}

function dump($var) {
  echo "<pre>" . print_r($var, true) . "</pre>";
}
