			<html>
				<head>
            		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
				</head>

			<?php


				session_start();
				if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
					$_SESSION['panier'] = array();
				 }


						if (isset($_POST['spectacle'])){
							$commande = array(
								"spectacle"   => unserialize($_POST['spectacle']),
								"adulte"	  => $_POST['adulte'],
								"enfant"	  => $_POST['enfant'],
								"tarif_reduit"=> $_POST['tarif_reduit']
							);
							
							if($_POST['is_modified'] == "true"){ 					//si commande modifiee
								foreach($_SESSION['panier'] as $i => $com){
									if ($com['spectacle'] == $commande['spectacle']){
										unset($_SESSION['panier'][$i]);			//on supprime la ligne correspondante dans le panier
									}
								}
							} else { 											//sinon normal
								foreach($_SESSION['panier'] as $i => $com){
									if ($com['spectacle'] == $commande['spectacle']){
										$commande['adulte'] = $com['adulte']+$commande['adulte'];
										$commande['enfant'] = $com['enfant']+$commande['enfant'];
										$commande['tarif_reduit'] = $com['tarif_reduit']+$commande['tarif_reduit'];
										unset($_SESSION['panier'][$i]);
									}
								}
							}
							if ($commande['adulte']+$commande['enfant']+$commande['tarif_reduit']>0)
								array_push($_SESSION['panier'], $commande); //si commande a 0 tickets, on ne push pas
						}

						foreach ($_SESSION['panier'] as $tab) {
							echo $tab['adulte']." ".$tab['tarif_reduit']." ".$tab['enfant'];
							echo '<br>';
							
						}
					    echo 'ok but XTF';
						print_r($_SESSION['Panier']);

				 ?>
				 	<script language="JavaScript" 
						type= "text/JavaScript"
					>
					</script>

			</html>
				<!-- echo "<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>";
		        echo "<script type='text/javascript' src='fancybox/jquery.fancybox-1.3.4.pack.js'></script>";
			    echo "<script type='text/javascript' src='fancybox/jquery.easing-1.3.pack.js'></script>";
		        echo "<link rel='stylesheet' href='fancybox/jquery.fancybox-1.3.4.css' type='text/css' media='screen' />" ; -->






