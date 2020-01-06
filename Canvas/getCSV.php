 <?php

    /* Mette le type du document à text/javascript plutôt qu’à text/html */

    header("Content-type: text/javascript");

	$table = GetCSV();	
/*	echo '<pre>';
	print_r($table);
	echo '</pre>'; */
	//Renvoie le tableau vers Javascript
    echo json_encode($table);

	
	
	
//Fonction qui ouvre le fichier CSV contenant les informations des spectacles et les renvoie sous forme de tableau
/*
function GetCSV(){

$fic = fopen("ResultatsFestival.csv", "r");

	
	$Titre= array();		
//	Format du CSV :	Jour / Heure / TitreSepctacle / Lieu / Village / Comagnie / P / R / O / SJ / SA / E
	$tableau = array();
	while($tab=fgetcsv($fic,1024,',')){
	
		if(!$tableau[$tab[2]]){

			$tableau[$tab[2]] = array ( "P" => $tab[6], "R" => $tab[7], "O" => $tab[8], "SJ" => $tab[9], "SA" => $tab[10], "E" => $tab[11]);
			
		}else{	
		
		$temp = array ( "P" => $tab[6] + $tableau[$tab[2]]["P"], "R" => $tab[7] + $tableau[$tab[2]]["R"], "O" => $tab[8] + $tableau[$tab[2]]["O"], "SJ" => $tab[9] + $tableau[$tab[2]]["SJ"], "SA" => $tab[10] + $tableau[$tab[2]]["SA"], "E" => $tab[11] + $tableau[$tab[2]]["E"]);
		$tableau[$tab[2]]= $temp;
		
		}		
	}
	//On supprime la première ligne du CSV qui contient les Titres des colonnes
	unset($tableau[TitreSpectacle]);
	return $tableau;
}
*/

function GetCSV(){

$fic = fopen("ResultatsFestival.csv", "r");

	

//	Format du CSV :	Jour / Heure / TitreSepctacle / Lieu / Village / Comagnie / P / R / O / SJ / SA / E
	$tableau = array();
	$tab=fgetcsv($fic,1024,',');
	while($tab=fgetcsv($fic,1024,',')){
	
		if(empty($tableau[$tab[2]])){

			$tableau[$tab[2]] = array ( "P" => $tab[6], "R" => $tab[7], "O" => $tab[8], "SJ" => $tab[9], "SA" => $tab[10], "E" => $tab[11], "Recette" => (($tab[6]*15 + $tab[7]*10)*0.1), "Depenses" => ($tab[9]*12.5 + $tab[10]*9));
			
		}else{	
		
		$temp = array ( "P" => $tab[6] + $tableau[$tab[2]]["P"], "R" => $tab[7] + $tableau[$tab[2]]["R"], "O" => $tab[8] + $tableau[$tab[2]]["O"], "SJ" => intval($tab[9]) + $tableau[$tab[2]]["SJ"], "SA" => intval($tab[10]) + $tableau[$tab[2]]["SA"], "E" => $tab[11] + $tableau[$tab[2]]["E"], "Recette" => (($tab[6]*15 + $tab[7]*10)*0.1) + $tableau[$tab[2]]["Recette"], "Depenses" => (intval($tab[9])*12.5 + intval($tab[10])*9) + $tableau[$tab[2]]["Depenses"]);
		$tableau[$tab[2]]= $temp;
		
		}		
	}
	//On supprime la première ligne du CSV qui contient les Titres des colonnes
//	unset($tableau[TitreSpectacle]);

	fclose($fic);
	return $tableau;
	
}



?>
