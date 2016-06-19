<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demotdb";

session_start();
$id_cond = $_SESSION['id_nou'];
mysql_connect("localhost",$username,$password);
mysql_select_db("demotdb") or die( "Unable to select database");

$data = null;

$result=mysql_query("SELECT ora_start, COUNT(ora_start) FROM vizita where id_condamnat='$id_cond' Group by ora_start");

$i=0;
if($result === FALSE) { 
    die(mysql_error()); 
}

while($row=mysql_fetch_array($result)) { 
$response[$i]['Ora']  = $row['ora_start']; 
$response[$i]['Numarul vizitelor']=$row[1];
$data['Condamnati'][$i] = $response[$i];
$i=$i+1;
} 


//CSV
$fp = fopen('Statistici/Durata_vizitelor.csv', 'w');

foreach ($response as $line) {
    fputcsv($fp, $line, ',');
}
fclose($fp);

//HTML
ob_start();
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="Numar_vizite.html"');
echo "<html><body><table>\n\n";
$f = fopen("Statistici/Durata_vizitelor.csv", "r");
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