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
				$last_lieu = "null";
				while(count($tab)>0) { //tant que $tab est nn vide	 
					foreach($tab as $line){
						//parcourir le tableau pour chercher le nouveau $last_lieu
						if($last_lieu != $line[3]){
							$last_lieu = $line[3];
							break 1;//On sort du foreach
						}
					}
					foreach($tab as $i => $line){
						if($tab[$i][3] == $last_lieu){
							array_push($sort_lieu, $tab[$i]);
							unset($tab[$i]);
						}
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
				
				echo "sort_lieu:<br/>";
				foreach($sort_lieu as $line) {
					foreach($line as $value){
						echo $value . " ";
					}
					echo "<br/>\n";
				}
				
				echo count($tab);
				echo " ";
				echo count($sort_lieu);
				
				
				echo "<tr>\n<td>";
				echo "<Horaire>" . $fields[1] . "</Horaire>, au <Lieu>" . $fields[3] . " à " . $fields[4] . "</Lieu>, <titreSpectacle>". $fields[2] . "</titreSpectacle> par <troupe>" . $fields[5] . "</troupe><br/>\n";
				echo "</td>\n <td>Reserver</td></tr>\n";
					
			
				
				echo "<table>\n</div><!--class=\"decalage\"-->\n<main>\n";
				fclose($handle);
				
			}
		?>
	</body>

</html>
