
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
    // Or, you may restrict access to  certain users based on their username. 
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
				$numar=0;


				while($row = mysql_fetch_array($result1))	
                {
			//echo $row[0];
				}
				
                mysql_close($con1);   
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
<!-- Tipul navbar-->
<div class = "navbar navbar-inverse navbar-static-top">	

	<!-- Ce va contine bara-->
	<div class = "container">
	
	
	  
			
			<!-- Brandul-->
			<div class = "navbar-brand"> DeMoT </div> 
	
		
		
		<ul class = "nav navbar-nav navbar-right">
		
			<li class = "active"> <a href="index.php">Home</a></li>
			<li> <a href = "#" class="dropdown-toggle" data-toggle="dropdown">Condamnati <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
				<li><a href="condamnatpg1.php">Adauga Condamnat</a></li>
				<li><a href="condamnati.php">Lista Condamnati</a></li>                                          
				</ul> </li>
			<li><a href="statistici.php">Statistici</a></li>
			<li><a href="<?php echo $logoutAction ?>">Logout</a></li>
			
		</ul>
				
	</div>		
		
</div>
	<div class = "container">
	<div class="jumbotron">
  <center><h1>DeMoT (Detention Monitoring Tool)</h1>
<br>
<br>
<br>
<br>
  <p><small>Detention Monitoring Tool este o aplicatie care ii ajuta pe utilizatori sa gestioneze vizitele dintr-un penitenciar sau dintr-o scoala de corectie. Aplicatia permite adaugarea unui condamnat (numele, prenumele, poza si motivul pedepsei) si adaugarea unei vizite la unul dintre acesti condamnati. Vizitele salveza informatii despre vizitatori (numele, prenumele si gradul de rudenie cu detinutul) cat si alte detalii, cum ar fi starea condamnatului la momentul vizitei, data vizitei, durata acesteia si alte informatii.</small></p>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  </center>
  <h3>Echipa formata din:</h3>
  <ul>
  <li><h2>Stefanescu Cosmin - Andrei, I3B5</h2></li>
  <li><h2>Dediu Vlad - Mihai, I3B5</h2></li>
  <li><h2>Gaman Andrei, I2B7</h2></li>
	</ul>
 </div>
</div>
	
</div>
	
	
 
	
<script src="https://ajax.s.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>
