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
	<link href = "css/bootstrap.min.css" rel= "stylesheet">
	<link href = "css/styles.css" rel= "stylesheet">
	<link href = "css/stil2.css" rel= "stylesheet">
</head>
<body>  
	<div class = "navbar navbar-inverse navbar-fixed-top">	
		<div class = "container">
			<div class = "navbar-brand"> DeMoT </div> 
				<ul class = "nav navbar-nav navbar-right">
					<li> <a href="index.php">Home</a></li>
					<li> <a href = "#" class="dropdown-toggle" data-toggle="dropdown">Condamnati <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="condamnatpg1.php">Adauga Condamnat</a></li>
						<li><a href="condamnati.php">Lista Condamnati</a></li>                                          
					</ul> </li>
					<li><a href="statistici.php">Statistici</a></li>
				</ul>
		</div>	
	</div>	
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
	echo '<div class="row">';
	while($row = mysql_fetch_array($result)){
		echo '<div class="col-xs-2 col-xs-2">';
			echo '<div class="thumbnail">';
			echo '<br>';
				echo '<img src="data:image;base64,'.$row[3].'" class="img-responsive"  style="width:200px;height:200px;">';
					echo '<div class="caption">';
						echo '<p> <small>'.$row[1].' '.$row[2].' </small></p>';
							echo '<label class="btn btn-default">';
								echo '<input type="radio" class="btn btn-success" data-toggle="button" name="radio" value ="'.$row[0].'"/> Selecteaza';
							echo '</label>';
					echo '</div>';
			echo '</div>';
		echo '</div>';
	} 
	echo '</div>';
	
	}
	else{
	
		
		
			echo '<div class="row">';
	while($row2 = mysql_fetch_array($result3)){
		echo '<div class="col-xs-2 col-xs-2">';
			echo '<div class="thumbnail">';
			echo '<br>';
				echo '<img src="data:image;base64,'.$row2[3].'" class="img-responsive"  style="width:200px;height:200px;">';
					echo '<div class="caption">';
						echo '<p> <small>'.$row2[1].' '.$row2[2].' </small></p>';
							echo '<label class="btn btn-default">';
								echo '<input type="radio" class="btn btn-success" data-toggle="button" name="radio" value ="'.$row[0].'"/> Selecteaza';
							echo '</label>';
					echo '</div>';
			echo '</div>';
		echo '</div>';
		//$_SESSION['id_cond'] = $id_cond;
	}
	
	}
?>

<input type="submit" name="submit" class="btn btn-primary btn-lg" value="Adauga Vizita"/> 
<input type="submit" name="submit2" class="btn btn-primary btn-lg" value="Vezi Vizite"/>

</form>
</div>
</center>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>