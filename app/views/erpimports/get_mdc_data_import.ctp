<?php 
	/** Include PHPExcel */
	require_once VENDORS.'PHPExcel'.DS.'PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("w")
							 ->setLastModifiedBy("")
							 ->setTitle("")
							 ->setSubject("")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");
							 
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'S. No')
			->setCellValue('B1', 'Customer No.')
			->setCellValue('C1', 'Customer Name')
			->setCellValue('D1', 'Email Id')
			->setCellValue('E1', 'Mobile No.')
			->setCellValue('F1', 'Customer Type')
			->setCellValue('G1', 'Status')
			->setCellValue('H1', 'Remarks');
	
	 foreach( $data as $key => $value ) :
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.($key+2), ($key+1))
						->setCellValue('B'.($key+2), $value['MstCustomerDetailsErp']['vc_customer_no'])
						->setCellValue('C'.($key+2), $value['MstCustomerDetailsErp']['vc_customer_name'])
						->setCellValue('D'.($key+2), $value['MstCustomerDetailsErp']['vc_email'])
						->setCellValue('E'.($key+2), $value['MstCustomerDetailsErp']['vc_mobile_no'])
						->setCellValue('F'.($key+2), $value['MstCustomerDetailsErp']['vc_cust_type'])
						->setCellValue('G'.($key+2), $value['status_imp'])
						->setCellValue('H'.($key+2), $value['message']);
		
		unset($value);
	 endforeach;
	
		
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	$dir = WWW_ROOT.'DataImportExcel'; 
	
	if (!file_exists($dir)) {

		mkdir($dir, 0777, true);
	}

	$objWriter->save($dir.DS.'MDC-Import-Data-'.date('Y-M-D-His').'-Portal'.'.xlsx');
	
	exit;
?>