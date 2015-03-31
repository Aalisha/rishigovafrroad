<?php 
App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

// set document information 
$pdf->SetCreator(PDF_CREATOR); 

$pdf->SetAuthor('RFA'); 

$pdf->SetTitle('RFA'); 

$pdf->SetSubject('Vehicle Report '); 

// set header and footer fonts 

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '','');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)); 

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 

// set default monospaced font 
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

//set margins 
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); 

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER); 

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 

//set auto page breaks 
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 

//set image scale factor 
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

// set font 
$pdf->SetFontSize(6);


// add a page 
$pdf->AddPage(); 

$html = "";
$html .= "<h2 align=\"center\">Customer Assessment History Report</h2>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
    
	$html .= "<tr>";
	
		$html .= "<td width=\"30%\">Inspector Id. : ". $this->Session->read('Auth.Member.vc_username')."</td>";
		
    $html .= "</tr>";
	
	$html .= "<tr>";
	
		$html .= "<td colspan=\"1\">&nbsp;</td>";
		
    $html .= "</tr>";

    $html .= "<tr>";
	
		 if($fromdate!=''){
		$html .= "<td width=\"30%\">From Date : ".$fromdate."</td>";
         
		 }else{
		
		$html .= "<td width=\"30%\"></td>";
		 
		 }
		 
		$html .= "</tr>";
		
		$html .= "<tr>";
	
				 if($todate!=''){
		
		$html .= "<td width=\"30%\">To Date : ".$todate."</td>";
         
		}else{
		$html .= "<td width=\"30%\"></td>";
		 
		}
		
		
		$html .= "</tr>";
		$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";



$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
    $html .= "<tr bgcolor=\"#BFBFBF \">";
                    $html .= "<td align='center'>S. No.</td>";
                    $html .= "<td align=\"center\">Customer Name</td>";    
                    $html .= "<td align=\"center\">Assessment Date</td>";
                    $html .= "<td align=\"center\">Assessment No.</td>";
                    $html .= "<td align=\"center\">Vehicle LIC. No.</td>";
                    $html .= "<td align=\"center\">Vehicle Reg. No.</td>";
                    $html .= "<td align=\"center\">Vehicle Type</td>";
                    $html .= "<td align=\"center\">Pay Frequency</td>";
                    $html .= "<td align=\"center\">Prev. End OM</td>";
                    $html .= "<td align=\"center\">End OM</td>";
                    $html .= "<td align=\"center\">KM Travel on Namibian Road Network</td>";
                    $html .= "<td align=\"center\">Rate(N$)</td>";
                    $html .= "<td align=\"center\">Payable(N$)</td>";
                    $html .= "<td align=\"center\">Status</td>";
                    
    $html .= "</tr>";

                  
if(count($assessmentreport) > 0) {
      
	foreach ($assessmentreport as  $key => $showvehiclereport) {
        
        $html .= "<tr>";
			$html .= "<td align=\"center\" >".($key+1)."</td>";
			$html .= "<td>".$showvehiclereport['AssessmentVehicleMaster']['vc_customer_name']."</td>";
                        $created_date = !empty($showvehiclereport['AssessmentVehicleDetail']['dt_created_date']) ?
                                         date('d M Y', strtotime($showvehiclereport['AssessmentVehicleDetail']['dt_created_date'])):
                                         '';
			$html .= "<td>".$created_date."</td>";
			$html .= "<td>".$showvehiclereport['AssessmentVehicleDetail']['vc_assessment_no']."</td>";
			$html .= "<td>".$showvehiclereport['AssessmentVehicleDetail']['vc_vehicle_lic_no']."</td>";
			$html .= "<td>".$showvehiclereport['AssessmentVehicleDetail']['vc_vehicle_reg_no']."</td>";
			$html .= "<td>".$showvehiclereport['VehicleDetail']['VEHICLETYPE']['vc_prtype_name']."</td>";
			$html .= "<td>".$showvehiclereport['AssessmentVehicleDetail']['vc_pay_frequency']."</td>";
			
                        $PrevEndOm = isset($showvehiclereport['AssessmentVehicleDetail']['vc_prev_end_om']) ? 
                                $this->Number->format($showvehiclereport['AssessmentVehicleDetail']['vc_prev_end_om'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
                        
                        $html .= "<td align=\"right\">$PrevEndOm</td>";
                        
                        $EndOm = isset($showvehiclereport['AssessmentVehicleDetail']['vc_end_om']) ? 
                                $this->Number->format($showvehiclereport['AssessmentVehicleDetail']['vc_end_om'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

			$html .= "<td align=\"right\">$EndOm</td>";
                        
                        $KMTravld = isset($showvehiclereport['AssessmentVehicleDetail']['vc_km_travelled']) ? 
                                $this->Number->format($showvehiclereport['AssessmentVehicleDetail']['vc_km_travelled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
                        
			$html .= "<td align=\"right\">$KMTravld</td>";
                        
                        $Rate = isset($showvehiclereport['AssessmentVehicleDetail']['vc_rate']) ? 
                                $this->Number->format($showvehiclereport['AssessmentVehicleDetail']['vc_rate'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';
                        
			$html .= "<td align=\"right\">$Rate</td>";
                        
                        $Payable = isset($showvehiclereport['AssessmentVehicleDetail']['vc_payable']) ? 
                                $this->Number->format($showvehiclereport['AssessmentVehicleDetail']['vc_payable'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';
                        
			$html .= "<td align=\"right\">$Payable</td>";
                        
			$html .= "<td align=\"left\">".$globalParameterarray[$showvehiclereport['AssessmentVehicleMaster']['vc_status']]."</td>";

		$html .= "</tr>";
      
    }
    
} else {
  
    $html .= "<tr>";
	      $html .= "<td colspan='12' style='text-align:center;'>No Records Found</td>";
	$html .= "</tr>";
}
    

$html .= "</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//Close and output PDF document 
$pdf->Output('Customer-Assessment-History-'.date('d-M-Y').'.pdf', 'D'); 
?> 
