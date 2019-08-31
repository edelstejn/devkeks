<?php include('../inc/header.php');

include('../inc/db.php');

<div class="row">
		<div class="col-12 mx-5 my-5">
			<h1 class="display-3 text-center my-5">Assassins Creed</h1>
			<p class="lead mx-5">Die Assassin’s-Creed-Reihe ist eine Computerspielserie des französischen Publishers Ubisoft aus dem Genre Action-Adventure.
Sie besteht seit 2007 mit der Veröffentlichung des gleichnamigen Spiels und umfasst elf Hauptspiele und zahlreiche Ableger. 
Die meisten Teile der Serie wurden vom kanadischen Studio Ubisoft Montreal entwickelt.
Alle Teile der Reihe sind Open-World-Spiele. Der Großteil der Handlung jedes der Spiele findet in der Vergangenheit in einer bestimmten Region und Epoche statt, wobei auf reale historische Ereignisse eingegangen wird. 
So trifft der Spieler im Laufe der Missionen auf zahlreiche bekannte Persönlichkeiten der jeweiligen Zeit wie Richard Löwenherz, Saladin, Leonardo da Vinci, Alexander VI. und viele weitere. 
Auch andere Ereignisse der Zeit werden integriert, so löst der Spieler unbeabsichtigt die Erdbeben in Haiti (1751) und das Erdbeben von Lissabon 1755 aus. 
Der Handlungsstrang, der sich durch die Serie zieht, ist der seit Jahrhunderten andauernde Konflikt zwischen Assassinen und Templern, wobei der Spieler zumeist einen Assassinen verkörpert. 
Die Reihe erzielt durch ihre oftmals realistische Einbindung von fiktiven Elementen in den zeithistorischen Kontext eine gelungene Immersion. 
Das Spiel lässt sich aus der Third-person betrachten und bietet dem Spieler viel Bewegungsspielraum, so lässt sich fast jedes Gebäude erklimmen.Hier folgen Einträge Videospielreihen der letzten Jahre die uns besonders gut gefallen, einfach anklicken und schauen, auf dieser Seite befinden sich alle Titel die in der Datenbank vorhanden sind. Von Western bis Science-Fiction ist für jeden etwas dabei. Um mehr über einzelene Reihen zu erfahren klicken sie einfach auf den Titel in der oberen Navigationsleiste, viel Spaß! </p>
		</div>
	</div>
	
	<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src=https://www.youtube.com/watch?v=kaRoCnxuDLw"allowfullscreen> </iframe>
</div>
  
$reiheid = 1504;

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
echo '<img alt="panorama" src="../bilder/ac_banner.jpg" style="height:400px; width:2000px" />';	

include('../inc/footer.php'); ?>
