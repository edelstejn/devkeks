<?php include('../inc/header.php');

include('../inc/db.php');


echo '<h1>Dark Souls</h1>';
echo'<p> Im Gegensatz zu den meisten anderen Videospielen besitzt Dark Souls wenig straff erzählte Handlung, sondern fordert den Spieler, die Geschichte der Spielwelt und die Bedeutung seiner Handlungen selbst herauszufinden. 
Kleine Hintergrundgeschichten und Informationen rund um die Spielwelt und ihre Bewohner werden durch Beschreibungen von Gegenständen oder kurze Dialoge mit NPCs erzählt.
Das Spiel lässt bewusst viele Details offen, sodass der Spieler gefordert wird, eigene Schlüsse aus den Handlungsfragmenten zu ziehen. 
Überall in der Spielwelt befinden sich Leuchtfeuer, die nach Aktivierung als Rücksetzpunkte beim Tod des Spielers dienen, die Estus-Flakons wieder auffüllen und es dem Spieler erlauben, von Monstern erhaltene Seelen in Talentpunkte zu investieren und später auch Waffen aufzuwerten oder zu reparieren. 
Bei Nutzung eines Leuchtfeuers werden die meisten Gegner (jedoch keine Bossgegner) wieder lebendig; dies auch, wenn der Spieler durch Tod an ein Leuchtfeuer zurückkehren muss. 
Außerdem verliert der Spieler alle gesammelten, jedoch noch nicht ausgegebenen Seelen und diese bleiben als grüne Wolke an der Position seines Todes zurück.
Er hat anschließend die Möglichkeit, sie wieder aufzusammeln, indem er ohne einen weiteren Tod zu ihnen gelangt. Stirbt er allerdings auf dem Weg dorthin erneut, sind die Seelen verloren. 
Diese Prinzip macht das Spiel anspruchsvoll und fordernd weshalb es bei seinen Fans so beliebt ist.';

$reiheid = 1502;

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

echo '<img alt="panorama" src="../bilder/dark_souls.jpg" style="height:400px; width:2000px" />';	
include('../inc/footer.php'); ?>

