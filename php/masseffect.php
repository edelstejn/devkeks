<?php include('../inc/header.php');

include('../inc/db.php');


echo '<h1>Mass Effect</h1>';

echo '<p> Die Spiele der Mass-Effect-Reihe werden von dem Entwicklerstudio BioWare entwickelt und sind im Genre der Third-Person Action-Rollenspiele angesiedelt. 
Bisher wurden vier Titel veröffentlich von denen zwei diverse Auszeichnungen und Preise erhielten. 
Die Reihe zeichnet sich durch ihre cineastischen Zwischensequenzen und die tiefgründigen Charaktere und Dialoge aus. 
Der Spieler schlüpft in die Haut des Commander Sheperds, dieser wird durch eine Verknüpfung von Ereignissen vor schwierige Entscheidungen gestellt  die die  Zukunft des Universums verändern. 
Mit Liebe zum Detail schafft BioWare in den Mass Effect -Spielen eine dynamische und lebendige Sci-Fi Welt die durch ihre Kulisse und Bewohner den Spieler in den Bann zieht. 
In spannenden Gefechten kämpft Commander Sheperd um die Zukunft der Menschheit und das Fortbestehen der Welt.</p>';

$reiheid = 1509;

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

echo '<img alt="panorama" src="../bilder/mass_effect 1.jpg" style="height:400px; width:2000px" />';	
include('../inc/footer.php'); ?>


