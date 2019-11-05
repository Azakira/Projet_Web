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
				<div class="Lieu">
					<p>	
					Dès cette première édition, le festival propose une programmation ambitieuse et riche. Les troupes participantes sont toutes aguerries et professionnelles et elles ont comme nous une approche passionnée du théâtre. 
					Cet événement se veut novateur et ambitieux, puisque l'excellence des spectacles sera accessible à tous, dans une ambiance amicale et chaleureuse.
				</p>
					<h2> Notre programmation...</h2>
					<h3> ...18 spectacles sélectionnés pour vous par notre directeur artistique.
					</h3>
					<p><li><titreSpectacle>Barbara, où rêvent mes saisons?</titreSpectacle>,
							d’après 
							<Auteur>Barbara et Sophie Pincemaille </Auteur>.	
						</li>
						<li><titreSpectacle>Le château de ma mère</titreSpectacle>,
							d’après 
							<Auteur>Marcel Pagnol</Auteur>.	
						</li>
						<li>
							Un triptyque sur 3 jour tiré 
							<titreSpectacle>des confessions</titreSpectacle>, 
							de 
							<Auteur>Saint Augustin</Auteur>.
						</li>
						<li>	
							<titreSpectacle>La demande en mariage et l’ours</titreSpectacle>, 
							de 
							<Auteur>Tchekhov</Auteur>.	
						</li> 
						<li>	<titreSpectacle>Fricassée de Berniques sur lit de Prévert</titreSpectacle>, lectures choisies de 
							<Auteur>Prévert</Auteur> parsemées de chansons.
						</li> 	
						<li><titreSpectacle>La gloire de mon père</titreSpectacle>, d’après 
							<Auteur>Marcel Pagnol</Auteur>. 
						</li>
						<li><titreSpectacle>Hugo démasqué</titreSpectacle>, d’après 
							<Auteur>Victor Hugo</Auteur>. 
						</li>
						<li><titreSpectacle>Mademoiselle Julie</titreSpectacle>, 
							d'<Auteur>August Stringberg</Auteur>. 
						</li>	
						<li><titreSpectacle>Le Marchand de Venise</titreSpectacle>, 
							de 
							<Auteur>Shakespeare</Auteur>. 
						</li>
						<li><titreSpectacle>Le mariage</titreSpectacle>, 
							de <Auteur>Jean Luc Jeener</Auteur>.
						</li>
						<li><titreSpectacle>La promesse de l'aube</titreSpectacle>, 
							tirée de l'œuvre de 
							<Auteur>Romain Gary</Auteur>. 
						</li>
						<li><titreSpectacle>Port racines</titreSpectacle>, 
							création de 
							<Auteur>labelle et Cie</Auteur>.
						</li>
						<li><titreSpectacle>Le prophète</titreSpectacle>, 
							de 
							<Auteur>Khalil Gilbran</Auteur>.
						</li>
						<li><titreSpectacle>Les soliloques de Mariette</titreSpectacle>, 
							tirée de Belle du Seigneur, d'<Auteur>Albert Cohen</Auteur>.
						</li>
						<li><titreSpectacle>le Tartuffe ou l'imposteur</titreSpectacle>, 
							de 
							<Auteur>Molière</Auteur>. 
						</li>
						<li><titreSpectacle>titre Provisoire</titreSpectacle>, 
							de 
							<Auteur>Pauline Mornet</Auteur>, notre <a href="presentation.php#label_carteBlanche">carte blanche</a>. 
						</li>
						<h2> navigation au coeur des spectacles</h2>
				
					<p>
					Dans la liste indiquant notre programmation un clic sur le titre du spectacle vous orientera directement vers son résumé et ses dates de représentations.
					Réprésentations que vous pourrez alors choisir de mettre dans le panier pour y réserver ensuite des places (dès la réservation ouverte).
					Quand un clic sur le nom de la compagnie vous redirigera vers son site web professionnel.
					Vous pouvez aussi accèder directement au détail d'un spectacle en cliquant simplement sur son affiche miniature.
					Pour revenir ici, il vous suffit de cliquer de nouveau sur l'onglet "spectacles" dans le menu du site.
					Vous pouvez aussi dérouler la description de tous les spectacles dans l'ordre alphabetique de titre via l'asenceur de votre navigateur. 
					</p>

				</div>


		<?php 
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$spectacle = "null";
				$tab = array();
				echo "<br/>\n";
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
