<?php
require "../init.php";
loginRequired();

$pages = ['createtable'];
$page = (isset($_GET['p']) && in_array($_GET['p'], $pages, true)) ? "./$_GET[p].php" : "./home.php";
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
