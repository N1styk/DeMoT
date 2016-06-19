<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demotdb";


mysql_connect("localhost",$username,$password);
mysql_select_db("demotdb") or die( "Unable to select database");

$data = null;

$result=mysql_query("SELECT * FROM Condamnat");

$i=0;
if($result === FALSE) { 
    die(mysql_error()); 
}

while($row=mysql_fetch_array($result)) { 
$response[$i]['Nume_condamnat']  = $row['nume_condamnat']; 

	$id_condamnat=$row['id_condamnat'];
	$result_vizite=mysql_query("SELECT * FROM Vizita WHERE Vizita.id_condamnat='$id_condamnat'") or die(mysql_error());
	$j=0;
	while($row_vizite=mysql_fetch_array($result_vizite)){
		$j=$j+1;}

$response[$i]['Numar_vizite']=$j;
$data['Condamnati'][$i] = $response[$i];
$i=$i+1;
} 

//CSV
$fp = fopen('Statistici/Numar_vizite.csv', 'w');

foreach ($response as $line) {
    fputcsv($fp, $line, ',');
}
fclose($fp);

//HTML
ob_start();
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="Numar_vizite.html"');
echo "<html><body><table>\n\n";
$f = fopen("Statistici/Numar_vizite.csv", "r");
$fp = fopen('php://output', 'w');
while (($line = fgetcsv($f)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table></body></html>";


?> 