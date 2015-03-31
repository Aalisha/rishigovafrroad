<?php
App::import('Vendor', 'tcpdf/tcpdf');

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
//$pdf->setVisibility('screen');
// add a page 
$pdf->AddPage();



$html = "";

$html .= "<h2 align=\"center\">Customer Payment History Report</h2>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
$html .= "<tr>";
	
$html .= "<td colspan=\"1\">&nbsp;</td>";

$html .= "<tr>";

	$html .= "<td width=\"30%\">Inspector Id. : ". $this->Session->read('Auth.Member.vc_username')."</td>";
	
$html .= "</tr>";
	
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
$html .= "<tr bgcolor=\"#BFBFBF \">";
$html .= "<td width=\"5%\" align=\"center\">S. No.</td>";
$html .= "<td width=\"15%\" align=\"center\">Assessment No.</td>";
$html .= "<td width=\"15%\" align=\"center\">Customer Name</td>";
$html .= "<td width=\"15%\" align=\"center\">Assessment Date</td>";
$html .= "<td width=\"10%\" align=\"center\">Payable Amount(N$)</td>";
$html .= "<td width=\"10%\" align=\"center\">Paid Amount(N$)</td>";
$html .= "<td width=\"15%\" align=\"center\">Payment Date</td>";
$html .= "<td width=\"15%\" align=\"center\">Payment Status</td>";

$html .= "</tr>";


if (count($paymentreport) > 0) {
    $i = 1;
    foreach ($paymentreport as $showpaymentreport) {

        $html .= "<tr>";
        $html .= "<td align=\"center\">" . $i . "</td>";
        $html .= "<td>" . $showpaymentreport['AssessmentVehicleMaster']['vc_assessment_no'] . "</td>";
	$html .= "<td>" . $showpaymentreport['AssessmentVehicleMaster']['vc_customer_name'] . "</td>";
        $AssMentDate = !empty ($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date']) ?
                        date('d-M-y', strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date'])):
                        '';
        $html .= "<td>" . $AssMentDate . "</td>";
        
        $TotAmtPayable = isset($showpaymentreport['AssessmentVehicleMaster']['nu_total_payable_amount']) ? 
                                $this->Number->format($showpaymentreport['AssessmentVehicleMaster']['nu_total_payable_amount'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';
        
        
        $html .= "<td align=\"right\">$TotAmtPayable</td>";
        
        $MdcPaid = isset($showpaymentreport['AssessmentVehicleMaster']['vc_mdc_paid']) ? 
                                $this->Number->format($showpaymentreport['AssessmentVehicleMaster']['vc_mdc_paid'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';
        
        $html .= "<td align=\"right\">$MdcPaid</td>";
        $PayMentDate = !empty ($showpaymentreport['AssessmentVehicleMaster']['dt_received_date']) ?
                        date('d M Y',  strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_received_date'])):
                        '';
        $html .= "<td>" . $PayMentDate . "</td>";
        $html .= "<td>" . $showpaymentreport['PaymentStatus']['vc_prtype_name'] . "</td>";

        $html .= "</tr>";
        $i++;
    }
} else {

  $html .= "<tr>";
  
  $html .= "<td colspan='7' style='text-align:center;'></td>";
  
  $html .= "</tr>";

}

$html .= "</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//Close and output PDF document 
$pdf->Output('payment-history-report-' . date('d-M-Y') . '.pdf', 'D');
?> 
