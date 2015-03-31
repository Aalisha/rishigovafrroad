<?php
$currentUser = $this->Session->read('Auth');
App::import('Vendor', 'tcpdf/tcpdf');
// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information 
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RFA - FLR');
$pdf->SetTitle('RFA - FLR');
$pdf->SetSubject('Claim Summary Report');
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
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set font 
$pdf->SetFontSize(6);
// add a page 
$pdf->AddPage();
$html = "";
$html .= "<h1 align=\"center\">Claim Detail Report</h1><br><br>";
$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" bgColor=\"#BFBFBF\" >";
$html .= "<tr style=\"font-size:8px;\">";
if (!empty($fromDate) || !empty($toDate)) {
    $html .= "<td width=\"33%\" color=\"#0000FF\" align=\"right\"><b>Claim report for the claims :</b></td>";
} else {
    $html .= "<td width=\"33%\">&nbsp;</td>";
}
if (!empty($fromDate)) {
    $fromDate = date('d M Y', strtotime($fromDate));
    $html .= "<td width=\"18%\" align=\"right\"><b>From : </b>" . $fromDate . "</td>";
} else {
    $html .= "<td width=\"18%\"></td>";
}

if (!empty($toDate)) {
    $toDate = date('d M Y', strtotime($toDate));
    $html .= "<td width=\"49%\"><b>To    : </b>" . $toDate . "</td>";
} else {
    $html .= "<td width=\"49%\"></td>";
}
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width=\"12%\" ><b>Client Name :</b></td>";
$html .= "<td width=\"33%\">" . wordwrap(ucfirst($currentUser['Client']['vc_client_name']), 25, "<br>\n", true) . "</td>";
$html .= "<td width=\"30%\">&nbsp;</td>";
$html .= "<td width=\"7%\" ><b>Tel. No. :</b></td>";
$html .= "<td width=\"18%\">" . wordwrap(ucfirst($currentUser['Client']['vc_tel_no']), 15, "<br>\n", true) . "</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width=\"12%\" ><b>Address :</b></td>";
$address = trim(ucfirst($currentUser['Client']['vc_address1']));
if (isset($currentUser['Client']['vc_address2']) && !empty($currentUser['Client']['vc_address2'])) {
    $address .= "<br/>" . trim(ucfirst($currentUser['Client']['vc_address2']));
}

if (isset($currentUser['Client']['vc_address3']) && !empty($currentUser['Client']['vc_address3'])) {
    $address .= '<br/>' . trim(ucfirst($currentUser['Client']['vc_address3']));
}

//if (isset($currentUser['Client']['vc_postal_code1']) && !empty($currentUser['Client']['vc_postal_code1'])) {
//    $address .= '<br/>' . trim(ucfirst($currentUser['Client']['vc_postal_code1']));
//}
$html .= "<td width=\"33%\">" . $address . "</td>";
$html .= "<td width=\"30%\">&nbsp;</td>";
$html .= "<td width=\"7%\" ><b>Email :</b></td>";
$html .= "<td width=\"18%\">" . wordwrap($currentUser['Client']['vc_email'], 33, "<br>\n", true) . "</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width=\"12%\" ><b>Mobile No. :</b></td>";
$html .= "<td width=\"33%\">" . wordwrap(ucfirst($currentUser['Client']['vc_cell_no']), 15, "<br>\n", true) . "</td>";
$html .= "<td width=\"30%\">&nbsp;</td>";
$html .= "<td width=\"7%\" ><b>Fax No. :</b></td>";
$html .= "<td width=\"18%\">" . wordwrap(ucfirst($currentUser['Client']['vc_fax_no']), 15, "<br>\n", true) . "</td>";
$html .= "</tr>";
$html .= "</table>";
$html .= "<br/>";
$html .= "<br/>";
$html .= "<br/>";
$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
$html .= "<tr  bgColor=\"#BFBFBF \">";
$html .= "<td width=\"5%\" align=\"center\"><b>SI. No.</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Claim No.</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Invoice No.</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Invoice Date</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Fuel Outlet</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Fuel Volume (ltrs)</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Refund Rate</b></td>";
$html .= "<td width=\"11%\" align=\"center\"><b>Invoice Status</b></td>";
$html .= "<td width=\"14%\" align=\"center\"><b>Reason for <br/>rejection</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Amount(N$)</b></td>";
$html .= "</tr>";
$total_amount = 0.00;

if (count($claimdetailreportpdf) > 0) {
    $i = 1;
    foreach ($claimdetailreportpdf as $claims) {
        $html .= "<tr>";
        $html .= "<td align=\"center\">" . $i . "</td>";
        $html .= "<td align=\"left\">" . $claims['ClaimHeader']['vc_claim_no'] . "</td>";
        $html .= "<td align=\"left\">" . $claims['ClaimDetail']['vc_invoice_no'] . "</td>";
        $invoice_date = !empty($claims['ClaimDetail']['dt_invoice_date']) ? date('d M Y', strtotime($claims['ClaimDetail']['dt_invoice_date'])) : '';
        $html .= "<td>" . $invoice_date . "</td>";
        $html .= "<td>" . $claims['ClaimDetail']['vc_outlet_code'] . "</td>";
        $liters = !empty($claims['ClaimDetail']['nu_litres']) ? number_format($claims['ClaimDetail']['nu_litres'],2,'.',',') : number_format(0,2,'.',',');
        $html .= "<td align=\"right\">" . $liters . "</td>";
        $html .= "<td align=\"right\">" . number_format($claims['ClaimDetail']['nu_refund_rate'], 2,'.',',') . "</td>";
        $html .= "<td align=\"left\">" . $globalParameterarray[$claims['ClaimDetail']['vc_status']] . "</td>";
        $html .= "<td align=\"right\">" . $claims['ClaimDetail']['vc_reasons'] ."</td>";
        $html .= "<td align=\"right\">" . number_format($claims['ClaimDetail']['nu_amount'], 2, '.', ',') . "</td>";
        $html .= "</tr>";
        
        $total_amount = $total_amount + $claims['ClaimDetail']['nu_amount'];
        $i++;
    }
    $html.= "<tr style=\"background-color:#eee;\">";
    $html .= "<td colspan=\"9\" style=\"text-align:right;\">Total Amount</td>";
    $sum = !empty($total_amount) ? number_format($total_amount, 2, '.', ',') : number_format(0, 2, '.', ',');
    $html .= "<td  style=\"text-align:right;\">" . $sum . "</td>";

    $html.= "</tr>";
}
$html .= "</table>";
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output('Claim-Details-Report' . '.pdf', 'D');
?> 
