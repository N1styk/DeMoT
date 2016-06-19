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
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="Durata_vizitelor.csv"');
$fp = fopen('php://output', 'w');
foreach ($response as $line) {
    fputcsv($fp, $line, ',');
}
fclose($fp);

?> 