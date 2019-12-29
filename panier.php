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
							
							if($_POST['is_modified'] == "true"){ 					//si commande modifiee
								foreach($_SESSION['panier'] as $i => $com){
									if ($com['spectacle'] == $commande['spectacle']){
										unset($_SESSION['panier'][$i]);			//on supprime la ligne correspondante dans le panier
									}
								}
							} else { 											//sinon normal
								foreach($_SESSION['panier'] as $i => $com){
									if ($com['spectacle'] == $commande['spectacle']){
										$commande['adulte'] = $com['adulte']+$commande['adulte'];
										$commande['enfant'] = $com['enfant']+$commande['enfant'];
										$commande['tarif_reduit'] = $com['tarif_reduit']+$commande['tarif_reduit'];
										unset($_SESSION['panier'][$i]);
									}
								}
							}
							if ($commande['adulte']+$commande['enfant']+$commande['tarif_reduit']>0)
								array_push($_SESSION['panier'], $commande); //si commande a 0 tickets, on ne push pas
						}
						
						if (isset($_POST['reset'])){
							$_SESSION['panier'] = array();
						}
						
						if (isset($_POST['supprSpec'])){
							foreach($_SESSION['panier'] as $i => $com){
								$unsSuppr = unserialize($_POST['supprSpec']);
								if($unsSuppr == $com['spectacle'])
									unset($_SESSION['panier'][$i]);
							}
						}
						
						
						echo "<form action='panier.php' method='post'>\n";
						echo "<input name='reset' type='hidden' value='true'>\n";
						echo "<input type=submit value='Réinitialiser'>\n</form></br>\n";
						
						$nbPlaces =0;
						$prix = 0;
						foreach($_SESSION['panier'] as $commande){
							
							echo "<div class=\"Spectacle\">";	
							echo "\n<titreSpectacle>" . $commande['spectacle']['titre'] . "</titreSpectacle>, le " . $commande['spectacle']['date'] . " à " . $commande['spectacle']['heure'] . "</br>\n";
							
							if($commande['adulte'] > 0)
								echo "" . "Tickets adulte: " . $commande['adulte'] . "</br>\n";
							if($commande['enfant'] > 0)
								echo " Tickets enfant: " . $commande['enfant'] . "</br>\n";
							if($commande['tarif_reduit'] > 0)
								echo " Tickets à tarif réduit: " . $commande['tarif_reduit'] . "</br>\n";

							$nbPlaces = intval($commande['adulte']) + intval($commande['enfant']) + intval($commande['tarif_reduit']);
							$prix = intval($commande['adulte'])*15 + intval($commande['tarif_reduit'])*10 + intval($commande['enfant'])*0;

							echo "<div class=\"petitPanier\"> <table> PANIER </br> Nombre places réservées : ". $nbPlaces /*+ intval($commande['enfant']) + intval($commande['tarif_reduit'])*/. "</br> Prix total : " . $prix . "</table>
								</div><!-- class=\"petitPanier\"-->";	
								//var_dump(intval($commande['adulte']) + intval($commande['enfant']));							
							
							echo "<form method=\"post\" action=\"reservation.php\">\n";
							echo "<input name='modify' type='hidden' value='" . serialize($commande) . "'>\n";
							echo "<input type=\"submit\" value=\"Modifier\" />\n";
							echo "</form>\n";
							echo "<form method=\"post\" action=\"panier.php\">\n";
							echo "<input name='supprSpec' type='hidden' value='". serialize($commande['spectacle']) ."'>\n";
							echo "<input type=\"submit\" value=\"Supprimer\" />\n";
							echo "</form>\n";
							echo "</div><!--class=\"Spectacle\"-->";
							//regarder la diff entre submit et value pour le type
						}
						
					?>
				</div><!--class="decalage"-->
			</section>
		</main>
	</body>
</html>