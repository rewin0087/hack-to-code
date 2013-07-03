<?php //-->
	$html = file_get_contents('http://bridgestone-admin.beehive-digital.com/articles/search?keyword=TECHNOLOGY');
	
	function getImagesFromHtml($html) {
		preg_match_all('/<img[^>]+>/i',$html, $result);
		
		return $result;
	}
	
	function getImageAttributes($images) {
		$img = array();
		echo '<pre>';
		foreach($images[0] as $i => $image) {
			preg_match_all('/(alt|title|src)=("[^"]*")/i',$image, $img[$image]);
			
			$images[0][$i] = array('image' => $image,
				'src' => isset($img[$image][2][0]) && $img[$image][2][0] ? $img[$image][2][0] : '');
		}
		
		return $images[0];
	}
	
	function getImagesWithAttribFromHtml($html) {
		$images = getImagesFromHtml($html);
		
		return getImageAttributes($images);
	}
	print_r(getImagesWithAttribFromHtml($html));