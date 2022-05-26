<?php

namespace MyDb;

use \PDO;

if (isLoggedIn()) redirect('/');

// User count
$sth = $dbh->prepare('SELECT `id` FROM `s_user`');
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
$userCount = count($result);
$heading = ($userCount) ? 'Login' : 'Create user';
$button = ($userCount) ? 'Login' : 'Create';

// Login
if (isset($_POST['login']) && $userCount > 0) {
    $sth = $dbh->prepare(
        'SELECT `id`, `password`, `type` FROM `s_user` WHERE `username` = ?'
    );
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
} elseif (isset($_POST['login']) && $userCount == 0) {
    // Create first user
    $sth = $dbh->prepare(
        'INSERT INTO `s_user` (`username`, `password`, `type`) VALUES (?, ?, ?)'
    );
    if ($sth->execute([
        $_POST['username'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        'admin'
    ])) {
        $_SESSION['id'] = $dbh->lastInsertId();
        $_SESSION['type'] = 'admin';
        redirect('/');
    }
    redirect();
}

?>
<h1><?php echo $heading; ?></h1>
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
            <td><input type="submit" name="login" value="<?php echo $button; ?>"></td>
        </tr>
    </table>
</form>
