<?php
    ini_set('mysql.connect_timeout',300);
    ini_set('default_socket_timeout',300);
session_start();
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
	<div class = "navbar navbar-inverse navbar-static-top">	
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
?>
		</div>
	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
    
</body>
</html>