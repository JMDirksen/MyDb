<?php
$_SESSION['breadcrums'] = ['home' => '/'];
if ($page) $_SESSION['breadcrums'][$page] = $_SERVER['REQUEST_URI'];
foreach ($_SESSION['breadcrums'] as $crum => $url) {
  $crumString[] = "<a href=\"$url\">$crum</a>";
}
$crumString = join('&rarr;', $crumString);
echo '<div class="breadcrums">' . $crumString . '</div>';
