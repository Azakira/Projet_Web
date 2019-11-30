<?php 
					if(($handle = fopen("distanceVille.csv", "r")) !== FALSE) {
					fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
					$spectacle = "null";
					$tab = array();
					while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
						
						foreach($data as $value) {
							$replaced = preg_replace_callback( // pour résoudre le problème de Barbara
								'/"(\\\\[\\\\"]|[^\\\\"])*"/',
								function ($match){
										$match = preg_replace("[,]", '&#44;', $match); //remplace les virgules par le symbole html
										$match = preg_replace("[\"]", '', $match); //retire les guillemets
										implode($match); //concatene le tout
										return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
								},
								$value = $
							);
		?>
		    <html>
	
	<!-- Affichage Dans l'onglet et choix des caractères-->
      <head>
        <title> Theatres de Bourbon&#8239;; Accueil</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
      </head>
	  
	
	 
	 <!-- Corps de la page-->
      <body>
		<div class="bandeau">
			 <div class="petitPanier"><table>Billets en vente exclusivement sur les lieux du festival: Monétay, Monteignet, Veauce  du 2 au 6 août dès 11h00 et le 6 août à Moulins de 19h00 à 20h00.
									Attention! à Moulins le début du spectacle à 20h00. </table></div><!-- class="petitPanier"-->							
										<h1> Festival Théâtres de Bourbon </h1>
		</div ><!--class="bandeau"-->


	</body>	
</html>