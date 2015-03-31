<?php  $currentUser = $this->Session->read('Auth');

App::import('Vendor','tcpdf/tcpdf'); 

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  

// set document information 
$pdf->SetCreator(PDF_CREATOR); 

$pdf->SetAuthor('RFA-CBC'); 

$pdf->SetTitle('RFA-CBC'); 

$pdf->SetSubject('Card List'); 

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


$html ="<h1 align=\"center\">Cards List</h1>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" bgColor=\"#BFBFBF\">";

	$html .= "<tr>";

        $html .= "<td width=\"13%\" ><b>Customer Name :</b></td>";
        $html .= "<td width=\"27%\">".wordwrap(ucfirst($currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname']), 30, "<br>\n", true)."</td>";
		$html .= "<td width=\"30%\">&nbsp;</td>";
		$html .= "<td width=\"10%\" ><b>Tel. No. :</b></td>";
        $html .= "<td width=\"20%\">".wordwrap(ucfirst($currentUser['Customer']['vc_tel_no']), 15, "<br>\n", true)."</td>";

	$html .= "</tr>";

	$html .= "<tr>";
		$address = trim(ucfirst($currentUser['Customer']['vc_address1']));
		
		if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address2']));
		
		if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address3']));
		
									
		$html .= "<td width=\"13%\" ><b>Address :</b></td>";
		$html .= "<td width=\"27%\">".$address."</td>";

		
		$html .= "<td width=\"30%\">&nbsp;</td>";
		$html .= "<td width=\"10%\" ><b>Email :</b></td>";
		$html .= "<td width=\"20%\">".wordwrap($currentUser['Customer']['vc_email'], 33, "<br>\n", true)."</td>";

	$html .= "</tr>";

	$html .= "<tr>";

		$html .= "<td width=\"13%\" ><b>Mobile No. :</b></td>";
		$html .= "<td width=\"27%\">".wordwrap(ucfirst($currentUser['Customer']['vc_mobile_no']), 15, "<br>\n", true)."</td>";
		$html .= "<td width=\"30%\">&nbsp;</td>";
		$html .= "<td width=\"10%\" ><b>Fax No. :</b></td>";
		$html .= "<td width=\"20%\">".wordwrap(ucfirst($currentUser['Customer']['vc_fax_no']), 15, "<br>\n", true)."</td>";

	$html .= "</tr>";

    $html .= "<tr>";
		$html .= "<td width=\"13%\"><b>Total Cards Issued :	</b></td>";
		$html .= "<td width=\"27%\">" .number_format($total_cards). "</td>";
		$html .= "<td width=\"30%\"><b>Active Cards :</b>" .' '.number_format($active_cards). "</td>";
		$html .= "<td width=\"10%\"><b>Inactive Cards :	</b></td>";
		$html .= "<td width=\"20%\">" .number_format($inactive_cards). "</td>";
		
	$html .= "</tr>";

$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";

    $html .= "<tr  bgColor=\"#BFBFBF \">";

		$html .= "<td width=\"7%\" align=\"center\"><b>SI. No.</b></td>";
        $html .= "<td width=\"31%\" align=\"center\"><b>Card No.</b></td>";
        $html .= "<td width=\"31%\" align=\"center\"><b>Issue Date</b></td>";
        $html .= "<td width=\"31%\" align=\"center\"><b>Current Status</b></td>";
        
$html .= "</tr>";


    $i = 1;
	
    foreach($records as $val){
        
        $html .= "<tr>";
		$html .= "<td align=\"right\">".$i."</td>";
		$html .= "<td align=\"right\">".wordwrap($val['ActivationDeactivationCard']['vc_card_no'], 30, "<br>\n", true)."</td>";
		$issueDate=!empty($val['ActivationDeactivationCard']['dt_issue_date']) ?
                                                  date('d-M-Y', strtotime($val['ActivationDeactivationCard']['dt_issue_date'])):
                                                  '';
     	$html .= "<td>".$issueDate."</td>";
        $html .= "<td>".$globalParameterarray[$val['ActivationDeactivationCard']['vc_card_flag']]."</td>";
        
        $html .= "</tr>";
        $i++;
    }
    
$html .= "</table>";

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Output('Cards-List'.'.pdf', 'D'); 
?> 
