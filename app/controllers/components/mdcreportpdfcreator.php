<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportpdfcreator
 *
 * @author Administrator
 */
App::import('fpdf');

class MdcReportpdfcreatorComponent extends FPDF {
	var $uses=array('VehicleDetail');
    // Margins
    var $left = 10;
    var $right = 10;
    var $top = 10;
    var $bottom = 10;
	
	function giveCompanyId($vc_vehicle_reg_no) {
      		   App::import('Model','VehicleDetail');

	       $VehicleDetail = ClassRegistry::init('VehicleDetail');
		   $VehicleCompanydetails = $VehicleDetail->find('first',array(
											'fields'=> array('VehicleDetail.nu_company_id','VehicleDetail.vc_vehicle_reg_no'),
											 'conditions' => array('VehicleDetail.vc_vehicle_reg_no'=>$vc_vehicle_reg_no)  
											));
			

		return $VehicleCompanydetails['VehicleDetail']['nu_company_id'];
	   
	   }

    function WriteTable($tcolums) {
        // go through all colums
        for ($i = 0; $i < sizeof($tcolums); $i++) {
            $current_col = $tcolums[$i];
            $height = 0;

            // get max height of current col
            $nb = 0;
            for ($b = 0; $b < sizeof($current_col); $b++) {
                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $nb = max($nb, $this->NbLines($current_col[$b]['width'], $current_col[$b]['text']));
                $height = $current_col[$b]['height'];
            }
            $h = $height * $nb;


            // Issue a page break first if needed
            $this->CheckPageBreak($h);

            // Draw the cells of the row
            for ($b = 0; $b < sizeof($current_col); $b++) {
                $w = $current_col[$b]['width'];
                $a = $current_col[$b]['align'];

                // Save the current position
                $x = $this->GetX();
                $y = $this->GetY();

                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);


                // Draw Cell Background
                $this->Rect($x, $y, $w, $h, 'FD');

                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);

                // Draw Cell Border
                if (substr_count($current_col[$b]['linearea'], "T") > 0) {
                    $this->Line($x, $y, $x + $w, $y);
                }

                if (substr_count($current_col[$b]['linearea'], "B") > 0) {
                    $this->Line($x, $y + $h, $x + $w, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "L") > 0) {
                    $this->Line($x, $y, $x, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "R") > 0) {
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }


                // Print the text
                $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

                // Put the position to the right of the cell
                $this->SetXY($x + $w, $y);
            }

