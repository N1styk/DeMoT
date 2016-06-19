<?php require_once('Connections/User_Information.php'); ?>
<?php
$id = uniqid();

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registration")) {
 
	
	$insertSQL = sprintf("INSERT INTO vizitator (id_vizitator, nume_vizitator, prenume_vizitator, relatie_condamnat,id_cond) VALUES ('$id',%s,%s,%s,%s)",
                       GetSQLValueString($_POST['nume'], "text"),
                       GetSQLValueString($_POST['prenume'], "text"),
                       GetSQLValueString($_POST['relatie'], "text"),
                       GetSQLValueString($_POST['id_cond'], "text"));


  mysql_select_db($database_User_Information, $User_Information);
  $Result1 = mysql_query($insertSQL, $User_Information) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
	
}

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registration")) {
 
	
	$insertSQL = sprintf("INSERT INTO utilizatori (id_utilizator,utilizator, parola) VALUES ('$id', %s,%s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));


  mysql_select_db($database_User_Information, $User_Information);
  $Result1 = mysql_query($insertSQL, $User_Information) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_User_Information, $User_Information);
$query_User_Request = "SELECT * FROM utilizatori";
$User_Request = mysql_query($query_User_Request, $User_Information) or die(mysql_error());
$row_User_Request = mysql_fetch_assoc($User_Request);
$totalRows_User_Request = mysql_num_rows($User_Request);


?>
<!doctype html>
<html>
<head>
    <title>Proiect Tehnologii Web</title>
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">

	<link href = "css/stil2.css" rel= "stylesheet">
</head>

<body>

<body>
	<div class = "jumbotron">
	<center>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
<h1>Register</h1>
<form method="POST" action="<?php echo $editFormAction; ?>" name="registration">
<label>Username:</label><br/>
<input name="username" type="text" style="color:black;" required="required"><br/>
<label>Password:</label><br/>
<input name="password" type="password" style="color:black;" required="required"><br/>
<label>Nume:</label><br/>
<input name="nume" type="text" style="color:black;" required="required"><br/>
<label>Prenume:</label><br/>
<input name="prenume" type="text" style="color:black;" required="required"><br/>
<label>Relatie:</label><br/>
<input name="relatie" type="text" style="color:black;" required="required"><br/>
<label>Id-ul condamnatului:</label><br/>
<input name="id_cond" type="text" style="color:black;" required="required"><br/>
<input type="submit" value="Register">
<input type="hidden" name="MM_insert" value="registration">
</form>
Aveti deja un cont? <a href="login.php">Login!</a>
</center>
</div>
</body>
</html>
<?php
mysql_free_result($User_Request);
?>
