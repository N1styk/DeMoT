
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
		//	echo $row[0];
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
</head>	<body class="w3-container">   
<?php
// define variables and set to empty values
$nume = $prenume = $categorie = "";

$id_img = $_SESSION['favcolor'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nume = test_input($_POST["nume"]);
  $prenume = test_input($_POST["prenume"]);
  $categorie = test_input($_POST["categorie"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="condamnati.php">Condamnati</a></li>
  <li><a class="active" href="condamnatpg1.php">Condamnat nou</a></li>
  <li><a href="statistici.php">Statistici</a></li>
    <li style="float:right"><a href="<?php echo $logoutAction ?>">Logout</a></li>
</ul>

<div class="jumbotron">
<center>
<?php

   if(isset($_POST['submit']))
   {
    //Do all the submission part or storing in DB work and all here
    header('Location: condamnati.php');
   }

                $con=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con);
				$qry = "SELECT imagine from imagini where id_imagine='$id_img'";
                $result=mysql_query($qry,$con);
				while($row = mysql_fetch_array($result))
                {
					echo '<img src="data:image;base64,'.$row[0].'" class="img-thumbnail" style="width:400px;height:400px;">';

					}
             
?>
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
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  


    <label>Nume</label>

    <input type="text" name = "nume" placeholder="Numele condamnatului">

 

    <label>Prenume</label>

    <input type="text" name = "prenume" placeholder="Prenumele condamnatului">

    <label>Categoria pedepsei</label>

    <select  name="categorie">
     <option value="crima">Crima</option>
    <option value="furt">Furt</option>
    <option value="viol">Viol</option>
    <option value="hartuire">Hartuire</option>
    <option value="santaj">Santaj</option>
    <option value="rapire">Rapire</option>
    </select>

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

$id = uniqid();

$sql = "INSERT INTO condamnat (id_condamnat, nume_condamnat, prenume_condamnat, categoria_pedepsei, id_img) VALUES ('$id','$nume','$prenume','$categorie','$id_img')";

if($nume != '')
{
  IF (mysqli_query($conn, $sql)) {
   echo "Great Job! You've entered it correctly!";
   
  } else {
	  echo "ERROR";
  }
}

$conn->close();



 ?>
 
</div>
</div>
</center>
</body>
</html>