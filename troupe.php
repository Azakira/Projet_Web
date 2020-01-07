<html>
	<head>
		<title>Festival Théâtres de Bourbon : jour après jour</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon : Par troupe  </h1>
		</div ><!--class="bandeau"-->

		<div class="panierFinal">
				<a href="panier.php"><img src="panier2.jpg" alt="imgPanier"></a>
				</br>
				<span>Panier</span>
		</div><!-- class="panierFinal"-->	

		<div class="menu">
			<ul class="navbar">
				<a href="index.php">Le site :</a>
				<li><a href="jours.php">Jour par Jour</a></li>
				<li><a href="lieu.php">Lieu par Lieu</a></li>
				<li><a href="spectacle.php">Spectacles</a></li>
				<li><a href="troupe.php">Troupe</a></li>
				<li><a href = "panier.php">Panier</a></li>
			</ul>			
		</div>
		
		<main>
			<div class="decalage">
				<br/>


<?php 

						if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
							fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
							$troupe = "null";
							$tab = array();
							while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
								
								foreach($data as $value) {
									$replaced = preg_replace_callback( // pour résoudre le problème de Barbara
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

							$sort_troupe = array();	//Pour y mettre le tableau trié en fonction des spectacles
							$last_troupe = "null";
							while(count($tab)>0){ 
								foreach($tab as $line){//parcourir le tableau pour chercher le nouveau $last_troupe
									if($last_troupe!= $line[5]){
										$last_troupe = $line[5];
										break 1;
									}
								}
								$tab_asso = array(); //tableau pour mettre les spectacles en fonction du last_troupe et est réinitialiser pour le prochain last_troupe
								foreach($tab as $i => $line){
									if($tab[$i][5] == $last_troupe){	 //si le titreDeSpectacle est égale au last_troupe alors on met sa ligne le concernant dans tab_asso et on retire la ligne de tab
										array_push($tab_asso, $tab[$i]);
										unset($tab[$i]);
									}	
								}
								$sort_troupe[$last_troupe] = $tab_asso;
							}  
							ksort($sort_troupe);
							//var_dump($sort_troupe);


						foreach($sort_troupe as $troupeTab => $line){	//Boucle pour l'affichage html
							foreach($line as $i => $value){
						
								if($troupe != $troupeTab){
								 	if($troupe != "null"){
							 			echo "</table>\n";
								 		echo "</div><!--class=\"Spectacle\"-->\n";
									
							 	}
							 	$troupe = $troupeTab;
							 	echo "<div class=\"Spectacle\">\n";
							 	echo "<h2> ". $troupe ."</troupe></h2>\n";
							 	echo "<table>\n";
							 }
							 echo "<tr>\n<td>";
							echo "<Spec>".$value[2]." ". "</Spec>" . "<Horaire> le " . $value[0] . " " . " à " . $value[1] . "</Horaire>, " . "au <Lieu>" . $value[3] . " à " . $value[4] . "</Lieu><br/>\n";
							echo "</td>\n <td>";
							echo "<form action='reservation.php' method='post'>\n";
							echo "<input type=\"submit\" value=\"Reserver\">\n";
							echo "<input name='titre' type=hidden value=\"" . $value[2] . "\">\n";
							echo "<input name='date' type=hidden value=\"" . $value[0] . "\">\n";
							echo "<input name='heure' type=hidden value=\"" . $value[1] . "\">\n";
							echo "<input name='lieu' type=hidden value=\"" . $value[3] . "\">\n";
							echo "<input name='ville' type=hidden value=\"" . $value[4] . "\">\n";
							echo "<input name='troupe' type=hidden value=\"" . $value[5] . "\">\n";
							echo "\n</form> \n</td> \n</tr>\n";						
								
							}
						}
					
				
					echo "</table>\n";
					echo "</div><!--class=\"decalage\"-->\n</main>\n";

							fclose($handle);
							
					}
				?>
						</div><!--class=\"decalage\"-->
		</main>
	</body>

</html>
