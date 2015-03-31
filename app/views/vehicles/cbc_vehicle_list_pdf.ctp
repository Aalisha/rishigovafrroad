<?php $currentUser = $this->Session->read('Auth');

App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

// set document information 
$pdf->SetCreator(PDF_CREATOR); 

$pdf->SetAuthor('RFA-CBC'); 

$pdf->SetTitle('RFA-CBC'); 

$pdf->SetSubject('Vehicles List'); 

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

$html ="<h1 align=\"center\">Vehicles List</h1>";
$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" bgColor=\"#BFBFBF\">";
	$html .= "<tr>";

        $html .= "<td width=\"10%\" ><b>Customer Name :</b></td>";
        $html .= "<td width=\"30%\">".wordwrap(ucfirst($currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname']), 30, "<br>\n", true)."</td>";
		$html .= "<td width=\"35%\">&nbsp;</td>";
		$html .= "<td width=\"7%\" ><b>Tel. No. :</b></td>";
        $html .= "<td width=\"18%\">".wordwrap(ucfirst($currentUser['Customer']['vc_tel_no']), 15, "<br>\n", true)."</td>";

	$html .= "</tr>";

	$html .= "<tr>";
		
		$address = trim(ucfirst($currentUser['Customer']['vc_address1']));
		
		if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address2']));
		
		if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address3']));
		
									
		$html .= "<td width=\"10%\" ><b>Address :</b></td>";
		$html .= "<td width=\"30%\">".$address."</td>";
		
		$html .= "<td width=\"35%\">&nbsp;</td>";
		$html .= "<td width=\"7%\" ><b>Email :</b></td>";
		$html .= "<td width=\"18%\">".wordwrap($currentUser['Customer']['vc_email'], 33, "<br>\n", true)."</td>";

	$html .= "</tr>";

	$html .= "<tr>";

		$html .= "<td width=\"10%\" ><b>Mobile No. :</b></td>";
		$html .= "<td width=\"30%\">".wordwrap(ucfirst($currentUser['Customer']['vc_mobile_no']), 15, "<br>\n", true)."</td>";
		$html .= "<td width=\"35%\">&nbsp;</td>";
		$html .= "<td width=\"7%\" ><b>Fax No. :</b></td>";
		$html .= "<td width=\"18%\">".wordwrap(ucfirst($currentUser['Customer']['vc_fax_no']), 15, "<br>\n", true)."</td>";

	$html .= "</tr>";
	
    $html .= "<tr>";
		$html .= "<td width=\"10%\"><b>Total Vehicles <br/>Registered :	</b></td>";
		$html .= "<td width=\"30%\">" .number_format($total_vehicles). "</td>";
		$html .= "<td width=\"60%\"colspan=\"3\">&nbsp;</td>";
	$html .= "</tr>";

$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";

    $html .= "<tr bgColor=\"#BFBFBF \">";

		$html .= "<td width=\"8%\" align=\"center\"><b>SI. No. </b></td>";
        $html .= "<td width=\"23%\" align=\"center\"><b>Vehicle Reg. No.</b></td>";
        $html .= "<td width=\"23%\" align=\"center\"><b>Vehicle Chassis No.</b></td>";
        $html .= "<td width=\"23%\" align=\"center\"><b>Vehicle Type</b></td>";
		$html .= "<td width=\"23%\" align=\"center\"><b>Current Status</b></td>";
        
$html .= "</tr>";


    $i = 1;
	
    foreach($records as $val){
        
        $html .= "<tr>";
		$html .= "<td align=\"right\">".$i."</td>";
		$html .= "<td>".wordwrap($val['ActivationDeactivationVehicle']['vc_reg_no'], 35, "<br>\n", true)."</td>";
		$html .= "<td>".wordwrap($val['ActivationDeactivationVehicle']['vc_chasis_no'], 35, "<br>\n", true)."</td>";
        $html .= "<td>".$globalParameterarray[$val['ActivationDeactivationVehicle']['vc_veh_type']]."</td>";
		$html .= "<td>".$globalParameterarray[$val['ActivationDeactivationVehicle']['vc_status']]."</td>";
        
        $html .= "</tr>";
        $i++;
    }
    
   
$html .= "</table>";


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('Vehicles-List'.'.pdf', 'D'); 
?> 
