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
    die(mysql_error()); // TODO: better error handling
}

while($row=mysql_fetch_array($result)) { 
$response[$i]['Categoria_pedepsei']  = $row['categoria_pedepsei']; 

$response[$i]['Durata_vizitelor']=$row['SUM(durata_vizitei)'];
$data['Condamnati'][$i] = $response[$i];
$i=$i+1;
} 

//JSON
$json_string = json_encode($data);
$file = 'Statistici/Numar_minute.json';
file_put_contents($file, $json_string);

//CSV
$fp = fopen('Statistici/Numar_minute.csv', 'w');

foreach ($response as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}
fclose($fp);

//HTML
ob_start();
echo "<html><body><table>\n\n";
$f = fopen("Statistici/Numar_minute.csv", "r");
while (($line = fgetcsv($f)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table></body></html>";
file_put_contents('Statistici/Numar_minute.html', ob_get_contents());
?> 