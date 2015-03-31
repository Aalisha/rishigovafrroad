<?php 
App::import('Vendor', 'tcpdf/tcpdf');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RFA');
$pdf->SetTitle('RFA');
$pdf->SetSubject('Vehicle Report');


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
$html .="<h2 align=\"center\">Vehicle Assessment History Report</h2>";
$html .="<br/>";
$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";

$html .= "<tr>";
$html .= "<td width=\"10%\">RFA Account No. :</td>";
$html .= "<td width=\"10%\">" . $vc_customer_no . "</td>";


        if(!empty($fromdate)){
            $fromdate = date('d M Y',  strtotime($fromdate));
            $html .= "<td width=\"20%\">From Date : ".$fromdate."</td>";
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

        if(!empty($todate)){
            $todate = date('d M Y',  strtotime($todate));
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

$html .= "<td align=\"center\">S. No.</td>";
$html .= "<td align=\"center\">Assessment Date</td>";
$html .= "<td align=\"center\">Assessment No</td>";
$html .= "<td align=\"center\">Vehicle LIC. No.</td>";
$html .= "<td align=\"center\">Vehicle Reg. No.</td>";
$html .= "<td align=\"center\">Vehicle Type</td>";
$html .= "<td align=\"center\">Pay Frequency</td>";
$html .= "<td align=\"center\">Prev. End OM</td>";
$html .= "<td align=\"center\">End OM</td>";
$html .= "<td align=\"center\">KM Travel on Namibian Road Network</td>";
$html .= "<td align=\"center\">Rate(N$)</td>";
$html .= "<td align=\"center\">Payable(N$)</td>";
$html .= "<td align=\"center\">Status</td>";
$html .= "</tr>";


if (count($assessmentreport) > 0) {

    foreach ($assessmentreport as $key => $showassessmentreport) {

        $html .= "<tr>";
        $html .= "<td align=\"center\">" . ($key + 1) . "</td>";
        $createdDate = !empty($showassessmentreport['AssessmentVehicleDetail']['dt_created_date']) ?
                          date('d M Y', strtotime($showassessmentreport['AssessmentVehicleDetail']['dt_created_date'])):
                          '';
                            
        $html .= "<td>" . $createdDate . "</td>";
		$html .= "<td>" . $showassessmentreport['AssessmentVehicleDetail']['vc_assessment_no'] . "</td>";
        $html .= "<td>" . $showassessmentreport['AssessmentVehicleDetail']['vc_vehicle_lic_no'] . "</td>";
        $html .= "<td>" . $showassessmentreport['AssessmentVehicleDetail']['vc_vehicle_reg_no'] . "</td>";
        $html .= "<td>" . $showassessmentreport['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'] . "</td>";
        $html .= "<td>" . $showassessmentreport['AssessmentVehicleDetail']['vc_pay_frequency'] . "</td>";
        
        
        $PrevEndOm = isset($showassessmentreport['AssessmentVehicleDetail']['vc_prev_end_om']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_prev_end_om'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
                        
       $html .= "<td align=\"right\">$PrevEndOm</td>";
                        
       $EndOm = isset($showassessmentreport['AssessmentVehicleDetail']['vc_end_om']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_end_om'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

     $html .= "<td align=\"right\">$EndOm</td>";      
        
      
        
      
     $KMTravld = isset($showassessmentreport['AssessmentVehicleDetail']['vc_km_travelled']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_km_travelled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
        
        
        
        
        
        $html .= "<td align=\"right\">$KMTravld</td>";
        
        $Rate= isset($showassessmentreport['AssessmentVehicleDetail']['vc_rate']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_rate'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';
        
        
        $html .= "<td align=\"right\">$Rate</td>";
        
        
        $Payable = isset($showassessmentreport['AssessmentVehicleDetail']['vc_payable']) ? 
                                $this->Number->format($showassessmentreport['AssessmentVehicleDetail']['vc_payable'], array(
                                'places' => 2,
                                'before' => false,
                                'escape' => false,
                                'decimals' => '.',
                                'thousands' => ','
                                )):'';
                        
	$html .= "<td align=\"right\">$Payable</td>";
        
	$html .= "<td align=\"left\">".$globalParameterarray[$showassessmentreport['AssessmentVehicleMaster']['vc_status']]."</td>";
                
        $html .= "</tr>";
    }
} else {

    $html .= "<tr>";
    $html .= "<td colspan='12' style='text-align:center;'>No Records Found</td>";
    $html .= "</tr>";
}


$html .= "</table>";

$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
 
$pdf->Output('Vehicle-Assessment-History-Report-' . date('d-M-Y') . '.pdf', 'D');
?> 
