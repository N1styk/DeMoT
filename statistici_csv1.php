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
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="Numar_vizite.csv"');
$fp = fopen('php://output', 'w');
foreach ($response as $line) {
    fputcsv($fp, $line, ',');
}
fclose($fp);


?> 