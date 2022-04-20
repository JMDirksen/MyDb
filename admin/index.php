<?php
require '../init.php';
loginRequired('admin');

$pages = ['create_table'];
if (in_array(@$_GET['page'], $pages, true)) $page = './' . $_GET['page'] . '.php';
else $page = './home.php';
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
