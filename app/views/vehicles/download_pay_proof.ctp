<?php

App::import('Vendor', 'tcpdf/tcpdf');

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information 
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('RFA (Road Fund Administration)');

$pdf->SetTitle(' RFA (Road Fund Administration) ');

$pdf->SetSubject('MDC( Mass Distance Charges ) Assessment Pay Proof ');

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

$html .="<td   style=\"border:solid 1px #000; text-align:center;\" width=\"25%\" > <strong> <h3> Mass Distance Charges </h3> </strong> <br /> <strong> Invoice </strong> </td>";
$html .="<td width=\"10%\" > &nbsp; </td>";
$html .="<td width=\"27%\" ><strong> Invoice No. :</strong> &nbsp;&nbsp;". $AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_invoice_no'] ."</td>";
$html .="<td width=\"10%\" > &nbsp; </td>";
$html .="<td width=\"18%\" ><strong>Invoice Date. :</strong> &nbsp;&nbsp;". date('d-M-Y', strtotime( $AssessmentVehicleMaster['AssessmentVehicleMaster']['dt_invoice_date'])) ."</td>";


$html .="</tr>";

$html .="<tr height=\"10px;\" >";

$html .="<td > &nbsp; </td>";
$html .="<td >  &nbsp; </td>";
$html .="<td > &nbsp; </td>";
$html .="<td > &nbsp; </td>";

$html .="</tr>";

$html .="<tr>";

$html .="<td colspan=\"2\" style=\"border:solid 1px #000; text-align:center;\" height=\"15px;\" width=\"50%\"; > <strong> MDC Account No.: " . trim($AssessmentVehicleMaster ['AssessmentVehicleMaster']['vc_customer_no']) . " </strong> </td>";
$html .="<td colspan=\"2\" style=\"border:solid 1px #000; text-align:center;\" height=\"15px;\" width=\"50%\";> <strong>Account Opening Date: " . date('d-M-Y', strtotime($this->Session->read('Auth.Profile.dt_account_create_date'))) . " </strong> </td>";

$html .="</tr>";

$html .="<tr>";

$html .="<td  colspan=\"2\" style=\"border:solid 1px #000; text-align:center;\"  height=\"15px;\" > <strong> RFA Assessment No.: " . trim($AssessmentVehicleMaster ['AssessmentVehicleMaster']['vc_assessment_no']) . "  </strong> </td>";
$html .="<td  colspan=\"2\" style=\"border:solid 1px #000; text-align:center;\" height=\"15px;\" > <strong>Assessment Date:  " . date('d-M-Y', strtotime($AssessmentVehicleMaster ['AssessmentVehicleMaster']['dt_assessment_date'])) . "</strong> </td>";

$html .="</tr>";

$html .="<tr height=\"10px;\" >";

$html .="<td style=\"text-align:center;\" > <strong > Operator Particulars: </strong> </td>";
$html .="<td> &nbsp; </td>";
$html .="<td > &nbsp; </td>";
$html .="<td >  &nbsp; </td>";


$html .="</tr>";

$html .="<tr height=\"10px;\" >";

$html .="<td style=\"text-align:center;\" > &nbsp; </td> <td style=\"text-align:center;\" width=\"50%\"; > ";

$html .=" <strong> " . ucwords(trim($this->Session->read('Auth.Profile.vc_customer_name'))) . "</strong> <br />";

if (!empty($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_address1'])) {

    $html .=" <strong> " . trim($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_address1']) . "</strong> <br />";
}


if (!empty($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_address2'])) {

    $html .=" <strong> ". trim($AssessmentVehicleMaster['AssessmentVehicleMaster']['vc_address2']) . "  </strong>  <br />";
}


if (!empty($AssessmentVehicleMaster ['AssessmentVehicleMaster']['vc_po_box'])) {
    $html .= " <strong>  ". trim($AssessmentVehicleMaster ['AssessmentVehicleMaster']['vc_po_box']) . "  </strong>  <br />";

}
if (!empty($AssessmentVehicleMaster ['AssessmentVehicleMaster']['vc_town'])) {
    $html .= " <strong>  ". trim($AssessmentVehicleMaster ['AssessmentVehicleMaster']['vc_town']) . "  </strong>  <br />";

}


$html .=" </td> <td > &nbsp; </td>";
$html .="<td >  &nbsp; </td>";


$html .="</tr>";


$html .="<tr>";

$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"25%\" height=\"15px;\" > <strong>S.No. </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"25%\" height=\"15px;\" > <strong>Vehicle Licence Number (e.g. N41467W) </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"25%\" height=\"15px;\" > <strong>Vehicle Registration Number (e.g. RNJ861H) </strong> </td>";
$html .="<td style=\"border:solid 1px #000; text-align:center;\" width=\"25%\"height=\"15px;\" > <strong> Amount (N$) </strong> </td>";

$html .="</tr>";

foreach ($AssessmentVehicleMaster['AssessmentVehicleDetail'] as $key => $value) :

    $html .="<tr >";

    $html .="<td style=\"border-left:solid 1px #000;text-align:center;\"  > " . ++$key . "</td>";
    $html .="<td  style=\"text-align:center;\" > " . trim($value['vc_vehicle_lic_no']) . "</td>";
    $html .="<td style=\"text-align:center;\" > " . trim($value['vc_vehicle_reg_no']) . "</td>";
    $html .="<td style=\"border-right:solid 1px #000; text-align:center;\"  > " . number_format(trim($value['vc_payable']), 2, '.', ',') . "</td>";

    $html .="</tr>";

endforeach;

$html .="<tr >";


$html .="<td colspan=\" 2 \"  height=\"15px;\" colspan=\"2\" style=\" text-align:right; border:solid 1px #000; background-color:#E6E6E6;\" width=\"50%\"   >  Payable Amount (N$) : </td>";

$html .="<td colspan=\" 2 \"  height=\"15px;\" colspan=\"2\"style=\" text-align:left; border:solid 1px #000; background-color:#E6E6E6;\" width=\"50%\" > " . number_format(trim($AssessmentVehicleMaster['AssessmentVehicleMaster']['nu_total_payable_amount']), 2, '.', ',') . "</td>";


$html .="</tr>";

$html .="<tr height=\"10px;\" >";

$html .="<td > &nbsp; </td>";

$html .="<td> &nbsp;</td>";

$html .="<td > &nbsp; </td>";

$html .="<td >  &nbsp; </td>";


$html .="</tr>";


/*
$html .=" <tr> ";

$html .="<td colspan=\"2\"  style=\"text-align:left;\" > ________________________<br /> SIGNATURE </td>";

$html .="<td style=\"border:solid 1px #000;text-align:center; \" width =\"40%\" colspan=\"2\" >  RFA<br />OFFICIAL<br />STAMP  </td>";

$html .=" </tr> ";

*/
$html .=" <tr> ";

$html .="<td colspan=\"2\"  style=\"text-align:left;\" > &nbsp; </td>";

$html .="<td style=\"text-align:right; \" width =\"40%\" colspan=\"2\" >  Print date : ".date('d-M-Y')."  </td>";

$html .=" </tr> ";

$html .="</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//Close and output PDF document 


$pdf->Output('MDC_Assessment_Invoice' . date('YmdHis') . '.pdf', 'D');
?> 