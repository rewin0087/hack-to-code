<?php //-->
	function factorial($var) {
		$number = 1;
				
		for($i = 1; $i <= $var; $i++) {
			$number = $number * $i;
		}	
		
		return $number;
	}
	
	function fibonacci($n) {
	    $total = 1;
	    $first_n = 0;
	    $second_n = 1;
	    $sequence = [0];
	
	    for($i = 0; $i < $n; $i++) {
	        $sequence[] = $total;
	        $total = $sequence[$i] + $sequence[$i + 1];
	    }
	
	    return implode($sequence, " , ");
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
