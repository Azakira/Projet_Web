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
		<style>  		table{
							border: 2mm ridge rgba(71, 141, 235, .6);

						}

						td.tarif { padding-top: 5px;
							padding-bottom: 5px;							
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
				<li><a href="panier.php">Panier</a></li>
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
							if ($commande['adulte']+$commande['enfant']+$commande['tarif_reduit']>0)
								array_push($_SESSION['panier'], $commande); //si commande a 0 tickets, on ne push pas
						}
						if (isset($_POST['reset'])){
							$_SESSION['panier'] = array();
						}
						
						echo "<form action='panier.php' method='post'>\n";
						echo "<input name='reset' type='hidden' value='true'>\n";
						echo "<input type=submit value='Réinitialiser'>\n</form></br>\n";
						
						foreach($_SESSION['panier'] as $commande){
							echo "<div class=\"Spectacle\">";
							echo "\n<titreSpectacle>" . $commande['spectacle']['titre'] . "</titreSpectacle>, le " . $commande['spectacle']['date'] . " à " . $commande['spectacle']['heure'] . "</br>\n";
							echo "" . "Tickets adulte: " . $commande['adulte'] . "</br>\n";
							echo " Tickets enfant: " . $commande['enfant'] . "</br>\n";
							echo " Tickets à tarif réduit: " . $commande['tarif_reduit'] . "</br>\n";
							echo "<form method=\"post\" action=\"index.php\">
								<input type=\"submit\" value=\"Modifier\" /> 
								</form></td>
								</table>
								</div><!--class=\"Spectacle\"-->";
								//regarder la diff entre submit et value pour le type
						}
						
					?>
				</div><!--class="decalage"-->
			</section>
		</main>
	</body>
</html>