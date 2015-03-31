<?php
App::import('Vendor', 'tcpdf/tcpdf');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RFA');
$pdf->SetTitle('RFA');
$pdf->SetSubject('Payment History Report');



$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '','');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFontSize(6);

$pdf->AddPage();



$html = " ";

$html .= "<br/>";
$html .="<h2 align=\"center\">Payment History Report</h2>";
$html .="<br/>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
$html .= "<tr>";
        $html .= "<td width=\"10%\">RFA Account No. :</td>";
        $html .= "<td width=\"10%\">" . $vc_customer_no . "</td>";
        
        if(!empty($fromDate)){
            $fromDate = date('d M Y',  strtotime($fromDate));
            $html .= "<td width=\"20%\">From Date : ".$fromDate."</td>";
        }else{
            $html .= "<td width=\"20%\"></td>";
        }
        
        $html .= "<td width=\"10%\"></td>";
        $html .= "<td width=\"10%\"></td>";        

$html .= "</tr>";




$html .= "<tr>";
$html .= "<td width=\"10%\">Customer Name :</td>";
$html .= "<td width=\"10%\">" . $vc_customer_name . "</td>";

        if(!empty($toDate)){
            $todate = date('d M Y',  strtotime($toDate));
            $html .= "<td width =\"20%\">To Date : ".$todate."</td>";
        }else{
            $html .= "<td width=\"20%\"></td>";
        }


$html .= "<td width =\"10%\">&nbsp;</td>";
$html .= "<td width =\"10%\">&nbsp;</td>";

$html .= "</tr>";

$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
$html .= "<tr bgcolor=\"#BFBFBF \">";
$html .= "<td width=\"10%\"  align=\"center\">S. No.</td>";
$html .= "<td width=\"15%\" align=\"center\">Assessment No.</td>";
$html .= "<td width=\"15%\" align=\"center\">Assessment Date</td>";
$html .= "<td width=\"10%\" align=\"center\">Payable Amount (N$)</td>";
$html .= "<td width=\"10%\" align=\"center\">Paid Amount (N$)</td>";
$html .= "<td width=\"10%\" align=\"center\">Variance Amount (N$)</td>";
$html .= "<td width=\"15%\" align=\"center\">Payment Date</td>";
$html .= "<td width=\"15%\" align=\"center\">Payment Status</td>";

$html .= "</tr>";


if (count($paymentreport) > 0) {
    $i = 1;
    foreach ($paymentreport as $showpaymentreport) {

        $html .= "<tr>";
        $html .= "<td>" . $i . "</td>";
        $html .= "<td>" . $showpaymentreport['AssessmentVehicleMaster']['vc_assessment_no'] . "</td>";
        $AssMntDate = !empty($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date']) ?
                            date('d M Y', strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_assessment_date'])):
                            '';
        $html .= "<td>" .$AssMntDate . "</td>";
        
        
        
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
        
		$VarianceAmount = isset($showpaymentreport['AssessmentVehicleMaster']['nu_variance_amount']) ? 
				$this->Number->format($showpaymentreport['AssessmentVehicleMaster']['nu_variance_amount'], array(
				'places' => 2,
				'before' => false,
				'escape' => false,
				'decimals' => '.',
				'thousands' => ','
				)):'';
                
		$html .= "<td align=\"right\">$VarianceAmount</td>";
		 
        $PayMntDate = !empty($showpaymentreport['AssessmentVehicleMaster']['dt_received_date']) ?
                             date('d M Y', strtotime($showpaymentreport['AssessmentVehicleMaster']['dt_received_date'])):
                             '';
        
        $html .= "<td>" . $PayMntDate . "</td>";
        
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


$pdf->Output('payment-history-report-'.date('d-M-Y').'.pdf', 'D');
?> 
