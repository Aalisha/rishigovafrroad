<?php

App::import('Vendor', 'tcpdf/tcpdf');

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information 
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('RFA');

$pdf->SetTitle('RFA');

$pdf->SetSubject('Customer Statement Report');

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

$html .= "<br/>";
$html .="<h2 align=\"center\">Customer Statement Report</h2>";
$html .="<br/><br/>";

$html .= "<table width=\"100%\" bgColor=\"#BFBFBF\"   cellspacing=\"0\" cellpadding=\"1\" align=\"left\" border=\"0\">";


$html .= "<tr style=\"font-size:8px;\">";
$html .= "<td width=\"35%\" color=\"#0000FF\" align=\"right\" ><b>Pre-Paid Customer Statement Report</b></td>";


if(isset($SearchfromDate) && $SearchfromDate!='')
$html .= "<td width=\"15%\"><b>From Date : </b>".date('d-M-Y',strtotime($SearchfromDate))."</td>";
else
$html .= "<td width=\"15%\"></td>";

if(isset($SearchtoDate) && $SearchtoDate!='')
$html .= "<td width =\"15%\"><b>To Date : </b>".date('d-M-Y',strtotime($SearchtoDate))."</td>";
else
$html .= "<td width=\"15%\"></td>";


$html .= "<td width=\"35%\" >&nbsp;&nbsp;&nbsp;Print Date : ".date('d-M-y')."</td>";

$html .= "</tr>";
$html .= "<tr >";

$html .= "<td width=\"100%\" colspan=\"5\" align=\"left\">";
$html .= "&nbsp;</td></tr>";

$html .= "<tr>";
$addressnovalue = 'N/A';

$html .= "<td width=\"100%\" colspan=\"5\" align=\"left\">
<table  width=\"100%\" align=\"left\" border=\"0\" cellpadding=\"1\"cellspacing=\"0\">";
$html .= "<tr>";
$html .= "<td width=\"10%\"><b>Customer Name :</b></td>";
$html .= "<td width=\"20%\">".ucwords($customername)."</td>";
$html .= "<td width=\"40%\"></td>";
$html .= "<td width=\"10%\"><b>Account Number :</b> </td>";
$html .= "<td width=\"20%\">".trim($customer['Customer']['vc_cust_no'])."</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width=\"10%\"><b>Company :</b> </td>";
$html .= "<td width=\"20%\">".$customer['Customer']['vc_company']."</td>";
$html .= "<td width=\"40%\"></td>";
$html .= "<td width=\"10%\"><b>Mobile No. :</b> </td>";
$html .= "<td width=\"20%\">".trim($customer['Customer']['vc_mobile_no'])."</td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width=\"10%\"><b>Address 1 :</b> </td>";
$html .= "<td width=\"20%\">".$customer['Customer']['vc_address1']."</td>";
$html .= "<td width=\"40%\"></td>";
$html .= "<td width=\"10%\"><b>Address 2 :</b> </td>";
if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))		
$html .= "<td width=\"20%\">".
		trim(ucfirst($currentUser['Customer']['vc_address2']))
		
." </td>";
else
$html .= "<td width=\"20%\">".$addressnovalue." </td>";
$html .= "</tr>";
$html .= "<tr>";
$html .= "<td width=\"10%\"><b>Address 3 :</b></td>";

if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
$html .= "<td width=\"20%\">".
		trim(ucfirst($currentUser['Customer']['vc_address3']))
		
." </td>";
else
$html .= "<td width=\"20%\">".$addressnovalue." </td>";
$html .= "<td width=\"40%\"></td>";
$html .= "<td width=\"10%\"><b>Email :</b></td>";
$html .= "<td width=\"20%\">".$customer['Customer']['vc_email']." </td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td width=\"10%\"><b>Tel. No. :</b></td>";
$html .= "<td width=\"20%\">".$customer['Customer']['vc_tel_no']." </td>";
$html .= "<td width=\"40%\"></td>";
$html .= "<td width=\"10%\"><b>Fax No. :</b></td>";
$html .= "<td width=\"20%\">".$customer['Customer']['vc_fax_no']." </td>";
$html .= "</tr>";

$html .= "</table></td>";

$html .= "</tr>";

$html .= "</table>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\"><tr><td>&nbsp;</td></tr>";

$html .= "</table>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";

