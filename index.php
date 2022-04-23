<?php
require 'init.php';

$page = @$_GET['page'];
$pageFile = (valid($page)) ? "./$page.php" : './home.php';
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
  require 'breadcrums.php';
  require $pageFile;
  ?>
</body>

</html>
