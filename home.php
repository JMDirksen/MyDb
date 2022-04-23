<?php
  loginRequired();

  $sth = $dbh->prepare('SELECT * FROM `s_table` WHERE NOT `hidden`');
  $sth->execute();
  $tables = $sth->fetchAll(PDO::FETCH_ASSOC);
  $tableList = '';
  foreach($tables as $table) {
    $tableList .= "<li><a href=\"?page=view_table&table=$table[name]\">$table[display_name]</a></li>\n";
  }
?>
<ul>
  <?php echo $tableList; ?>
</ul>
