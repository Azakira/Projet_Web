<html>
	<head>
		<title>Festival Théâtres de Bourbon : jour après jour</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon : jour après jour </h1>
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
					if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
						fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
						$jour = "null";
						
						while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
							
							foreach($data as $value) {
								$replaced = preg_replace_callback(
									'/"(\\\\[\\\\"]|[^\\\\"])*"/',
									function ($match){
										$match = preg_replace("[,]", '&#44;', $match); //remplace les virgules par le symbole html
										$match = preg_replace("[\"]", '&#34;', $match); //remplace les guillemets par le symbole html
										implode($match); //concatene le tout
										return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
									},
									$value
								);
								
								$fields = preg_split("[,]", $replaced);
								if($jour != $fields[0]){
									if($jour != "null"){
										echo "</table>\n";
									}
									$jour = $fields[0];
									echo "<h2> " . $jour . "</h2>\n";
									echo "<table>\n";
								}
								echo "<tr>\n<td>";
								echo "<Horaire>" . $fields[1] . "</Horaire>, au <Lieu>" . $fields[3] . " à " . $fields[4] . "</Lieu>, <titreSpectacle>". $fields[2] . "</titreSpectacle> par <troupe>" . $fields[5] . "</troupe><br/>\n";
								echo "</td>\n <td>";
								echo "<form action='reservation.php' method='post'>\n";
								echo "<input type=\"submit\" value=\"Reserver\">\n";
								echo "<input name='titre' type=hidden value=\"" . $line[2] . "\">\n";
								echo "<input name='date' type=hidden value=\"" . $line[0] . "\">\n";
								echo "<input name='heure' type=hidden value=\"" . $line[1] . "\">\n";
								echo "<input name='lieu' type=hidden value=\"" . $line[3] . "\">\n";
								echo "<input name='troupe' type=hidden value=\"" . $line[5] . "\">\n";
								echo "</form>\n</td>\n</tr>\n";
							
							}
					
						}
						fclose($handle);
						
					}
				?>
			</div><!--class=\"decalage\"-->
		</main>
	</body>

</html>
