<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demotdb";

session_start();
$ceva = $_SESSION['id_nou'];
mysql_connect("localhost",$username,$password);
mysql_select_db("demotdb") or die( "Unable to select database");

$data = null;

$result=mysql_query("SELECT ora_start, COUNT(ora_start) FROM vizita where id_condamnat='$ceva' Group by ora_start");

$i=0;
if($result === FALSE) { 
    die(mysql_error()); 
}

while($row=mysql_fetch_array($result)) { 
$response[$i]['Categoria_pedepsei']  = $row['categoria_pedepsei']; 

$response[$i]['Durata_vizitelor']=$row['SUM(durata_vizitei)'];
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