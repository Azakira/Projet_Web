<?php 
	session_start();

	if(!isset($_POST['pay']) || !isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		//erreur: on arrive de nulle part OU panier vide / non initialisé
		header('Location: http://localhost/Projet_Web/panier.php');
		exit();
	}
	$handle = fopen("ResultatsFestival.csv", "r") or die('Fichier inexistant');
	$firstline = fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
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
	}
	fclose($handle);
	
	function convertHTML($str){
		$res = preg_replace_callback('([\s\S]+)', // /s => match espaces, /S => match all chars sauf espaces
			function ($match){
				$match = preg_replace("[&#44;]", ',', $match);
				$match = preg_replace("[&#146;]", "’", $match);
				implode($match); //concatene le tout
				return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
			},
			$str
		);
		return $res;
	}
	//modification des données avec le contenu du panier
	foreach($_SESSION['panier'] as $i => $com){
		foreach($tab as $j => $line){
			if (   $com['spectacle']['titre']  == convertHTML($line[2])
				&& $com['spectacle']['date']   == convertHTML($line[0])
				&& $com['spectacle']['heure']  == convertHTML($line[1])
				&& $com['spectacle']['lieu']   == convertHTML($line[3])
				&& $com['spectacle']['troupe'] == convertHTML($line[5])
				&& $com['spectacle']['ville']  == convertHTML($line[4])
			){
				$tab[$j][6] += $com['adulte']; //adulte
				$tab[$j][7] += $com['tarif_reduit']; //reduit
				// $tab[$j][8] += $com['offert']; //offert
				// $tab[$j][9] += ...//sj
				// $tab[$j][10] += ...//sa
				$tab[$j][11] += $com['enfant'];//enfant
			}
			
		}
	}
	
	//On remet les données modifiées dans le csv
	$handle2 = fopen("ResultatsFestival.csv", "w") or die('Veuillez fermer le .csv'); //!\NE MARCHE PAS SI LE CSV EST OUVERT
	
	foreach($tab as $i => $line){
		foreach($line as $j => $value){
			$tab[$i][$j] = convertHTML($value);
		}
	}
	
	fputcsv($handle2, $firstline,',');
	foreach($tab as $line){
		fputs($handle2, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		fputcsv($handle2, $line,',');
	}
	
	
					
?>


<html>
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
		<?php			
			print_r($tab);
		?>
	</body>
</html>
