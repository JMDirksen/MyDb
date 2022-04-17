<?php
  if(isLoggedIn()) redirect("/");
?>
<form method="POST" action="action.php">
    <table>
        <tr><td>Username</td><td><input type="text" name="username" placeholder="username"></td></tr>
        <tr><td>Password</td><td><input type="password" name="password" placeholder="password"></td></tr>
        <tr><td></td><td><input type="submit" name="login" value="Login"></td></tr>
    </table>
</form>
