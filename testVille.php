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
									Attention! à Moulins le début du spectacle à 20h00. </table></div>
									<!-- class="petitPanier"-->							
										<!-- <h1> Festival Théâtres de Bourbon </h1> -->
		</div ><!--class="bandeau"-->



<?php

		if(($handle = fopen("distanceVille.csv", "r")) !== FALSE) {
			fgetcsv($handle, 1000, ",");
				$tab = array();
				while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
							
					foreach($data as $value) {
	        			$fields = preg_split("[,]", $value);
	        			array_push($tab, $fields);
	        		}

				}
			
    		fclose($handle);
		}


		$villeAsso = array();

		$indVille="";
		foreach ($tab as $line) {
			if($indVille!=$line[0]){
				$indVille=$line[0];
				$villeAsso[$indVille] = $line;
			}

		}

		function distVille($tableau,$ville1,$ville2){
			$ind = -1;
			$cpt =1;
			foreach($tableau as $keyVille => $value1){
				if($keyVille == $ville1){
					$ind = $cpt;
					break 1;
				}else{
					$cpt++;
				}
			}
			if($ind == -1){
				echo "La ville de votre 1er spectacle n'existe pas,veuillez rééssayer pls ";
			}
			else {
				$cpt2=1;
				$ind2=-1;
				foreach($tableau as $keyVille2 => $value2){
					 if($keyVille2 == $ville2){
					 	$ind2 = $cpt2;
						//return $tableau[$ville1][$ind2];
						return $timeAndDistance = preg_split("[/]",$tableau[$ville1][$ind2]);

					}else{$cpt2++; }
				}
				if($ind2 == -1){
					echo "La ville du 2eme spectacle n'existe pas,veuillez rééssayer pls ";
				}
			}

		}
			distVille($villeAsso,"Monteignet","Clermont-Ferrand");


?>


	</body>	
</html>