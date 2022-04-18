<?php
require "init.php";

// Login
if (isset($_POST['login'])) {
  $sql = "SELECT id, password, type FROM s_user WHERE username = ?";
  $sth = $dbh->prepare($sql);
  $sth->execute([$_POST['username']]);
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  if (count($result) == 1) {
    $row = $result[0];
    if (password_verify($_POST['password'], $row['password'])) {
      $_SESSION['id'] = $row['id'];
      $_SESSION['type'] = $row['type'];
      redirect("/");
    }
  }
  redirect("/?p=login");
}

loginRequired();

// Edit record
if (isset($_POST['edit_record'])) {
  if (!valid($table = $_POST['table'])) die("Invalid table name");
  $id = $_POST['id'];
  if ($id == "new") $new = true;

  // Build columns and values arrays
  foreach ($_POST as $name => $value) {
    if (substr($name, 0, 7) == "column_") {
      if (!valid($name)) die("Invalid column name");
      $column = substr($name, 7);
      if ($column == "id") continue;
      $columns[] = $column;
      $values[] = $value;
    }
  }

  if ($new) {
    // Build/execute insert query
    $sql = "INSERT INTO $table (" . join(", ", $columns) . ") VALUES (" . join(", ", array_fill(0, count($values), "?")) . ")";
    $sth = $dbh->prepare($sql);
    if (!$sth->execute($values)) die(dump($sth->errorInfo()));
  } else {
    // Build/execute update query
    $sql = "UPDATE $table SET " . join(" = ?, ", $columns) . " = ? WHERE id = ?";
    $sth = $dbh->prepare($sql);
    $params = array_merge($values, [$id]);
    if (!$sth->execute($params)) die(dump($sth->errorInfo()));
  }
  redirect("/?p=view_table&t=$table");
}

// Delete record
if ($_GET['a'] == "d") {
  if (!valid($table = $_GET['t'])) die("Invalid table name");
  $sql = "DELETE FROM $table WHERE id = ?";
  $sth = $dbh->prepare($sql);
  if (!$sth->execute([$_GET['id']])) die(dump($sth->errorInfo()));
  redirect("/?p=view_table&t=$table");
}
