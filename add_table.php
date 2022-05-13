<?php

namespace MyDb;

loginRequired('admin');

// Action
if (isset($_POST['name'])) {
    if (!valid($tablename = strtolower($_POST['name']))) die('Invalid table name');

    $table = new Table($tablename, true);
    $table->display_name = htmlspecialchars($_POST['display_name']);
    $table->save();
    redirect('/?page=edit_table&table=' . $tablename);
}

// Form
?>
<form method="POST">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" placeholder="tablename" required><br />
    <label for="display_name">Display name</label>
    <input type="text" name="display_name" id="display_name" placeholder="Display name" required><br />
    <input type="submit" value="Go">
</form>
