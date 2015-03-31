<?php $currentUser = $this->Session->read('Auth');
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
$html .= "<h1 align=\"center\">Customer Recharge Report</h1><br><br>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\" bgColor=\"#BFBFBF\" >";

	$html .= "<tr style=\"font-size:8px;\">";
		if(!empty($fromDate) || !empty($toDate)){
		$html .= "<td width=\"33%\" color=\"#0000FF\" align=\"right\"><b>Recharge Report :</b></td>";
		}else{
		$html .= "<td width=\"33%\">&nbsp;</td>";
		}
         if(!empty($fromDate)){
            $fromDate = date('d-M-Y',  strtotime($fromDate));
        $html .= "<td width=\"18%\" align=\"right\"><b>From Date : </b>".$fromDate."</td>";
		
        }else{
        $html .= "<td width=\"18%\"></td>";
        }
        
        if(!empty($toDate)){
            $toDate = date('d-M-Y',  strtotime($toDate));
            $html .= "<td width=\"49%\"><b>To Date : </b>".$toDate."</td>";
			
        }else{
        $html .= "<td width=\"49%\"></td>";
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
		
		$html .= "<td width=\"12%\" ><b>Address :</b></td>";
		
		
		$address = trim(ucfirst($currentUser['Customer']['vc_address1']));
		
		if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address2']));
		
		if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address3']));
		
									
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



$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";

    $html .= "<tr  bgColor=\"#BFBFBF \">";

		$html .= "<td width=\"5%\" align=\"center\"><b>SI. No.</b></td>";
        $html .= "<td width=\"9%\" align=\"center\"><b>Recharge Date</b></td>";
        $html .= "<td width=\"10%\" align=\"center\"><b>Cheque/Bank Ref. No.</b></td>";
        $html .= "<td width=\"10%\" align=\"center\"><b>Cheque/Bank Ref. Date</b></td>";
        $html .= "<td width=\"11%\" align=\"center\"><b>Recharge Amount (N$)</b></td>";
        $html .= "<td width=\"11%\" align=\"center\"><b>Approved Amount (N$)</b></td>";
        $html .= "<td width=\"10%\" align=\"center\"><b>Admin Fee (N$)</b></td>";
        $html .= "<td width=\"11%\" align=\"center\"><b>Net Amount (N$)</b></td>";
		$html .= "<td width=\"8%\" align=\"center\"><b>Recharge Status</b></td>";
		$html .= "<td width=\"15%\" align=\"center\"><b>Reason</b></td>";
        
$html .= "</tr>";

	if (count($report) > 0) {
		$i = 1;
		foreach($report as $val){
			
			$html .= "<tr>";
			
				$html .= "<td align=\"right\">".$i."</td>";
				$entryDate =!empty($val['AccountRecharge']['dt_entry_date']) ?
														  date('d-M-Y', strtotime($val['AccountRecharge']['dt_entry_date'])):
														  '';			  
				$html .= "<td>".$entryDate."</td>";
				
				$html .= "<td>".wordwrap($val['AccountRecharge']['vc_ref_no'], 20, "<br>\n", true)."</td>";
				
				$paymentDate =!empty($val['AccountRecharge']['dt_payment_date']) ?
														  date('d-M-Y', strtotime($val['AccountRecharge']['dt_payment_date'])):
														  '';
				$html .= "<td>".$paymentDate."</td>";
				
				$html .= "<td align=\"right\">".wordwrap(number_format($val['AccountRecharge']['nu_amount_un'], 2, '.', ','), 30, "<br>\n", true)."</td>";
				
				$html .= "<td align=\"right\">".wordwrap(number_format($val['AccountRecharge']['nu_amount'], 2, '.', ','), 30, "<br>\n", true)."</td>";
				
				$html .= "<td align=\"right\">".wordwrap(number_format($val['AccountRecharge']['nu_hand_charge'], 2, '.', ','), 12, "<br>\n", true)."</td>";
				
					if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY04' && !empty($val['AccountRecharge']['nu_amount']) && $val['AccountRecharge']['nu_amount'] > 100){
					
						$html .= "<td align=\"right\">".wordwrap(number_format((($val['AccountRecharge']['nu_amount']) - 100), 2, '.', ','), 30, "<br>\n", true)."</td>";
					}
					else{
						$novalue='N/A';
						$html .= "<td align=\"right\">".$novalue."</td>";
					}
				$html .= "<td>".$globalParameterarray[$val['AccountRecharge']['vc_recharge_status']]."</td>";
				
					if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY05'){
					
						$html .= "<td>".$val['AccountRecharge']['vc_remarks']."</td>";
					
					} else{
					
						$novalue='N/A';
						$html .= "<td align=\"left\">".$novalue."</td>";
					}
				
			
			$html .= "</tr>";
			$i++;
		}
	
	} else {

		 $html .= "<tr>";
		 $html .='<td colspan="10" style="text-align:center;">  No Records Found </td>';
		 $html .= "</tr>";

	}
    
   
$html .= "</table>";


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('Customer-Recharge-Report'.'.pdf', 'D'); 
?> 
