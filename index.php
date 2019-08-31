<?php include('inc/header.php'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 mx-5 my-5">
			<h1 class="display-3 text-center my-5">Willkommen bei Boss Games!</h1>
			<p class="lead mx-5">Hier folgen Einträge Videospielreihen der letzten Jahre die uns besonders gut gefallen, einfach anklicken und schauen, auf dieser Seite befinden sich alle Titel die in der Datenbank vorhanden sind. Von Western bis Science-Fiction ist für jeden etwas dabei. Um mehr über einzelene Reihen zu erfahren klicken sie einfach auf den Titel in der oberen Navigationsleiste, viel Spaß! </p>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col mx-5 my-5">
			<?php include('inc/db.php');
# Die variable $suchergebnis soll mit dem Formular befüllt werden, sodass die sql-Abfrage dann nach dem Namen des Spiels in der Datenbank sucht. Cool wärs auch, wenn ne Fehlermeldung wie "Leider führte die Suche zu keinem Ergebnis"
# wenn die Suche keine Treffer ausgibt. Dazu bin ich aber einfach zu dumm.
$suchergebnis = 'batt';

$sql = "SELECT idSpiel, Spielname, Spielzeit, ReleaseDate, Kurzbeschreibung, Publisher, Cover FROM Spiel
INNER JOIN Publisher ON Publisher_idPublisher = idPublisher
WHERE Spielname LIKE '%%'
ORDER BY ReleaseDate DESC
";
$data = $dbm->query($sql);

#TEst

while($row = mysqli_fetch_object($data))
{
$bildarray[] = $row->Cover;
$bildlink = implode($bildarray);

$spielid = $row->idSpiel;
#echo $spielid . '<br>';
echo '<table class="table table-borderless">';
echo '<thead>';
echo '<tr>';
echo '<th>'.$row->Spielname.'</th>';
echo '<th>'."Genres:".'</th>';
echo '<th>'."Beschreibung:".'</th>';
echo '<th>'."Erscheinungsdatum:".'</th>';
echo '<th>'."Publisher:".'</th>';
echo '<th>'."Plattform:".'</th>';
echo '<th>'."Spielzeit (ca.):".'</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
echo '<tr>';
echo '<td>'.'<img src="'. $bildlink . '" style="max-height:100%; max-width:100%"/>'.'</td>';

#Generierung der Abfrage für die einzelnen Genres des Titels
$sqlg = "SELECT Genre FROM Spiel
INNER JOIN Spiel_has_Genre ON Spiel.idSpiel = Spiel_has_Genre.Spiel_idSpiel
INNER JOIN Genre ON Spiel_has_Genre.Genre_idGenre = Genre.idGenre
WHERE idSpiel LIKE '$spielid'";

$genresql = $dbm->query($sqlg);

while ($grow = mysqli_fetch_object($genresql))
{
$genresqlarray[] = $grow->Genre;
}

$genresqlrein = array_unique ($genresqlarray);
$genresqlliste = implode(", ", $genresqlrein);

unset($genresqlarray);

echo '<td>'.$genresqlliste.'</td>';
echo '<td>'.$row->Kurzbeschreibung.'</td>';
echo '<td>'.$row->ReleaseDate.'</td>';
echo '<td>'.$row->Publisher.'</td>';

#Generierung der Abfrage für die einzelnen Plattformen des Titels
$plattsql ="Select Plattform FROM Spiel
INNER JOIN Spiel_has_Plattform ON Spiel.idSpiel = Spiel_has_Plattform.Spiel_idSpiel
INNER JOIN Plattform ON Spiel_has_Plattform.Plattform_idPlattform = Plattform.idPlattform
WHERE idSpiel LIKE '$spielid'";

$plattsqldata = $dbm->query($plattsql);

while ($prow = mysqli_fetch_object($plattsqldata))
{
$plattsqlarray[] = $prow->Plattform;
}

$plattsqlrein = array_unique ($plattsqlarray);
$plattsqlliste = implode(", ", $plattsqlrein);

echo '<td>'.$plattsqlliste.'</td>';
echo '<td>'.$row->Spielzeit." Std.".'</td>';
echo '</tr>';
echo '</tbody>';

unset($plattsqlarray);
unset($bildarray);

echo "</table>";
echo "<br>";

}


$dbm->close();
?>
</div>
</div>
</div>
<?php include('inc/footer.php'); ?>