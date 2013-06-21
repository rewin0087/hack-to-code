<?php  //-->
	
	$html = file_get_contents('peme.html');
//	echo $html;exit;
	include("MPDF56/mpdf.php");

	function pdf($html) {
		$mpdf=new mPDF('c'); 

		$mpdf->WriteHTML($html);
		
		return $mpdf->Output();
		
		}	
	
	class Me {
		
		public function pdf($html) {
			$mpdf=new mPDF('c'); 
		
			$mpdf->WriteHTML($html);
			
			return $mpdf->Output();
		
		}	
	}

	$pdf = new Me();
	$pdf->pdf($html);