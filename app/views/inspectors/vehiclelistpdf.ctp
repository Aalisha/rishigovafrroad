<?php 

App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

// set document information 
$pdf->SetCreator(PDF_CREATOR); 

$pdf->SetAuthor('RFA'); 

$pdf->SetTitle('RFA'); 

$pdf->SetSubject('Vehicle Report '); 



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
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

// set font 
$pdf->SetFontSize(6);


// add a page 
$pdf->AddPage(); 

$html = "";
$html .= "<h2 align=\"center\">Vehicle History Report</h2>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
    $html .= "<tr>";
	
		$html .= "<td colspan=\"1\">&nbsp;</td>";
    $html .= "</tr>";
		$html .= "<tr>";

	$html .= "<td colspan=\"1\" >Inspector Id. : ". $this->Session->read('Auth.Member.vc_username')."</td>";
	
	$html .= "</tr>";
	
		if($fromDate!=''){
		$html .= "<tr>";
	
		 
		$html .= "<td width=\"30%\">From Date : ".$fromDate."</td>";
         
		 
	    $html .= "</tr>";
		}
		if($toDate!=''){
		 
		$html .= "<tr>";
	
		
		$html .= "<td width=\"30%\">To Date : ".$toDate."</td>";
         
		 
		
		$html .= "</tr>";
		}
	$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
    $html .= "<tr  bgcolor=\"#BFBFBF \">";
        $html .= "<td width=\"5%\" align=\"center\">S. No.</td>";
        $html .= "<td width=\"15%\" align=\"center\">Customer Name</td>";
	$html .= "<td width=\"15%\" align=\"center\">Vehicle LIC. No.</td>";
        $html .= "<td width=\"15%\" align=\"center\">Vehicle Reg. No.</td>";
        $html .= "<td width=\"10%\" align=\"center\">Registration Date</td>";
        $html .= "<td width=\"10%\" align=\"center\">Vehicle Type</td>";
        $html .= "<td width=\"10%\" align=\"center\">V Rating</td>";
        $html .= "<td width=\"10%\" align=\"center\">D/T Rating</td>";
        $html .= "<td width=\"10%\" align=\"center\">Rate(N$)</td>";
	
$html .= "</tr>";

                    
if(count($vehiclereport) > 0) {
    $i = 1;
    foreach ($vehiclereport as $showvehiclereport) {
        
        $html .= "<tr>";
        $html .= "<td align=\"center\">".$i."</td>";
        $html .= "<td>".$showvehiclereport['CustomerProfile']['vc_customer_name']."</td>";
	$html .= "<td>".$showvehiclereport['VehicleDetail']['vc_vehicle_lic_no']."</td>";
        $html .= "<td>".$showvehiclereport['VehicleDetail']['vc_vehicle_reg_no']."</td>";
        $html .= "<td>".date('d M Y', strtotime($showvehiclereport['VehicleDetail']['dt_created_date']))."</td>";
        $html .= "<td>".$showvehiclereport['VEHICLETYPE']['vc_prtype_name']."</td>";
        
        $V_Rating = isset($showvehiclereport['VehicleDetail']['vc_v_rating']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_v_rating'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
        
        
       $html .= "<td align=\"right\">$V_Rating</td>";
        
       $D_T_Rating = isset($showvehiclereport['VehicleDetail']['vc_dt_rating']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_dt_rating'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
        
        
        $html .= "<td align=\"right\">$D_T_Rating</td>";
        
        $Rate = isset($showvehiclereport['VehicleDetail']['vc_rate']) ? 
                                $this->Number->format($showvehiclereport['VehicleDetail']['vc_rate'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';

        $html .= "<td align=\"right\">$Rate</td>";
	
        $html .= "</tr>";
        $i++;
    }
    
} else {

 $html .= "<tr>";
 $html .='<td colspan="9" style="text-align:center;">  No Records Found </td>';
 $html .= "</tr>";

}
    
   
$html .= "</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('vehicle-list-'.date('d-M-Y').'.pdf', 'D'); 
?> 
