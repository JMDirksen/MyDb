<?php

namespace MyDb;

use \PDO;

loginRequired();

$sth = $dbh->prepare('SELECT * FROM `s_table` WHERE NOT `hidden`');
$sth->execute();
$tables = $sth->fetchAll(PDO::FETCH_ASSOC);
$tableList = '';
foreach ($tables as $table) {
    $tableList .= sprintf(
        '<li><a href="?page=view_table&table=%s">%s</a></li>',
        $table['name'],
        htmlspecialchars($table['display_name']),
    );
}
?>
<ul>
    <?php echo $tableList; ?>
</ul>
