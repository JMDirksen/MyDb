<?php

function redirect($url = "")
{
  header("Location: $url");
  die();
}

function dump($var)
{
  echo "<pre>" . print_r($var, true) . "</pre>";
}

function loginRequired($type = "")
{
  if (!isLoggedIn()) redirect("/?p=login");
}

function isLoggedIn()
{
  if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    return [$_SESSION['id'], $_SESSION['type']];
  }
  return false;
}
