<?php $currentUser = $this->Session->read('Auth');
App::import('Vendor','tcpdf/tcpdf'); 
// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
// set document information 
$pdf->SetCreator(PDF_CREATOR); 
$pdf->SetAuthor('RFA - FLR'); 
$pdf->SetTitle('RFA - FLR'); 
$pdf->SetSubject('Payment Detail Report'); 
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
$html .= "<h1 align=\"center\">Payment Detail Report</h1><br/><br/>";
$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" bgColor=\"#BFBFBF\" >";
$html .= "<tr style=\"font-size:8px;\">";
if (!empty($fromDate) || !empty($toDate)) {
    $html .= "<td width=\"33%\" color=\"#0000FF\" align=\"right\"><b>Payment detail report for the claims :</b></td>";
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

$html .= "<table width = \"100%\" cellspacing=\"0\" cellpadding=\"5\" border=\"1\">";
$html .= "<tr  bgColor=\"#BFBFBF \">";
$html .= "<td width=\"5%\" align=\"center\"><b>SI. No.</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Claim No.</b></td>";
$html .= "<td width=\"10%\" align=\"center\"><b>Claim Date</b></td>";
$html .= "<td width=\"20%\" align=\"center\" colspan=\"2\"><b>Claim Period</b><br/> From - To</td>";
$html .= "<td width=\"11%\" align=\"center\"><b>Fuel Claimed (ltrs)</b></td>";
$html .= "<td width=\"11%\" align=\"center\"><b>Claim Amount (N$)</b></td>";
$html .= "<td width=\"11%\" align=\"center\"><b>Payment Status</b></td>";
$html .= "<td width=\"11%\" align=\"center\"><b>Payment Amount(N$)</b></td>";
//$html .= "<td width=\"9%\" align=\"center\"><b>Expected Payment Date</b></td>";
$html .= "<td width=\"11%\" align=\"center\"><b>Payment Date</b></td>";

$html .= "</tr>";

 $tot_claim_amount = 0.00;
 $tot_payment_amount = 0.00;
if (count($paymentreportpdf) > 0) {
    $i = 1;
    foreach ($paymentreportpdf as $paymentreport) {
        $html .= "<tr>";
        $html .= "<td align=\"center\">" . $i . "</td>";
        $html .= "<td>". $paymentreport['ClaimHeader']['vc_claim_no']."</td>";
        $claim_date = !empty($paymentreport['ClaimHeader']['dt_entry_date'])?date('d M Y', strtotime($paymentreport['ClaimHeader']['dt_entry_date'])):'';
        $html .= "<td>" . $claim_date . "</td>";
        $claim_from = !empty($paymentreport['ClaimHeader']['dt_claim_from']) ?date('d M Y',strtotime($paymentreport['ClaimHeader']['dt_claim_from'])):'';
        $claim_to = !empty($paymentreport['ClaimHeader']['dt_claim_to'])?date('d M Y',strtotime($paymentreport['ClaimHeader']['dt_claim_to'])):'';
        $html .= "<td>" . $claim_from ."</td>";
        $html .= "<td>" . $claim_to . "</td>";
        
        
        
        $fuelcalimed = 0;
        foreach($paymentreport['ClaimDetail'] as $key) {
            if($key['vc_status']!='STSTY05')
            $fuelcalimed = $fuelcalimed+$key['nu_litres'];
        }
        
        $fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : number_format(0,2,'.',',');
        
        
        //$fuelLiters = !empty($paymentreport['ClaimHeader']['nu_tot_litres'])?number_format($paymentreport['ClaimHeader']['nu_tot_litres']):number_format(0);
        $html .= "<td align=\"right\">$fuelLiters</td>";
        
        if ($paymentreport['ClaimHeader']['vc_status'] != 'STSTY05') {
            $claim_amount = !empty($paymentreport['ClaimHeader']['nu_tot_amount'])?number_format($paymentreport['ClaimHeader']['nu_tot_amount'],'2','.',','):number_format(0,'2','.','');
        } else {
           $claim_amount =  "0.00";
        }
        
        $html .= "<td align=\"right\">$claim_amount</td>";
        $html .= "<td align=\"left\">".$globalParameterarray[$paymentreport['ClaimHeader']['vc_status']]."</td>";
        $PaymentAmount = !empty($paymentreport['ClaimHeader']['nu_payment_amount'])?number_format($paymentreport['ClaimHeader']['nu_payment_amount'],'2','.',','):number_format(0,'2','.',',');
        $html .= "<td align=\"right\">$PaymentAmount</td>";
//        $ExpectedDate = !empty($paymentreport['ClaimHeader']['dt_expected_date'])?date('d M Y',strtotime($paymentreport['ClaimHeader']['dt_expected_date'])):'';
//        $html .= "<td align=\"right\">".$ExpectedDate ."</td>";
        $PayMentDate = !empty($paymentreport['ClaimHeader']['dt_payment_date'])?date('d M Y',strtotime($paymentreport['ClaimHeader']['dt_payment_date'])):'';
        $html .= "<td align=\"right\">".$PayMentDate."</td>";
        $html .= "</tr>";
      
        $tot_payment_amount   =   $tot_payment_amount + $paymentreport['ClaimHeader']['nu_payment_amount'];
        
        if($paymentreport['ClaimHeader']['vc_status']!='STSTY05') 
        {
            $tot_claim_amount   =   $tot_claim_amount + $paymentreport['ClaimHeader']['nu_tot_amount'];
        }
        
        $i++;
    }
    
    $html.="<tr style=\"background-color:#eee;\">";
        $html.="<td colspan=\"6\" style=\"text-align:right;\">Total</td>";
        $calim_sum = !empty($tot_claim_amount)?number_format($tot_claim_amount,2,'.',','):number_format(0,'2','.',',');
        $html.="<td style=\"text-align:right;\">".$calim_sum."</td>";
        
        $html.= "<td colspan=\"1\" style=\"text-align:right;\" >Total</td>";
        $payment_sum = !empty($tot_payment_amount)?number_format($tot_payment_amount,2,'.',','):number_format(0,'2','.',',');
        $html.="<td style=\"text-align:right;\">".$payment_sum."</td>";
        
        $html.= "<td>&nbsp;</td>";
        $html.= "<td>&nbsp;</td>";
      
    $html.="</tr>";
} 

$html .= "</table>";
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output('Payment-Detail-Report'.'.pdf', 'D'); 
?> 
