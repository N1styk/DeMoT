
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
<h1>Detalii vizita</h1><br>
<br><br>
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=number], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=date], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #008CBA;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  



<label >Data vizitei</label>

<input type="date"  name="data" min="2016-06-06" max="2025-01-01" >

 <label>Durata vizitei(numarul de ore)</label>

    <input type="number"value="0" name="durata_ora" min="0" max="23" >

<label>Durata vizitei (numarul de minute)</label>

<input type="number"value="0" name="durata_minute" min="0" max="59" >


  <label >Obiecte furnizate</label>

    <input type="text"name = "stare" placeholder="Obiecte furnizate condamnatului">

<br/>
<br/>
<br/>
<br/>

  <input type="submit"  onclick=" return buttonClickd();" name="submit" value="Submit">  
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
</center>

</body>
</html>