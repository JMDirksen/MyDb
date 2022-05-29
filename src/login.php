<?php

namespace MyDb;

use \PDO;
use FormFramework as FF;

if (User::isLoggedIn()) redirect('/');

$userCount = User::count();

// Create first user / Login
if (isset($_POST['login'])) {
    if ($userCount == 0) {
        User::create($_POST['username'], $_POST['password'], 'admin');
    }
    if (User::login($_POST['username'], $_POST['password'])) redirect('/');
    else redirect();
}

echo sprintf('<h1>%s</h1>', ($userCount) ? 'Login' : 'Create user');
$form = new FF\Form();
$form->elements[] = new FF\Input('text', 'username', null, 'username', 'Username', autofocus: true);
$form->elements[] = new FF\Input('password', 'password', null, 'password', 'Password');
$form->elements[] = new FF\Input('submit', 'login', ($userCount) ? 'Login' : 'Create');
echo $form->getHtml(true);
