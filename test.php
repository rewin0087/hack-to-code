<?php //-->
	function factorial($var) {
		$number = 1;
				
		for($i = 1; $i <= $var; $i++) {
			$number = $number * $i;
		}	
		
		return $number;
	}
	
	function fibonacci($var) {
		// first number
		$st 	= 0;	
		// final total
		$final 	= 1;
		// temp value cache
		$temp 	= 0;
		// second value
		$nd 	= 1;
		
		// compute each until n
		for($i = 0; $i < $var; $i++) {
			// save first value
			$array['temp']['f'+$i] = $final;
			// add first number and second number (final = First + Second)
			$final = $st + $nd;
			// copy second number ( temp = Second)
			$temp 	= $nd;
			// save to cache temporary number for next add ( first = Second)
			$st 	= $temp;
			// move total to second number (First + Second)
			$nd 	= $final;
			
		}
		
		return $array;
	}
	
	function palindrume($string) {
		$condition 	= 'not a palindrum';
		$length 	= strlen($string);
		$tempstring = '';
		
		for($i = 0; $length >= $i; $length--) {
			// contatinate now the character (prevent offset)
			$tempstring .= !isset($string[$length]) ? NULL : $string[$length];
		}
		
		// check now if it is a palindrum
		if($string == $tempstring) {
			$condition = 'palindrum';
		}
		
		return $condition;	
	}

	function multiply($var) {
		$array = array();
		
		for($i = 1; $i <= $var; $i++) {
			for($j = 1; $j <= $var; $j++) {
				$array[$i.' * '.$j] = $i * $j;
			}
		}
		
		return $array;
	}
	
	function output($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';	
	}
	
	output(multiply(10));