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
$html .= "<h1 align=\"center\">Claim Summary Report</h1><br/><br/>";
$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" bgColor=\"#BFBFBF\" >";
$html .= "<tr style=\"font-size:8px;\">";
if (!empty($fromDate) || !empty($toDate)) {
    $html .= "<td width=\"33%\" color=\"#0000FF\" align=\"right\"><b>Claim summary report for the claims :</b></td>";
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
$html .= "<td width=\"11%\" align=\"center\"><b>Claim No.</b></td>";
$html .= "<td width=\"14%\" align=\"center\"><b>Claim Date</b></td>";
$html .= "<td width=\"18%\" align=\"center\" colspan=\"2\"><b>Claim Period</b><br/> From - To</td>";
$html .= "<td width=\"10%\" align=\"center\"><b>No. of invoice</b></td>";
$html .= "<td width=\"14%\" align=\"center\"><b>Fuel Claimed (ltrs)</b></td>";
$html .= "<td width=\"14%\" align=\"center\"><b>Claim Status</b></td>";
$html .= "<td width=\"14%\" align=\"center\"><b>Claim Amount(N$)</b></td>";
$html .= "</tr>";
$total_amount = 0.00;
if (count($claimsummaryreportpdf) > 0) {
    $i = 1;
    foreach ($claimsummaryreportpdf as $claimsummary) {
        $html .= "<tr>";
        $html .= "<td align=\"center\">" . $i . "</td>";
        $html .= "<td>" . $claimsummary['ClaimHeader']['vc_claim_no'] . "</td>";
        $claim_date = !empty($claimsummary['ClaimHeader']['dt_entry_date']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_entry_date'])) :
                '';
        $html .= "<td>" . $claim_date . "</td>";
        $claim_from = !empty($claimsummary['ClaimHeader']['dt_claim_from']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_claim_from'])) : '';
        $claim_to = !empty($claimsummary['ClaimHeader']['dt_claim_to']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_claim_to'])) : '';
        $html .= "<td>" . $claim_from . "</td>";

        $html .= "<td>" . $claim_to . "</td>";
        $html .= "<td align=\"right\">" . count($claimsummary['ClaimDetail']) . "</td>";
        
        
        $fuelcalimed = 0;
        foreach($claimsummary['ClaimDetail'] as $key) {
            if($key['vc_status']!='STSTY05')
            $fuelcalimed = $fuelcalimed+$key['nu_litres'];
        }

        //$fuelLiters = !empty($val['ClaimHeader']['nu_tot_litres'])? number_format($val['ClaimHeader']['nu_tot_litres'],'2','.',',') : number_format(0);

        $fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : number_format(0,2,'.',',');
        
        $html .= "<td align=\"right\">$fuelLiters</td>";
        $html .= "<td align=\"left\">" . $globalParameterarray[$claimsummary['ClaimHeader']['vc_status']] . "</td>";

        if ($claimsummary['ClaimHeader']['vc_status'] != 'STSTY05') {
            $Amount = !empty($claimsummary['ClaimHeader']['nu_tot_amount']) ? number_format($claimsummary['ClaimHeader']['nu_tot_amount'], '2', '.', ',') : number_format(0, '2', '.', '');
        } else {
            $Amount = "0.00";
        }
        
        $html .= "<td align=\"right\">$Amount</td>";
        $html .= "</tr>";

        if ($claimsummary['ClaimHeader']['vc_status'] != 'STSTY05') {
            $total_amount = $total_amount + $claimsummary['ClaimHeader']['nu_tot_amount'];
        }

        $i++;
    }
    $html.= "<tr style=\"background-color:#eee;\">";
    $html.= "<td colspan=\"8\" style=\"text-align:right;\" >Total</td>";
    $sum = !empty($total_amount) ? number_format($total_amount, 2, '.', ',') : number_format(0, 2, '.', ',');
    $html.="<td  style=\"text-align:right;\">" . $sum . "</td>";
    $html.= "</tr>";
}
$html .= "</table>";
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output('Claim-Summary-Report' . '.pdf', 'D');
?> 
