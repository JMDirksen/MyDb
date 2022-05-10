<?php
echo '<div class="menu">';
echo '<a href="/">Home</a> ';
if (isLoggedIn()) {
    echo '<a href="/?page=options">Options</a> ';
    if (isLoggedIn()['type'] == 'admin') {
        echo '<a href="?page=admin">Admin</a> ';
    }
    echo '<a href="/?page=logout">Logout</a> ';
}
echo '</div>';
