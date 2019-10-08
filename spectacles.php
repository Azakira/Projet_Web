<html>
	<head>
		<title>Theatres de Bourbon</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styleTheatresDeBourbonPourPHP.css">
	</head>
	
	<body>
		<div class="bandeau">						
			<h1> Festival Théâtres de Bourbon </h1>
		</div ><!--class="bandeau"-->
		
		<?php 
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
					
				foreach($data as $value) {
					$exp = '/[,^","]/';
					$fields = preg_split($exp, $value);
					if($jour != $fields[0]){
						$jour = $fields[0];
						echo "<h2> " . $jour . "</h2>";
					}
					echo "<div class= \"Lieu\">\n";
					echo $fields[2] . ", par " . $fields[5] . " à " . $fields[4] . "\n</div>\n";
					
				
			}
			
		}
		
		fclose($handle);
	}
		?>
	</body>

</html>