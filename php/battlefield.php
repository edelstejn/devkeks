<?php include('../inc/header.php');

include('../inc/db.php');
<div class="row">
		<div class="col-12 mx-5 my-5">
			<h1 class="display-3 text-center my-5">Battlefeld</h1>
			<p class="lead mx-5">Die Battlefield-Reihe ist ein Franchise von Computerspielen, das bisher aus zwölf Spielen besteht. 
Die Serie zählt zu den erfolgreichsten FPS (First-Person-Shootern) und ist bei seinen Fans beliebt wegen der spannenden Mulitplayer Gefechte die bis zu 64 Spielern fassen sowie der akkuraten Darstellung von Kriegsmaschinerie und Waffen.
Auch wenn die Serie von tieferen philosophischen Ideen befreit ist so bietet sie denn noch kurzweiligen Spaß für zwischendurch mit Freunden.
Die verscheidenen Titel beschäftigen sich mit diversen historischen oder fiktiven Zeitgeschenissen. </p>
		</div>
	</div>


$reiheid = 1503;

$genre = "SELECT * FROM Spiel
INNER JOIN Spiel_has_Genre ON Spiel.idSpiel = Spiel_has_Genre.Spiel_idSpiel
INNER JOIN Genre ON Spiel_has_Genre.Genre_idGenre = Genre.idGenre
WHERE Spielereihe_idSpielereihe LIKE '$reiheid'";

$genredata = $dbm->query($genre);

while ($row = mysqli_fetch_object($genredata))
{
$genrearray[] = $row->Genre;
}

$genrerein = array_unique ($genrearray);
$genreliste = implode(", ", $genrerein);

echo '<p>'.'Die Spiele dieser Reihe gehören den Genre/s ' . '<b>' .$genreliste . '</b>'.' an</p>';

$platt ="Select * FROM Spiel
INNER JOIN Spiel_has_Plattform ON Spiel.idSpiel = Spiel_has_Plattform.Spiel_idSpiel
INNER JOIN Plattform ON Spiel_has_Plattform.Plattform_idPlattform = Plattform.idPlattform
WHERE Spielereihe_idSpielereihe LIKE '$reiheid'";

$plattdata = $dbm->query($platt);

while ($row = mysqli_fetch_object($plattdata))
{
$plattarray[] = $row->Plattform;
}

$plattrein = array_unique ($plattarray);
$plattliste = implode(", ", $plattrein);

/*Spiel auf folgenden Plattformen verfügbar*/
echo 'Die Spiele dieser Reihe sind auf den Plattformen ' . '<b>' .$plattliste . '</b>'; 
echo ' erschienen.<br><br>';

$sql = "SELECT idSpiel, Spielname, Spielzeit, ReleaseDate, Kurzbeschreibung, Cover, Publisher FROM Spiel
INNER JOIN Publisher ON Publisher_idPublisher = idPublisher

WHERE Spielereihe_idSpielereihe LIKE '$reiheid' ORDER BY ReleaseDate ASC
";
$data = $dbm->query($sql);

while($row = mysqli_fetch_object($data))
{
$bildarray[] = $row->Cover;
$bildlink = implode($bildarray);

$spielid = $row->idSpiel;
#echo $spielid . '<br>';

echo '<table class="table table-striped">';
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

echo '<img alt="panorama" src="../bilder/bf4_wallpaper.jpg" style="height:400px; width:2000px" />';	

include('../inc/footer.php'); ?>
