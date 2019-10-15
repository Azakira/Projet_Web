<html>
	<head>
		<title>Theatres de Bourbon</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon </h1>
		</div ><!--class="bandeau"-->
		
		<?php 
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				echo '<div class="decalage">\n';
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
							
							$jour = $fields[0];
							echo "<h2> " . $jour . "</h2>\n";
						}
						echo "<Horaire>" . $fields[1] . "</Horaire>, au <Lieu>" . $fields[3] . " à " . $fields[4] . "</Lieu>, <titreSpectacle>". $fields[2] . "</titreSpectacle> par <troupe>" . $fields[5] . "</troupe><br/>\n";
						
					
					}
			
				}
		
				fclose($handle);
				echo '</div><!--class="decalage"-->\n';
			}
		?>
	</body>

</html>