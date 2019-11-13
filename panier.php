<?php 
	session_start();
	if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}
?>
<html>
	<head>
		<title>Panier</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
		<style> tarif { color : blue;
		}
		</style>
	</head>
	
	<body>
		<div class="bandeau">
			<h1>Panier</h1>
		</div ><!--class="bandeau"-->
		<div class="menu">
			<ul class="navbar">
				<a href="index.php">Le site :</a>
				<li>Qui sommes nous?</li>
				<li><a href="jours.php">Jour par Jour</a></li>
				<li><a href="lieu.php">Lieu par Lieu</a></li>
				<li><a href="spectacle.php">Spectacles</a></li>
				<li><a href="panier.html">Panier</a></li>
				<li>Tarifs</li>
			</ul>
		</div><!--class="menu"-->
		
		<main>
			<section>
				<div class="decalage">
					<?php 
						if (isset($_POST['spectacle'])){
							$commande = array(
								"spectacle"   => unserialize($_POST['spectacle']),
								"adulte"	  => $_POST['adulte'],
								"enfant"	  => $_POST['enfant'],
								"tarif_reduit"=> $_POST['tarif_reduit']
							);
							array_push($_SESSION['panier'], $commande);
						}

						echo "<table>";
						foreach($_SESSION['panier'] as $commande){
							if(empty($_SESSION['panier'])){
								echo"</table>";
							}
							echo "<spectacle></br><tr><td>" . $commande['spectacle']['titre'] . ", le " . $commande['spectacle']['date'] . " à " . $commande['spectacle']['heure'] . "</spectacle></br>\n";
							echo "<tarif><td>" . "Tarif Adulte: " . $commande['adulte'] . "</td>\n";
							echo "<td> Tarif enfant: " . $commande['enfant'] . "</td>\n";
							echo "<td> Tarif Reduit: " . $commande['tarif_reduit'] . "</td></tarif>\n";

						}
						
					?>
				</div><!--class="decalage"-->
			</section>
		</main>
	</body>
</html>