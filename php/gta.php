<?php include('../inc/header.php');

include('../inc/db.php');


echo '<h1>Grand Theft Auto</h1>';

echo' <p>Grand Theft Auto (oft abgekürzt als GTA) ist eine Computerspielserie des schottischen Entwicklerstudios Rockstar North, die Action-, Rennspiel-, Open-World-Spiel- und Third-Person-Shooter-Elemente enthält. 
Der Name ist dem US-amerikanischen Straftatbestand des schweren Kraftfahrzeugdiebstahls entlehnt. 
1997 erschien der erste Teil der Serie.
Mit Verkaufszahlen von ungefähr 150 Millionen Exemplaren ist die Serie eine der erfolgreichsten Computerspieleserien und die meistverkaufte Spieleserie Einem Medienbericht zufolge hat der Open-World-Titel GTAV rund 6 Milliarden US-Dollar (umgerechnet etwa 5,4 Milliarden Euro) eingespielt.
Alle Teile der Reihe weisen eine vergleichbare Handlung auf, bei der meist ein männlicher Protagonist mit einer kriminellen Vorgeschichte in einer amerikanischen Großstadt eine Verbrecherkarriere anstrebt. 
Dazu kann er Aufträge mit unterschiedlicher Komplexität und Schwierigkeit annehmen, deren Erfüllung zu weiteren Kontakten auf höheren Ebenen der Verbrecherhierarchie führt. 
Neben diesen Hauptaufträgen kann der Spieler eine Reihe freiwilliger Zusatzaufgaben übernehmen. 
Diese führen in der Regel nicht die Haupthandlung weiter, sondern belohnen den Spieler mit Geld, Waffen oder ähnlich nützlichen Boni.
<p/>';

$reiheid = 1505;

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


echo '<p>'.'Die Spiele dieser Reihe sind auf den Plattformen ' . '<b>' .$plattliste . '</b>'.' erschienen.<br><br>'.'</p>';


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
echo '<img alt="panorama" src="../bilder/gta_v.jpg" style="height:400px; width:2000px" />';	
include('../inc/footer.php'); ?>