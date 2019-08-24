<?php
include 'config.php';
// error_reporting(E_ALL);
error_reporting(0);
$db = new mysqli('db2018.bui.haw-hamburg.de', 'mui2_14', 'fnibd2018', 'mui2_14');
$db->set_charset('utf8');
print_r ($db->connect_error);
if ($db->connect_errno) {
    die('Sorry - gerade gibt es ein Problem');
    
}
?>