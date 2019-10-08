<?php

	
	if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
		fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
		while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
			// foreach($data as $value) {
				
				// $fields = explode(",", $value);
				// for(int $i=0; $i<=11; $i++){
					// echo $fields[$i] . "<br />\n";
				// }
				// echo "<br />";
			// }
			
			foreach($data as $value) {
				
				$fields = explode(",", $value);
				echo $fields[0] . " ==> " . $fields[1] . "<br />\n";
				
			}
			
		}
		
		fclose($handle);
	}
	
	
?>