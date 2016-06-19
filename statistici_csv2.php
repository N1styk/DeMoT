<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demotdb";


mysql_connect("localhost",$username,$password);
mysql_select_db("demotdb") or die( "Unable to select database");

$data = null;

$result=mysql_query("SELECT condamnat.categoria_pedepsei,SUM(durata_vizitei) FROM vizita INNER JOIN condamnat ON condamnat.id_condamnat=vizita.id_condamnat GROUP BY condamnat.categoria_pedepsei");

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