$html .= "<tr>";
$html .= "<td bgColor=\"#BFBFBF \"  width=\"12%\" align=\"center\"><b>Opening Balance (N$)</b></td>";
$html .= "<td bgColor=\"#BFBFBF \" width=\"10%\" align=\"center\"><b>Recharge (N$)</b></td>";
$html .= "<td bgColor=\"#BFBFBF \"  width=\"15%\" align=\"center\"><b>Admin Fees (N$)</b></td>";
$html .= "<td width=\"10%\" bgColor=\"#BFBFBF \" align=\"center\"><b>Card Issue (N$)</b></td>";
$html .= "<td width=\"10%\" bgColor=\"#BFBFBF \" align=\"center\"><b>CBC Total (N$)</b></td>";
$html .= "<td width=\"11%\" bgColor=\"#BFBFBF \" align=\"center\"><b>MDC Total (N$)</b></td>";
$html .= "<td width=\"11%\" bgColor=\"#BFBFBF\"  color=\"red\" align=\"center\"><b>Refund (N$)</b></td>";
$html .= "<td bgColor=\"#BFBFBF \"  width=\"21%\" align=\"center\"><b>Account Balance (N$)</b></td>";
$html .= "</tr>";
//C34A2C
$openingbalance='';

if(isset($TotalsumRecharge) && $TotalsumRecharge!='' ) 
$TotalsumRecharge= $TotalsumRecharge; 
else 
$TotalsumRecharge=0;	

if(isset($Noofrecharge) && $Noofrecharge!='' ) 
$Noofrecharge= ($Noofrecharge)*($globalParameterarray['CBCADMINFEE']); 
else 
$Noofrecharge =0;
                                  
if(isset($sumofcardsIssued) && $sumofcardsIssued!='' ) 
$sumofcardsIssuedcost= ($sumofcardsIssued)*($globalParameterarray['CBCADMINFEE']); 
else
$sumofcardsIssuedcost= 0;                   
                   
 if(isset($totalcbcamt) && $totalcbcamt!='' ) 
 $totalcbcamt = $totalcbcamt; 
 else 
 $totalcbcamt = 0;
 
 if(isset($totalmdcamt) && $totalmdcamt!='' ) 
 $totalmdcamt =$totalmdcamt; 
 else 
 $totalmdcamt =0;
 
 if(isset($TotalsumRefund) && $TotalsumRefund!='' ) 
  $TotalsumRefund=$TotalsumRefund; 
 else 
   $TotalsumRefund= 0;
   
					$openingbalance='';
					$totalRefundAll='';
					$totalpaid='';
					
					//$totalRefundAll = $customer['Customer']['nu_account_balance']+$TotalsumRecharge +$TotalsumRefund;
					//$nu_account_balance = $customer['Customer']['nu_account_balance'];
					$totalpaid      = $Noofrecharge+$totalcbcamt+$totalmdcamt+$sumofcardsIssuedcost;
					$nu_account_balance = ($funcopeningbalance+$TotalsumRecharge+$TotalsumRefund)-$totalpaid;

                    
$html .= "<tr>";
$html .= "<td width=\"12%\" align=\"right\" color=\"#0000FF\"><b>".wordwrap(number_format($funcopeningbalance, 2, '.', ','),15, "<br>\n", true)."</b></td>";
$html .= "<td width=\"10%\" align=\"right\" color=\"#0000FF\"><b>".wordwrap(number_format($TotalsumRecharge, 2, '.', ','),15, "<br>\n", true)."</b></td>";
$html .= "<td width=\"15%\" align=\"right\" color=\"red\"><b>".wordwrap(number_format($Noofrecharge, 2, '.', ','),15, "<br>\n", true)."</b></td>";
$html .= "<td width=\"10%\" align=\"right\" color=\"red\"><b>".wordwrap(number_format($sumofcardsIssuedcost, 2, '.', ','),15, "<br>\n", true)."</b></td>";
$html .= "<td width=\"10%\" align=\"right\" color=\"red\"><b>".wordwrap(number_format($totalcbcamt, 2, '.', ','),15, "<br>\n", true)."</b></td>";
$html .= "<td  width=\"11%\"  align=\"right\" color=\"red\"><b>".wordwrap(number_format($totalmdcamt, 2, '.', ','),15, "<br>\n", true)."</b></td>";
$html .= "<td  width=\"11%\"  align=\"right\" color=\"red\"><b>".wordwrap(number_format($TotalsumRefund, 2, '.', ','),15, "<br>\n", true)."</b></td>";

					$pos = strpos($nu_account_balance,'-');
					
					if($pos!== false){
						$html .= "<td  width=\"21%\" align=\"right\" color=\"#0000FF\"><b>(".trim(wordwrap(number_format($nu_account_balance, 2, '.', ','),30, "<br>\n", true),'-').")</b></td>";			
						
					} else {				

						$html .= "<td  width=\"21%\" align=\"right\" color=\"#0000FF\"><b>" . wordwrap(number_format($nu_account_balance, 2, '.', ','),30, "<br>\n", true). "</b></td>";
						
					
				
				 }

