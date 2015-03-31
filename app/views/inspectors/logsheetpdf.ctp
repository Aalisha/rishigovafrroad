<?php 
App::import('Vendor','tcpdf/tcpdf'); 
 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  


$pdf->SetCreator(PDF_CREATOR); 
$pdf->SetAuthor('RFA'); 
$pdf->SetTitle('RFA'); 
$pdf->SetSubject('Vehicle Log Report '); 

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '','');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)); 
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT); 
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER); 
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 

 
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  


$pdf->SetFontSize(6);
$pdf->setVisibility('screen');


$pdf->AddPage(); 
               
$html = "";

$html .= "<h2 align=\"center\">Customer Vehicle Log History Report</h2>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
   
        $html .= "<tr>";
	
		$html .= "<td colspan=\"1\">&nbsp;</td>";
        $html .= "</tr>";
		
				$html .= "<tr>";

	$html .= "<td colspan=\"1\" >Inspector Id. : ". $this->Session->read('Auth.Member.vc_username')."</td>";
	
	$html .= "</tr>";
		
		if($fromdate!=''){

		$html .= "<tr>";
		$html .= "<td width=\"30%\">From Date : ".$fromdate."</td>";
        $html .= "</tr>";

		}
		if($todate!=''){
		
		$html .= "<tr>";		
		$html .= "<td width=\"30%\">To Date : ".$todate."</td>";
        $html .= "</tr>"; 
		 
		}
	
        
		

$html .= "</table>";
$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
    $html .= "<tr bgcolor=\"#BFBFBF \">";
        $html .= "<td width=\"10%\" align=\"center\">Log Date</td>";
        $html .= "<td width=\"10%\" align=\"center\">Customer Name </td>";
	$html .= "<td width=\"10%\" align=\"center\">Vehicle Reg No.</td>";
        $html .= "<td width=\"10%\" align=\"center\">Vehicle LIC. No.</td>";
        $html .= "<td width=\"12%\" align=\"center\">Driver Name</td>";
        $html .= "<td width=\"8%\" align=\"center\">Start Odometer</td>";
        $html .= "<td width=\"8%\" align=\"center\">End Odometer</td>";
        $html .= "<td width=\"8%\" align=\"center\">Origin</td>";
        $html .= "<td width=\"8%\" align=\"center\">Destination</td>";
        $html .= "<td width=\"8%\" align=\"center\">KM Travel on Namibian Road Network</td>";
        $html .= "<td width=\"8%\" align=\"center\">KM Travel on<br> Other Road Network</td>";
	
       $html .= "</tr>";

                    
if(count($logreport) > 0) {
    $i = 1;
    foreach ($logreport as $showlogreport) {
        
        $html .= "<tr>";
            $LogDate = !empty ($showlogreport['VehicleLogDetail']['dt_log_date']) ? 
                        date('d M Y', strtotime($showlogreport['VehicleLogDetail']['dt_log_date'])):
                        '';
            $html .= "<td width=\"10%\">".$LogDate."</td>";
            $html .= "<td width=\"10%\">".$showlogreport['VehicleLogMaster']['vc_customer_name']."</td>";
            $html .= "<td width=\"10%\">".$showlogreport['VehicleLogDetail']['vc_vehicle_reg_no']."</td>";
            $html .= "<td width=\"10%\">".$showlogreport['VehicleLogDetail']['vc_vehicle_lic_no']."</td>";
            $html .= "<td width=\"12%\">".wordwrap($showlogreport['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true)."</td>";
            
            
           $StartOMet = isset($showlogreport['VehicleLogDetail']['nu_start_ometer']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_start_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
            
            $html .= "<td width=\"8%\" align=\"right\"> $StartOMet </td>";
            
            $EndOMet = isset($showlogreport['VehicleLogDetail']['nu_end_ometer']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_end_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
            $html .= "<td width=\"8%\" align=\"right\">$EndOMet</td>";
            $html .= "<td width=\"8%\">".wordwrap($showlogreport['VehicleLogDetail']['vc_orign_name'], 12, "<br>\n", true)."</td>";
            $html .= "<td width=\"8%\">".wordwrap($showlogreport['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true)."</td>";
            
            $KmTraV = isset($showlogreport['VehicleLogDetail']['nu_km_traveled']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
            
            $html .= "<td width=\"8%\" align=\"right\" >$KmTraV</td>";
            
            $KmTravOth = isset($showlogreport['VehicleLogDetail']['nu_other_road_km_traveled']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_other_road_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
            
            $html .= "<td width=\"8%\" align=\"right\">$KmTravOth</td>";

	   $CreatedDate = !empty ($showlogreport['VehicleLogDetail']['dt_created_date']) ? 
                            date('d M Y', strtotime($showlogreport['VehicleLogDetail']['dt_created_date'])):
                            '';
            
        $html .= "</tr>";
        $i++;
    }
    
}


$html .= "</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 
$pdf->Output('vehicle_log_sheet-'. date('d-M-Y') . '.pdf', 'D'); 
?> 
