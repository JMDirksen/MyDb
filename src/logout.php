<?php

namespace MyDb;

unset($_SESSION['id']);
unset($_SESSION['type']);
redirect('/?page=login');
