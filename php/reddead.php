<?php
include('../inc/header.php');
include('../txt/Red Dead Redemption.html');
?>
<?php
include('../inc/db.php');
$reiheid = 1500;
/*Spiel folgendem Genre zugeordnet*/
/*Select genre value from DB*/
$genre = "SELECT * FROM Spiel INNER JOIN Spiel_has_Genre ON Spiel.idSpiel = Spiel_has_Genre.Spiel_idSpiel INNER JOIN Genre ON Spiel_has_Genre.Genre_idGenre = Genre.idGenre WHERE Spielereihe_idSpielereihe LIKE '$reiheid'";
$genredata = $dbm->query($genre);
while ($row = mysqli_fetch_object($genredata)){
	$genrearray[] = $row->Genre;
}
$genrerein = array_unique ($genrearray);
$genreliste = implode(", ", $genrerein);
echo '<p class="mx-5">'.'Die Spiele dieser Reihe gehören den folgenden Genre/s an:'.'<br><b class="text-danger">'.$genreliste .'</b></p>';
?>
<?php
/*Spiel auf folgenden Plattformen verfügbar*/
/*Select plattform value from DB*/ 
$platt ="SELECT * FROM Spiel INNER JOIN Spiel_has_Plattform ON Spiel.idSpiel = Spiel_has_Plattform.Spiel_idSpiel INNER JOIN Plattform ON Spiel_has_Plattform.Plattform_idPlattform = Plattform.idPlattform WHERE Spielereihe_idSpielereihe LIKE '$reiheid'";
$plattdata = $dbm->query($platt);
while ($row = mysqli_fetch_object($plattdata)){
	$plattarray[] = $row->Plattform;
}
$plattrein = array_unique ($plattarray);
$plattliste = implode(", ", $plattrein); /*Ausnahme Funktion einbauen: Wert1, Wert2 "und" Wert3*/
echo '<p class="mx-5">'.'Die Spiele dieser Reihe sind auf den folgenden Plattformen erschienen:'.'<br><b class="text-danger">' .$plattliste . '</b></p></div></div>';
?>
<div class="row container-fluid justify-content-center">
<?php
/*Ausgewählte Werte der Elemente des DB Eintrags ausdrucken*/
$sql = "SELECT idSpiel, Spielname, Spielzeit, ReleaseDate, Kurzbeschreibung, Cover, Publisher FROM Spiel INNER JOIN Publisher ON Publisher_idPublisher = idPublisher WHERE Spielereihe_idSpielereihe LIKE '$reiheid' ORDER BY ReleaseDate ASC";
$data = $dbm->query($sql);
while($row = mysqli_fetch_object($data)){
	$bildarray[] = $row->Cover;
	$bildlink = implode($bildarray);
	$spielid = $row->idSpiel;
	#echo $spielid . '<br>';
	#Generierung der Abfrage für die einzelnen Genres des Titels
	$sqlg = "SELECT Genre FROM Spiel INNER JOIN Spiel_has_Genre ON Spiel.idSpiel = Spiel_has_Genre.Spiel_idSpiel INNER JOIN Genre ON Spiel_has_Genre.Genre_idGenre = Genre.idGenre WHERE idSpiel LIKE '$spielid'";
	$genresql = $dbm->query($sqlg);
	while ($grow = mysqli_fetch_object($genresql)){
		$genresqlarray[] = $grow->Genre;
	}
	$genresqlrein = array_unique ($genresqlarray);
	$genresqlliste = implode(", ", $genresqlrein);
	unset($genresqlarray);
	#Generierung der Abfrage für die einzelnen Plattformen des Titels
	$plattsql ="SELECT Plattform FROM Spiel INNER JOIN Spiel_has_Plattform ON Spiel.idSpiel = Spiel_has_Plattform.Spiel_idSpiel INNER JOIN Plattform ON Spiel_has_Plattform.Plattform_idPlattform = Plattform.idPlattform WHERE idSpiel LIKE '$spielid'";
	$plattsqldata = $dbm->query($plattsql);
	while ($prow = mysqli_fetch_object($plattsqldata)){
		$plattsqlarray[] = $prow->Plattform;
	}
	$plattsqlrein = array_unique ($plattsqlarray);
	$plattsqlliste = implode(", ", $plattsqlrein);
	unset($plattsqlarray);
	unset($bildarray);
	echo '<div class="col-sm-3 mx-5 mb-5">';
	echo '<div class="card" style="width: 30rem;">';
	echo '<img src="'. $bildlink .'" class="card-img-top" alt="...">';
	echo '<div class="card-body">';
	echo '<h5 class="card-title">'.$row->Spielname.'</h5>';
	echo '<p class="card-text">'.'<b>Erschienen am: </b>'.$row->ReleaseDate.'</p>';
	echo '<p class="card-text">'.'<b>Publisher: </b>'.$row->Publisher.'</p>';
	echo '<p class="card-text">'.'<b>Genre: </b>'.$genresqlliste.'</p>';
	echo '<p class="card-text">'.'<b>Plattformen: </b>'.$plattsqlliste.'</p>';
	echo '<p class="card-text">'.'<b>Spielzeit ca.: </b>'.$row->Spielzeit.' Std.'.'</p>';
	echo '<p class="card-text">'.$row->Kurzbeschreibung.'</p>';
	echo '<a href="#" class="btn btn-primary">'.'Buy on Steam!'.'</a>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
echo '<img alt="panorama" src="../bilder/rdrimg.jpg" style="height:400px; width:2000px"/>';
?>
</div>
<?php include('../inc/footer.php');
?>



