<!DOCTYPE HTML>  
<html>
<head>
    <title>Proiect Tehnologii Web</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>	
<body>  



<meta name="viewport" content="width = device-width, initial-scale = 1.0">
	<link href = "css/bootstrap.min.css" rel= "stylesheet">
	<link href = "css/styles.css" rel= "stylesheet">
	<link href = "css/stil2.css" rel= "stylesheet">
    </head>

<!-- Tipul navbar-->
<div class = "navbar navbar-inverse navbar-fixed-top">	

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
	<br>
	<br>
	<br>
	<br>

        
    <?php
session_start();
$var1 = $_SESSION['buton'];
                $con1=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con1);
				$qry1 = "SELECT imagini.imagine, condamnat.categoria_pedepsei, condamnat.nume_condamnat, condamnat.prenume_condamnat
FROM condamnat
inner join imagini on condamnat.id_img=imagini.id_imagine
WHERE condamnat.id_condamnat like '$var1'";

                $result1=mysql_query($qry1,$con1);
				$numar=0;


				while($row = mysql_fetch_array($result1))	
                {
					
			echo '<div class="media">';
  echo '<div class="media-left media-bottom">';
    echo '<a href="#">';
      echo '<img class="img-thumbnail" height="300" width="300" src="data:image;base64,'.$row[0].'">';
    echo '</a>';
  echo '</div>';
  echo '<div class="media-left media-middle">';

    echo '<h2>Numele condamnatului: '.$row[2].'</h2>';
	echo '<h2>Prenumele condamnatului: '.$row[3].'</h2>';
	echo '<h3>Categoria pedepsei: '.$row[1].'</h3>';
    

			
			echo '</div>';
			echo '</div>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
                }

                mysql_close($con1);   

?>


	
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;margin:0px auto;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-4996{font-size:14px;text-align:right;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
th.tg-sort-header::-moz-selection { background:transparent; }th.tg-sort-header::selection      { background:transparent; }th.tg-sort-header { cursor:pointer; }table th.tg-sort-header:after {  content:'';  float:right;  margin-top:7px;  border-width:0 4px 4px;  border-style:solid;  border-color:#404040 transparent;  visibility:hidden;  }table th.tg-sort-header:hover:after {  visibility:visible;  }table th.tg-sort-desc:after,table th.tg-sort-asc:after,table th.tg-sort-asc:hover:after {  visibility:visible;  opacity:0.4;  }table th.tg-sort-desc:after {  border-bottom:none;  border-width:4px 4px 0;  }@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}</style>

  <div class="table-responsive">          
	<table class="table table-striped table-hover">
    <thead>
  <tr>
    <th class="tg-031e">Nume vizitator</th>
    <th class="tg-yw4l">Prenume vizitator</th>
    <th class="tg-yw4l">Relatia cu condamnatul</th>
    <th class="tg-yw4l">Natura vizitei</th>
    <th class="tg-yw4l">Data vizite</th>
    <th class="tg-yw4l">Durata vizitei</th>
    <th class="tg-yw4l">Obiecte furnizate</th>
    <th class="tg-yw4l">Stare sanatate</th>
    <th class="tg-yw4l">Nume martor</th>
  </tr>
  </thead>

<?php

                $con=mysql_connect("localhost","root","");
                mysql_select_db("demotdb",$con);
				$qry = "SELECT vizitator.nume_vizitator, vizitator.prenume_vizitator, vizitator.relatie_condamnat, vizitator.natura_vizitei, vizita.data_vizitei, vizita.durata_vizitei, vizita.obiecte_furnizate, vizita.stare_sanatate, vizita.nume_martor
FROM condamnat
INNER JOIN vizita ON condamnat.id_condamnat=vizita.id_condamnat
inner join imagini on condamnat.id_img=imagini.id_imagine
inner join vizitator on vizita.id_vizitator=vizitator.id_vizitator
WHERE condamnat.id_condamnat like '$var1'";

                $result=mysql_query($qry,$con);
				$numar=0;


				while($row = mysql_fetch_array($result))	
                {
					echo'<tbody>';
					echo'<tr>';
					echo '<th class="tg-031e">'.$row[0].'</th>';
					echo '<th class="tg-031e">'.$row[1].'</th>';
					echo '<th class="tg-031e">'.$row[2].'</th>';
					echo '<th class="tg-031e">'.$row[3].'</th>';
					echo '<th class="tg-031e">'.$row[4].'</th>';
					echo '<th class="tg-031e">'.$row[5].'</th>';
					echo '<th class="tg-031e">'.$row[6].'</th>';
					echo '<th class="tg-031e">'.$row[7].'</th>';
					echo '<th class="tg-031e">'.$row[8].'</th>';

					echo'</tr>';
					echo'</tbody>';
                }
				echo '</table></div>';
				
                mysql_close($con);   

?>



</body>
</html>