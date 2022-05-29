<?php

namespace MyDb;

echo '<div class="menu">';
echo '<a href="/">Home</a> ';
if (User::isLoggedIn()) {
    echo '<a href="/?page=options">Options</a> ';
    if (User::isLoggedIn()->type == 'admin') {
        echo '<a href="?page=admin">Admin</a> ';
    }
    echo '<a href="/?page=logout">Logout</a> ';
}
echo '</div>';
