<html>
	<head>
		<title>Festival Théâtres de Bourbon : Spectacle par spectacle</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon : Spectacle par spectacle </h1>
		</div ><!--class="bandeau"-->
		<div class="menu">
			<ul class="navbar">
				<a href="projet.html">Le site :</a>
				<li>Qui sommes nous?</li>
				<li><a href="jours.php">Jour par Jour</a></li>
				<li><a href="lieu.php">Lieu par Lieu</a></li>
				<li><a href="spectacle.php">Spectacles</a></li>
				<li>Tarifs</li>
			</ul>			
		</div>

		<?php 
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$spectacle = "null";
				$tab = array();
				echo "<main>\n<div class=\"decalage\">\n<br/>\n";
				while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
					
					foreach($data as $value) {
						$replaced = preg_replace_callback(
							'/"(\\\\[\\\\"]|[^\\\\"])*"/',
							function ($match){
								$temp = preg_replace("[,]", '&#44;', $match);
								implode($temp);
								return $temp[0];
							},
							$value
						);
						$fields = preg_split("[,]", $replaced);
						array_push($tab, $fields);
					}
				}

				$sort_spec = array();	//Pour y mettre le tableau trié en fonction des jours
				$last_spec = "null";
				while(count($tab)>0){ 
					foreach($tab as $line){
						//parcourir le tableau pour chercher le nouveau $last_lieu
						if($last_spec!= $line[2]){
							$last_spec = $line[2];
							break 1;
						}
					}
					foreach($tab as $i => $line){
						if($tab[$i][2] == $last_spec){
							array_push($sort_spec, $tab[$i]);
							unset($tab[$i]);
						}
					}
				}  //tant que $tab et $sort_lieu ont un nbre d'elts !=	
//Boucle pour l'affichage html
				foreach($sort_spec as $line){
					
					if($spectacle != $line[2]){
						if($spectacle != "null"){
							echo "</table>\n";
						}
						$spectacle = $line[2];
						echo "<h2> " . $spectacle . "</h2>\n";
						echo "<table>\n";
					}
					
					echo "<tr>\n<td>";
					echo "<Horaire> Le " . $line[0] . " " . " à " . $line[1] . "</Horaire>, " . "<titreSpectacle>". $line[2] . "</titreSpectacle> par <troupe>" . $line[5] . "</troupe><br/>\n";
					echo "</td>\n <td>Reserver</td></tr>\n";
				}
					
			
				
				echo "<table>\n</div><!--class=\"decalage\"-->\n</main>\n";
				fclose($handle);
				
			}
		?>
	</body>
</html>