$html .= "</tr>";

$html .= "</table>";
$html .= "<br/><br/>";

$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";



$html .= "<tr>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"3%\" align=\"center\"><b>SI. No.</b></td>";
$html .= "<td bgColor=\"#BFBFBF\"width=\"9%\" align=\"center\"><b>Transaction<br> Type</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"10%\" align=\"center\"><b>Transaction <br>Date</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"15%\" align=\"center\"><b>Remarks</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"10%\" align=\"center\"><b>Issue/Ref.<br> Date</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"10%\" align=\"center\"><b>Card No.</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"11%\" align=\"center\"><b>Permit/Ref. No.</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"11%\" align=\"center\"><b>Vehicle Reg. No.</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"9%\" align=\"center\"><b>Net Amount (N$)</b></td>";
$html .= "<td bgColor=\"#BFBFBF\" width=\"12%\" align=\"center\"><b>Running <br>Balance (N$)</b></td>";


	$html .= "</tr>";
	$runningValue ='';
	//$runningValue = $totalopeningbalance;
		$runningValue = $funcopeningbalance;
				
			

if ($totalrows > 0) {
    $i = 1;
    foreach ($storeallValues as $index => $value) {
		            	$bracket=0;   
						$remarks ='';						

						$transaction_type = $value['Temp']['transaction_type'];
						$permit_refno = (isset($value['Temp']['permit_refno']) && $value['Temp']['permit_refno']!='' && $value['Temp']['permit_refno']!='NA')?$value['Temp']['permit_refno']:'N/A';
						$remarks      = (isset($value['Temp']['remarks']) && $value['Temp']['remarks']!='' && $value['Temp']['remarks']!='NA')?$value['Temp']['remarks']:'N/A';
						$cardno       = (isset($value['Temp']['cardno']) && $value['Temp']['cardno']!='' && $value['Temp']['cardno']!='NA')?$value['Temp']['cardno']:'N/A';
						$vehicleregno = (isset($value['Temp']['vehicleregno']) && $value['Temp']['vehicleregno']!='' && $value['Temp']['vehicleregno']!='NA')?$value['Temp']['vehicleregno']:'N/A';
						
						$netamount        = $value['Temp']['netamount'];
						
						
						if ($value['Temp']['transaction_type'] == 'Recharge'){
						
							$transaction_type = 'Recharge';
							if($vehicleregno=='STSTY04')
							{
							$cardno='N/A';
							$vehicleregno='N/A';
							$permit_refno = $value['Temp']['permit_refno'];

 
							if($value['Temp']['netamount'] == 0)
							{
							 $netamount        = 0;				
							 $runningValue     = $runningValue+0;							 
						 	 $netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $runningValue = ($runningValue)+($netamount);

							 //$remarks = ;
							 //$remarks = $value['Temp']['netamount'];

							}else{
							//echo 'run--'.$runningValue;
							 $netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $runningValue = ($runningValue)+($netamount);
							 $remarks = $value['Temp']['netamount'].' - '.$globalParameterarray['CBCADMINFEE'].' ( Admin Fee )';
 
							}
							
							}else{
							
							
 
							if($value['Temp']['netamount'] == 0)
							{
							 $netamount        = 0;				
							 $runningValue     = $runningValue+0;							 
							 $remarks = 'Recharge  '.$globalParameterarray[$vehicleregno];
 
							 //$remarks = ;
							 //$remarks = $value['Temp']['netamount'];

							}else{
							//echo 'run--'.$runningValue;
							 $runningValue = ($runningValue)+0;
							 $remarks = 'Recharge  '.$globalParameterarray[$vehicleregno];
 
							}

							$cardno='N/A';
							$vehicleregno='N/A';
							$permit_refno = $value['Temp']['permit_refno'];

							}
						}
						if ($value['Temp']['transaction_type'] == 'Refund'){
							$transaction_type = 'Refund';
							if($vehicleregno=='STSTY04')
							{
							$vehicleregno='';
							$cardno='';
							$remarks = ' Refund from HO ';
							//VehicleRegNo							
							if($value['Temp']['netamount'] == 0)
							{
							// $netamount        = 'Pending';				
							 $runningValue     = $runningValue+0;
							}else{
							 //$netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $netamount        = $value['Temp']['netamount'];				
							 $runningValue = $runningValue+$netamount;
							}
							$vehicleregno='N/A';
							$cardno='N/A';
							
							
						  }else {
						  
							$remarks = ' Refund '.$globalParameterarray[$vehicleregno].' from HO ';
							
							//VehicleRegNo							
							if($value['Temp']['netamount'] == 0)
							{
							// $netamount        = 'Pending';				
							 $runningValue     = $runningValue+0;
							}else{
							 //$netamount        = $value['Temp']['netamount']-$globalParameterarray['CBCADMINFEE'];				
							 $netamount        = $value['Temp']['netamount'];				
							 $runningValue = $runningValue+0;
							}
							$vehicleregno='N/A';
							$cardno='N/A';
							
						  }
						}
						
						
						
						if ($value['Temp']['transaction_type'] == 'CardsIssued'){
							$bracket=1;
							$vehicleregno='N/A';
			
							$transaction_type = 'Card Issue';
							if(isset($value['Temp']['running']) && $value['Temp']['running']>0){
							//$remarks = $value['Temp']['running'].' Cards ';
							//else 					
						    	
							$netamount= ($value['Temp']['running'])*($globalParameterarray['CBCADMINFEE']);
							$runningValue = $runningValue-$netamount;
							}
						}
						
						if ($value['Temp']['transaction_type']!= 'Recharge' && $value['Temp']['transaction_type']!= 'CardsIssued' && $value['Temp']['transaction_type']!= 'Refund'){
						$bracket=1;
							$runningValue = $runningValue-$netamount;
							if($value['Temp']['transaction_type']== 'MDC' || $value['Temp']['transaction_type']== 'CBC')
							$remarks = $value['Temp']['remarks'];
											
						}

        $html .= "<tr>";
        $html .= "<td align=\"right\">" . $i . "</td>";
        $html .= "<td>" . $transaction_type . "</td>";
        $html .= "<td>" . date('d-M-Y', strtotime($value['Temp']['transaction_date'])) . "</td>";
        $html .= "<td>" . $remarks . "</td>";
		if(isset($value['Temp']['issue_ref_date']) && $value['Temp']['issue_ref_date']!=''){
        $html .= "<td>" . date('d-M-Y', strtotime($value['Temp']['issue_ref_date'])) . "</td>";
		} else {
		$html .= "<td> N/A</td>";		
		}
        $html .= "<td align=\"right\">" . $cardno . "</td>";
        $html .= "<td>" . $permit_refno . "</td>";
        $html .= "<td>" . $vehicleregno . "</td>";
		if($bracket==1) {
        $html .= "<td align=\"right\"> (" . wordwrap(number_format($netamount, 2, '.', ','),20, "<br>\n", true) . ") </td>";
		}else {
        $html .= "<td align=\"right\">" . wordwrap(number_format($netamount, 2, '.', ','),20, "<br>\n", true). "</td>";
        }
		
		$pos = strpos($runningValue,'-');
		if($pos!== false){
		
			$html .= "<td align=\"right\">(".trim(wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true),'-').")</td>";

		}else{
		$html .= "<td align=\"right\">" . wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true) . "</td>";
        
		
		}
		
		
		$html .= "</tr>";
        $i++;
    }
	$html .= "<tr>";
	$html .= "<td width=\"88%\" colspan=\"9\" align=\"right\" style=\"text-align:'right';\" color=\"#0000FF\"><b>Closing Balance</b> </td>";
		$pos = strpos($runningValue,'-');
		if($pos!== false){
		
		$html .= "<td align=\"right\"><b>(".trim(wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true),'-').")</b></td>";

		}else{
		$html .= "<td align=\"right\"><b>" . wordwrap(number_format($runningValue, 2, '.', ','),30, "<br>\n", true). "</b></td>";
        
		
		}
		
	$html .= "</tr>";

}else {

$html .= "<tr>";
$html .= "<td width=\"15%\" colspan=\"10\">No Record Found</td>";
$html .= "</tr>";

}


$html .= "</table>";


$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$Filename =  $customer['Customer']['vc_cust_no'].'-CustomerStatement-Report.pdf';
	$pdf->Output(WWW_ROOT.'upload-files-for-cbc-mdc/'.$Filename, 'F');


//$pdf->Output('cbc-pdfs/'.$Filename, 'D');


