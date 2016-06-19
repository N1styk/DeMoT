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