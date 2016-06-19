
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
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">
	<link href = "css/bootstrap.min.css" rel= "stylesheet">
	<link href = "css/styles.css" rel= "stylesheet">
	<link href = "css/stil2.css" rel= "stylesheet">
</head>
<body>  
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
<div class = "container">
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

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Nume</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "nume" placeholder="Numele condamnatului">
	</div>
 </fieldset>
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Prenume</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "prenume" placeholder="Prenumele condamnatului">
	</div>
 </fieldset>
  <fieldset class="form-group">
    <label for="exampleSelect1" class="col-sm-2 form-control-label">Categoria pedepsei</label>
	<div class="col-sm-10">
    <select class="form-control" name="categorie">
     <option value="crima">Crima</option>
    <option value="furt">Furt</option>
    <option value="viol">Viol</option>
    <option value="hartuire">Hartuire</option>
    <option value="santaj">Santaj</option>
    <option value="rapire">Rapire</option>
    </select>
	</div>
  </fieldset>
  <input type="submit"  onclick=" return buttonClickd();" name="submit"  class="btn btn-primary btn-lg" value="Submit">  
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>