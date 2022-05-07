<?php

function redirect($url = null) {
  if (!$url) $url = $_SERVER['REQUEST_URI'];
  header('Location: ' . $url);
  die();
}

function dump($var) {
  echo '<pre>' . print_r($var, true) . '</pre>';
}

function loginRequired($type = null) {
  if (!$user = isLoggedIn()) redirect('/?page=login');
  if (isset($type) && $type != $user['type']) redirect('/?page=login');
}

function isLoggedIn() {
  if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    return ['id' => $_SESSION['id'], 'type' => $_SESSION['type']];
  }
  return false;
}

function valid(string $value, int $type = 1) {
  switch ($type) {
    case 1:
      return preg_match('/^[a-z][a-z0-9_]*$/', $value) === 1;
      break;
  }
}

function addBackticks(string $string): string {
  $elements = array_map('trim', explode(',', $string));
  return '`' . implode('`, `', $elements) . '`';
}
