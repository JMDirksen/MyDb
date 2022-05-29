<?php

namespace MyDb;

function redirect($url = null)
{
    if (!$url) $url = $_SERVER['REQUEST_URI'];
    header('Location: ' . $url);
    die();
}

function dump($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}

function valid(string $value, int $type = 1)
{
    switch ($type) {
        case 1:
            return preg_match('/^[a-z][a-z0-9_]*$/', $value) === 1;
            break;
    }
}

function addBackticks(string $string): string
{
    $elements = array_map('trim', explode(',', $string));
    return '`' . implode('`, `', $elements) . '`';
}
