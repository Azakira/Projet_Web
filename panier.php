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
							array_push($_SESSION['panier'], $commande);
						}
						
						foreach($_SESSION['panier'] as $commande){
							echo "<div class=\"Spectacle\">";
							echo "<table>\n";
							echo "<tr>\n<td>\n" . $commande['spectacle']['titre'] . ", le " . $commande['spectacle']['date'] . " à " . $commande['spectacle']['heure'] . "</td>\n";
							echo "<td class=\"tarif\">" . "Tarif Adulte: " . $commande['adulte'] . "</td>\n";
							echo "<td class=\"tarif\"> Tarif enfant: " . $commande['enfant'] . "</td>\n";
							echo "<td class=\"tarif\"> Tarif Reduit: " . $commande['tarif_reduit'] . "</td>";
							echo "<td><form method=\"post\" action=\"index.php\">
								<input type=\"submit\" value=\"Modifier\" /> 
								</form></td>
								</table>
								</div><!--class=\"Spectacle\"-->
								</tr>\n";
								//regarder la diff entre submit et value pour le type
						}
						
					?>
				</div><!--class="decalage"-->
			</section>
		</main>
	</body>
</html>