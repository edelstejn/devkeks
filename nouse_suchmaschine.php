<? 

// deine daten 

$server= "localhost";
$user= "mui2_14";
$passwort= "fnibd2018";
$datenbank= "mui2_14";
$tabelle= "Spiel";
// Datenbank auswählen 
$db = mysqli_connect($server, $user, $passwort, $datenbank);
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}

// Suchen 
$suche = "%$suche%";
$result=MYSQL_QUERY(" SELECT * FROM $tabelle WHERE RELEASENAME='$suche'");

// Ergebnisse zählen 

$num_rows = mysql_num_rows($result); 
echo "Es wurden $num_rows Ergebnisse gefunden!"; 

// kopf der seite ausspucken 

echo "<table>"; 
echo "<tr>"; 
echo "<th>"; 
echo "releasedate"; 
echo "</th> <th>"; 
echo "rleasename"; 
echo "</th> <th>"; 
echo "releasecrew"; 
echo "</th> <th>"; 
echo "disks"; 
echo "</th> </tr>"; 

// gefundene daten ausspucken 

while($myrow=mysql_fetch_row($result)) 
{ 
echo "<tr>"; 
echo "<td>"; 
echo "$myrow[0]"; 
echo "</td>"; 
echo "<td>"; 
echo "$myrow[1]"; 
echo "</td>"; 
echo "<td>"; 
echo "$myrow[2]"; 
echo "</td>"; 
echo "<td>"; 
echo "$myrow[3]"; 
echo "</td>"; 
echo "</tr>"; 
} 

// bottom der seite 
echo "Dein Suchwort ist $suche";
echo "</table>"; 
?>