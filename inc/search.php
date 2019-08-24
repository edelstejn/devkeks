<?php
// Verbindung zur Datenbank aufbauen
$db = new mysqli('db2018.bui.haw-hamburg.de', 'mui2_14', 'fnibd2018', 'mui2_14');
$db->set_charset('utf8');
print_r ($db->connect_error);
if ($db->connect_errno) {
    die('Sorry - gerade gibt es ein Problem');
    
}

// Suchbegriff posten
$searchfor = $_POST['searchfor'];

// Dann könntest du noch prüfen, ob überhaupt was eingegeben wurde
// Den Query, der die Spalte durchsucht, sieht so aus:
$query = 'SELECT
                     *
                FROM
                     Spiel
                WHERE
                     `Spielname` LIKE "%'.$searchfor.'%"';
$result = mysql_query($query);

if(mysql_num_rows($result) == 0) {
  echo 'Es wurden keine Einträge gefunden!';
} else {
  echo 'Es wurden '.mysql_num_rows($result).' Einträge gefunden!';
  //Ausgabe
}
?>