<?php
require 'inc/db2.php';
echo "<h1>Suchergebnisse</h1>";
$erg = $db->query("SELECT Spielname, Kurzbeschreibung FROM Spiel")
		or die($db->error);
print_r($erg);
if ($erg->num_rows) {
	echo "<p>Daten vorhanden: Anzahl ";
	echo $erg->num_rows.'<br>';
}
while ($zeile = $erg->fetch_assoc()) {
	echo '<br>' . $zeile['Spielname'] .'<br>'. $zeile['Kurzbeschreibung'].'<br>';
}
?>