<?php

function redirect($url = null) {
  if(!$url) $url = $_SERVER['REQUEST_URI'];
  header('Location: '.$url);
  die();
}

function dump($var) {
  echo "<pre>" . print_r($var, true) . "</pre>";
}

function loginRequired($type = null) {
  if (!$user = isLoggedIn()) redirect("/?p=login");
  if(isset($type) && $type != $user['type']) redirect("/?p=login");
}

function isLoggedIn() {
  if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    return ["id" => $_SESSION['id'], "type" => $_SESSION['type']];
  }
  return false;
}

function valid($value, $type = 1) {
  switch ($type) {
    case 1:
      return preg_match("/^[a-z0-9_]+$/", $value) === 1;
      break;
  }
}
