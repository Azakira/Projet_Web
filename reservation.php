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



	if(($handle = fopen("distanceVille.csv", "r")) !== FALSE) {
		fgetcsv($handle, 1000, ",");
			$tab = array();
			while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
							
				foreach($data as $value) {
	        		$fields = preg_split("[,]", $value);
	        		array_push($tab, $fields);
	        	}

			}
			
    	fclose($handle);
	}


	$villeAsso = array();

	$indVille="";
	foreach ($tab as $line) {
		if($indVille!=$line[0]){
			$indVille=$line[0];
			$villeAsso[$indVille] = $line;
		}

	}

	function distVille($tableau,$ville1,$ville2,$horaire){
		$distTime = array();
		$ind = -1;
		$cpt =1;
		switch ($ville1) {
			case 'Monétay sur Allier':
				$ville1 = "Monétay";
				break;
			case 'Monteignet sur l’Andelot':
				$ville1 = "Monteignet";
				break;			
		}

		switch ($ville2) {
			case 'Monétay sur Allier':
				$ville2 = "Monétay";
				break;
			case 'Monteignet sur l’Andelot':
				$ville2 = "Monteignet";
				break;
		}	

		foreach($tableau as $keyVille => $value1){
			if($keyVille == $ville1){

				$ind = $cpt;
				break 1;

			}else{ $cpt++; }

		}
		if($ind == -1){
			echo "La ville de votre 1er spectacle n'existe pas,veuillez rééssayer pls ";
		}

		else {
			$cpt2=1;
			$ind2=-1;
			foreach($tableau as $keyVille2 => $value2){
				if($keyVille2 == $ville2){
					 $ind2 = $cpt2;
					//return $tableau[$ville1][$ind2];
					$timeAndDistance = preg_split("[/]",$tableau[$ville1][$ind2]);
					$timeAndDistance[0]= intval($timeAndDistance[0]);
					$timeAndDistance[1]= intval($timeAndDistance[1]);
					$time=intval($timeAndDistance[1]);
					if($horaire >=17 and $horaire <=19)
						$timeAndDistance[1]+=$timeAndDistance[1]*0.1;

				}
				else{ $cpt2++; }
			}

			if($ind2 == -1){
				echo "La ville du 2eme spectacle n'existe pas,veuillez rééssayer pls ";
			}
		}
		return $timeAndDistance;

	}		
		
	function mConvertH($time){
		return round($time/60,1); 
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
	
	<body onload="hiddenDDL2(); hideSpec()">
		<div class="bandeau">
			<h1> Festival Théâtres de Bourbon : Réservation</h1>
		</div ><!--class="bandeau"-->
		<div class="menu">
			<ul class="navbar">
				<a href="index.php">Le site :</a>
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
					function convertHTML($str){
						$res = preg_replace_callback('([\s\S]+)', // /s => match espaces, /S => match all chars sauf espaces
							function ($match){
								$match = preg_replace("[&#44;]", ',', $match); //remplace les virgules par le symbole html
								$match = preg_replace("[&#146;]", "’", $match); //remplace les apostrophes par le symbole html
								implode($match); //concatene le tout
								return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
							},
							$str
						);
						return $res;
					}
					
					function compareHTML($str1, $str2){
						$res = convertHTML($str2);
						if($res == $str1)
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
								"titre" => convertHTML($title),
								"date"  => convertHTML($rep[0]),
								"heure" => convertHTML($rep[1]),
								"lieu"  => convertHTML($rep[3]),
								"troupe"=> convertHTML($rep[5]),
								"ville" => convertHTML($rep[4])
							);
							
							echo "<option value='" . serialize($spectacleDDL) . "'";// au milieu
							//if($rep[0] == $spectacleDDL['date'] && $rep[1] == $spectacleDDL['heure'] && $rep[3] == $spectacleDDL['lieu'] && $rep[5] == $spectacleDDL['troupe'])
						if (   $spectacle['titre'] 	== $spectacleDDL['titre']
							&& $spectacle['date'] 	== $spectacleDDL['date'] 
							&& $spectacle['heure'] 	== $spectacleDDL['heure'] 
							&& $spectacle['lieu']	== $spectacleDDL['lieu'])
							echo " selected";
							
							echo ">";
							
							// echo "<!-- " . $spectacle['lieu'] . " | " . $spectacleDDL['lieu'] . "-->";
							//echo "<!-- " . (($spectacle['lieu']==$spectacleDDL['lieu']) ? "true" : "false") . " -->";
							
							echo "Le " . $rep[0] . " " . " à " . $rep[1] . ", " . "au " . $rep[3] . " à " . $rep[4] . ", par " . $rep[5] . "<br/>\n";
							echo "</option>\n";
							// echo "<!--" . serialize($spectacleDDL). " || " . $spectacleText . " -->";
							//distVille($villeAsso,$rep[4])
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
					 // le pb avec spectacleText est si le client réserve un spectacle d'une page qquonque mais décide de modifié et prends Barbara ou Tratuffe au moment de réserver, on n'envoie rien au panier
						
					echo "<input name='is_modified' type='hidden' value='" . $is_modified ."'>"; //on envoie $is_modified en hidden: false=reservation normale, true=modification
					


					echo "</table>\n";
					echo "<input type='submit' value='Réserver'>\n";
					echo "</form>\n";
					
					$arrayTestSpec = unserialize($spectacleText);
					
					$arrayDistTime = array();
					foreach ($_SESSION['panier'] as $t => $com) {
						if($arrayTestSpec["date"]==$com["spectacle"]["date"]){
							$arrayDistTime = distVille($villeAsso,$arrayTestSpec["ville"],$com["spectacle"]["ville"],intval($arrayTestSpec["heure"]));
							//var_dump(intval($arrayTestSpec["heure"]) +2+ mConvertH($arrayDistTime[1]));
							//var_dump($arrayTestSpec["ville"]);
							
							$limitTime1 = intval($arrayTestSpec["heure"]) + 2  + mConvertH($arrayDistTime[1]);
							$limitTime2 = intval($arrayTestSpec["heure"]) - 2  - mConvertH($arrayDistTime[1]);

							// var_dump($limitTime);
							// var_dump(intval($com["spectacle"]["heure"]));

							if(intval($arrayTestSpec["heure"]) == intval($com["spectacle"]["heure"]) && $arrayTestSpec["titre"] == $com["spectacle"]["titre"] && $arrayTestSpec["date"] == $com["spectacle"]["date"] && is_null($_POST['modify'])){
								echo "<script language=\"javascript\">" . "alert('Attention vous avez sélectionner un spectacle que vous avez déjà dans votre panier NIBBA0');"."</script>";

							}else{

								if(intval($arrayTestSpec["heure"] <= $com["spectacle"]["heure"]) && is_null($_POST['modify'])){
									if($limitTime1 > intval($com["spectacle"]["heure"])){
										echo "<script language=\"javascript\">" . "alert('Attention vous avez un spectacle après que vous allez chevauché NIBBA1');"."</script>";
									}
								} else{
									if($limitTime2 < intval($com["spectacle"]["heure"])&& is_null($_POST['modify'])){
										echo "<script language=\"javascript\">" . "alert('Attention vous avez un spectacle avant qui chevauche celui choisi NIBBA2');"."</script>";
									}
								}
							echo "</br>";
							}
						}
 				
					}	
					$nbPlace=0;
					$tr=0;
					foreach ($_SESSION['panier'] as $co) {
						$nbPlace += intval($co['adulte']) + intval($co['enfant']) + intval($co['tarif_reduit']);
						if(intval($co['tarif_reduit'])!=0)
							$tr++;

				}
				
					
				?>
			</div><!--class=\"decalage\"-->
		</main>
		
	</body>

</html>
