<?php 
	session_start();
	if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}
?>
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
				<a href="index.php">Le site :</a>
				<li>Qui sommes nous?</li>
				<li><a href="jours.php">Jour par Jour</a></li>
				<li><a href="lieu.php">Lieu par Lieu</a></li>	
				<li><a href="spectacle.php">Spectacles</a></li>
				<li>Tarifs</li>
			</ul>			
		</div>
		
		<main>
			<section>
				<div class="decalage">
					<h2> Quatres demeures de l'Allier, un musée et une église vous ouvrent leurs grilles pour assister aux représentations théâtrales.
					</h2>
					<p>Coissisez un lieu en cliquant sur son bouton (dans le menu de la page) pour voir la programmation qu'il accueille puis selectionnez les spectacles qui s'y jouent et vous intéresse.
					</p>
					<figure> <img src="mapCastle.jpg" alt= "Infographie des châteaux dans le département" width="100%" height="100%">
					</figure>
					<br/>
					<?php 
					
					if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
						fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
						$lieu = "null";
						$tab = array();
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
						//Boucle pour l'affichage html
						foreach($sort_lieu as $line){
							
							if($lieu != $line[3]){
								if($lieu != "null"){
									echo "</table>\n";
									echo "</div><!--class=\"Lieu\"-->\n";
								}
								$lieu = $line[3];
								echo "<div class=\"Lieu\">\n";
								echo "<h2> " . $lieu . ", " . $line[4] . "</h2>\n";
								echo "<table>\n";
							}
							
							echo "<tr>\n<td>\n";
							echo "<Horaire> Le " . $line[0] . " " . " à " . $line[1] . "</Horaire>, " . "<titreSpectacle>". $line[2] . "</titreSpectacle> par <troupe>" . $line[5] . "</troupe><br/>\n</td>\n";
							echo "<td> \n";
							echo "<form action='reservation.php' method='post'>\n";
							echo "<input type=\"submit\" value=\"Reserver\">\n";
							echo "<input name='titre' type=hidden value=\"" . $line[2] . "\">\n";
							echo "<input name='date' type=hidden value=\"" . $line[0] . "\">\n";
							echo "<input name='heure' type=hidden value=\"" . $line[1] . "\">\n";
							echo "<input name='lieu' type=hidden value=\"" . $line[3] . "\">\n";
							echo "<input name='ville' type=hidden value=\"" . $fields[4] . "\">\n";
							echo "<input name='troupe' type=hidden value=\"" . $line[5] . "\">\n";
							echo "\n</form> \n</td> \n</tr>\n";
						}
						echo "</table>\n";
						fclose($handle);
					}
				?>
			</div><!--class=\"decalage\"-->
		</main>
	</body>

</html>
