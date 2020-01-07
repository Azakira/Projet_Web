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
				<a href="index.html">Le site :</a>
                <li><a href="jours.php">Jour</a></li>
                <li><a href="troupe.php">Troupe</a></li>
                <li><a href=".lieu.php">Lieu</a></li>
                <li><a href="spectacle.php">Spectacle</a></li>
                <li><a href="troupe.php">troupe</a></li>
                <li><a href="panier.php"> Panier</a> </li>   
                <li><a href="depenses.html"> depenses par Representation</a> </li>   
                <li><a href="depensesLieu.html"> depenses par Lieu</a> </li>  
                <li><a href="depensesTroupe.html"> depenses par Troupe</a> </li> 
			</ul>			
		</div>
		<main>
			<div class="decalage">
				<h1> <a href="Festival2018ProgrammationVueGlobale.php">Du 2 au 6 août 2019</a>
			 	</h1>
					<h2> <a href="spectacle.php">Une quinzaine de spectacles</a>, 
					<a href="jours.php">une quarantaine de représentations</a>
					</h2>
					<h2>Des plus grands auteurs 
					(<!--mettre lien--> Molière<!---->,					
					<!--mettre autre lien-->Shakespeare
					<!--</a>-->...) 
					aux créations <a href="spectacle.php#labelSpectacle1">les plus originales	</a>,
					</h2>
				<h2> En plein air, les pieds dans l'herbe mais dans 
					<a href="lieu.php">des cadres exceptionnels</a>, 
				</h2>
				<h2> <a href="tarif.php">en toute simplicité</a>, chaleur et convivialité, 
				<a href="lieu.php">au cœur de la France</a>.
				</h2>

				<h1> <a href="InComingMaybeWhenWeWillHaveTimeToSpendOnIt.php">Changeons quelque chose à notre vie&#8239;!</a>
				</h1>
				<h2 class="adroite">
					<a href="presentation.php">Théâtres de bourbon</a>
				</h2>
				<div class="adroite"> 
					<a href="index.php">
						<img class="petiteVignette" src="logo.jpg" alt="[logo de l'association vers l'accueil du site]"width=100% height=100% decoding=low>
					</a>	
				</div><!--  adroite -->

				information de derniere minute: à cause du spectacle de son et lumiere de Moulins, la représentation de Tartuffe ou l'imposteur au CNCS de Moulins le 6 août 2019 initialement prévu à 20h30 est avancé à 20h00. 
		
				<iframe src="images/PdfFlyerA4RectoVerso.pdf" width="640" height="480"></iframe>
			</div><!--  decalage -->	
		</main> 
	</body>
</html>
