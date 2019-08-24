<?php
include 'config.php';
$dbm = new mysqli( $db_host, $db_user,$db_passwort,$db_name_database);
if (mysqli_connect_errno() != 0)
{
die('Fehler bei Verbindungsaufbau: '.mysqli_connect_error().'
(Fehlercode: '.mysqli_connect_errno().')');
}
else
{
$dbm->set_charset("utf8");
}
?>
