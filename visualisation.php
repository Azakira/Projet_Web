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
					if (($handle1 = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
						if (($handle2 = fopen("ResultatsFestival.csv", "w")) !== FALSE) {
							fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
							while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {
								//on modifie les $data...
								fputcsv($handle2, $data) //et on les remet dans le csv
								
							}
							fclose($handle2);
						}
						fclose($handle1);
					}
				
				?>
			</div><!--  decalage -->	
		</main> 
	</body>
</html>
