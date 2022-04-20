<?php
require "init.php";

$pages = ['home', 'login', 'logout', 'view_table', 'edit_record', 'options'];
$pageFile = (in_array($page = @$_GET['page'], $pages, true)) ? "./$page.php" : './home.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>MyDb</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  require 'menu.php';
  require $pageFile;
  ?>
</body>

</html>
