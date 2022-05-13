<?php

namespace MyDb;

if (isLoggedIn()) redirect('/');

// Login
elseif (isset($_POST['login'])) {
    $sth = $dbh->prepare('SELECT `id`, `password`, `type` FROM `s_user` WHERE `username` = ?');
    $sth->execute([$_POST['username']]);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 1) {
        $row = $result[0];
        if (password_verify($_POST['password'], $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['type'] = $row['type'];
            redirect('/');
        }
    }
    redirect();
}

?>
<form method="POST">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" placeholder="username"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" placeholder="password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="login" value="Login"></td>
        </tr>
    </table>
</form>
