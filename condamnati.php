<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
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

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
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

?>
<!DOCTYPE HTML>  
<html>
<head>
	<title>Proiect Tehnologii Web</title>
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">
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

<center>

<?php
	
	error_reporting(0);
	$con=mysql_connect("localhost","root","");
	mysql_select_db("demotdb",$con);
	$con2=mysql_connect("localhost","root","");
	mysql_select_db("demotdb",$con2);
	$qry = "SELECT t1.id_condamnat, t1.nume_condamnat, t1.prenume_condamnat, t2.imagine FROM condamnat AS t1 INNER JOIN imagini AS t2 ON t1.id_img = t2.id_imagine";
	$result=mysql_query($qry,$con);
	$ceva = $_SESSION['MM_Username'];
$con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT id_utilizator FROM utilizatori WHERE utilizator like '$ceva'";

                $result1=mysql_query($qry1,$con1);


				while($row = mysql_fetch_array($result1))	
                {
			$id_util=$row[0];
				}
				mysql_select_db("demotdb",$con1);
				$qry2 = "SELECT id_cond FROM vizitator WHERE id_vizitator like '$id_util'";

                $result2=mysql_query($qry2,$con1);



				while($row = mysql_fetch_array($result2))	
                {
			$id_cond=$row[0];
				}

	$qry3 = "SELECT t1.id_condamnat, t1.nume_condamnat, t1.prenume_condamnat, t2.imagine FROM condamnat AS t1 INNER JOIN imagini AS t2 ON t1.id_img = t2.id_imagine AND t1.id_condamnat='$id_cond'";
	$result3=mysql_query($qry3,$con2);
	$_SESSION['buton'] = $_POST['radio'];
	if(isset($_POST['submit'])){
    header('Location: vizita_noua.php');
   }
	if(isset($_POST['submit2'])){
    header('Location: vizite.php');
   }
?>

<form method="post" action="">
	<div class="jumbotron container-fluid">
	<h1 class="display-4"> <font color="white">Lista Condamnati</font></h1>
<br>

<?php

if($_SESSION['MM_Username']=='guest' or $_SESSION['MM_Username']=='admin' ){
echo '<table align="left">';
$numar = 0;
	while($row = mysql_fetch_array($result)){
if($numar == 5){
echo '<tr>';
$numar=0;

}
echo ' <td align="center">';
				//echo $numar;
			$numar=$numar+1;
				echo '<img src="data:image;base64,'.$row[3].'" class="img-responsive"  style="width:200px;height:200px;">';
					echo '<div class="caption">';
						echo '<p>'.$row[1].' '.$row[2].'</p>';
							echo '<label class="btn btn-default">';
								echo '<input type="radio" class="button2" data-toggle="button" name="radio" value ="'.$row[0].'"/> Selecteaza';
							echo '</label>';
					echo '</div>';
						echo '<br>';
						echo '<br>';
echo '</td>';
if($numar==5){
echo '</tr>';
}
	} 

echo '</table>';	
	}
	
	
	
	else{
	
		
		
			echo '<div class="row">';
	while($row2 = mysql_fetch_array($result3)){
		echo '<div class="col-xs-2 col-xs-2">';
			echo '<div class="thumbnail">';
			echo '<br>';
				echo '<img src="data:image;base64,'.$row2[3].'" class="img-responsive"  style="width:200px;height:200px;">';	
						echo '<p> <small>'.$row2[1].' '.$row2[2].' </small></p>';
								echo '<input type="radio" data-toggle="button" name="radio" value ="'.$row[0].'"/> Selecteaza';
			echo '</div>';
		echo '</div>';
		//$_SESSION['id_cond'] = $id_cond;
	}
	
	}
?>

<?php if($_SESSION['MM_Username']=='guest'){?>
<input type="submit" name="submit" class="button2" value="Adauga Vizita" disabled/> 
<input type="submit" name="submit2" class="button2" value="Vezi Vizite" disabled/>
<?php } else {?>
<input type="submit" name="submit" class="button2" value="Adauga Vizita" /> 
<input type="submit" name="submit2" class="button2" value="Vezi Vizite" />
<?php } ?>
</form>
</div>
</center>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>