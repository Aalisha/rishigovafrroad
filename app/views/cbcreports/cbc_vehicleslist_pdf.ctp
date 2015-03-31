<?php 
 $currentUser = $this->Session->read('Auth');
App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

// set document information 
$pdf->SetCreator(PDF_CREATOR); 

$pdf->SetAuthor('RFA-CBC'); 

$pdf->SetTitle('RFA-CBC'); 

$pdf->SetSubject('Customer Recharge Report'); 

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

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

// set font 
$pdf->SetFontSize(6);


// add a page 
$pdf->AddPage(); 

$html = "";
$html .="<h1 align=\"center\">Vehicle List Report</h1>";

$html .= "<br/>";
$html .="<br/>";
$html .="<br/>";
$html .="<br/>";


$html .= "<table width=\"100%\" bgColor=\"#BFBFBF\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
    $html .= "<tr>";
       
		if(!empty($vehicletype)){
			$html .="<td width =\"35%\">&nbsp;</td>";
			$html .="<td width =\"12%\" color=\"#0000FF\"><b>Vehicle List Report</b></td>";
            $html .= "<td width =\"8%\"><b>Vehicle Type :</b></td>";
            $html .= "<td width =\"45%\" >".$globalParameterarray[$vehicletype]."</td>";
        }else{
            $html .= "<td width=\"100%\"></td>";
        }
        
    $html .= "</tr>";

	$html .= "<tr>";
	
  $html .= "<td width=\"12%\" ><b>Customer Name :</b></td>";
        $html .= "<td width=\"33%\">".wordwrap(ucfirst($currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname']), 25, "<br>\n", true)."</td>";
		$html .= "<td width=\"30%\">&nbsp;</td>";
		$html .= "<td width=\"7%\" ><b>Tel. No. :</b></td>";
        $html .= "<td width=\"18%\">".wordwrap(ucfirst($currentUser['Customer']['vc_tel_no']), 15, "<br>\n", true)."</td>";

	$html .= "</tr>";

	$html .= "<tr>";
		
		$address = trim(ucfirst($currentUser['Customer']['vc_address1']));
		
		if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address2']));
		
		if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address3']));
		
									
		$html .= "<td width=\"12%\" ><b>Address :</b></td>";
		$html .= "<td width=\"33%\">".$address."</td>";
		$html .= "<td width=\"30%\">&nbsp;</td>";
		$html .= "<td width=\"7%\" ><b>Email :</b></td>";
		$html .= "<td width=\"18%\">".wordwrap($currentUser['Customer']['vc_email'], 33, "<br>\n", true)."</td>";

	$html .= "</tr>";

	$html .= "<tr>";

		$html .= "<td width=\"12%\" ><b>Mobile No. :</b></td>";
		$html .= "<td width=\"33%\">".wordwrap(ucfirst($currentUser['Customer']['vc_mobile_no']), 15, "<br>\n", true)."</td>";
		$html .= "<td width=\"30%\">&nbsp;</td>";
		$html .= "<td width=\"7%\" ><b>Fax No. :</b></td>";
		$html .= "<td width=\"18%\">".wordwrap(ucfirst($currentUser['Customer']['vc_fax_no']), 15, "<br>\n", true)."</td>";

	$html .= "</tr>";
	
$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";




$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
    $html .= "<tr>";
		$html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"5%\"><b>SI No.</b></td>";
        $html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"5%\"><b>Vehicle Type</b></td>";
        $html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>Vehicle Reg. No.</b></td>";
        $html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>Type No.</b></td>";
		$html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>Vehicle Make</b></td>";
		$html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>No. of Axle</b></td>";
		$html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>Series Name</b></td>";
		$html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>Engine No.</b></td>";
		$html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>Chassis No.</b></td>";
        $html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>V Rating</b></td>";
        $html .= "<td align=\"centre\" bgColor=\"#BFBFBF\" width=\"10%\"><b>D/T Rating</b></td>";
        
$html .= "</tr>";

if (count($vehiclereport) > 0) {
    $i = 1;
    foreach($vehiclereport as $val){
        
        $html .= "<tr>";
        $html .= "<td align=\"right\">".$i."</td>";
        $html .= "<td>".$globalParameterarray[$val['AddVehicle']['vc_veh_type']]."</td>";
        $html .= "<td>".wordwrap($val['AddVehicle']['vc_reg_no'] , 12,"<br>\n", true)."</td>";
        $html .= "<td>".$globalParameterarray[$val['AddVehicle']['vc_type_no']]."</td>";
		$html .= "<td>".wordwrap ($globalParameterarray[$val['AddVehicle']['vc_make']], 12,"<br>\n", true)."</td>";
		$html .= "<td>".wordwrap ($globalParameterarray[$val['AddVehicle']['vc_axle_type']], 12,"<br>\n", true)."</td>";
		$html .= "<td>".wordwrap ($val['AddVehicle']['vc_series_name'], 12, "<br>\n", true)."</td>";
		$html .= "<td>".wordwrap($val['AddVehicle']['vc_engine_no'], 12,"<br>\n", true)."</td>";
		$html .= "<td>".wordwrap($val['AddVehicle']['vc_chasis_no'], 12,"<br>\n", true)."</td>";
		$html .= "<td align=\"right\">".number_format($val['AddVehicle']['nu_v_rating'])."</td>";
		$html .= "<td align=\"right\">".number_format($val['AddVehicle']['nu_d_rating'])."</td>";
        $html .= "</tr>";
        $i++;
    }
}
   
$html .= "</table>";


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('Vehicle_List_report'.'.pdf', 'D'); 
?>