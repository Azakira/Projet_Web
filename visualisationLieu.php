<?php 
	header("Content-type: text/javascript");
		$lieuCSV = csvLieu();
	 echo json_encode($lieuCSV);

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


			function csvLieu(){
					/*CODE A METTRE DANS LE PANIER APRES CONFIRMATION DU PAYEMENT*/
					if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) { //r+ -> lecture et ecriture
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
						
					}
						$specTab = array();
						foreach ($tab as $line){
									if(empty($specTab[$line[3]])){
										 $specTab[$line[3]] = array ( "P" => intval($line[6]), 
										 							  "R" => intval($line[7]), 
										 							  "O" => intval($line[8]), 
										 							  "SJ" => intval($line[9]), 
										 							  "SA" => intval($line[10]), 
										 							  "E" => intval($line[11]), 
										 							  "Recette" => ((intval($line[6])*15 + intval($line[7])*10)*0.1), 
										 							  "Depenses" => (intval($line[9])*12.5 + intval($line[10])*9));
            
       								} else{    
								        
								        $add = array ("P" => intval($line[6]) + $specTab[$line[3]]["P"], 
													  "R" => intval($line[7]) + $specTab[$line[3]]["R"], 
													  "O" => intval($line[8]) + $specTab[$line[3]]["O"], 
													  "SJ" => intval($line[9]) + $specTab[$line[3]]["SJ"], 
													  "SA" => intval($line[10]) + $specTab[$line[3]]["SA"], 
													  "E" => intval($line[11]) + $specTab[$line[3]]["E"], 
													  "Recette" => ((intval($line[6])*15 + intval($line[7])*10)*0.1) + $specTab[$line[3]]["Recette"], 
													  "Depenses" => ((intval($line[9]))*12.5 + (intval($line[10])*9) + $specTab[$line[3]]["Depenses"]));
								        $specTab[$line[3]]= $add;
								    }      
						}
						fclose($handle);
						// $res = array();
						// foreach($specTab as $spec => $line){
						// 	$spec2=html_entity_decode($spec);
						// 	if(empty($res[$spec2])){
						// 		$res[$spec2] = $line;

							//}
						//}

						return $specTab;
				}
					
				?>