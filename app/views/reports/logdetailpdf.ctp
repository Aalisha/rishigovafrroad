<?php
App::import('Vendor', 'tcpdf/tcpdf');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RFA');
$pdf->SetTitle('RFA');

$pdf->SetSubject('Log Sheet History Report');

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
$html .="<h2 align=\"center\">Log Sheet History Report</h2>";
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
$html .= "<td width=\"4%\" align=\"center\">S. No.</td>";
$html .= "<td width=\"8%\" align=\"center\">Log Date</td>";
$html .= "<td width=\"9%\" align=\"center\">Vehicle Reg. No.</td>";
$html .= "<td width=\"10%\" align=\"center\">Vehicle LIC. No.</td>";
$html .= "<td width=\"8%\" align=\"center\">Vehicle Type</td>";
$html .= "<td width=\"10%\" align=\"center\">Driver Name</td>";
$html .= "<td width=\"7%\" align=\"center\">Start Odometer</td>";
$html .= "<td width=\"7%\" align=\"center\">End Odometer</td>";
$html .= "<td width=\"9%\" align=\"center\">Origin</td>";
$html .= "<td width=\"9%\" align=\"center\">Destination</td>";
$html .= "<td width=\"9%\" align=\"center\">KM Travel on Namibian Road Network</td>";					
$html .= "<td width=\"7%\" align=\"center\">KM Travel on <br>Other Road</td>";
$html .= "</tr>";


if (count($vehiclelogreport) > 0) {

    $i = 1;
    foreach ($vehiclelogreport as $showlogreport) {
	
	
	        $nu_start_ometer = isset($showlogreport['VehicleLogDetail']['nu_start_ometer']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_start_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
		    $nu_km_traveled   =  isset($showlogreport['VehicleLogDetail']['nu_km_traveled']) ? 
                                $this->Number->format($showlogreport['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

			$nu_end_ometer = isset($showlogreport['VehicleLogDetail']['nu_end_ometer']) ? 
			$this->Number->format($showlogreport['VehicleLogDetail']['nu_end_ometer'], array(
			'places' => false,
			'before' => false,
			'escape' => false,
			'decimals' => false,
			'thousands' => ','
			)):'';
			
			$other_km_traveled = isset($showlogreport['VehicleLogDetail']['nu_other_road_km_traveled']) ? 
			$this->Number->format($showlogreport['VehicleLogDetail']['nu_other_road_km_traveled'], array(
			'places' => false,
			'before' => false,
			'escape' => false,
			'decimals' => false,
			'thousands' => ','
			)):'';
		

 if ($showlogreport['VehicleLogDetail']['vc_remark_by'] != 'USRTYPE03'){
        $html .= "<tr style=\"background-color: #ABABAB;\" >";
 }else{
        $html .= "<tr  >";
 }

        $LogDate = !empty ($showlogreport['VehicleLogDetail']['dt_log_date']) ? 
                           date('d M Y', strtotime($showlogreport['VehicleLogDetail']['dt_log_date'])):
                           '';
       
        $html .= "<td width=\"4%\" align=\"center\">".$i."</td>";
        $html .= "<td width=\"8%\">" . $LogDate . "</td>";
        $html .= "<td width=\"9%\">" . $showlogreport['VehicleLogDetail']['vc_vehicle_reg_no'] . "</td>";
        $html .= "<td width=\"10%\">" . $showlogreport['VehicleLogDetail']['vc_vehicle_lic_no'] . "</td>";
        
        foreach($vehiclelist as $key => $val) {
            if($showlogreport['VehicleDetail']['vc_vehicle_type'] == $key) {
                $html .= "<td width=\"8%\">" . @$val . "</td>";
                break;
            }
        }
       
        $html .= "<td width=\"10%\">" . wordwrap($showlogreport['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true) . "</td>";
        $html .= "<td width=\"7%\" align=\"right\">" . $nu_start_ometer . "</td>";
        $html .= "<td width=\"7%\" align=\"right\">" . $nu_end_ometer . "</td>";
        $html .= "<td width=\"9%\">" . wordwrap($showlogreport['VehicleLogDetail']['vc_orign_name'], 12, "<br>\n", true) . "</td>";
        $html .= "<td width=\"9%\">" . wordwrap($showlogreport['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true) . "</td>";
        $html .= "<td width=\"9%\" align=\"right\">" . $nu_km_traveled . "</td>";
        $html .= "<td width=\"7%\" align=\"right\">" . $other_km_traveled . "</td>";
        $html .= "</tr>";
        $i++;
    }
} else {

    $html .= "<tr>";
    $html .='<td colspan="12" style="text-align:center;">  No Records Found </td>';
    $html .= "</tr>";
}


$html .= "</table>";



$pdf->setPrintHeader(false);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('vehicle_log_sheet-'.date('d-M-Y').'.pdf', 'D');
?> 
<style>
.insp-fkd{background-color: #ABABAB !important;}
</style>