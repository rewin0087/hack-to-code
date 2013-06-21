<?php //-->

	include 'phpqrcode/qrlib.php';
	
	$svg = QRcode::png('http://asclepius.hmi.ph/logine');
	
	print_r($svg);