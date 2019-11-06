<?php 
	session_start();
	if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}
?>
<html>
	<head>
		<title>Festival Théâtres de Bourbon : Réservation</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon : Réservation</h1>
		</div ><!--class="bandeau"-->
		<div class="menu">
			<ul class="navbar">
				<a href="index.php">Le site :</a>
				<li>Qui sommes nous?</li>
				<li><a href="jours.php">Jour par Jour</a></li>
				<li><a href="lieu.php">Lieu par Lieu</a></li>	
				<li><a href="spectacle.php">Spectacles</a></li>
				<li>Tarifs</li>
			</ul>			
		</div>
		
		<?php
			$spectacle = array(
				"titre" => $_POST['titre'],
				"date"  => $_POST['date'],
				"heure" => $_POST['heure'],
				"lieu"  => $_POST['lieu'],
				"troupe"=> $_POST['troupe']
			);
			foreach($spectacle as $i => $v){
				echo $i . " => " .$v . ", \n";
			}
		?>
		
	</body>

</html>
