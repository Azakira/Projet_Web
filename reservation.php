<?php 
	session_start();
	if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
		$_SESSION['panier'] = array();
	}
	
	$titresSpectacles = array();
	
	if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
		fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
		$last_spec = "null";
		$tab = array();
		while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
		
			foreach($data as $value) {
				$replaced = preg_replace_callback(
					'/"(\\\\[\\\\"]|[^\\\\"])*"/',
					function ($match){
						$match = preg_replace("[,]", '&#44;', $match); //remplace les virgules par le symbole html
						$match = preg_replace("[\"]", '', $match); //retire les guillemets
						implode($match); //concatene le tout
						return $match[0]; //probleme: cree un tableau dont la 1ere case contient ce que l'on veut :/
					},
				$value
				);
							
				$replaced = preg_replace("[']", '&#146;', $replaced); //remplace les apostrophes par le symbole html
				
				$fields = preg_split("[,]", $replaced);
				array_push($tab, $fields);
			}
		}
		while(count($tab)>0){ 
			foreach($tab as $line){//parcourir le tableau pour chercher le nouveau $last_spec
				if($last_spec!= $line[2]){
					$last_spec = $line[2];
					break 1;
				}
			}
			$tab_asso = array(); //tableau pour mettre les spectacles en fonction du last_spec et est réinitialiser pour le prochain last_spec
			foreach($tab as $i => $line){
				if($tab[$i][2] == $last_spec){	 //si le titreDeSpectacle est égale au last_spec alors on met sa ligne le concernant dans tab_asso et on retire la ligne de tab
					array_push($tab_asso, $tab[$i]);
					unset($tab[$i]);
				}	
			}
			$titresSpectacles[$last_spec] = $tab_asso;
		}  
		ksort($titresSpectacles);
		
		$titres = array();
		foreach($titresSpectacles as $line){
			foreach($line as $elt){
				foreach($elt as $wtf){
					array_push($titres, $wtf);
				}
			}
		}
	}



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

	function distVille($tableau,$ville1,$ville2,$horaire){
		$distTime = array();
		$ind = -1;
		$cpt =1;
		switch ($ville1) {
			case 'Monétay sur Allier':
				$ville1 = "Monétay";
				break;
			case 'Monteignet sur l’Andelot':
				$ville1 = "Monteignet";
				break;			
		}

		switch ($ville2) {
			case 'Monétay sur Allier':
				$ville2 = "Monétay";
				break;
			case 'Monteignet sur l’Andelot':
				$ville2 = "Monteignet";
				break;
		}	

		foreach($tableau as $keyVille => $value1){
			if($keyVille == $ville1){

				$ind = $cpt;
				break 1;

			}else{ $cpt++; }

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
					$timeAndDistance = preg_split("[/]",$tableau[$ville1][$ind2]);
					print_r($timeAndDistance);
					$timeAndDistance[0]= intval($timeAndDistance[0]);
					$timeAndDistance[1]= intval($timeAndDistance[1]);
					$time=intval($timeAndDistance[1]);
					if($horaire >=17 and $horaire <=19)
						$timeAndDistance[1]+=$timeAndDistance[1]*0.1;

				}
				else{ $cpt2++; }
			}

			if($ind2 == -1){
				echo "La ville du 2eme spectacle n'existe pas,veuillez rééssayer SVP ";
			}
		}
		return $timeAndDistance;

	}		
		
	function mConvertH($time){
		return round($time/60,1); 
	}

	
	//code déplacé en haut pour pouvoir utilisé header(), devant être appelée avant tt affichage html
	
	if (isset($_POST['titre'])){ //si on vient de reserver un spectacle
		$spectacle = array(
			"titre" => $_POST['titre'],
			"date"  => $_POST['date'],
			"heure" => $_POST['heure'],
			"lieu"  => $_POST['lieu'],
			"troupe"=> $_POST['troupe'],
			"ville" => $_POST['ville']
		);
		$adulte = $enfant = $tarif_reduit = 0;
		$spectacleText = serialize($spectacle);
		$is_modified = "false";
	} else if (isset ($_POST['modify'])){ //si on vient de modifier (du panier)
			$commande = unserialize($_POST['modify']);
			$spectacle = $commande['spectacle'];
			$spectacleText = serialize($spectacle);
			
			$adulte = $commande['adulte'];
			$enfant = $commande['enfant'];
			$tarif_reduit = $commande['tarif_reduit'];
			
			$is_modified = "true";
	} else { //sinon (si on vient de nulle part) 
			// header('Location: http://localhost/Projet_Web/erreur.php');
			// exit();
		}
