<?php
require "init.php";

$pages = ['home', 'login', 'logout', 'view_table', 'edit_record'];
$page = (isset($_GET['page']) && in_array($_GET['page'], $pages, true)) ? './' . $_GET['page'] . '.php' : './home.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>MyDb</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include $page; ?>
</body>

</html>
