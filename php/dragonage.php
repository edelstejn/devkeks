<?php include('../inc/header.php');

include('../inc/db.php');


echo '<h1>Dragon Age</h1>';

echo'<p>Die herrschenden Magier des Imperiums Tevinter drangen auf der Suche nach einem mächtigen magischen Ort, der Goldenen Stadt, der Wohnstätte des Erbauers, einst mit Hilfe der Blutmagie ins Nichts ein. 
Dort wurden sie zwar fündig, doch machten sie durch den Aufenthalt eine Verwandlung durch und wurden in ihre Heimat Thedas zurückgeschleudert, aus ihnen wurden die Ersten der dunklen Brut. 
Da sie das Tageslicht nicht ertrugen, zogen sie sich unter die Erde zurück. 
Dort stießen sie auf Dumat, einen der sieben alten Götter, den sie befreiten und der anschließend in Gestalt eines Drachen als erster Erzdämon die Führung über die dunkle Brut übernahm. 
Die Unterstützung des Erzdämons verlieh der Brut zusätzliche Stärke. 
Nahezu das gesamte unterirdische Zwergenkönigreich wurde von den Kreaturen überrannt und seither befindet sich das den gesamten Kontinent durchziehende Tunnelnetzwerk, die Tiefen Wege, in ihrer Hand. 
Als sie ihre Herrschaft an die Oberfläche auszudehnen versuchten, konnten sie durch den neugegründeten Orden der Grauen Wächter zurückgeschlagen werden, der den Erzdämon erschlug und die dunkle Brut somit eines Großteils ihrer Stärke beraubte. 
Mit der Zurückschlagung dieser sogenannten ersten Verderbnis zog sich die dunkle Brut wieder in die Tiefen Wege zurück, um nach den anderen alten Göttern zu suchen. 
Jedes Mal, wenn sie einen von ihnen befreien können, übernimmt dieser als neuer Erzdämon die Herrschaft über die dunkle Brut und führt sie in einer neuen Welle der Verderbnis an die Oberfläche. 
Dies ist die Geschichte auf der das Fantasy Rollespiel von den Entwicklern Bioware fußt.  Dragon Age ist eines der besten Rollespielreighen der letzten Jahre und zieht den Spieler mit seiner umfangreichen Historie und Entscheidungfreiheit in den Bann.</p>';


$reiheid = 1508;

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

echo '<img alt="panorama" src="../bilder/dragon_age.jpg" style="height:400px; width:2000px" />';	
include('../inc/footer.php'); ?>