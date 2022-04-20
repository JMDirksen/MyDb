<?php
require 'init.php';
unset($_SESSION['id']);
unset($_SESSION['type']);
redirect('/?page=login');
