
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
$ceva = $_SESSION['MM_Username'];
$con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT id_utilizator FROM utilizatori WHERE utilizator like '$ceva'";

                $result1=mysql_query($qry1,$con1);
				$numar=0;


				while($row = mysql_fetch_array($result1))	
                {
			$altceva= $row[0];
				}
				
                mysql_close($con1);  

//echo $altceva;				
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
<!--MENIU-->
<div class = "navbar navbar-inverse navbar-static-top">	

	<!-- Ce va contine bara-->
	<div class = "container">
		
			<!-- Brandul-->
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
<!--MENIU-->

<div class = "container">

	<div class="jumbotron container-fluid">
	<center>
<?php
$var1 = $_SESSION['buton'];
  if(isset($_POST['submit']))
   {
    //Do all the submission part or storing in DB work and all here
    header('Location: condamnati.php');
   }
// define variables and set to empty values
$stare = "";
$durata_minute=$durata_ora=$data=0;

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
				
if($_SESSION['buton']==''){
	$var1=$var2;
}
else{
	$var1 = $_SESSION['buton'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $stare = test_input($_POST["stare"]);
  $durata_minute = test_input($_POST["durata_minute"]);
  $durata_ora = test_input($_POST["durata_ora"]);
  $data = test_input($_POST["data"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<h1 class="display-4">Detalii vizita</h1><br>
<fieldset class="form-group">
<label for="exampleSelect1" class="col-sm-2 form-control-label">Data vizitei</label>
<div class="col-sm-10">
<input type="date"  class="form-control" name="data" min="2016-06-06" max="2025-01-01" >
</div>
 </fieldset>
 
 <fieldset class="form-group">
 <label for="exampleSelect1" class="col-sm-2 form-control-label">Durata vizitei(numarul de ore)</label>
<div class="col-sm-10">
    <input type="number" class="form-control" value="0" name="durata_ora" min="0" max="23" >
	</div>
 </fieldset>

 <fieldset class="form-group">
 <label for="exampleSelect1" class="col-sm-2 form-control-label">Durata vizitei (numarul de minute)</label>
<div class="col-sm-10">
    <input type="number" class="form-control" value="0" name="durata_minute" min="0" max="59" >
	</div>
 </fieldset>
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Stare condamnat</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "stare" placeholder="Obiecte furnizate condamnatului">
	</div>
 </fieldset> 



  <input type="submit"  onclick=" return buttonClickd();" class="btn btn-primary btn-lg" name="submit" value="Submit">  
</form>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demotdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$ore=$durata_ora;
$minute=$durata_minute;
$dbc = @mysqli_connect("localhost", "root", "", "demotdb");

$query = "SELECT curtime( ) as timestamp";
$result = mysqli_query($dbc, $query) or die(mysqli_error());
$row = mysqli_fetch_assoc($result);
$ora_actuala=$row["timestamp"];

 $con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "select max(ora_final) from vizita where data_vizitei='$data'";

                $result1=mysql_query($qry1,$con1);
				$numar=0;


				while($row = mysql_fetch_array($result1))	
                {
					$ora_noua=$row[0];
				}
	
		
if($ora_actuala>$ora_noua){
	
	$ora_insert=$ora_actuala;
	$query2 = "SELECT ADDTIME( curtime( ) , '".$ore.":".$minute.":00' ) as timestamp2";
$result2 = mysqli_query($dbc, $query2) or die(mysqli_error());
$row2 = mysqli_fetch_assoc($result2);
$oraa=$row2["timestamp2"];
}
else {
	
	$ora_insert=$ora_noua;
	$query2 = "SELECT ADDTIME( '".$ora_insert."', '".$ore.":".$minute.":00' ) as timestamp2";
$result2 = mysqli_query($dbc, $query2) or die(mysqli_error());
$row2 = mysqli_fetch_assoc($result2);
$oraa=$row2["timestamp2"];
}

$id = uniqid();
$sql = "INSERT INTO vizita (id_vizita, id_condamnat, id_vizitator, data_vizitei, durata_minute, durata_ore, stare_sanatate, ora_start,ora_final) VALUES
('$id',  '$var1', '$altceva', '$data', '$durata_ora', '$durata_minute', '$stare','$ora_insert','$oraa')";

if($stare !='')
{
if (mysqli_query($conn, $sql)) { 
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();
   
 


?>
</div>
</div>
</center>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>