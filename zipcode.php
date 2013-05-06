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
		$file = 'csv/csv-'.date('Y-m-d-H:i:s').'.csv';
		$csv = fopen($file,"w");
		
		foreach($array as $fields) {
			
			fputcsv($csv, $fields);
		}
	
		fclose($csv);
	
	}
	
	// getting data before putting to csv
	function getCsv($file) {
		$row = 1;
		if (($handle = fopen($file, "r")) !== FALSE) {
			echo '<table border="1" width="100" cellpadding="5" cellspacing="10">';
			
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				$row++;
				
				echo '<tr>';
				$state = $data[7];
				if(!empty($data[5]) && $data[7] == '0') {
					
					if($state =='') {
						$state = 'test';	
					}
				}
				$data[5] = strlen($data[5]) == 4 ? '0'.$data[5] : $data[5];
				$state = ($data[7] == 0) && (strlen($data[7]) == 1)  ? getState($data[5]) : $data[7];
				
						echo '<td>'.$data[0].'</td>';
						echo '<td>'.$data[1].'</td>';
						echo '<td>'.$data[2].'</td>';
						echo '<td>'.$data[3].'</td>';
						echo '<td>'.$data[4].'</td>';
						echo '<td>'.$data[5].'</td>';
						echo '<td>'.$data[6].'</td>';					
						echo '<td>'.$state.'</td>';
						echo '<td>'.$data[8].'</td>';
						
				$_SESSION['csv'][] = $newCsv['csv'][] = array($data[0], $data[1], $data[2], $data[3], 
															  $data[4], $data[5], $data[6], $state, $data[8]);
				echo '</tr>';
			}
			echo '</table>';
			
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
