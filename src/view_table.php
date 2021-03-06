<?php

namespace MyDb;

User::checkLogin();

if (!valid($tableName = @$_GET['table'])) die('Invalid table name');

// Delete record
if (isset($_GET['delete'])) {
    (new Record($tableName, $_GET['delete']))->delete();
    redirect('/?page=view_table&table=' . $tableName);
}

$table = new Table($tableName);
$display_name = $table->display_name;

// Columns
$columnHtml = '';
foreach ($table->columns as $column) {
    $columnHtml .= sprintf('<th>%s</th>', htmlspecialchars($column->display_name));
}

// Data
$page = $_GET['p'] ?? 1;
$pagesize = $_GET['s'] ?? 25;
$recordset = new Recordset($table->name, page: $page, pagesize: $pagesize);
$recordcount = $recordset->recordcount;
$dataHtml = '';
foreach ($recordset->records as $record) {
    $dataHtml .= '<tr><td>' .
        sprintf('<a href="?page=edit_record&table=%s&id=%d">E</a> ', $tableName, $record->id) .
        sprintf(
            '<a href="?page=view_table&table=%s&delete=%s" onClick="return confirm(\'Delete record %s?\')">X</a>',
            $tableName,
            $record->id,
            $record->id,
        ) .
        '</td>';
    foreach ($record->columns as $column) {
        $value = htmlspecialchars($record->data[$column->name]);
        // Checkbox value
        if ($column->type == 'checkbox')
            $value = ($value == '1') ?
                '<input type="checkbox" checked onclick="return false">' :
                '<input type="checkbox" onclick="return false">';
        $dataHtml .= sprintf('<td>%s</td>', $value);
    }
    $dataHtml .= '</tr>' . PHP_EOL;
}
?>

<h1><?php echo htmlspecialchars($display_name); ?></h1>
<a href="?page=add_record&table=<?php echo $tableName; ?>">Add</a>
<div><?php echo pageSelector($page, $pagesize, $recordcount); ?></div>
<table>
    <tr>
        <th></th><?php echo $columnHtml; ?>
    </tr>
    <?php echo $dataHtml; ?>
</table>
