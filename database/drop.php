<?php
require_once('index.php');

$db = new Database();

if ($db->is_error()) {
    echo "Error: ".$db->error_msg();
}
else {
    if ($db->drop()) {
        echo "Database droped<br>";
    }            
    else echo $db->error_msg();
}
