<?php 
	session_start();
	if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}
	
	//code déplacé en haut pour pouvoir utilisé header(), devant être appelée avant tt affichage html
	
	if (isset($_POST['titre'])){ //si on vient de reserver un spectacle
		$spectacle = array(
			"titre" => $_POST['titre'],
			"date"  => $_POST['date'],
			"heure" => $_POST['heure'],
			"lieu"  => $_POST['lieu'],
			"troupe"=> $_POST['troupe'],
			"ville" => $_POST['ville']
		);
		$adulte = $enfant = $tarif_reduit = 0;
		$spectacleText = serialize($spectacle);
		$is_modified = "false";
	} else if (isset ($_POST['modify'])){ //si on vient de modifier (du panier)
			$commande = unserialize($_POST['modify']);
			$spectacle = $commande['spectacle'];
			$spectacleText = serialize($spectacle);
			
			$adulte = $commande['adulte'];
			$enfant = $commande['enfant'];
			$tarif_reduit = $commande['tarif_reduit'];
			
			$is_modified = "true";
	} else { //sinon (si on vient de nulle part) 
			header('Location: http://localhost/Projet_Web/erreur.php');
			exit();
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
					
					echo "<titreSpectacle>". $spectacle['titre'] . "</titreSpectacle><Horaire> Le " . $spectacle['date'] . " à " . $spectacle['heure'] . "</Horaire>, " . " par <troupe>" . $spectacle['troupe'] . "</troupe> à <lieu>" . $spectacle['lieu'] . ", " . $spectacle['ville'] . ".</lieu><br/>\n</td>\n";
					echo "<form action='panier.php' method='POST'>\n";
					
					echo "Places adulte: <button type='button' onclick='if (document.getElementById(\"adulte\").value > 0) {document.getElementById(\"adulte\").value--}'> - </button>\n";
					echo "<input id='adulte' type='number' name='adulte' value='" . $adulte . "' min='0'>\n";
					echo "<button type='button' onclick='document.getElementById(\"adulte\").value++'> + </button></br>\n";
					
					echo "Places enfant: <button type='button' onclick='if (document.getElementById(\"enfant\").value > 0) {document.getElementById(\"enfant\").value--}'> - </button>\n";
					echo "<input id='enfant' type='number' name='enfant' value='" . $enfant . "'min='0'>\n";
					echo "<button type='button' onclick='document.getElementById(\"enfant\").value++'> + </button></br>\n";
					
					echo "Places tarif réduit: <button type='button' onclick='if (document.getElementById(\"tarif_reduit\").value > 0) {document.getElementById(\"tarif_reduit\").value--}'> - </button>\n";
					echo "<input id='tarif_reduit' type='number' name='tarif_reduit' value='" . $tarif_reduit . "' min='0'>\n";
					echo "<button type='button' onclick='document.getElementById(\"tarif_reduit\").value++'> + </button></br>\n";
					
					echo "<input name='spectacle' type='hidden' value='" . $spectacleText ."'>";
					echo "<input name='is_modified' type='hidden' value='" . $is_modified ."'>"; //on envoie $is_modified en hidden: false=reservation normale, true=modification
					
					echo "<input type='submit' value='Réserver'>\n";
					echo "</form>\n";
				?>
			</div><!--class=\"decalage\"-->
		</main>
		
	</body>

</html>
