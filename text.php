<?php //-->
	$query 	= array('api' => 'uYfzrqspkVfEBXYSMeWZ', 'number' => $_GET['n'],
			'message'	=> $_GET['m']);
	$url 	= 'https://fireflyapi.com/api/sms';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);
	
	print_r($result);