?>
<html>
	<head>
		<title>Festival Théâtres de Bourbon : Réservation</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
		<script src="reservation.js"></script>
		<!--Fancybox-->
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>
        <script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="fancybox/jquery.easing.1.4.1.js"></script>    
        <link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" /> 
        <style>	.panierFinal{	color:white;
								width:12%;
								text-align: center;
								position: fixed;
								top: 0%;
								right:0%
        			}
        </style> 

	</head>
	
	<body onload="hiddenDDL2(); hideSpec()">
		<div class="bandeau">
			<h1> Festival Théâtres de Bourbon : Réservation</h1>
		</div ><!--class="bandeau"-->

		<div class="panierFinal">
				<a href="panier.php"><img src="panier2.jpg" alt="imgPanier"></a>
				</br>
				<span>Panier</span>
		</div><!-- class="panierFinal"-->		

		<div class="menu">
			<ul class="navbar">
				<a href="index.php">Le site :</a>
                <li><a href="jours.php">Par jour</a></li>
                <li><a href="troupe.php">Par troupe </a></li>
                <li><a href="lieu.php">Par lieu</a></li>
                <li><a href="spectacle.php">Par spectacle</a></li>
                <li><a href="troupe.php">Par troupe</a></li>
                <li><a href="panier.php"> Panier</a> </li>  
			</ul>
		</div>

		<main>
			<div class="decalage">
				<br/>
		
				<?php
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
					
					function compareHTML($str1, $str2){
						$res = convertHTML($str2);
						if($res == $str1)
							return true;
						return false;
					}
					
					
					/**
					 *	TESTS
					 *	
					 **/
					
					
					echo "<select name='titre' id='titre' onchange='hiddenDDL2()'>\n";
					echo " <option disabled selected value> -- Veuillez sélectionner un spectacle -- </option>\n";
					foreach($titresSpectacles as $i => $val){
						echo "<option value='" . $i . "'";
						if(compareHTML($spectacle['titre'], $i))
							echo " selected";
						echo ">" . $i . "</option>\n";
					}
					echo "</select></br>\n";
					$i=0;
					foreach($titresSpectacles as $title => $representations){
						echo "<div id='" . $title . "'>\n";
						echo "<select ";
						/*
						if(!compareHTML($spectacle['titre'], $title))
							echo "hidden "; //conflict w/ javascript fun.
						*/
						echo "id='" . $i++ . "' onchange='selectSpec(this.value)'>\n";
						echo " <option selected disabled value=''> -- Veuillez sélectionner un spectacle -- </option>\n";
						foreach($representations as $rep){
							$spectacleDDL = array( //pour Spectacle Drop Down List
								"titre" => convertHTML($title),
								"date"  => convertHTML($rep[0]),
								"heure" => convertHTML($rep[1]),
								"lieu"  => convertHTML($rep[3]),
								"troupe"=> convertHTML($rep[5]),
								"ville" => convertHTML($rep[4])
							);
							
							echo "<option value='" . serialize($spectacleDDL) . "'";// au milieu
							//if($rep[0] == $spectacleDDL['date'] && $rep[1] == $spectacleDDL['heure'] && $rep[3] == $spectacleDDL['lieu'] && $rep[5] == $spectacleDDL['troupe'])
						if (   $spectacle['titre'] 	== $spectacleDDL['titre']
							&& $spectacle['date'] 	== $spectacleDDL['date'] 
							&& $spectacle['heure'] 	== $spectacleDDL['heure'] 
							&& $spectacle['lieu']	== $spectacleDDL['lieu'])
							echo " selected";
							
							echo ">";
							
							// echo "<!-- " . $spectacle['lieu'] . " | " . $spectacleDDL['lieu'] . "-->";
							//echo "<!-- " . (($spectacle['lieu']==$spectacleDDL['lieu']) ? "true" : "false") . " -->";
							
							echo "Le " . $rep[0] . " " . " à " . $rep[1] . ", " . "au " . $rep[3] . " à " . $rep[4] . ", par " . $rep[5] . "<br/>\n";
							echo "</option>\n";
							// echo "<!--" . serialize($spectacleDDL). " || " . $spectacleText . " -->";
							//distVille($villeAsso,$rep[4])
						}
						echo "</select>\n</div><!--id=\"" . $title . "\"-->\n";
					}


					//TODO: RESIZE INPUTS NUMBER W/ CSS
					echo "<form id='panier' action='panier.php' method='POST'>\n";
					
					echo "<table><thead><tr> <th>Type de place</th>\n <th>nb de places</th>\n <th>Prix Unitaire</th><tr></thead>\n"; 

					echo "<tr>";
					echo " <td> Places adulte: </td>";					
					echo "<td> <button type='button' onclick='if (document.getElementById(\"adulte\").value > 0) {document.getElementById(\"adulte\").value--}'> - </button>\n";
					echo "<input id='adulte' type='number' name='adulte' value='" . $adulte . "' min='0' required>\n";
					echo "<button type='button' onclick='document.getElementById(\"adulte\").value++'> + </button></br></td>\n";
					echo "<td align ='center'> 15 € </td></tr>\n";
										
					echo "<tr>";
					echo " <td> Places enfant: </td>";
					echo "<td> <button type='button' onclick='if (document.getElementById(\"enfant\").value > 0) {document.getElementById(\"enfant\").value--}'> - </button>\n";
					echo "<input id='enfant' type='number' name='enfant' value='" . $enfant . "'min='0' required>\n";
					echo "<button type='button' onclick='document.getElementById(\"enfant\").value++'> + </button></br></td>\n";
					echo "<td align ='center'> 0 € </td></tr>\n";
					
					echo "<tr>";
					echo "<td> Places tarif réduit: </td>";
					echo"<td> <button type='button' onclick='if (document.getElementById(\"tarif_reduit\").value > 0) {document.getElementById(\"tarif_reduit\").value--}'> - </button>\n";
					echo "<input id='tarif_reduit' type='number' name='tarif_reduit' value='" . $tarif_reduit . "' min='0' required>\n";
					echo "<button type='button' onclick='document.getElementById(\"tarif_reduit\").value++'> + </button></br></td>\n";
					echo "<td align='center'> 10 € </td></tr>\n";
					echo "<input required id='spectacle' name='spectacle' type='text' size='100' value='" . $spectacleText ."'>";
					 // le pb avec spectacleText est si le client réserve un spectacle d'une page qquonque mais décide de modifié et prends Barbara ou Tratuffe au moment de réserver, on n'envoie rien au panier
						
					echo "<input name='is_modified' type='hidden' value='" . $is_modified ."'>"; //on envoie $is_modified en hidden: false=reservation normale, true=modification
					


					echo "</table>\n";
					echo "<input type='submit' type='hidden' value='Réserver'>\n";
					echo "</form>\n";


					
					$arrayTestSpec = unserialize($spectacleText);
					
					$arrayDistTime = array();
					foreach ($_SESSION['panier'] as $t => $com) {
						if($arrayTestSpec["date"]==$com["spectacle"]["date"]){
							$arrayDistTime = distVille($villeAsso,$arrayTestSpec["ville"],$com["spectacle"]["ville"],intval($arrayTestSpec["heure"]));
							//var_dump(intval($arrayTestSpec["heure"]) +2+ mConvertH($arrayDistTime[1]));
							//var_dump($arrayTestSpec["ville"]);
							
							$limitTime1 = intval($arrayTestSpec["heure"]) + 2  + mConvertH($arrayDistTime[1]);
							$limitTime2 = intval($arrayTestSpec["heure"]) - 2  - mConvertH($arrayDistTime[1]);

							// var_dump($limitTime);
							// var_dump(intval($com["spectacle"]["heure"]));

							if(intval($arrayTestSpec["heure"]) == intval($com["spectacle"]["heure"]) && $arrayTestSpec["titre"] == $com["spectacle"]["titre"] && $arrayTestSpec["date"] == $com["spectacle"]["date"] && !isset($_POST['modify'])){
								echo "<script language=\"javascript\">" . "alert('Attention vous avez sélectionner un spectacle que vous avez déjà dans votre panier');"."</script>";

							}else{

								if(intval($arrayTestSpec["heure"] <= $com["spectacle"]["heure"]) && is_null($_POST['modify'])){
									if($limitTime1 > intval($com["spectacle"]["heure"])){
										echo "<script language=\"javascript\">" . "alert('Attention vous avez un spectacle après que vous allez chevauché ');"."</script>";
									}
								} else{
									if($limitTime2 < intval($com["spectacle"]["heure"])&& is_null($_POST['modify'])){
										echo "<script language=\"javascript\">" . "alert('Attention vous avez un spectacle avant qui chevauche celui choisi ');"."</script>";
									}
								}
							echo "</br>";
							}
						}
 				
					}	
					$nbPlace=0;
					$tr=0;
					foreach ($_SESSION['panier'] as $co) {
						$nbPlace += intval($co['adulte']) + intval($co['enfant']) + intval($co['tarif_reduit']);
						if(intval($co['tarif_reduit'])!=0)
							$tr++;

				}
				
					
				?>
				<script type="text/javascript">
					    $(function() {
					 
					      $('#fermer').click(function(){
					             $.ajax({
					        type: "POST",
					        url: "panier.php",
					                success : parent.jQuery.fancybox.close()
					    });
					               
					          });
					           
					            
					    });
					</script>
					<div class="Lieu">
					<section class="proseTarif">
						<section><!-- Présentation des tarifs -->

							<h1 id="label_Prose">Notre PROSE tarifaire</h1>
								<h2> Mise en vente </h2>
								<p>
									
									<!-- Les billets seront ouverts à la vente sur internet à une date communiquée ultérieurement 
									(les spectateurs seront alors invités à imprimer eux-mêmes chaque billet acheté), 
									et en prévente à partir du 1er juin dans les offices 
									du tourisme de la Communauté de Communes de St Pourçain - Sioule - Limagne.
									Des billets seront bien évidemment également disponibles sur place pendant toute la durée du festival 
									dans les trois villages qui accueillent des représentations&#8239;: Manoir des noix à Veauce, Château de Lachaise à Monnetay sur Allier, 
									Chateau d'Idogne à Monteignet sur l'Andelot, 
									mais exclusivement  pour les représentations qui y auront dans le village, et dans la mesure des places encore disponibles.-->
									Les billets sont exclusivement disponibles sur place pendant toute la durée du festival du 2 au 6 août 2019
									dans les trois villages qui accueillent des représentations : Veauce (Manoir des noix et Eglise), Monétay sur Allier (Château de Lachaise) et 
									Monteignet sur l'Andelot (Château d'Idogne et domaine de La Quéyre), jusqu'à la dernière minute pour les représentations qui y auront dans le même village et jusqu'à la veille pour les représentations dans des villages différents.
									</p>

								<p>	La représentation du 6 août au CNCS de Moulins étant avancée à 20h00 (par rapport à l'information transmise sur votre flyer), la vente aura lieu du 2 au 5 août dans les villages susnommés et sur place dès 19h00 le 6 août 2019.  

								</p>

								<p> Sont acceptés les paiements en espèces, les chèques sur présentation d'une pièce d'identité au même nom et dans la mesure du fonctionnement du réseau cellulaire et d'une surtaxe de 1 euro par transaction les paiements par carte bancaire. En cas d'achat groupé un billet est offert dès 5 billets payés. 
								</p>

								<h2> P : tarif Plein : 15 euros,</h2>
								<h2> R : tarif Réduit : 10 euros (-26 ans, chomeurs, handicapés),</h2>
								<h2> O : un billet Offert pour cinq billets payants 
								</h2><h2> S : invitation Spéciale pour les membres bienfaiteurs du festival
								</h2><h2> E : Enfant gratuit (-12 ans)  </h2>

								<p> 
									Le <b>tarif plein</b> concerne la majorité des adultes; il est fixé à <b>15 euros TTC</b>.
								</p>

								<p> 
								   Le <b>tarif réduit</b> concerne les jeunes de plus de 12 ans et de moins de 26 ans au premier jour du festival 
								   et les adultes pouvant justifier d'une situation sociale particulière (chômeurs, bénéficiaires des minima sociaux, handicapés). 
								</p>

								<p> 
									Le tarif réduit est fixé pour tous les spectacles à <b>10 euros TTC</b>. 
								</p>

								<p> 
									Les mineurs de 12 ans accompagnés ont droit à un billet gratuit dans la limite d’un billet gratuit 
									pour un billet payant 
									(les autres enfants qui viennent en groupes accompagnés se voient appliquer le tarif réduit, 
									même si certains ont moins de 12 ans). 
									Ceux qui ne sont pas accompagnés d'au moins un responsable de plus de 16 ans ne sont pas acceptés.
								</p>

								<p> 
									Les achats en nombre ne peuvent dépasser 12 billets à la fois. Lors d'un achat en nombre, 
									l’achat de 5 billets donne droit à un sixième billet gratuit, au choix du client, 
									mais dans la catégorie payée la moins chère.
								</p>
								<p> 
									Pour assiter à un spectacle, chaque spectateur  doit être porteur d'un billet individuel indiquant le titre du spectacle, 
									sa date, son horaire et le lieu de la représentation. 
								</p> 							
						</section> <!-- Présentation des tarifs -->
				
						<section><!-- Explication des tarifs -->
							<h1 id="label_Philosophie"> Notre philosophie tarifaire </h1>
					
							<section><!-- qualité des spectacles et des lieux -->	
								<h2> La qualité du spectacle avant tout, mais pour tous!</h2>
								<p>
									Le but du festival "Théâtres de Bourbon" est de permettre à un large public d'accéder 
									à un théâtre professionnel de qualité dans un cadre patrimonial de qualité. 
									C’est pourquoi les tarifs pratiqués sont en dessous de ceux habituels dans les théâtres classiques 
									et qu’un grand nombre de catégories ayant difficilement accès au théâtre ont accès à un tarif réduit 
									substantiellement inférieur au plein tarif.
									Comme le festival se veut au service des troupes et comme un instrument de mise en valeur de leur travail, 
									propre à servir l’étendue de leur identité et les différentes facettes  de leur jeu, 90% du produit de la billetterie 
									leur est directement et intégralement reversé.
									Tout ceci n’est possible que grâce au triple soutien des bénévoles, des lieux d'accueil et des puissances publiques 
									qui nous subventionnent, au premier rang desquelles la Communauté de Communes de St Pourçain-Sioule-Limagne. 
									Les 3 hôtes du festival (les châteaux de Lachaise, d'Idogne et le manoir des noix) ne se contentent en effet 
									pas d’ouvrir leur propriétés pour permettre les représentations en plein air. Ils sont partie prenante dans le projet 
									de festival sans contre partie financière.
								</p>
							</section><!-- qualité des spectacles et des lieux -->	
							
						
					
							
							<section><!-- Présentation de l'association -->
								<h1 id="label_Contexte"> 	Notre contexte tarifaire </h1>
							
								<h2> 	Théâtres de Bourbon est une association à but non lucratif </h2>
								<p>	
									<img class="vignette" src="logo.png" alt="[logo de l&#39;association]" width="20%" height="20%" decoding="low">		
									</br>
									Fondée par un groupe de 34 bénévoles, l'association théâtres de Bourbon est une association loi 1901 à but entièrement non lucratif. 
									Chaque bénévole y donne de son temps (et de son argent) pour que tous puissent profiter du patrimoine de l'Allier et 
									d'un théâtre de qualité qui met l'homme au centre du projet. 
									Les comptes sont gérés minutieusement et en toute transparence.
								</p>
							</section><!-- Présentation de l'association -->
							
							
							
							
							
							
							<section><!--Financeurs-->
							
								<h2 id="label_aides"> Ils nous soutiennent </h2>
							
								<p>Châteaux de Lachaise et d'Idogne </p>
								<p>Centre national du costume de scène (CNCS)</p>
								<p>Domaine de la Quéyrie</p>
								<p>Manoir des noix à Veauce</p>
								<p>Mairie de Veauce</p>

								<p> Communauté de commune de Saint Pourcain la Sioule
									</p>
										<div> <a href="http://www.comcompayssaintpourcinois.fr/" target="_blank" rel="noopener noreferrer">
											  		<img src="imgSponsorLogoCommunauteCommune.jpg" alt="[ LogoCommunautéDeCommune]" width="50%" height="50%" decoding="low"> 
											   </a>
										</div>
								<p></p>
								<p> Centre National su costume de scène Moulins
								</p>
								<div> 
										<a href="http://www.www.cncs.fr/" target="_blank" rel="noopener noreferrer">
											<img src="imgLogoCNCS.jpg" alt="[ LogoCNCS]" width="50%" height="50%"> 
										</a>
								</div>
								<p></p>
						
							</section><!--Financeurs-->
						</section><!-- Explication des tarifs -->

					</section><!--section class="proseTarif"-->	
				</div>

			</div><!--class=\"decalage\"-->
		</main>
		
	</body>

</html>
