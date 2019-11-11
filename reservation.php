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

		<main>
			<div class="decalage">
				<br/>
		
				<?php

					// if (($handle = fopen("distanceVille.csv", "r")) !== FALSE) {
					// 	//fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
					// 	// $spectacle = "null";
					// 	$tab = array();
					// 	while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
					// 		foreach($data as $value){
					// 			echo $data[$i] . "<br/>\n"
					// 		}
					// 	}
					// }
					// fclose($handle);

					$spectacle = array(
						"titre" => $_POST['titre'],
						"date"  => $_POST['date'],
						"heure" => $_POST['heure'],
						"lieu"  => $_POST['lieu'],
						"troupe"=> $_POST['troupe'],
						"ville" => $_POST['ville']
					);
					echo "<titreSpectacle>". $spectacle['titre'] . "</titreSpectacle><Horaire> Le " . $spectacle['date'] . " à " . $spectacle['heure'] . "</Horaire>, " . " par <troupe>" . $spectacle['troupe'] . "</troupe> à <lieu>" . $spectacle['lieu'] . ", " . $spectacle['ville'] . ".</lieu><br/>\n</td>\n";
					echo "<form action='jsp.php'>\n";
					echo "Places adulte: <input type='number' name='quantity' min='0'></br>\n";
					echo "Places enfant: <input type='number' name='quantity' min='0'></br>\n";
					echo "Places tarif réduit: <input type='number' name='quantity' min='0'></br>\n";
					echo "<input type='submit'>\n";
					echo "</form>\n";
				?>
			</div><!--class=\"decalage\"-->
		</main>
		
	</body>

</html>
