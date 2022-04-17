<?php
require("init.php");

$pages = ['home', 'login', 'logout'];
$page = (isset($_GET['p']) && in_array($_GET['p'], $pages, true)) ? "./$_GET[p].php" : "./home.php";
?>
<!DOCTYPE html>
<html>

<head>
  <title>MyDb</title>
</head>

<body>
  <?php include($page); ?>
</body>

</html>
