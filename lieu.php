<html>
	<head>
		<title>Festival Théâtres de Bourbon : Lieu par lieu</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon : Lieu par lieu </h1>
		</div ><!--class="bandeau"-->
		<div class="menu">
			<ul class="navbar">
				<a href="projet.html">Le site :</a>
				<li>Qui sommes nous?</li>
				<li><a href="jours.php">Jour par jour</a></li>
				<li>Lieu par Lieu</li>	
				<li>Spectacles</li>
				<li>Tarifs</li>
			</ul>			
		</div>
		
		
		<?php 
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$lieu = "null";
				$last_lieu = "null";
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
				$sort_lieu = array();	//Pour y mettre le tableau trié en fonction des jours
				
				while(count($tab)!= count($sort_lieu)){ //tant que $tab et $sort_lieu ont un nbre d'elts !=
					foreach($tab as $line){
						if($line[3] == $last_lieu){
							array.push($sort_lieu, $line)
						}
					}
					foreach($tab as $line){
						//parcourir le tableau pour chercher le nouveau $last_lieu
					}
				}				
				if($lieu != $fields[3]){
					if($lieu != "null"){
						echo "</table>\n";
					}
					$lieu = $fields[3];
					echo "<h2> " . $lieu . "</h2>\n";
					echo "<table>\n";
				}
				echo "<tr>\n<td>";
				echo "<Horaire>" . $fields[1] . "</Horaire>, au <Lieu>" . $fields[3] . " à " . $fields[4] . "</Lieu>, <titreSpectacle>". $fields[2] . "</titreSpectacle> par <troupe>" . $fields[5] . "</troupe><br/>\n";
				echo "</td>\n <td>Reserver</td></tr>\n";
					
			
				
				echo "<table>\n</div><!--class=\"decalage\"-->\n<main>\n";
				fclose($handle);
				
			}
		?>
	</body>

</html>
