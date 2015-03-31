<?php 
App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

// set document information 
$pdf->SetCreator(PDF_CREATOR); 

$pdf->SetAuthor('RFA'); 

$pdf->SetTitle('RFA'); 

$pdf->SetSubject('Vehicle Log Report '); 



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
//$pdf->setVisibility('screen');

// add a page 
$pdf->AddPage(); 

               
$html = "";


$html .= "<h2 align=\"center\">Vehicle Log Sheet History Report</h2>";

$html .="<br/>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
		$html .= "<tr>";
	
		$html .= "<td colspan=\"2\">&nbsp;</td>";
		$html .= "</tr>";
				$html .= "<tr>";

	$html .= "<td colspan=\"2\" >Inspector Id. : ". $this->Session->read('Auth.Member.vc_username')."</td>";
	
	$html .= "</tr>";
		$html .= "<tr>";
	
		if($fromdate!=''){
		$html .= "<td width=\"16%\">From Date : ".$fromdate."</td>";
         
		}else{
		
		$html .= "<td width=\"16%\"></td>";
		 
		}
		
    
		if($vehicletypename!=''){
        $html .= "<td width=\"30%\">Vehicle Type : ".$vehicletypename."</td>";
		}else {
		$html .= "<td width=\"30%\"></td>";
		
		}       
   $html .= "</tr>";
   	
	
        if($todate!=''){
			
		$html .= "<tr>";
	
		$html .= "<td colspan=\"2\" width=\"100%\">To Date : ".$todate."</td>";
         
		
		       
   $html .= "</tr>";
   }
   
   
$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
    $html .= "<tr bgcolor=\"#BFBFBF \">";
        $html .= "<td width=\"10%\">Log Date</td>";
        $html .= "<td width=\"9%\">Vehicle Reg. No.</td>";
        $html .= "<td width=\"9%\">Vehicle LIC. No.</td>";
        $html .= "<td width=\"9%\">Driver Name</td>";
        $html .= "<td width=\"9%\">Start Odometer</td>";
        $html .= "<td width=\"9%\">End Odometer</td>";
        $html .= "<td width=\"9%\">Road Type</td>";
        $html .= "<td width=\"9%\">Origin</td>";
        $html .= "<td width=\"9%\">Destination</td>";
        $html .= "<td width=\"9%\">KM Travel on Namibian Road Network</td>";
        $html .= "<td width=\"9%\">KM Travel on <br>other Road</td>";
	$html .= "<td width=\"9%\">Created Date</td>";
		
		
$html .= "</tr>";

                    
if(count($vehiclelogreport) > 0) {
    
    foreach ($vehiclelogreport as $showlogreport) {
        
        $html .= "<tr>";
            
                        $logDate = !empty($showlogreport['VehicleLogDetail']['dt_log_date']) ?
                                              date('d M Y', strtotime($showlogreport['VehicleLogDetail']['dt_log_date'])) :
                                                '';
			$html .= "<td width=\"10%\">" .$logDate . "</td>";
			$html .= "<td width=\"9%\">" . $showlogreport['VehicleLogDetail']['vc_vehicle_reg_no'] . "</td>";
			$html .= "<td width=\"9%\">" . $showlogreport['VehicleLogDetail']['vc_vehicle_lic_no'] . "</td>";
			$html .= "<td width=\"9%\">" . wordwrap($showlogreport['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true) . "</td>";
			
                        
                        $StartOMet = isset($showlogreport['VehicleLogDetail']['nu_start_ometer']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_start_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
                        
                        
                        $html .= "<td width=\"9%\">$StartOMet</td>";
                        
                        $EndOMet = isset($showlogreport['VehicleLogDetail']['nu_end_ometer']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_end_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
			$html .= "<td width=\"9%\" align=\"right\">$EndOMet</td>";
                        
			$html .= "<td width=\"9%\">" . wordwrap($showlogreport['VehicleLogDetail']['vc_orign_name'], 12, "<br>\n", true) . "</td>";
			$html .= "<td width=\"9%\">" . wordwrap($showlogreport['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true) . "</td>";
			
                        
                        $KmTraV = isset($showlogreport['VehicleLogDetail']['nu_km_traveled']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
                        
                        $html .= "<td width=\"9%\" align=\"right\">$KmTraV</td>";
                        
                        $KmTravOth = isset($showlogreport['VehicleLogDetail']['nu_other_road_km_traveled']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_other_road_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
                        
                        
			$html .= "<td width=\"9%\" align=\"right\">$KmTravOth</td>";
			
                        $created_date = $showlogreport['VehicleLogDetail']['dt_created_date'] ?
                                                date('d M Y', strtotime($showlogreport['VehicleLogDetail']['dt_created_date'])):
                                                '';
                        $html .= "<td width=\"9%\">" . $created_date  . "</td>";
            
        $html .= "</tr>";
      
    }
    
}else {

 $html .= "<tr>";
 $html .='<td colspan="10" style="text-align:center;">  No Records Found </td>';
 $html .= "</tr>";

}


$html .= "</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('vehicle_log_sheet-' . date('d-M-Y') . '.pdf','D'); 
?> 
