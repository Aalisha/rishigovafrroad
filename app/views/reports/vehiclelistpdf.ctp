<?php 
App::import('Vendor', 'tcpdf/tcpdf');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RFA');
$pdf->SetTitle('RFA');
$pdf->SetSubject('Vehicle History Report ');

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

$html =" ";
$html .= "<br/>";

$html .="<h2 align=\"center\">Vehicle History Report</h2>";

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
        
        if(!empty($vehicletypename)){
            $html .= "<td width=\"10%\">Vehicle Type :</td>";
            $html .= "<td width=\"10%\">" . @$vehicletypename . "</td>";
        }else{
            $html .= "<td width=\"10%\"></td>";
            $html .= "<td width=\"10%\"></td>";
        }       

$html .= "</tr>";

$html .= "<tr>";
$html .= "<td width=\"10%\">Customer Name :</td>";
$html .= "<td width=\"10%\">" . $vc_customer_name . "</td>";

        if(!empty($toDate)){
            $toDate = date('d M Y',  strtotime($toDate));
            $html .= "<td width =\"20%\">To Date : ".$toDate."</td>";
        }else{
            $html .= "<td width=\"20%\"></td>";
        }

$html .= "<td width=\"15%\"> &nbsp; </td>";
$html .= "<td width=\"15%\"> &nbsp; </td>";
$html .= "</tr>";

$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";

    $html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
        $html .= "<tr bgcolor=\"#BFBFBF \">";
            $html .= "<td width=\"5%\" align=\"center\">S. No.</td>";
            $html .= "<td width=\"15%\" align=\"center\">Vehicle LIC. No.</td>";
            $html .= "<td width=\"15%\" align=\"center\">Vehicle Reg. No.</td>";
            $html .= "<td width=\"10%\" align=\"center\">Registration Date</td>";
            $html .= "<td width=\"15%\" align=\"center\">Vehicle Type</td>";
            $html .= "<td width=\"15%\" align=\"center\">V Rating</td>";
            $html .= "<td width=\"15%\" align=\"center\">D/T Rating</td>";
            $html .= "<td width=\"10%\" align=\"center\">Rate (N$)</td>";
         $html .= "</tr>";
			
    if(count($vehiclereport) > 0) {
		$i = 1;
		foreach ($vehiclereport as $showvehiclereport) {

		
		$vc_v_rating = isset($showvehiclereport['VehicleDetail']['vc_v_rating']) ? 
									$this->Number->format($showvehiclereport['VehicleDetail']['vc_v_rating'], array(
									'places' => false,
									'before' => false,
									'escape' => false,
									'decimals' => false,
									'thousands' => ','
									)):'';
				$vc_rate   =  isset($showvehiclereport['VehicleDetail']['vc_rate']) ? 
									$this->Number->format($showvehiclereport['VehicleDetail']['vc_rate'], array(
									 'places' => 2,
									'before' => false,
									'escape' => false,
									'decimals' => '.',
									'thousands' => ','
									)):'';

			$vc_dt_rating = isset($showvehiclereport['VehicleDetail']['vc_dt_rating']) ? 
			$this->Number->format($showvehiclereport['VehicleDetail']['vc_dt_rating'], array(
			'places' => false,
			'before' => false,
			'escape' => false,
			'decimals' => false,
			'thousands' => ','
			)):'';
		$html .= "<tr>";
		$html .= "<td align=\"center\">".$i."</td>";
		 $html .= "<td>".$showvehiclereport['VehicleDetail']['vc_vehicle_lic_no']."</td>";
		$html .= "<td>".$showvehiclereport['VehicleDetail']['vc_vehicle_reg_no']."</td>";
		$createdDate = !empty($showvehiclereport['VehicleDetail']['dt_created_date']) ?
							date('d M Y', strtotime($showvehiclereport['VehicleDetail']['dt_created_date'])):
							'';
		$html .= "<td>".$createdDate."</td>";
		$html .= "<td>".$showvehiclereport['VEHICLETYPE']['vc_prtype_name']."</td>";
		$html .= "<td align=\"right\">$vc_v_rating</td>";
		$html .= "<td align=\"right\">$vc_dt_rating</td>";
		$html .= "<td align=\"right\">$vc_rate</td>";

		$html .= "</tr>";
		$i++;
		
		}

    } else {

    $html .= "<tr>";
    $html .='<td colspan="8" style="text-align:center;">  No Records Found </td>';
    $html .= "</tr>";

    }



    $html .= "</table>";


    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


    $pdf->Output('Vehicle-history-report-'.date('d-M-Y').'.pdf', 'D'); 

    
?> 
