<?php

App::import('Vendor', 'tcpdf/tcpdf');

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information 
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('RFA (Road Fund Administration)');

$pdf->SetTitle(' RFA (Road Fund Administration) ');

$pdf->SetSubject('MDC( Mass Distance Charges ) Assessment Payment Receipt ');

// set header and footer fonts 

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');

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
$pdf->SetFontSize(7);


// add a page 
$pdf->AddPage();

$html = " <table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" >";

$html .="<tr>";

$html .="<td width=\"20%\">Statement</td>";

$html .="<td width=\"20%\">&nbsp;</td>";

$html .="<td width=\"15%\">&nbsp;</td>";

$html .="<td width=\"15%\">&nbsp;</td>";

$html .="<td width=\"15%\">&nbsp;</td>";

$html .="<td width=\"15%\">" . Date('d-M-Y') . "</td>";

$html .="</tr>";

$html .="<tr height=\"100px;\" >";

$html .="<td width=\"20%\"> &nbsp; </td>";
$html .="<td width=\"20%\">  &nbsp; </td>";
$html .="<td width=\"15%\"> &nbsp; </td>";
$html .="<td width=\"15%\"> &nbsp; </td>";
$html .="<td width=\"15%\">  &nbsp; </td>";
$html .="<td width=\"15%\"> &nbsp; </td>";

$html .="</tr>";

$html .="<tr>";

$html .="<td  colspan=\"6\" width=\"100%\" style=\"float:left;\" > Dear Customer, </td>";

$html .="</tr>";

$html .="<tr>";

$html .="<td style=\"text-indent:48px;padding-bottom:28px;\" colspan=\"6\" > Please find the following details of your submitted assessment no. for the listed
vehicles. The assessment is reflecting the due amount N$ ". number_format($Outstanding, 2, '.', ',') ." payable by you. In order to get CONFIRMATION OF PAYMENT from
us, please deposit the due amount.</td>";

$html .="</tr>";

$html .="<tr height=\"10px;\" >";

$html .="<td width=\"20%\"> &nbsp; </td>";
$html .="<td width=\"20%\">  &nbsp; </td>";
$html .="<td width=\"15%\"> &nbsp; </td>";
$html .="<td width=\"15%\"> &nbsp; </td>";
$html .="<td width=\"15%\">  &nbsp; </td>";
$html .="<td width=\"15%\"> &nbsp; </td>";

$html .="</tr>";

$html .="<tr>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\" height=\"15px;\" ><strong>  Assessment Number </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\" height=\"15px;\" > <strong> Assessment Date </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\" height=\"15px;\" > <strong> Vehicle License No. </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\" height=\"15px;\" > <strong> Vehicle Registration No. </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\" height=\"15px;\" > <strong> Total KM </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\"height=\"15px;\" > <strong> KM/100 </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\" height=\"15px;\" > <strong> Rate (N$) </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\"height=\"15px;\" > <strong> Amount Due (N$)</strong></td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\"height=\"15px;\" > <strong> Amount Paid (N$)</strong></td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"10%\"height=\"15px;\" > <strong> Outstanding Amount (N$)</strong></td>";

$html .="</tr>";
foreach ($data as $val){

    $html .="<tr>";
	$html .="<td style=\"border-left:solid 1px #000;text-align:center;\" width=\"10%\" > " . trim($val['AssessmentVehicleMaster']['vc_assessment_no']) . "</td>";
    $html .="<td width=\"10%\" style=\"text-align:center;\" > ". date('d-M-y', strtotime($val['AssessmentVehicleMaster']['dt_process_date'])) . "</td>";
    
    $html .="<td width=\"10%\" style=\"text-align:center;\" > ". trim($val['AssessmentVehicleDetail']['vc_vehicle_lic_no']) . "</td>";
    $html .="<td width=\"10%\" style=\"text-align:center;\" > " . trim($val['AssessmentVehicleDetail']['vc_vehicle_reg_no']) . "</td>";
    $html .="<td width=\"10%\" style=\"text-align:center;\" > " . number_format(trim($val['AssessmentVehicleDetail']['vc_km_travelled'])) . "</td>";
    $html .="<td width=\"10%\" style=\"text-align:center;\" > " . number_format((trim($val['AssessmentVehicleDetail']['vc_km_travelled']) / 100)) . "</td>";
    $html .="<td width=\"10%\" style=\"text-align:center;\" > " . number_format(trim($val['AssessmentVehicleDetail']['vc_rate']), 2, '.', ',') . "</td>";
    
	$amount_due = number_format(trim($val['AssessmentVehicleMaster']['nu_total_payable_amount']), 2, '.', ',');
	
	$html .="<td width=\"10%\" style=\"text-align:center;\" > " . $amount_due . "</td>";
	
	$amount_paid = number_format(trim($val['AssessmentVehicleMaster']['vc_mdc_paid']), 2, '.', ',');
	
	$html .="<td width=\"10%\" style=\"text-align:center;\" > " . $amount_paid . "</td>";
	
	$outstanding_particularassessment = (float)$val['AssessmentVehicleMaster']['nu_total_payable_amount'] - (float)$val['AssessmentVehicleMaster']['vc_mdc_paid'];
	
	$amount_outstanding = number_format(trim($outstanding_particularassessment), 2, '.', ',');
	
	$html .="<td style=\"border-right:solid 1px #000; text-align:center;\" width=\"10%\" > "  . $amount_outstanding . "</td>";
    
	$html .="</tr>";
	
}//die;
$html .="<tr >";
$html .="<td height=\"15px;\" style=\"border:solid 1px #000; background-color:#E6E6E6;\" width=\"33%\" > Assessment Amount (N$): &nbsp;&nbsp; " . number_format($nu_total_payable_amount, 2, '.', ',') . "</td>";
$html .="<td height=\"15px;\" style=\"border:solid 1px #000; background-color:#E6E6E6;\" width=\"33%\" > MDC Paid (N$) : &nbsp;&nbsp;" . number_format($vc_mdc_paid, 2, '.', ',') . " </td>";
$html .="<td  height=\"15px;\" colspan=\"2\" style=\"border:solid 1px #000; background-color:#E6E6E6;\" width=\"34%\" >Net Outstanding (N$) : &nbsp;&nbsp; " . number_format($Outstanding, 2, '.', ',') . " </td>";

$html .="</tr>";

$html .="</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//Close and output PDF document 
//$pdf->Output($fileNL,'F');

$pdf->Output('Statement_Report' . '.pdf', 'D');

?> 