<?php

namespace MyDb;

use FormFramework\Form;
use FormFramework\Input;
use FormFramework\Select;

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

function pageSelector($page, $pagesize, $recordcount): string
{
    $lastpage = ceil($recordcount / $pagesize);
    $previouspage = min($lastpage, max(1, $page - 1));
    $nextpage = min($lastpage, $page + 1);
    $previousURL = http_build_query(array_merge($_GET, array('p' => $previouspage)));
    $nextURL = http_build_query(array_merge($_GET, array('p' => $nextpage)));
    $form = new Form('GET');
    $form->other = 'style="display:inline;"';
    $form->elements[] = new Input('hidden', 'page', 'view_table');
    $form->elements[] = new Input('hidden', 'table', $_GET['table']);
    $form->elements[] = $select = new Select('s', $_GET['s'] ?? '25', onchange: 'submit()');
    $select->options[] = ['10', '10', 'Records per page'];
    $select->options[] = ['25', '25', 'Records per page'];
    $select->options[] = ['50', '50', 'Records per page'];
    $select->options[] = ['100', '100', 'Records per page'];
    $select->options[] = ['250', '250', 'Records per page'];
    $select->options[] = ['500', '500', 'Records per page'];
    $select->options[] = ['1000', '1000', 'Records per page'];
    return sprintf(
        '<a href="?%s">Previous</a> <a href="?%s">Next</a> Page: %d/%d Records: %d-%d/%d %s',
        $previousURL,                           // Previous page URL
        $nextURL,                               // Next page URL
        $page,                                  // Current page
        $lastpage,                              // Total pages
        ($page - 1) * $pagesize + 1,            // First record
        min($recordcount, $page * $pagesize),   // Last record
        $recordcount,                           // Total records
        $form->getHtml(),
    );
}
