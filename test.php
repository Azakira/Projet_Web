<html>
				<head>
            		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
				</head>

			<?php


				session_start();
				if(!isset($_SESSION['panier']) || empty($_SESSION['panier'])){
					$_SESSION['panier'] = array();
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