            // Go to the next line
            $this->Ln($h);
        }
    }

    // If the height h would cause an overflow, add a new page immediately
    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // Computes the number of lines a MultiCell of width w will take
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function headerData($title, $period = NULL, $customerInfo = array(), $toDate, $fromDate, $id) {
        $this->ReportTitle = $title;
        $this->Member = $customerInfo;
        $this->Id = $id;
    }

    function Header() {

        $title = $this->ReportTitle;

        $this->SetFont('Arial', 'B', 12);
        $w = $this->GetStringWidth($title) + 6;
        $this->SetX((210 - $w) / 2);
        $this->SetLineWidth(1);

        $this->Image(WWW_ROOT . 'img/logo.jpg', 10, 5, 15, 20);

        $this->Cell($w, 9, $title, 0, 1, 'C');

        $currentUser = $this->Member;

        $this->Ln(10);

        if ($this->PageNo() == 1) {

            $this->SetFillColor(191, 191, 191);

            if ($this->Id == 1) {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 7);
                $this->MultiCell(30, 8, 'RFA Acccount no. : ', 0, '', 'L', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                $this->SetFont('Arial', '', 7);
                $this->MultiCell(155, 8, $currentUser['Member']['vc_username'], 0, '', 'L', true);
                // $this->SetY($y);
                //$this->SetX($x + 185);

                $this->Ln(0);
                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 7);
                $this->MultiCell(30, 8, 'Customer Name : ', 0, '', 'L', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                $this->SetFont('Arial', '', 7);
                $this->MultiCell(155, 8, $currentUser['Profile']['vc_customer_name'], 0, '', 'L', true);
                //$this->SetY($y);
                //$this->SetX($x + 185);
            } else {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 7);
                $this->MultiCell(43, 8, 'RFA Acccount no. : ', 0, '', 'L', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 43);

                $this->SetFont('Arial', '', 7);
                $this->MultiCell(155, 8, $currentUser['Member']['vc_username'], 0, '', 'L', true);
                // $this->SetY($y);
                //$this->SetX($x + 185);

                $this->Ln(0);
                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 7);
                $this->MultiCell(43, 8, 'Customer Name : ', 0, '', 'L', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 43);

                $this->SetFont('Arial', '', 7);
                $this->MultiCell(155, 8, $currentUser['Profile']['vc_customer_name'], 0, '', 'L', true);
                //$this->SetY($y);
                //$this->SetX($x + 185);
            }

            $this->Ln(2);
        }
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
        $this->Cell(50, 10, 'Page ' . $this->PageNo(), 0, 0, 'L');
        $this->Cell(0, 10, 'Date ' . date('d-M-Y'), 0, 0, 'R');
    }

  function genrate_mdc_vehiclereport($columnsHeadings, $data, $allconstants, $toDate = null, $fromDate = null, $vehicletypename = NULL,$nu_company_id=null,$CompanyName,$vehiclelicno=null) {

        $this->AddPage();
        $this->SetFont('Arial', 'B', 6);
        $c = 0;
        $this->SetFillColor(191, 191, 191);
        $length = count($columnsHeadings) - 1;

        $heightdynamic = 8;
		if (empty($nu_company_id)){
		
			$columnwidtharrays = array(10,30,25,25,20,20,20,20,15);
		
		}else{
        
			$columnwidtharrays = array(10, 25, 25, 25, 25, 25, 25, 25);
		
		}

        if ($this->PageNo() == 1) {

            $this->SetFillColor(191, 191, 191);

            if ((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ||
                    (isset($vehicletypename) && !empty($vehicletypename)) || (isset($nu_company_id) && !empty($nu_company_id))) {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(15, 8, 'From Date : ', 0, '', 'L', true);
                else
                    $this->MultiCell(15, 8, '', 0, '', 'L', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 15);

                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(15, 8, date('d M Y', strtotime($fromDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(15, 8, '', 0, '', 'L', true);


                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                $this->SetFont('Arial', 'B', 6);
                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(15, 8, 'To Date :', 0, '', 'R', true);
                else
                    $this->MultiCell(15, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 45);

                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(15, 8, date('d M Y', strtotime($toDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(15, 8, '', 0, '', 'L', true);


                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 60);

                $this->SetFont('Arial', 'B', 6);
                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(17, 8, 'Vehicle Type :', 0, '', 'R', true);
                else
                    $this->MultiCell(17, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 77);
//$vehicletypename='vehicletypename';
                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(23, 8, $vehicletypename, 0, '', 'L', true);
                else
                    $this->MultiCell(23, 8, '', 0, '', 'L', true);
				
				$this->SetFont('Arial', 'B', 6);				
				$this->SetY($y);  //Reset the write point
                $this->SetX($x + 100);

				
				
					
				
                
				if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(20, 8, 'Company Name :', 0, '', 'L', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'L', true);
				
				$this->SetFont('Arial', '', 6);
				$this->SetY($y);     //Reset the write point
                $this->SetX($x + 120);
//150+35=185
                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(65, 8,ucfirst($CompanyName[$nu_company_id]), 0, '', 'L', true);
                else
                    $this->MultiCell(65, 8, '', 0, '', 'L', true);			
				


                $this->Ln(2);
				}
				
			if (isset($vehiclelicno) && !empty($vehiclelicno)){
				$x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
				
				if (isset($vehiclelicno) && !empty($vehiclelicno))
                    $this->MultiCell(25, 8, 'Vehicle Register No. :', 0, '', 'L', true);
                else
                    $this->MultiCell(25, 8, '', 0, '', 'L', true);
				
				$this->SetFont('Arial', '', 6);
				$this->SetY($y);     //Reset the write point
                $this->SetX($x + 25);
				
				if (isset($vehiclelicno) && !empty($vehiclelicno))
                    $this->MultiCell(160, 8,$vehiclelicno, 0, '', 'L', true);
                else
                    $this->MultiCell(160, 8, '', 0, '', 'L', true);
					 $this->Ln(2);
            }
        }
			$this->SetFont('Arial', 'B', 6);

        foreach ($columnsHeadings as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
            if ($c == 0 || $c == 1 || $c == 2 || $c == 4 || $c == 5 || $c == 6) {
                $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
            } else {
                if ($c == $length)
                    $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
                else
                    $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
            }
            $c++;
        }

        $this->SetFont('Arial', '', 5);
        $i = 0;
        $this->Ln();

        foreach ($data as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
            $alignvalue = 'L';
            $columns = array();
            $col = array();
            
            
            $licenceno  =   $val['VehicleDetail']['vc_vehicle_lic_no'];
            $registrno  =   $val['VehicleDetail']['vc_vehicle_reg_no'];
            $createdDate = !empty($val['VehicleDetail']['dt_created_date']) ? date('d M Y', strtotime($val['VehicleDetail']['dt_created_date'])) : 'N/A';
            $vehicletypename    =   $val['VEHICLETYPE']['vc_prtype_name'];
            $v_rating       =   number_format($val['VehicleDetail']['vc_v_rating']);
            $dt_rating      =   number_format($val['VehicleDetail']['vc_dt_rating']);
			                   
			if($val['VehicleDetail']['vc_vehicle_status']=='STSTY04')
            $rate           =   number_format($val['VehicleDetail']['vc_rate'], 2, '.', ',');
			else
			$rate           =   'N/A';
			
            //$rate           =   number_format($val['VehicleDetail']['vc_rate'], 2, '.', ',');
			if(isset($val['VehicleDetail']['nu_company_id']) && !empty($val['VehicleDetail']['nu_company_id']))
			$Company_Name    =   ucfirst($CompanyName[$val['VehicleDetail']['nu_company_id']]);
           
            $font_size = 7;
            $fillcolor = '255,250,250';
			if (empty($nu_company_id)){
			
            $col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
			$col[] = array('text' => $Company_Name, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $licenceno, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            $col[] = array('text' => $registrno, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            $col[] = array('text' => $createdDate, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            $col[] = array('text' => $vehicletypename, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
            $alignvalue = 'R';
            $col[] = array('text' => $v_rating, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
            $col[] = array('text' => $dt_rating, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
			$col[] = array('text' => $rate, 'width' => $columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
                'linewidth' => '0', 'linearea' => 'LTBR');
			$alignvalue = 'L';
			
			
			

			}else{
			
			$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
            $col[] = array('text' => $licenceno, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            $col[] = array('text' => $registrno, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            $col[] = array('text' => $createdDate, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            $col[] = array('text' => $vehicletypename, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
            $alignvalue = 'R';
            $col[] = array('text' => $v_rating, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
            $col[] = array('text' => $dt_rating, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
            
			$col[] = array('text' => $rate, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
                'linewidth' => '0', 'linearea' => 'LTBR');
			$alignvalue = 'L';
			
			
			
			
			
			}
			
            
            
            $columns[] = $col;
            $this->WriteTable($columns);
            $i++;
            
            
        }
    }

    function genrate_mdc_vehiclelogreport($columnsHeadings, $data, $allconstants, $toDate = null, $fromDate = null, $vehiclelist, $vehicletypename = NULL, $nu_company_id = NULL, $CompanyId,$vehiclelicno=null) {
		
		//Configure :: write('debug',0);
        $this->AddPage();
        $this->SetFont('Arial', 'B', 6);
        $c = 0;
        $this->SetFillColor(191, 191, 191);
        $length = count($columnsHeadings) - 1;
        $heightdynamic = 8;
		
		if (empty($nu_company_id)){
		
			 $columnwidtharrays = array(8, 18, 16, 14,
										15, 15, 15, 15,
										18, 14, 14, 18,
											18);
			
		}else{
		
			 $columnwidtharrays = array(
			 8, 18, 14, 15,
			 15, 15, 15, 18,
			 14, 20, 20, 26);
		
		}

        if ($this->PageNo() == 1) {
            
			$this->SetFillColor(191, 191, 191);

            if ((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ||
                    (isset($vehicletypename) && !empty($vehicletypename)) || (isset($nu_company_id) && !empty($nu_company_id))) {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(20, 8, 'From Date : ', 0, '', 'L', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'L', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 20);

                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(30, 8, date('d M Y', strtotime($fromDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);


                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 50);

                $this->SetFont('Arial', 'B', 6);
                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(20, 8, 'To Date :', 0, '', 'R', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 70);

                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(30, 8, date('d M Y', strtotime($toDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);


                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 100);

                $this->SetFont('Arial', 'B', 6);
                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(20, 8, 'Vehicle Type :', 0, '', 'R', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 120);

                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(20, 8, $vehicletypename, 0, '', 'L', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'L', true);
				
				$this->SetY($y);  //Reset the write point
                $this->SetX($x + 140);

                $this->SetFont('Arial', 'B', 6);
                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(28, 8, 'Company Name :', 0, '', 'R', true);
                else
                    $this->MultiCell(28, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 168);

                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(30, 8, $CompanyId[$nu_company_id], 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);
                
				
				$this->Ln(2);
				}
				
				if (isset($vehiclelicno) && !empty($vehiclelicno)) {
				
				$x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
                if (isset($vehiclelicno) && !empty($vehiclelicno))
                    $this->MultiCell(30, 8, 'Vehicle Register No. : ', 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);
					
				
				$this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                if (isset($vehiclelicno) && !empty($vehiclelicno))
                    $this->MultiCell(168, 8, $vehiclelicno, 0, '', 'L', true);
                else
                    $this->MultiCell(168, 8, '', 0, '', 'L', true);				
					
					
					
					$this->Ln(2);
            }
        }

		$this->SetFont('Arial', 'B', 5);
		
        foreach ($columnsHeadings as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
	
			if (empty($nu_company_id)){

				if ($c == 0 || $c == 6 || $c == 7 ||$c == 2 || $c == 5 || $c == 8 || $c == 9 || $c == 10 || $c == 12 || $c == 11 || $c == 1 ){

					$this->MultiCell($columnwidtharrays[$c], 8, $val, 1, 'C', true);
					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]);
				} else {
					$this->MultiCell($columnwidtharrays[$c], 4, $val, 1, 'C', true);
					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]);
				}

				$c++;
				
			}else{
			
				if ($c == 0 || $c == 5 || $c == 1 || $c == 4 || $c == 7 || $c == 8 || $c == 9 || $c == 10 || $c == 11  || $c == 6) {

					$this->MultiCell($columnwidtharrays[$c], 8, $val, 1, 'C', true);
					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]);
					
				} else {
				
					$this->MultiCell($columnwidtharrays[$c], 4, $val, 1, 'C', true);
					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]);
				}

				$c++;
			}
        }

        $this->SetFont('Arial', '', 5);
        $i = 0;
        $this->Ln();
        foreach ($data as $val) {

            //line break after 16

            $x = $this->GetX();
            $y = $this->GetY();
            $alignvalue = 'L';
            $columns = array();
            $col = array();

            $LogDate = !empty($val['VehicleLogDetail']['dt_log_date']) ? date('d M Y', strtotime($val['VehicleLogDetail']['dt_log_date'])) : 'N/A';
            $vc_reg_no = $val['VehicleLogDetail']['vc_vehicle_reg_no'];
            $vc_lic_no = $val['VehicleLogDetail']['vc_vehicle_lic_no'];
            $vc_type = $allconstants[$val['VehicleDetail']['vc_vehicle_type']];
            $dirvename = $val['VehicleLogDetail']['vc_driver_name'];
            $strtmeter = number_format($val['VehicleLogDetail']['nu_start_ometer']);
            $endmeter = number_format($val['VehicleLogDetail']['nu_end_ometer']);
				
				if($val['VehicleLogDetail']['ch_road_type']==1){
				
				$origin = $val['VehicleLogDetail']['vc_other_road_orign_name'];
				$destination = $val['VehicleLogDetail']['vc_other_road_destination_name'];
				//$kmtravldnamroad = number_format($val['VehicleLogDetail']['nu_km_traveled']);
				$kmtravldnamroad = number_format($val['VehicleLogDetail']['nu_other_road_km_traveled']);
				
				}else{
				
				$origin = $val['VehicleLogDetail']['vc_orign_name'];
				$destination = $val['VehicleLogDetail']['vc_destination_name'];
				$kmtravldnamroad = number_format($val['VehicleLogDetail']['nu_km_traveled']);
				//$kmtrvldotheroad = number_format($val['VehicleLogDetail']['nu_other_road_km_traveled']);
				
				}
				if($val['VehicleLogDetail']['ch_road_type']==1)
				$ch_road_type= 'Other Road';
				else
				$ch_road_type=  'Namibian Road';
							
            
			//pr($HelperCompanyId);die;
			if($val['VehicleLogDetail']['vc_remark_by'] != 'USRTYPE03'){
			$HelperCompanyId =	$this->giveCompanyId($val['VehicleLogDetail']['vc_vehicle_reg_no']);
			
				$company = $CompanyId[$HelperCompanyId];
				
			}else{
			
				$company = $CompanyId[$val['VehicleLogDetail']['nu_company_id']];
			}

			if (empty($nu_company_id)){
			
				$font_size = 7;
				$fillcolor = '255,250,250';

				$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $company, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				
				$col[] = array('text' => $LogDate, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vc_reg_no, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vc_lic_no, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vc_type, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $dirvename, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'R';
				$col[] = array('text' => $strtmeter, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $endmeter, 'width' => $columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');
					
				$alignvalue = 'L';
					$col[] = array('text' => $ch_road_type, 'width' => $columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');
					
				$col[] = array('text' => $origin, 'width' => $columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $destination, 'width' => $columnwidtharrays[11], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$alignvalue = 'R';
				$col[] = array('text' => $kmtravldnamroad, 'width' => $columnwidtharrays[12], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				
				$alignvalue = 'L';
				$columns[] = $col;
				$this->WriteTable($columns);
				$i++;
			
			}else{
			
				$font_size = 7;
				$fillcolor = '255,250,250';

				$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $LogDate, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vc_reg_no, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vc_lic_no, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vc_type, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $dirvename, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'R';
				$col[] = array('text' => $strtmeter, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $endmeter, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'L';
				
				$col[] = array('text' => $ch_road_type, 'width' => $columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $origin, 'width' => $columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $destination, 'width' => $columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$alignvalue = 'R';
				$col[] = array('text' => $kmtravldnamroad, 'width' => $columnwidtharrays[11], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');


				$alignvalue = 'L';
				$columns[] = $col;
				$this->WriteTable($columns);
				$i++;
			}
        }
    }

    function genrate_mdc_vehicleassessreport_old($columnsHeadings, $data, $allconstants, $toDate = null, $fromDate = null, $vehicletypename = NULL) {

        $this->AddPage();
        $this->SetFont('Arial', 'B', 6);
        $c = 0;
        $this->SetFillColor(191, 191, 191);
        $length = count($columnsHeadings) - 1;
        $heightdynamic = 10;
        $columnwidtharrays = array(10, 15, 15, 15, 15, 12, 13, 14, 13, 28, 17, 17, 14);

        if ($this->PageNo() == 1) {

            $this->SetFillColor(191, 191, 191);

            if ((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ||
                    (isset($vehicletypename) && !empty($vehicletypename))) {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(30, 8, 'From Date : ', 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(50, 8, '', 0, '', 'L', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 80);

                $this->SetFont('Arial', 'B', 6);
                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(25, 8, 'To Date :', 0, '', 'R', true);
                else
                    $this->MultiCell(25, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 105);

                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(25, 8, date('d M Y', strtotime($toDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(25, 8, '', 0, '', 'L', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 130);

                $this->SetFont('Arial', 'B', 6);
                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(33, 8, 'Vehicle Type :', 0, '', 'R', true);
                else
                    $this->MultiCell(33, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 163);

                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(35, 8, $vehicletypename, 0, '', 'L', true);
                else
                    $this->MultiCell(35, 8, '', 0, '', 'L', true);

                $this->Ln(2);
            }
        }


        foreach ($columnsHeadings as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
            if ($c == 0 || $c == 10 || $c == 11 || $c == 8 || $c == 12) {
                $this->MultiCell($columnwidtharrays[$c], 12, $val, 1, '', 'C', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
            } else {
                if ($c == $length)
                    $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, '', 'C', true);
                else
                    $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, '', 'C', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
            }
            $c++;
        }

        $this->SetFont('Arial', '', 5);
        $i = 1;
        $this->Ln();

        foreach ($data as $val) {

            $x = $this->GetX();
            $y = $this->GetY();

            $this->MultiCell($columnwidtharrays[0], $heightdynamic, $i, 1, 'C');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $createdDate = !empty($val['AssessmentVehicleDetail']['dt_created_date']) ? date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date'])) : 'N/A';

            $this->MultiCell($columnwidtharrays[1], $heightdynamic, $createdDate, 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[2], $heightdynamic, $val['AssessmentVehicleDetail']['vc_assessment_no'], 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[3], $heightdynamic, $val['AssessmentVehicleDetail']['vc_vehicle_lic_no'], 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[4], $heightdynamic, $val['AssessmentVehicleDetail']['vc_vehicle_reg_no'], 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[5], $heightdynamic, $allconstants[$val['VehicleDetail']['vc_vehicle_type']], 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[6], $heightdynamic, $val['AssessmentVehicleDetail']['vc_pay_frequency'], 1, 'L');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[7], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_prev_end_om'], 2, '.', ','), 1, 'R');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[7] + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[8], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_end_om'], 2, '.', ','), 1, 'R');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[8] + $columnwidtharrays[7] + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[9], $heightdynamic, $val['AssessmentVehicleDetail']['vc_km_travelled'], 1, 'R');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[9] + $columnwidtharrays[8] + $columnwidtharrays[7] + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[10], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_rate'], 2, '.', ','), 1, 'R');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[10] + $columnwidtharrays[9] + $columnwidtharrays[8] + $columnwidtharrays[7] + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[11], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_payable'], 2, '.', ','), 1, 'R');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[11] + $columnwidtharrays[10] + $columnwidtharrays[9] + $columnwidtharrays[8] + $columnwidtharrays[7] + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            $this->MultiCell($columnwidtharrays[12], $heightdynamic, $allconstants[$val['AssessmentVehicleMaster']['vc_status']], 1, 'R');
            $this->SetY($y);  //Reset the write point
            $this->SetX($x + $columnwidtharrays[12] + $columnwidtharrays[11] + $columnwidtharrays[10] + $columnwidtharrays[9] + $columnwidtharrays[8] + $columnwidtharrays[7] + $columnwidtharrays[6] + $columnwidtharrays[5] + $columnwidtharrays[4] + $columnwidtharrays[3] + $columnwidtharrays[2] + $columnwidtharrays[1] + $columnwidtharrays[0]); //Move X to $x + width of last cell

            if ($i % 20 == 0 && $i > 0) {

                $this->AddPage();
            }

            $this->Ln();
            $i++;
        }
    }

    function genrate_mdc_vehicleassessreport($columnsHeadings, $data, $allconstants, $toDate = null, $fromDate = null, $vehicletypename = NULL, $nu_company_id = NULL,$CompanyId,$vehiclelicno=null) {

        $this->AddPage();
        $this->SetFont('Arial', 'B', 6);
        $c = 0;
        $this->SetFillColor(191, 191, 191);
        $length = count($columnsHeadings) - 1;
        $heightdynamic = 8;
		
		if (empty($nu_company_id)){
		
			$columnwidtharrays = array(8, 15, 15, 15, 15, 15, 12, 13, 14, 12, 20, 15, 15, 14);
			
		}else{
		
			$columnwidtharrays = array(8, 17, 17, 15, 15, 12, 13, 14, 13, 28, 15, 17, 14);
		
		}
		
        if ($this->PageNo() == 1) {

            $this->SetFillColor(191, 191, 191);

            if ((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ||
                    (isset($vehicletypename) && !empty($vehicletypename)) || (isset($nu_company_id) && !empty($nu_company_id))) {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(20, 8, 'From Date : ', 0, '', 'L', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'L', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 20);

                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(30, 8, date('d M Y', strtotime($fromDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 50);

                $this->SetFont('Arial', 'B', 6);
                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(20, 8, 'To Date :', 0, '', 'R', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 70);

                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(30, 8, date('d M Y', strtotime($toDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 100);

                $this->SetFont('Arial', 'B', 6);
                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(20, 8, 'Vehicle Type :', 0, '', 'R', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 120);

                if (isset($vehicletypename) && !empty($vehicletypename))
                    $this->MultiCell(28, 8, $vehicletypename, 0, '', 'L', true);
                else
                    $this->MultiCell(28, 8, '', 0, '', 'L', true);

				$this->SetY($y);  //Reset the write point
                $this->SetX($x + 148);

                $this->SetFont('Arial', 'B', 6);
                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(20, 8, 'Company Name :', 0, '', 'R', true);
                else
                    $this->MultiCell(20, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 168);

                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(30, 8, ucfirst($CompanyId[$nu_company_id]), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->Ln(2);
				}
				
				if (isset($vehiclelicno) && !empty($vehiclelicno)) {
				
				$x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
				if (isset($vehiclelicno) && !empty($vehiclelicno))
                    $this->MultiCell(30, 8, 'Vehicle Register No. :', 0, '', 'R', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                if (isset($vehiclelicno) && !empty($vehiclelicno))
                    $this->MultiCell(168, 8, $vehiclelicno, 0, '', 'L', true);
                else
                    $this->MultiCell(168, 8, '', 0, '', 'L', true);
				
				
				//$vehiclelicno
				$this->Ln(2);
            }
        }

		$this->SetFont('Arial', 'B', 6);
		
        foreach ($columnsHeadings as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
			
			if (empty($nu_company_id)){
			
				if ( $c == 11 || $c == 12 || $c == 9 || $c == 13 ) {
					$this->MultiCell($columnwidtharrays[$c], 12, $val, 1, 'C', true);
					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				} else {
					if ($c == $length)
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
					else
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);

					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				}
				$c++;
			
			}else{
				if ( $c == 10 || $c == 11 || $c == 8 || $c == 12) {
					$this->MultiCell($columnwidtharrays[$c], 12, $val, 1, 'C', true);
					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				} else {
					if ($c == $length)
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
					else
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);

					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				}
				$c++;
			}
        }

        $this->SetFont('Arial', '', 5);
        $i = 0;
        $this->Ln();

        foreach ($data as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
            $alignvalue = 'L';
            $columns = array();
            $col = array();
			
            $assessmentDate = !empty($val['AssessmentVehicleDetail']['dt_created_date']) ? date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date'])) : 'N/A';
            $assessmentNo = $val['AssessmentVehicleDetail']['vc_assessment_no'];
            $licencenumber = $val['AssessmentVehicleDetail']['vc_vehicle_lic_no'];
            $registerno = $val['AssessmentVehicleDetail']['vc_vehicle_reg_no'];
            $vehicletype = $allconstants[$val['VehicleDetail']['vc_vehicle_type']];
            $payfrequency = $val['AssessmentVehicleDetail']['vc_pay_frequency'];
            $prev_endmeter = number_format($val['AssessmentVehicleDetail']['vc_prev_end_om']);
            $end_meter = number_format($val['AssessmentVehicleDetail']['vc_end_om']);
            $kmtravlednamroad = number_format($val['AssessmentVehicleDetail']['vc_km_travelled']);
            $rate = number_format($val['AssessmentVehicleDetail']['vc_rate'], 2, '.', ',');
            $payable = number_format($val['AssessmentVehicleDetail']['vc_payable'], 2, '.', ',');
            $status = $allconstants[$val['AssessmentVehicleMaster']['vc_status']];
			$company = $CompanyId[$val['AssessmentVehicleMaster']['nu_company_id']];
			if (empty($nu_company_id)){
			
				//pr($nu_company_id);die;
				
				$font_size = 7;
				$fillcolor = '255,250,250';

				$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $company, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				
				$col[] = array('text' => $assessmentDate, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $assessmentNo, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $licencenumber, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $registerno, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vehicletype, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'R';
				$col[] = array('text' => $payfrequency, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

				$alignvalue = 'R';
				$col[] = array('text' => $prev_endmeter, 'width' => $columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $end_meter, 'width' => $columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $kmtravlednamroad, 'width' => $columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $rate, 'width' => $columnwidtharrays[11], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $payable, 'width' => $columnwidtharrays[12], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'L';
				$col[] = array('text' => $status, 'width' => $columnwidtharrays[13], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$columns[] = $col;
				$this->WriteTable($columns);
				$i++;
				
				
				
			
			}else{
				$font_size = 7;
				$fillcolor = '255,250,250';

				$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $assessmentDate, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $assessmentNo, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $licencenumber, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $registerno, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $vehicletype, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'R';
				$col[] = array('text' => $payfrequency, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

				$alignvalue = 'R';
				$col[] = array('text' => $prev_endmeter, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $end_meter, 'width' => $columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $kmtravlednamroad, 'width' => $columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $rate, 'width' => $columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $payable, 'width' => $columnwidtharrays[11], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'L';
				$col[] = array('text' => $status, 'width' => $columnwidtharrays[12], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$columns[] = $col;
				$this->WriteTable($columns);
				$i++;
			}
        }
    }

    function genrate_mdc_vehiclepayreport($columnsHeadings, $data, $allconstants, $toDate, $fromDate, $nu_company_id = NULL, $CompanyId) {

        $this->AddPage();
        $this->SetFont('Arial', 'B', 6);
        $c = 0;
        $this->SetFillColor(191, 191, 191);
        $length = count($columnsHeadings) - 1;
        $heightdynamic = 10;
		
		if (empty($nu_company_id)){
		
			$columnwidtharrays = array(10, 22, 21, 20, 24, 24, 26, 18, 20);
			
		}else{
		
			$columnwidtharrays = array(12, 20, 20, 29, 29, 30, 20, 25);
		
		}

        if ($this->PageNo() == 1) {
            $this->SetFillColor(191, 191, 191);
            if ((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ||
                    (isset($vehicletypename) && !empty($vehicletypename)) || (isset($nu_company_id) && !empty($nu_company_id))) {

                $x = $this->GetX();
                $y = $this->GetY();

                $this->SetFont('Arial', 'B', 6);
                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(30, 8, 'From Date : ', 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 30);

                if (isset($fromDate) && !empty($fromDate))
                    $this->MultiCell(30, 8, date('d M Y', strtotime($fromDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 60);

                $this->SetFont('Arial', 'B', 6);
                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(30, 8, 'To Date :', 0, '', 'R', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 90);

                if (isset($toDate) && !empty($toDate))
                    $this->MultiCell(30, 8, date('d M Y', strtotime($toDate)), 0, '', 'L', true);
                else
                    $this->MultiCell(30, 8, '', 0, '', 'L', true);

                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 120);

                $this->SetFont('Arial', 'B', 6);
                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(25, 8, 'Company :', 0, '', 'R', true);
                else
                    $this->MultiCell(25, 8, '', 0, '', 'R', true);

                $this->SetFont('Arial', '', 6);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + 145);

                if (isset($nu_company_id) && !empty($nu_company_id))
                    $this->MultiCell(40, 8, $CompanyId[$nu_company_id], 0, '', 'L', true);
                else
                    $this->MultiCell(40, 8, '', 0, '', 'L', true);

                $this->Ln(2);
            }
        }

		$this->SetFont('Arial', 'B', 6);

        foreach ($columnsHeadings as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
			
			if (empty($nu_company_id)){
		
				if ($c == 0) {
                $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				} else {
					if ($c == $length)
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
					else
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);

					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				}
				$c++;
			
			}else{
			
				if ($c == 0) {
                $this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
                $this->SetY($y);  //Reset the write point
                $this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				} else {
					if ($c == $length)
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);
					else
						$this->MultiCell($columnwidtharrays[$c], 6, $val, 1, 'C', true);

					$this->SetY($y);  //Reset the write point
					$this->SetX($x + $columnwidtharrays[$c]); //Move X to $x + width of last cell
				}
				$c++;
			}
        }

        $this->SetFont('Arial', '', 5);
        $i = 0;
        $this->Ln();

        foreach ($data as $val) {

            $x = $this->GetX();
            $y = $this->GetY();
            $alignvalue = 'L';
            $columns = array();
            $col = array();

            $assmentno = $val['AssessmentVehicleMaster']['vc_assessment_no'];
            $AssMntDate = !empty($val['AssessmentVehicleMaster']['dt_assessment_date']) ? date('d M Y', strtotime($val['AssessmentVehicleMaster']['dt_assessment_date'])) : '';
            $paybleamt = number_format($val['AssessmentVehicleMaster']['nu_total_payable_amount'], 2, '.', ',');
            $mdcpaid = number_format($val['AssessmentVehicleMaster']['vc_mdc_paid'], 2, '.', ',');
           
			$VarianceAmount=(float)($val['AssessmentVehicleMaster']['nu_total_payable_amount'])-(float)($val['AssessmentVehicleMaster']['vc_mdc_paid']);
         

                                 $VarianceAmount; 
                             $varamount = number_format($VarianceAmount, 2, '.', ',');  
			
			//$varamount = number_format($val['AssessmentVehicleMaster']['nu_variance_amount'], 2, '.', ',');
            $PayMntDate = !empty($val['AssessmentVehicleMaster']['dt_received_date']) ? date('d M Y', strtotime($val['AssessmentVehicleMaster']['dt_received_date'])) : '';
            $status = $val['PaymentStatus']['vc_prtype_name'];
			$company = $CompanyId[$val['AssessmentVehicleMaster']['nu_company_id']];
			
			if (empty($nu_company_id)){
			
				$font_size = 7;
				$fillcolor = '255,250,250';

				$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $company, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				
				$col[] = array('text' => $assmentno, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $AssMntDate, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'R';
				$col[] = array('text' => $paybleamt, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $mdcpaid, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $varamount, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

				$alignvalue = 'L';
				
				$col[] = array('text' => $PayMntDate, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $status, 'width' => $columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$columns[] = $col;
				$this->WriteTable($columns);
				$i++;
			
			}else{
			
				$font_size = 7;
				$fillcolor = '255,250,250';

				$col[] = array('text' => $i + 1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $assmentno, 'width' => $columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $AssMntDate, 'width' => $columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$alignvalue = 'R';
				$col[] = array('text' => $paybleamt, 'width' => $columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $mdcpaid, 'width' => $columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
				$col[] = array('text' => $varamount, 'width' => $columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

				$alignvalue = 'L';
				
				$col[] = array('text' => $PayMntDate, 'width' => $columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

				$col[] = array('text' => $status, 'width' => $columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0',
					'linewidth' => '0', 'linearea' => 'LTBR');

				$columns[] = $col;
				$this->WriteTable($columns);
				$i++;
			
			}
        }
    }

}

?>
