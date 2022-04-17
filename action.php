<?php
require("init.php");

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
