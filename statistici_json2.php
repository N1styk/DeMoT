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
$response[$i]['Categoria_pedepsei']  = $row['ora_start']; 
$response[$i]['Durata_vizitelor']=$row[1];
$data['Condamnati'][$i] = $response[$i];
$ceva;
$i=$i+1;
} 


//JSON
header('Content-type:application/json;charset=utf-8');
header('Content-Disposition: attachment; filename="Durata_vizitelor.json"');
$fp = fopen('php://output', 'w');
$json_string = json_encode($data);
fclose($fp);
echo $json_string;

?> 