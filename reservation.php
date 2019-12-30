<?php 
	session_start();
	if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}
	
	$titresSpectacles = array();
	
	if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
		fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
		$last_spec = "null";
		$tab = array();
		while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
		
			foreach($data as $value) {
				$replaced = preg_replace_callback(
					'/"(\\\\[\\\\"]|[^\\\\"])*"/',
					function ($match){
						$match = preg_replace("[,]", '&#44;', $match); //remplace les virgules par le symbole html
						$match = preg_replace("[\"]", '', $match); //retire les guillemets
						implode($match); //concatene le tout
						return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
					},
				$value
				);
							
				$replaced = preg_replace("[']", '&#146;', $replaced); //remplace les apostrophes par le symbole html
				
				$fields = preg_split("[,]", $replaced);
				array_push($tab, $fields);
			}
		}
		while(count($tab)>0){ 
			foreach($tab as $line){//parcourir le tableau pour chercher le nouveau $last_spec
				if($last_spec!= $line[2]){
					$last_spec = $line[2];
					break 1;
				}
			}
			$tab_asso = array(); //tableau pour mettre les spectacles en fonction du last_spec et est réinitialiser pour le prochain last_spec
			foreach($tab as $i => $line){
				if($tab[$i][2] == $last_spec){	 //si le titreDeSpectacle est égale au last_spec alors on met sa ligne le concernant dans tab_asso et on retire la ligne de tab
					array_push($tab_asso, $tab[$i]);
					unset($tab[$i]);
				}	
			}
			$titresSpectacles[$last_spec] = $tab_asso;
		}  
		ksort($titresSpectacles);
		
		$titres = array();
		foreach($titresSpectacles as $line){
			foreach($line as $elt){
				foreach($elt as $wtf){
					array_push($titres, $wtf);
				}
			}
		}
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
			// header('Location: http://localhost/Projet_Web/erreur.php');
			// exit();
		}
?>
<html>
	<head>
		<title>Festival Théâtres de Bourbon : Réservation</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
		<style> th {
					  background-color: #4CAF50;
					  color: white;
					}
		</style>
		<script src="reservation.js"></script>
	</head>
	
	<body onload="hiddenDDL2()">
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
					function compareHTML($str1, $str2){
						$str1 = preg_replace_callback('([\s\S]+)', // /s => match espaces, /S => match all chars sauf espaces
							function ($match){
								$match = preg_replace("[,]", '&#44;', $match); //remplace les virgules par le symbole html
								$match = preg_replace("[’]", '&#146;', $match); //remplace les apostrophes par le symbole html
								implode($match); //concatene le tout
								return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
							},
							$str1
						);
						if($str1 == $str2)
							return true;
						return false;
					}
					
					/**
					 *	TESTS
					 *	
					 **/

					echo "<p id=\"test\"> Testing block </p></br>\n";
					
					
					echo "<select name='titre' id='titre' onchange='hiddenDDL2()'>\n";
					echo " <option disabled selected value> -- Veuillez sélectionner un spectacle -- </option>\n";
					foreach($titresSpectacles as $i => $val){
						echo "<option value='" . $i . "'";
						if(compareHTML($spectacle['titre'], $i))
							echo " selected";
						echo ">" . $i . "</option>\n";
					}
					echo "</select></br>\n";
					$i=0;
					foreach($titresSpectacles as $title => $representations){
						echo "<div id='" . $title . "'>\n";
						echo "<select ";
						/*
						if(!compareHTML($spectacle['titre'], $title))
							echo "hidden "; //conflict w/ javascript fun.
						*/
						echo "id='" . $i++ . "' onchange='selectSpec(this.value)'>\n";
						echo " <option selected disabled value=''> -- Veuillez sélectionner un spectacle -- </option>\n";
						foreach($representations as $rep){
							$spectacleDDL = array( //pour Spectacle Drop Down List
								"titre" => $title,
								"date"  => $rep[0],
								"heure" => $rep[1],
								"lieu"  => $rep[3],
								"troupe"=> $rep[5],
								"ville" => $rep[4]
							);
							echo "<!--" . serialize($spectacleDDL). " || " . $spectacleText . " -->";
							echo "<option value='" . serialize($spectacleDDL) . "'";// au milieu
							//if($rep[0] == $spectacleDDL['date'] && $rep[1] == $spectacleDDL['heure'] && $rep[3] == $spectacleDDL['lieu'] && $rep[5] == $spectacleDDL['troupe'])
						if (compareHTML($spectacle['titre'], $spectacleDDL['titre']) 
							&& compareHTML($spectacle['date'], $spectacleDDL['date']) 
							&& compareHTML($spectacle['heure'], $spectacleDDL['heure']) 
							&& compareHTML($spectacle['lieu'], $spectacleDDL['lieu']))
								echo " selected";
							echo ">";
							echo "Le " . $rep[0] . " " . " à " . $rep[1] . ", " . "au " . $rep[3] . " à " . $rep[4] . ", par " . $rep[5] . "<br/>\n";
							echo "</option>\n";
						}
						echo "</select>\n</div><!--id=\"" . $title . "\"-->\n";
					}

					echo "<form action='panier.php' method='POST'>\n";
					
					echo "<table><thead><tr> <th>Type de place</th>\n <th>nb de places</th>\n <th>Prix Unitaire</th><tr></thead>\n"; 

					echo "<tr>";
					echo " <td> Places adulte: </td>";					
					echo "<td> <button type='button' onclick='if (document.getElementById(\"adulte\").value > 0) {document.getElementById(\"adulte\").value--}'> - </button>\n";
					echo "<input id='adulte' type='number' name='adulte' value='" . $adulte . "' min='0' required>\n";
					echo "<button type='button' onclick='document.getElementById(\"adulte\").value++'> + </button></br></td>\n";
					echo "<td align ='center'> 15 € </td></tr>\n";
										
					echo "<tr>";
					echo " <td> Places enfant: </td>";
					echo "<td> <button type='button' onclick='if (document.getElementById(\"enfant\").value > 0) {document.getElementById(\"enfant\").value--}'> - </button>\n";
					echo "<input id='enfant' type='number' name='enfant' value='" . $enfant . "'min='0' required>\n";
					echo "<button type='button' onclick='document.getElementById(\"enfant\").value++'> + </button></br></td>\n";
					echo "<td align ='center'> 0 € </td></tr>\n";
					
					echo "<tr>";
					echo "<td> Places tarif réduit: </td>";
					echo"<td> <button type='button' onclick='if (document.getElementById(\"tarif_reduit\").value > 0) {document.getElementById(\"tarif_reduit\").value--}'> - </button>\n";
					echo "<input id='tarif_reduit' type='number' name='tarif_reduit' value='" . $tarif_reduit . "' min='0' required>\n";
					echo "<button type='button' onclick='document.getElementById(\"tarif_reduit\").value++'> + </button></br></td>\n";
					echo "<td align='center'> 10 € </td></tr>\n";
					echo "<input required id='spectacle' name='spectacle' type='text' size='100' value='" . $spectacleText ."'>";
						
					echo "<input name='is_modified' type='hidden' value='" . $is_modified ."'>"; //on envoie $is_modified en hidden: false=reservation normale, true=modification
					


					echo "</table>\n";
					echo "<input type='submit' value='Réserver'>\n";
					echo "</form>\n";
				?>
			</div><!--class=\"decalage\"-->
		</main>
		
	</body>

</html>
