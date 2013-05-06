<?php


	function curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}

	function getState($zip) {
		$content = curl("http://zip.elevenbasetwo.com/v2/".$zip);
		$array = json_decode($content, true);
		
		return $array['state'] != '' ? $array['state'] : '0';
	}
	
	// putting data to csv
	function putToCsv($array) {
		// set the path and the name of the file to be save
		$file = 'csv/csv-'.date('Y-m-d-H:i:s').'.csv';
		// open the file the we have created
		$csv = fopen($file,"w");
		// now get the array and get the data by index and put now to csv
		foreach($array as $fields) {
			
			fputcsv($csv, $fields);
		}
		// close now the file
		fclose($csv);
	
	}
	
	// getting data before putting to csv
	function getCsv($file) {
		$row = 1;
		// lets open the file to get the data from csv
		if (($handle = fopen($file, "r")) !== FALSE) {
			// lets create an output on the browser so we can see the lines/ data that our code see inside the file
			echo '<table border="1" width="100" cellpadding="5" cellspacing="10">';
			
			// after we open the file parse it line by line
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				// count the total line the the csv file have
				$num = count($data);
				$row++;
				
				
				echo '<tr>';
				$state = $data[7];
				if(!empty($data[5]) && $data[7] == '0') {
					
					if($state =='') {
						$state = 'test';	
					}
				}
				
				// now since csv cannot start with a zero value, if total length is equal to 4, lets prepend a zero the data
				$data[5] = strlen($data[5]) == 4 ? '0'.$data[5] : $data[5];
				
				// lest check if data index 7 if data index 7 is equal to zero, and has length of 1 lest run the api function to get a data
				$state = ($data[7] == 0) && (strlen($data[7]) == 1)  ? getState($data[5]) : $data[7];
						// create an output to see the changes
						echo '<td>'.$data[0].'</td>';
						echo '<td>'.$data[1].'</td>';
						echo '<td>'.$data[2].'</td>';
						echo '<td>'.$data[3].'</td>';
						echo '<td>'.$data[4].'</td>';
						echo '<td>'.$data[5].'</td>';
						echo '<td>'.$data[6].'</td>';					
						echo '<td>'.$state.'</td>';
						echo '<td>'.$data[8].'</td>';
				// lets save it to session and a global array variable so later we can see the final output	adn used on the next process
				$_SESSION['csv'][] = $newCsv['csv'][] = array($data[0], $data[1], $data[2], $data[3], 
															  $data[4], $data[5], $data[6], $state, $data[8]);
				echo '</tr>';
			}
			echo '</table>';
			
			// now lest close the file
			fclose($handle);
		}
	}

$newCsv = array();
if(isset($_POST['file'])) {
	$file = $_FILES['csv']['tmp_name'];
	getCsv($file);
}

if(!empty($newCsv)) {
	putToCsv($newCsv['csv']);	
}

?>
<form method="post" enctype="multipart/form-data">
<input type="file" name="csv" />
<input type="submit" name="file" />
</form> 
