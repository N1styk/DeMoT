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
<center>
<br>
<br>
<br>
<br>

<?php
	error_reporting(0);
	session_start();
	$con=mysql_connect("localhost","root","");
	mysql_select_db("demotdb",$con);
	$qry = "SELECT t1.id_condamnat, t1.nume_condamnat, t1.prenume_condamnat, t2.imagine FROM condamnat AS t1 INNER JOIN imagini AS t2 ON t1.id_img = t2.id_imagine";
	$result=mysql_query($qry,$con);
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
	mysql_close($con);   
	echo '</div>';
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