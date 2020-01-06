<?php 
	session_start();
?>

<!DOCTYPE html>	
<html>
	<head>
		<title>Theatres de Bourbon</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
	  	<div class="bandeau">
			<div class="petitPanier">
				<table>Billets en vente exclusivement sur les lieux du festival: Monétay,Monteignet, Veauce  du 2 au 6 août dès 11h00 et le 6 août à Moulins de 19h00 à 20h00.
					Attention! à Moulins le début du spectacle à 20h00.
				</table>
			</div><!-- class="petitPanier"-->							
			<h1> Festival Théâtres de Bourbon </h1>
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
				<?php 
					/*CODE A METTRE DANS LE PANIER APRES CONFIRMATION DU PAYEMENT*/
					if (($handle = fopen("ResultatsFestival2.csv", "r")) !== FALSE) { //r+ -> lecture et ecriture
							fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
							$tab = array();
							while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
								$line = array();				
								foreach($data as $value){
									$value = preg_replace_callback(
										'/"(\\\\[\\\\"]|[^\\\\"])*"/',
										function ($match){
											$match = preg_replace("[,]", '&#44;', $match); //remplace les virgules par le symbole html
											$match = preg_replace("[\"]", '', $match); //retire les guillemets
											implode($match); //concatene le tout
											return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
										},
										$value
									);
									
									$value = preg_replace("[']", '&#146;', $value); //remplace les apostrophes par le symbole html
									$fields = preg_split("[,]", $value);
									array_push($tab, $fields);
								}
								//array_push($tab, $line);
								//fputcsv($handle, $data); //et on les remet dans le csv
							}
						fclose($handle);
						echo "<p>";
						foreach ($tab as $line){
								foreach($line as $i => $val){
									echo $val . " (" . $i . "); ";
								}
							echo "</p>\n";
						}
						
					}
					
					
				?>
			</div><!--  decalage -->	
		</main> 
	</body>
</html>
