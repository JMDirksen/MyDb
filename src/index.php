<?php

namespace MyDb;

$timerStart = microtime(true);

require 'init.php';

$page = @$_GET['page'] ?? '';
$pageFile = (valid($page) && is_file("./$page.php")) ? "./$page.php" : './home.php';
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
<?php echo sprintf('<!-- Load time: %g -->', round(microtime(true) - $timerStart, 3));
