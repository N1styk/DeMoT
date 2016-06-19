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
		
			<li> <a href="index.html">Home</a></li>
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
  if(isset($_POST['submit']))
   {
    //Do all the submission part or storing in DB work and all here
    header('Location: condamnati.php');
   }
// define variables and set to empty values
$nume = $prenume = $relatie = $tip = "";
$data = $durata = $obiecte = $stare = $martor = "";
session_start();

$var1 = $_SESSION['buton'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nume = test_input($_POST["nume"]);
  $prenume = test_input($_POST["prenume"]);
  $relatie = test_input($_POST["relatie"]);
  $tip = test_input($_POST["tip"]);
  $data = test_input($_POST["data"]);
  $durata = test_input($_POST["durata"]);
  $obiecte = test_input($_POST["obiecte"]);
  $stare = test_input($_POST["stare"]);
  $martor = test_input($_POST["martor"]);
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
<h1 class="display-4">Detalii vizitator</h1><br>
<fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Nume</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "nume" placeholder="Numele vizitatorului">
	</div>
 </fieldset>
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Prenume</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "prenume" placeholder="Prenumele vizitatorului">
	</div>
 </fieldset> 
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Natura vizitei</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "tip" placeholder="Natura vizitei">
	</div>
 </fieldset> 
 

 
<fieldset class="form-group">
    <label for="exampleSelect1" class="col-sm-2 form-control-label">Relatie</label>
	<div class="col-sm-10">
    <select class="form-control" name="relatie">
 <option value="ruda">Ruda</option>
    <option value="tutore">Tutore</option>
    <option value="avocat">Avocat</option>
    <option value="prieten">Prieten</option>
    </select>
	</div>
</fieldset>
<br><br>
<h1 class="display-4">Detalii vizita</h1><br>
<fieldset class="form-group">
<label for="exampleSelect1" class="col-sm-2 form-control-label">Data vizitei</label>
<div class="col-sm-10">
<input type="date"  class="form-control" name="data" max="2016-06-06" >
</div>
 </fieldset>
 
 <fieldset class="form-group">
 <label for="exampleSelect1" class="col-sm-2 form-control-label">Durata vizitei</label>
<div class="col-sm-10">
    <input type="number" class="form-control" value="0" name="durata" >
	</div>
 </fieldset>
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Obiecte furnizate</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "obiecte" placeholder="Obiecte furnizate condamnatului">
	</div>
 </fieldset> 
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Stare condamnat</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "stare" placeholder="Starea condamnatului la momentul vizitei">
	</div>
 </fieldset> 
 
 <fieldset class="form-group">
    <label for="exampleInputEmail1" class="col-sm-2 form-control-label">Nume martor</label>
	<div class="col-sm-10">
    <input type="text" class="form-control" name = "martor" placeholder="Numele martorului care a asistat la intalnire">
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

$id = uniqid();
$id2 = uniqid();
$sql = "INSERT INTO vizitator (id_vizitator, nume_vizitator, prenume_vizitator, relatie_condamnat,natura_vizitei) VALUES ('$id','$nume','$prenume','$relatie','$tip')";
$sql2 = "INSERT INTO vizita (id_vizita, id_condamnat, id_vizitator, data_vizitei, durata_vizitei, obiecte_furnizate, stare_sanatate, nume_martor) VALUES
('$id2',  '$var1', '$id', '$data', '$durata', '$obiecte', '$stare', '$martor')";

if($nume != '')
{
IF (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

if($obiecte != '')
{
IF (mysqli_query($conn, $sql2)) { 
    echo "New record created successfully";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
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