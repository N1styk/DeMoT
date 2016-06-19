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
	<div class="jumbotron">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
	<p>Genereaza statistici dupa numarul minutelor in functie de categoria pedepsei in formatul JSON</p>	
	<form action=" statistici_json2.php" target="_blank">
		<input type="submit" class="btn btn-primary" value="Genereaza!">
	</form>
	<br/>
	<p>Genereaza statistici dupa numarul vizitelor obtinute de fiecare detinut in formatul JSON</p>	
	<form action=" statistici_json1.php" target="_blank">
		<input type="submit" class="btn btn-primary" value="Genereaza"/>
	</form>
	<br/>
	<p>Genereaza statistici dupa numarul minutelor in functie de categoria pedepsei in formatul CSV</p>	
	<form action=" statistici_csv2.php" target="_blank">
		<input type="submit" class="btn btn-primary" value="Genereaza!">
	</form>
	<br/>
	<p>Genereaza statistici dupa numarul vizitelor obtinute de fiecare detinut in formatul CSV</p>	
	<form action=" statistici_csv1.php" target="_blank">
		<input type="submit"  class="btn btn-primary" value="Genereaza"/>
	</form>
	<br/>
	<p>Genereaza statistici dupa numarul minutelor in functie de categoria pedepsei in formatul HTML</p>	
	<form action=" statistici_html2.php" target="_blank">
		<input type="submit" class="btn btn-primary" value="Genereaza!">
	</form>
	<br/>
	<p>Genereaza statistici dupa numarul vizitelor obtinute de fiecare detinut in formatul HTML</p>	
	<form action=" statistici_html1.php" target="_blank">
		<input type="submit" class="btn btn-primary" value="Genereaza!"/>
	</form>
</center>
	</div>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>