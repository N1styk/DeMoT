
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

// *** Restrict Access Page: Grant or deny access to this page
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
<!DOCTYPE html>
<html>

<head>
    <title>Proiect Tehnologii Web</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link href = "css/stil2.css" rel= "stylesheet">

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
  <li><a class="active" href="index.php">Home</a></li>
  <li><a href="condamnati.php">Condamnati</a></li>
  <li><a href="condamnatpg1.php">Condamnat nou</a></li>
  <li><a href="statistici.php">Statistici</a></li>
  <li style="float:right"><a href="<?php echo $logoutAction ?>">Logout</a></li>

</ul>




<center>
<div class="jumbotron">
<div id="box-container">
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
  <h1>Stefanescu Cosmin - Andrei, I3B5</h1>
  <h1>Dediu Vlad - Mihai, I3B5</h1>
  <h1>Gaman Andrei, I2B7</h1>
 
 </div>
 </div>


</center>
</body>
</html>

