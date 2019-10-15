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
				$jour = "null";
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
						echo "</td>\n <td>Reserver</td></tr>\n";
					
					}
			
				}
				echo "<table>\n</div><!--class=\"decalage\"-->\n<main>\n";
				fclose($handle);
				
			}
		?>
	</body>

</html>
