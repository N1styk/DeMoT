
<?php

if (!isset($_SESSION)) {
  session_start();
}


$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){

  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";


function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 

  $isValid = False; 


  if (!empty($UserName)) { 

    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 

    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "access_denied.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
$ceva = $_SESSION['MM_Username'];

$con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT id_utilizator FROM utilizatori WHERE utilizator like '$ceva'";

                $result1=mysql_query($qry1,$con1);

				while($row = mysql_fetch_array($result1))	
                {
			$id_util = $row[0];
				}
				
				
				                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT id_cond FROM vizitator WHERE id_vizitator like '$id_util'";

                $result1=mysql_query($qry1,$con1);

				while($row = mysql_fetch_array($result1))	
                {
			$var2 = $row[0];
				}
				
                mysql_close($con1);   
				
				

?>
<!DOCTYPE HTML>  
<html>
<head>
	<title>Proiect Tehnologii Web</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href = "css/stil2.css" rel= "stylesheet">
	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    border: 1px solid #e7e7e7;
    background-color: #f3f3f3;
}

li {
    float: left;
}

li a {
    display: block;
    color: #666;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #ddd;
}

li a.active {
    color: white;
    background-color: #008CBA;
}
</style>
</head>
<body class="w3-container"> 


<ul>
  <li><a href="index.php">Home</a></li>
  <li><a class="active" href="condamnati.php">Condamnati</a></li>
  <li><a href="condamnatpg1.php">Condamnat nou</a></li>
  <li><a href="statistici.php">Statistici</a></li>
    <li style="float:right"><a href="<?php echo $logoutAction ?>">Logout</a></li>
</ul>

<div class="jumbotron">
        <center>
    <?php
$var1 = $_SESSION['buton'];
if($_SESSION['buton']==''){
	$con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT imagini.imagine, condamnat.categoria_pedepsei, condamnat.nume_condamnat, condamnat.prenume_condamnat
FROM condamnat
inner join imagini on condamnat.id_img=imagini.id_imagine
WHERE condamnat.id_condamnat like '$var2'";

                $result1=mysql_query($qry1,$con1);
				$numar=0;


				while($row = mysql_fetch_array($result1))	
                {
					
			echo '<div class="media">';
  echo '<div class="media-left media-bottom">';
    echo '<a href="#">';
      echo '<img class="img-thumbnail" height="300" width="300" src="data:image;base64,'.$row[0].'">';
    echo '</a>';
  echo '</div>';
  echo '<div class="media-left media-middle">';

    echo '<h2>Numele condamnatului: '.$row[2].'</h2>';
	echo '<h2>Prenumele condamnatului: '.$row[3].'</h2>';
	echo '<h3>Categoria pedepsei: '.$row[1].'</h3>';
    

			
			echo '</div>';
			echo '</div>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
                }
}
else{
                $con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT imagini.imagine, condamnat.categoria_pedepsei, condamnat.nume_condamnat, condamnat.prenume_condamnat
FROM condamnat
inner join imagini on condamnat.id_img=imagini.id_imagine
WHERE condamnat.id_condamnat like '$var1'";

                $result1=mysql_query($qry1,$con1);
				$numar=0;


				while($row = mysql_fetch_array($result1))	
                {
					
			echo '<div class="media">';
  echo '<div class="media-left media-bottom">';
    echo '<a href="#">';
      echo '<img class="img-thumbnail" height="300" width="300" src="data:image;base64,'.$row[0].'">';
    echo '</a>';
  echo '</div>';
  echo '<div class="media-left media-middle">';

    echo '<h2>Numele condamnatului: '.$row[2].'</h2>';
	echo '<h2>Prenumele condamnatului: '.$row[3].'</h2>';
	echo '<h3>Categoria pedepsei: '.$row[1].'</h3>';
    

			
			echo '</div>';
			echo '</div>';
			echo '<br>';

                }
}
                mysql_close($con1);   

?>


	
<style type="text/css">
.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #a9a9a9;border-collapse: collapse;}
.tftable th {font-size:12px;background-color:#b8b8b8;border-width: 1px;padding: 8px;border-style: solid;border-color: #a9a9a9;text-align:left;}
.tftable tr {background-color:#ffffff;}
.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #a9a9a9;}
.tftable tr:hover {background-color:#ffff99;}
</style>
       
<table class="tftable" border="1">

  <tr>
    <th>Nume vizitator</th>
    <th>Prenume vizitator</th>
    <th>Relatia cu condamnatul</th>
    <th>Data vizitei</th>
    <th>Durata vizite(minute)</th>
    <th>Durata vizite(ore)</th>
    <th>Timpul inceperii</th>
    <th>Timpul finalizarii</th>
    <th>Stare condamnat</th>
  </tr>


<?php

if($_SESSION['buton']==''){$con=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con);
				$qry = "SELECT vizitator.nume_vizitator, vizitator.prenume_vizitator, vizitator.relatie_condamnat, vizita.data_vizitei, vizita.durata_minute, vizita.durata_ore, vizita.ora_start, vizita.ora_final, vizita.stare_sanatate
FROM condamnat
INNER JOIN vizita ON condamnat.id_condamnat=vizita.id_condamnat
inner join imagini on condamnat.id_img=imagini.id_imagine
inner join vizitator on vizita.id_vizitator=vizitator.id_vizitator
WHERE condamnat.id_condamnat like '$var2'";

                $result=mysql_query($qry,$con);
				$numar=0;


				while($row = mysql_fetch_array($result))	
                {

					echo'<tr>';
					echo '<td>'.$row[0].'</td>';
					echo '<td>'.$row[1].'</td>';
					echo '<td>'.$row[2].'</td>';
					echo '<td>'.$row[3].'</td>';
					echo '<td>'.$row[4].'</td>';
					echo '<td>'.$row[5].'</td>';
					echo '<td>'.$row[6].'</td>';
					echo '<td>'.$row[7].'</td>';
					echo '<td>'.$row[8].'</td>';
					echo'</tr>';

                }
				echo '</table>';}
else{
                $con=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con);
				$qry = "SELECT vizitator.nume_vizitator, vizitator.prenume_vizitator, vizitator.relatie_condamnat, vizita.data_vizitei, vizita.durata_minute, vizita.durata_ore, vizita.ora_start, vizita.ora_final, vizita.stare_sanatate
FROM condamnat
INNER JOIN vizita ON condamnat.id_condamnat=vizita.id_condamnat
inner join imagini on condamnat.id_img=imagini.id_imagine
inner join vizitator on vizita.id_vizitator=vizitator.id_vizitator
WHERE condamnat.id_condamnat like '$var1'";

                $result=mysql_query($qry,$con);



				while($row = mysql_fetch_array($result))	
                {
				echo'<tr>';
					echo '<td>'.$row[0].'</td>';
					echo '<td>'.$row[1].'</td>';
					echo '<td>'.$row[2].'</td>';
					echo '<td>'.$row[3].'</td>';
					echo '<td>'.$row[4].'</td>';
					echo '<td>'.$row[5].'</td>';
					echo '<td>'.$row[6].'</td>';
					echo '<td>'.$row[7].'</td>';
					echo '<td>'.$row[8].'</td>';
					echo'</tr>';
                }
		echo '</table>';}
                mysql_close($con);   

?>

</div>
</center>
</body>
</html>