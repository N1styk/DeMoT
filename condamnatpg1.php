
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
			$id_util=$row[0];
				}
				
                mysql_close($con1);   
?>
<!DOCTYPE HTML> 
<?php
    ini_set('mysql.connect_timeout',300);
    ini_set('default_socket_timeout',300);
$id="";

?>
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


if($id_util!=1){
		?>
		<div class = "navbar navbar-inverse navbar-static-top">	
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
	<div class = "container">
		<div class="jumbotron">
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
			<h1 class="display-4">NU PUTETI ADAUGA CONDAMNATI</h1> <br>
			<?php
}
else{
	?>
	
		<div class = "navbar navbar-inverse navbar-static-top">	
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
	<div class = "container">
		<div class="jumbotron">
			<h1 class="display-4">Adauga Condamnat</h1> <br>
			<img src="fb.jpg" class="img-thumbnail" style="width:400px;height:400px;">
			<p>
			<form method="post" enctype="multipart/form-data">
				<label class="btn btn-default btn-file">Browse...
					<input type="file" name = "image" style="display: none;">
				</label>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<input type="submit" name="submit" value="Upload" class="btn btn-primary btn-lg" />
			</form>
	
	<?php
	if(isset($_POST['submit'])){
		if(getimagesize($_FILES['image']['tmp_name']) == FALSE){
			echo "Please select an image.";
		}
		else{
			$image= addslashes($_FILES['image']['tmp_name']);
			$image= file_get_contents($image);
			$image= base64_encode($image);
			$con=mysql_connect("localhost","root","");
			mysql_select_db("demotdb",$con);
			$id=uniqid();
			$qry="insert into imagini (id_imagine,imagine) values ('$id','$image')";
			$result=mysql_query($qry,$con);
			if($result){
				echo "<br/>Image uploaded.";
			}
			else{
				echo "<br/>Image not uploaded.";
			}
		}
	}
	$_SESSION['favcolor'] = "$id";
	if(isset($_POST['submit'])){
	header("Location: condamnatpg2.php");
	}
}
?>
		</div>
	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
    
</body>
</html>