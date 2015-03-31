<?php $profile = $this->Session->read('Auth'); ?>
<?php
App::import('Vendor', 'tcpdf/tcpdf');

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information 
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RFA');
$pdf->SetTitle('RFA');
$pdf->SetSubject('Vehicle Report ');
//$pdf->SetKeywords('TCPDF, CakePHP, PDF, example, test, guide'); 
// set default header data 
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Road Funds Administration - Namibia', ''); 
// set header and footer fonts 
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
$pdf->SetFontSize(6);
//$pdf->setVisibility('screen');
// add a page 
$pdf->AddPage();


$html = "";

$html .= "<h2 align=\"center\">Vehicle History Report</h2>";

$html .= "<br/>";

$html .= "<table width=\"100%\"  cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
$html .= "<tr>";
$html .= "<td width=\"30%\">Customer Name :" . $profile['Profile']['vc_customer_name'] . "</td>";
$html .= "<td width=\"30%\">From Date :1 Jan 2012</td>";
$html .= "<td width =\"30%\">To Date :22 May 2012</td>";
$html .= "</tr>";
$html .= "</table>";

$html .= "<br/>";
$html .= "<br/>";


$html .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
$html .= "<tr>";
$html .= "<td width=\"5%\">S No.</td>";
$html .= "<td width=\"15%\">Vehicle LIC No.</td>";
$html .= "<td width=\"15%\">Vehicle Reg No.</td>";
$html .= "<td width=\"15%\">Vehicle Type</td>";
$html .= "<td width=\"15%\">V Rating</td>";
$html .= "<td width=\"15%\">D/T Rating</td>";
$html .= "<td width=\"15%\">Rate</td>";

$html .= "</tr>";


if (count($vehiclereport) > 0) {
    $i = 1;
    foreach ($vehiclereport as $showvehiclereport) {

        $html .= "<tr>";
        $html .= "<td>" . $i . "</td>";
        $html .= "<td>" . $showvehiclereport['VehicleDetail']['vc_vehicle_lic_no'] . "</td>";
        $html .= "<td>" . $showvehiclereport['VehicleDetail']['vc_registration_no'] . "</td>";
        $html .= "<td>" . $showvehiclereport['VEHICLETYPE']['vc_prtype_name'] . "</td>";
        $html .= "<td>" . $showvehiclereport['VehicleDetail']['vc_v_rating'] . "</td>";
        $html .= "<td>" . $showvehiclereport['VehicleDetail']['vc_dt_rating'] . "</td>";
        $html .= "<td>" . $showvehiclereport['VehicleDetail']['vc_rate'] . "</td>";

        $html .= "</tr>";
        $i++;
    }
}


$html .= "</table>";

// print a line using Cell() 
//$pdf->writeHTML($html, true, false, true, false, '');

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//Close and output PDF document 
$pdf->Output('vehicle-report.pdf', 'FD');
?> 
