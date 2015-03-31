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

// end of class for the table creation //
/*
$tablepdf=new MYPDF('P','mm','A4');
$tablepdf->AliasNbPages();
$tablepdf->SetMargins($tablepdf->left, $tablepdf->top, $tablepdf->right); 
$tablepdf->AddPage();

*/

class CbcreportpdfcreatorComponent extends FPDF {
	   // Margins
   var $left = 10;
   var $right = 10;
   var $top = 10;
   var $bottom = 10;
	
	  function WriteTable($tcolums)
   {
      // go through all colums
      for ($i = 0; $i < sizeof($tcolums); $i++)
      {
         $current_col = $tcolums[$i];
         $height = 0;
         
         // get max height of current col
         $nb=0;
         for($b = 0; $b < sizeof($current_col); $b++)
         {
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
         $h=$height*$nb;
         
         
         // Issue a page break first if needed
         $this->CheckPageBreak($h);
         
         // Draw the cells of the row
         for($b = 0; $b < sizeof($current_col); $b++)
         {
            $w = $current_col[$b]['width'];
            $a = $current_col[$b]['align'];
            
            // Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            
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
            if (substr_count($current_col[$b]['linearea'], "T") > 0)
            {
               $this->Line($x, $y, $x+$w, $y);
            }            
            
            if (substr_count($current_col[$b]['linearea'], "B") > 0)
            {
               $this->Line($x, $y+$h, $x+$w, $y+$h);
            }            
            
            if (substr_count($current_col[$b]['linearea'], "L") > 0)
            {
               $this->Line($x, $y, $x, $y+$h);
            }
                        
            if (substr_count($current_col[$b]['linearea'], "R") > 0)
            {
               $this->Line($x+$w, $y, $x+$w, $y+$h);
            }
            
            
            // Print the text
            $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);
            
            // Put the position to the right of the cell
            $this->SetXY($x+$w, $y);         
         }
         
         // Go to the next line
         $this->Ln($h);          
      }                  
   }

   
   // If the height h would cause an overflow, add a new page immediately
   function CheckPageBreak($h)
   {
      if($this->GetY()+$h>$this->PageBreakTrigger)
         $this->AddPage($this->CurOrientation);
   }


   // Computes the number of lines a MultiCell of width w will take
   function NbLines($w, $txt)
   {
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
         $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r", '', $txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
         $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb)
      {
         $c=$s[$i];
         if($c=="\n")
         {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
         }
         if($c==' ')
            $sep=$i;
         $l+=$cw[$c];
         if($l>$wmax)
         {
            if($sep==-1)
            {
               if($i==$j)
                  $i++;
            }
            else
               $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
         }
         else
            $i++;
      }
      return $nl;
   }
   
	function headerData($title, $period = NULL,$customerInfo=array(),$vehicletype=null,$todate=null,$fromdate=null) {
        $this->ReportTitle = $title;
		$this->Customer = $customerInfo;
		$this->vehicletype = $vehicletype;
    }
	
	
	
    function Header() {
        
		//global $title;
		
        $title = $this->ReportTitle;		

        // Arial bold 15
        $this->SetFont('Arial', 'B', 12);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title) + 6;
        $this->SetX((210 - $w) / 2);
        // Colors of frame, background and text
        //$this->SetDrawColor(0, 80, 180);
        //$this->SetFillColor(230, 230, 0);
        //$this->SetTextColor(220, 50, 50);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(1);
        // Title
		$this->Image(WWW_ROOT.'img/logo.jpg', 10, 5, 15, 20);

        //$this->Image('images/fair/autumn13header.png', 10, 5, 190, 50);
        $this->Cell($w, 9, $title, 0, 1, 'C');
        // Line break
		//$currentUser = $this->Session->read('Auth');
		$currentUser = $this->Customer;
        $this->Ln(10);
		//$this->SetFont('Arial', 'B', 12);
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		$x= $this->GetX();
		$y= $this->GetY();
		
		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Customer Name : ',0,'L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		
		$this->MultiCell(100, 8, ucfirst($currentUser['Customer']['vc_first_name'] . ' ' .$currentUser['Customer']['vc_surname']) ,0,'L',true);	
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Tel. No.  :',0,'R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, $currentUser['Customer']['vc_tel_no'] ,0,'L',true);	
		$this->Ln(0);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			
		$address = trim(ucfirst($currentUser['Customer']['vc_address1']));
		
		if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address2']));
		
		if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
		$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address3']));
		

		$this->MultiCell(25, 8, 'Address : ',0,'L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8,$address,0,'L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Email :',0,'R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8,$currentUser['Customer']['vc_email'] ,0,'L',true);	
		$this->Ln(0);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Mobile No. : ',0,'L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8,$currentUser['Customer']['vc_mobile_no'] ,0,'L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Fax No.  :',0,'R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, $currentUser['Customer']['vc_fax_no'],0,'L',true);	
		$x= $this->GetX();
		$y= $this->GetY();
		$this->SetFont('Arial', 'B', 6);		

		$this->MultiCell(25, 8, 'Company : ',0,'L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8,$currentUser['Customer']['vc_company'] ,0,'L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Account No.  :',0,'R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, $currentUser['Customer']['vc_cust_no'],0,'L',true);
		$this->Ln(5);			
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
	
	function genrate_cbc_vehiclelist_pdf($columnsValues,$data,$allconstants,$Customer,$vehicletype=null) {
	
	 	$this->AddPage();
		$this->SetFont('Arial', 'B', 6);		
		$heightdynamic=10;	
		$c=0;
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if(isset($vehicletype) && !empty($vehicletype)){
		
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Vehicle Type : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8, $allconstants[$vehicletype] ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, '' ,0,'','L',true);	
		$this->Ln(2);
		}
		
		}
		$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays=array(12,17,
			20,16,
			17,15,
			18,
			18,18,
			20,19); 
		
		
		foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();
			
			
			if($c==0 )
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'','C',true);
			else
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'','C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]);
		 
		    $c++;
		  

		}
		$this->SetFont('Arial', '', 5);
		$i=0;
		$this->Ln();
		foreach ($data as $val) {
			
			//line break after 16
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();
			
			$vc_veh_type      = $allconstants[$val['AddVehicle']['vc_veh_type']];
			$vc_reg_no        = $val['AddVehicle']['vc_reg_no'];
			$vc_type_no       = $allconstants[$val['AddVehicle']['vc_type_no']];
			$vc_make          = $allconstants[$val['AddVehicle']['vc_make']];
			$vc_axle_type     = $allconstants[$val['AddVehicle']['vc_axle_type']];
			$vc_series_name   = $val['AddVehicle']['vc_series_name'];
			$vc_engine_no     = $val['AddVehicle']['vc_engine_no'];
			$vc_chasis_no     = $val['AddVehicle']['vc_chasis_no'];
			$nu_v_rating      = number_format($val['AddVehicle']['nu_v_rating']);
			$nu_d_rating      = number_format($val['AddVehicle']['nu_d_rating']);

			
			
			$font_size=7;
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_veh_type, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
		
			$col[] = array('text' => $vc_reg_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			

			
			$col[] = array('text' => $vc_type_no, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			
			
			$col[] = array('text' => $vc_make, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' => $vc_axle_type, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		
			
			$col[] = array('text' => $vc_series_name, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
				
			
			
			$col[] = array('text' => $vc_engine_no, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			
			$col[] = array('text' =>$vc_chasis_no, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';

			$col[] = array('text' => $nu_v_rating, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $nu_d_rating, 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
						
			$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;
			
			}

	}
	
	 function genrate_cbc_vehiclelist_pdf_old($columnsValues,$data,$allconstants,$Customer,$vehicletype=null) {
	 
		$this->AddPage();
		$this->SetFont('Arial', 'B', 6);		
		$heightdynamic=10;	
		$c=0;
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
	
		
		
				
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if(isset($vehicletype) && !empty($vehicletype)){
		
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Vehicle Type : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8, $allconstants[$vehicletype] ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, '' ,0,'','L',true);	
		$this->Ln(2);
		}
		
		}
		$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays=array(12,17,
								20,16,
								17,15,
								18,
								18,18,
								20,19); 
		
		
		foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();
			
			
			if($c==0 )
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'','C',true);
			else
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'','C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]);
		 
		    $c++;
		  

		}
		$this->SetFont('Arial', '', 5);
		$i=0;
		$this->Ln();
	
		foreach ($data as $val) {
			
			//line break after 16
			
			
			//	echo '<pre>';	
			//  print_r($val);
			//  print_r($arr);die;
			//	vc_series_name,vc_engine_no,vc_chasis_no
			
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
            $this->MultiCell($columnwidtharrays[0], $heightdynamic, $i+1, 1,'C');
            // $this->MultiCell(10, 10, $val['AccountRecharge']['nu_acct_rec_id'], 1,'C');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, $allconstants[$val['AddVehicle']['vc_veh_type']], 1,'L');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[2],$heightdynamic, $val['AddVehicle']['vc_reg_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[3],$heightdynamic,
			$allconstants[$val['AddVehicle']['vc_type_no']] , 1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			 
			$this->MultiCell($columnwidtharrays[4],$heightdynamic, $allconstants[$val['AddVehicle']['vc_make']], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			
			$this->MultiCell($columnwidtharrays[5],$heightdynamic,$allconstants[$val['AddVehicle']['vc_axle_type']], 1,'L');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic,$val['AddVehicle']['vc_series_name'], 1,'L');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic, $val['AddVehicle']['vc_engine_no'], 1,'L');
		    
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			//echo $this->NbLines($columnwidtharrays[8],$val['AddVehicle']['vc_chasis_no']);
			//die('hua');
			
			$this->MultiCell($columnwidtharrays[8],$heightdynamic, $val['AddVehicle']['vc_chasis_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
			$this->SetX($x+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			$this->MultiCell($columnwidtharrays[9], $heightdynamic, number_format($val['AddVehicle']['nu_v_rating']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			
			
			$this->MultiCell($columnwidtharrays[10],$heightdynamic, number_format($val['AddVehicle']['nu_d_rating']), 1,'R');
			
			//$this->SetY($y);  //Reset the write point
			
			//$this->SetX($x+$columnwidtharrays[10]+$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			
			if((int)$this->GetY()>180 && $i>0)	{
			
				$this->AddPage();
			
			}					
			//$this->Ln();
			$i++;
			
			}

	 
	 }
	 
	
	function genrate_cbc_customerrechargepdf($columnsValues,$data,$allconstants,$Customer,$toDate=null,$fromDate=null) {
	
		//	$this=new MYPDF('P','mm','A4');
		$this->AliasNbPages();
		$this->SetMargins($this->left, $this->top, $this->right); 
		$this->AddPage();
		$this->SetFont('Arial', 'B', 7);		
		$c=0;		
		$this->SetFillColor(191,191,191);		
		$length = count($columnsValues)-1;
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ){
		

		$this->SetFont('Arial', 'B', 6);
	    if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(25, 8, 'From Date : ',0,'L',true);
		else
		$this->MultiCell(25, 8, ' ',0,'L',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(100, 8, $fromDate ,0,'L',true);	
		else
		$this->MultiCell(100, 8, $fromDate ,0,'L',true);	
		

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(25, 8, 'To Date : ',0,'R',true);
		else
		$this->MultiCell(25, 8, ' ',0,'R',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(40, 8, $toDate ,0,'L',true);
		else		
		$this->MultiCell(40, 8, '' ,0,'L',true);
		$this->Ln(2);
		
		}
		}
	$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays = array(12,16,
			20,22,
			20,20,
			15,23,
			15,28); 
        foreach($columnsValues as $val) {
			//$this->Ln(0);
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0  ||$c==7 ){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		if($c==$length)
			 $this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			else
			 $this->MultiCell($columnwidtharrays[$c], 6, $val , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
	
	$this->Ln();
	$heightdynamic = 10;
	$alignvalue    = 'L';
	$i=0;
		
	foreach ($data as $val) {
			
			$alignvalue = 'L';
			$columns = array();
			$col = array();
			$entryDate =!empty($val['AccountRecharge']['dt_entry_date'])?
			date('d-M-Y', strtotime($val['AccountRecharge']['dt_entry_date'])):'';
			
			$vc_remarks=$val['AccountRecharge']['vc_remarks'];
			$paymentDate =!empty($val['AccountRecharge']['dt_payment_date']) ?
														  date('d-M-Y', strtotime($val['AccountRecharge']['dt_payment_date'])):
														  'N/A';
			
			$font_size=7;
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $entryDate, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $val['AccountRecharge']['vc_ref_no'], 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $paymentDate, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';
			
			$col[] = array('text' => number_format($val['AccountRecharge']['nu_amount_un'], 2, '.', ','), 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' => number_format($val['AccountRecharge']['nu_amount'], 2, '.', ','), 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			
			$col[] = array('text' => number_format($val['AccountRecharge']['nu_hand_charge'], 2, '.', ','), 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY04' && !empty($val['AccountRecharge']['nu_amount']) && (int)$val['AccountRecharge']['nu_amount'] > (int)$allconstants['CBCADMINFEE']){
					
				$approvedamt = number_format((($val['AccountRecharge']['nu_amount']) - (int)$allconstants['CBCADMINFEE']), 2, '.', ',');
						
			}
			else {
					
				$approvedamt = 'N/A';
						
			}
			
			$col[] = array('text' => $approvedamt, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $allconstants[$val['AccountRecharge']['vc_recharge_status']], 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_remarks, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;

	
		}
     
	
	}
	
 

    function headerallpages($openingbal,$recharge){
		 
		 
	}

	function genrate_cbc_customerstatement_pdf($columnsValues,$data,$allconstants,$Customer,$toDate=null,$fromDate=null,$funcopeningbalance,
	$TotalsumRefund,$totalmdcamt=null,$totalcbcamt=null,$NoOfrefund=null,
	$TotalsumRecharge=null,$Noofrecharge=null,$sumofcardsIssued=null,$checkreport) {
	
	    $this->AddPage();
		$this->SetFont('Arial', 'B', 7);		
		$c=0;
		$heightdynamic = 10;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		$columnwidtharrays=array(27,23,
			                     22,22,
  								 23,23,
								 23,27,
								 ); 
		
		// start for opening balance section in header
		$columnsofheader=array('Opening Balance (N$)','Recharge (N$)','Admin Fees (N$)',
		'Card Issue (N$)','CBC Total (N$)','MDC Total (N$)','Refund (N$)',
		'Account Balance (N$)');
		
		$x= $this->GetX();
		$y= $this->GetY();
		
		$this->SetFont('Arial', 'B', 6);

		$this->MultiCell($columnwidtharrays[0], $heightdynamic,$columnsofheader[0],1,'C',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[0]);		
		$this->MultiCell($columnwidtharrays[1],$heightdynamic,$columnsofheader[1],1,'C',true);

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$this->MultiCell($columnwidtharrays[2], $heightdynamic,$columnsofheader[2],1,'C',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[3], $heightdynamic,$columnsofheader[3],1,'C',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[4], $heightdynamic,$columnsofheader[4],1,'C',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[5], $heightdynamic,$columnsofheader[5],1,'C',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
	    $this->SetTextColor(208,121,121);

		$this->MultiCell($columnwidtharrays[6], $heightdynamic,$columnsofheader[6],1,'C',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+     $columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		 $this->SetTextColor(0,0,0);

		 $this->MultiCell($columnwidtharrays[7], $heightdynamic,$columnsofheader[7],1,'C',true);

		 $this->Ln(0);
		
		 if(isset($TotalsumRecharge) && $TotalsumRecharge!='' ) 
		 $TotalsumRecharge= $TotalsumRecharge; 
		 else 
		 $TotalsumRecharge=0;	

		 if(isset($Noofrecharge) && $Noofrecharge!='' ) 
		 $Noofrecharge= ($Noofrecharge)*($allconstants['CBCADMINFEE']); 
		 else 
		 $Noofrecharge =0;
                                  
		 if(isset($sumofcardsIssued) && $sumofcardsIssued!='' ) 
		 $sumofcardsIssuedcost= ($sumofcardsIssued)*($allconstants['CBCADMINFEE']); 
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
		   
		$totalRefundAll='';
		$totalpaid='';
					
		$totalpaid      = $Noofrecharge+$totalcbcamt+$totalmdcamt+$sumofcardsIssuedcost;
		$nu_account_balance = ($funcopeningbalance+$TotalsumRecharge+$TotalsumRefund)-$totalpaid;
		    
		$x= $this->GetX();
		$y= $this->GetY();
		
		$this->SetFont('Arial', 'B', 6);
		$this->SetTextColor(0,0,255);

		$this->MultiCell($columnwidtharrays[0], $heightdynamic,number_format($funcopeningbalance, 2, '.', ','),1,'R',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[0]);		
		$this->MultiCell($columnwidtharrays[1],$heightdynamic,number_format($TotalsumRecharge, 2, '.', ','),1,'R',true);
		
		
        $this->SetTextColor(208,21,21);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$this->MultiCell($columnwidtharrays[2], $heightdynamic,number_format($Noofrecharge, 2, '.', ','),1,'R',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[3], $heightdynamic,number_format($sumofcardsIssuedcost, 2, '.', ','),1,'R',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[4], $heightdynamic,number_format($totalcbcamt, 2, '.', ','),1,'R',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[5], $heightdynamic,number_format($totalmdcamt, 2, '.', ','),1,'R',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[6], $heightdynamic,number_format($TotalsumRefund, 2, '.', ','),1,'R',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$pos = strpos($nu_account_balance,'-');
		$this->SetTextColor(0,0,255);
					
		if($pos!== false){
		
		$this->MultiCell($columnwidtharrays[7], $heightdynamic,"(".number_format($nu_account_balance, 2, '.', ',').")",1,'R',true);
		
		} else {				
						
		$this->MultiCell($columnwidtharrays[7], $heightdynamic,number_format($nu_account_balance, 2, '.', ','),1,'R',true);
				
		}
		
        $this->SetTextColor(0,0,0);

		$this->Ln(2);


		
		// end  for opening balance section in header
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ){
		

		$this->SetFont('Arial', 'B', 6);
	    if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(25, 8, 'From Date : ',0,'L',true);
		else
		$this->MultiCell(25, 8, ' ',0,'L',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(100, 8, date('d-M-Y',strtotime($fromDate)) ,0,'','L',true);	
		else
		$this->MultiCell(100, 8,'' ,0,'','L',true);	
		

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(25, 8, 'To Date : ',0,'','R',true);
		else
		$this->MultiCell(25, 8, ' ',0,'','R',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(40, 8, date('d-M-Y',strtotime($toDate)) ,0,'L',true);
		else		
		$this->MultiCell(40, 8, '' ,0,'L',true);
		
		$this->Ln(2);
		
		}
		}
		
		$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays=array(12,15,
			16,30,
			18,17,
			18,19,
			20,25);
			
		 foreach($columnsValues as $val) {		
			
			$x= $this->GetX();
		    $y= $this->GetY();

			if($c==2  || $c==1){
			
			$this->MultiCell($columnwidtharrays[$c], 7, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
			else
			{
    		 $this->MultiCell($columnwidtharrays[$c], 14, $val , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		
		$this->SetFont('Arial', '', 5);
		$i=0;
		$this->Ln();
		$runningValue ='';
		$runningValue = $funcopeningbalance;
		
		// start of foreach data loop for display of all records
		
				foreach ($data as $value) {	
		
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
						 $netamount        = $value['Temp']['netamount']-$allconstants['CBCADMINFEE'];				
						 $runningValue = ($runningValue)+($netamount);

						

						}else{
						
						 $netamount        = $value['Temp']['netamount']-$allconstants['CBCADMINFEE'];				
						 $runningValue = ($runningValue)+($netamount);
						 $remarks = $value['Temp']['netamount'].' - '.$allconstants['CBCADMINFEE'].' ( Admin Fee )';

						}
						
						}else{
						
						

						if($value['Temp']['netamount'] == 0)
						{
						 $netamount        = 0;				
						 $runningValue     = $runningValue+0;							 
						 $remarks = 'Recharge  '.$allconstants[$vehicleregno];

					
						}else{
						 $runningValue = ($runningValue)+0;
						 $remarks = 'Recharge  '.$allconstants[$vehicleregno];

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
						if($value['Temp']['netamount'] == 0)
						{
						 $runningValue     = $runningValue+0;
						}else{
										
						 $netamount        = $value['Temp']['netamount'];				
						 $runningValue = $runningValue+$netamount;
						}
						$vehicleregno='N/A';
						$cardno='N/A';
						
						
					  }else {
					  
						$remarks = ' Refund '.$allconstants[$vehicleregno].' from HO ';
						
						if($value['Temp']['netamount'] == 0)
						{
						 $runningValue     = $runningValue+0;
						}else{
										
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
							
						$netamount= ($value['Temp']['running'])*($allconstants['CBCADMINFEE']);
						$runningValue = $runningValue-$netamount;
						}
					}
						
					if ($value['Temp']['transaction_type']!= 'Recharge' && $value['Temp']['transaction_type']!= 'CardsIssued' && $value['Temp']['transaction_type']!= 'Refund'){
					
						$bracket=1;
						$runningValue = $runningValue-$netamount;
						if($value['Temp']['transaction_type']== 'MDC' || $value['Temp']['transaction_type']== 'CBC')
						$remarks = $value['Temp']['remarks'];
										
					}
						
			
					if(isset($value['Temp']['issue_ref_date']) && $value['Temp']['issue_ref_date']!=''){
						$issue_ref_date = date('d-M-Y', strtotime($value['Temp']['issue_ref_date'])) ;
						} else {
						$issue_ref_date = 'N/A';
					
					}
					
			/////////code for columns display 
					
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();
			
			//$vc_veh_type      = $allconstants[$val['AddVehicle']['vc_veh_type']];
			$transaction_date = $value['Temp']['transaction_date'];
			
			$font_size=7;
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $transaction_type, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			
			$col[] = array('text' => date('d-M-Y', strtotime($transaction_date)), 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			

			
			$col[] = array('text' => $remarks, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			
			
			$col[] = array('text' => $issue_ref_date, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';
			$col[] = array('text' => $cardno, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $permit_refno, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
				
			
			
			$col[] = array('text' => $vehicleregno, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';
	
     	    $netamount= number_format($netamount, 2, '.', ',');
		
		    $col[] = array('text' =>$netamount, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$pos = strpos($runningValue,'-');
			if($pos!== false){
			
						$runningValuelast = '('.number_format($runningValue, 2, '.', ',').')';

			} else {
						$runningValuelast = number_format($runningValue, 2, '.', ',');

			}
			
			$col[] = array('text' =>$runningValuelast, 'width' =>$columnwidtharrays[9],
			'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			

			
						
			$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;
					
					
					
					
					
		}  // end of foreach data loop
		
		
		$this->SetFont('Arial', 'B', 7);		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		$this->SetFont('Arial', 'B', 6);
	    $this->MultiCell(25, 8, ' ',0,'L',true);		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+20);		
		$this->MultiCell(100, 8, '' ,0,'L',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+120);
		$this->SetFont('Arial', 'B', 6);
		$this->SetTextColor(0,0,255);
		$this->MultiCell(40, 8, ' Closing Balance (N$) ',0,'R',true);
        $this->SetTextColor(0,0,0);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+160);	
		
		$pos = strpos($runningValue,'-');
		if($pos!== false){
		   
		   $this->MultiCell(30, 8,"(". number_format($runningValue, 2, '.', ',').") " ,0,'R',true);
	
		}else{
			$this->MultiCell(30, 8, number_format($runningValue, 2, '.', ',')." " ,0,'R',true);
		
		}
		
		
	
	}
	
	
	function genrate_cbc_customerstatement_pdf_old($columnsValues,$data,$allconstants,$Customer,$toDate=null,$fromDate=null,$funcopeningbalance,
	$TotalsumRefund,$totalmdcamt=null,$totalcbcamt=null,$NoOfrefund=null,
	$TotalsumRecharge=null,$Noofrecharge=null,$sumofcardsIssued=null,$checkreport) {
	
		$this->AddPage();
		$this->SetFont('Arial', 'B', 7);	
		
		$c=0;
		$heightdynamic = 10;
		
		$this->SetFillColor(191,191,191);
		$length = count($columnsValues)-1;
		$columnwidtharrays=array(27,23,
			                     22,22,
  								 23,23,
								 23,27,
								 ); 

		
		// start for opening balance section in header
		$columnsofheader=array('Opening Balance (N$)','Recharge (N$)','Admin Fees (N$)',
		'Card Issue (N$)','CBC Total (N$)','MDC Total (N$)','Refund (N$)',
		'Account Balance (N$)');
		
	    $x= $this->GetX();
		$y= $this->GetY();
		
		$this->SetFont('Arial', 'B', 6);

		$this->MultiCell($columnwidtharrays[0], $heightdynamic,$columnsofheader[0],1,'C',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[0]);		
		$this->MultiCell($columnwidtharrays[1],$heightdynamic,$columnsofheader[1],1,'C',true);

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$this->MultiCell($columnwidtharrays[2], $heightdynamic,$columnsofheader[2],1,'C',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[3], $heightdynamic,$columnsofheader[3],1,'C',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[4], $heightdynamic,$columnsofheader[4],1,'C',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[5], $heightdynamic,$columnsofheader[5],1,'C',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
	    $this->SetTextColor(208,121,121);

		$this->MultiCell($columnwidtharrays[6], $heightdynamic,$columnsofheader[6],1,'C',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$this->SetTextColor(0,0,0);

		$this->MultiCell($columnwidtharrays[7], $heightdynamic,$columnsofheader[7],1,'C',true);

		$this->Ln(0);
		
		if(isset($TotalsumRecharge) && $TotalsumRecharge!='' ) 
		$TotalsumRecharge= $TotalsumRecharge; 
		else 
		$TotalsumRecharge=0;	

		if(isset($Noofrecharge) && $Noofrecharge!='' ) 
		$Noofrecharge= ($Noofrecharge)*($allconstants['CBCADMINFEE']); 
		else 
		$Noofrecharge =0;
                                  
		if(isset($sumofcardsIssued) && $sumofcardsIssued!='' ) 
		$sumofcardsIssuedcost= ($sumofcardsIssued)*($allconstants['CBCADMINFEE']); 
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
		   
		$totalRefundAll='';
		$totalpaid='';
					
		$totalpaid      = $Noofrecharge+$totalcbcamt+$totalmdcamt+$sumofcardsIssuedcost;
		$nu_account_balance = ($funcopeningbalance+$TotalsumRecharge+$TotalsumRefund)-$totalpaid;


			    
		$x= $this->GetX();
		$y= $this->GetY();
		
		$this->SetFont('Arial', 'B', 6);
		$this->SetTextColor(0,0,255);

		$this->MultiCell($columnwidtharrays[0], $heightdynamic,number_format($funcopeningbalance, 2, '.', ','),1,'R',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[0]);		
		$this->MultiCell($columnwidtharrays[1],$heightdynamic,number_format($TotalsumRecharge, 2, '.', ','),1,'R',true);
		
		
        $this->SetTextColor(208,21,21);

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$this->MultiCell($columnwidtharrays[2], $heightdynamic,number_format($Noofrecharge, 2, '.', ','),1,'R',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[3], $heightdynamic,number_format($sumofcardsIssuedcost, 2, '.', ','),1,'R',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[4], $heightdynamic,number_format($totalcbcamt, 2, '.', ','),1,'R',true);
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[5], $heightdynamic,number_format($totalmdcamt, 2, '.', ','),1,'R',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$this->MultiCell($columnwidtharrays[6], $heightdynamic,number_format($TotalsumRefund, 2, '.', ','),1,'R',true);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$pos = strpos($nu_account_balance,'-');
		$this->SetTextColor(0,0,255);
					
		if($pos!== false){
		
		$this->MultiCell($columnwidtharrays[7], $heightdynamic,"(".number_format($nu_account_balance, 2, '.', ',').")",1,'R',true);
		
		} else {				
						
		$this->MultiCell($columnwidtharrays[7], $heightdynamic,number_format($nu_account_balance, 2, '.', ','),1,'R',true);
				
		}
		
        $this->SetTextColor(0,0,0);

		$this->Ln(2);


		
		// end  for opening balance section in header

		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ){
		

		$this->SetFont('Arial', 'B', 6);
	    if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(25, 8, 'From Date : ',0,'L',true);
		else
		$this->MultiCell(25, 8, ' ',0,'L',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(100, 8, date('d-M-Y',strtotime($fromDate)) ,0,'','L',true);	
		else
		$this->MultiCell(100, 8,'' ,0,'','L',true);	
		

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(25, 8, 'To Date : ',0,'','R',true);
		else
		$this->MultiCell(25, 8, ' ',0,'','R',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(40, 8, date('d-M-Y',strtotime($toDate)) ,0,'L',true);
		else		
		$this->MultiCell(40, 8, '' ,0,'L',true);
		
		$this->Ln(2);
		
		}
		}
		
		$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays=array(12,16,
			15,30,
			18,17,
			18,19,
			20,25);
			
        foreach($columnsValues as $val) {		
			
			$x= $this->GetX();
		    $y= $this->GetY();

			if($c==2  || $c==1){
			
			$this->MultiCell($columnwidtharrays[$c], 7, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
			else
			{
    		 $this->MultiCell($columnwidtharrays[$c], 14, $val , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		
		$this->SetFont('Arial', '', 5);
		$i=0;
		$this->Ln();
		$runningValue ='';
		$runningValue = $funcopeningbalance;
		
		foreach ($data as $value) {
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, $i+1, 1,'L');
			
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
					 $netamount        = $value['Temp']['netamount']-$allconstants['CBCADMINFEE'];				
					 $runningValue = ($runningValue)+($netamount);

					

					}else{
					
					 $netamount        = $value['Temp']['netamount']-$allconstants['CBCADMINFEE'];				
					 $runningValue = ($runningValue)+($netamount);
					 $remarks = $value['Temp']['netamount'].' - '.$allconstants['CBCADMINFEE'].' ( Admin Fee )';

					}
					
					}else{
					
					

					if($value['Temp']['netamount'] == 0)
					{
					 $netamount        = 0;				
					 $runningValue     = $runningValue+0;							 
					 $remarks = 'Recharge  '.$allconstants[$vehicleregno];

				
					}else{
					 $runningValue = ($runningValue)+0;
					 $remarks = 'Recharge  '.$allconstants[$vehicleregno];

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
					if($value['Temp']['netamount'] == 0)
					{
					 $runningValue     = $runningValue+0;
					}else{
									
					 $netamount        = $value['Temp']['netamount'];				
					 $runningValue = $runningValue+$netamount;
					}
					$vehicleregno='N/A';
					$cardno='N/A';
					
					
				  }else {
				  
					$remarks = ' Refund '.$allconstants[$vehicleregno].' from HO ';
					
					if($value['Temp']['netamount'] == 0)
					{
					 $runningValue     = $runningValue+0;
					}else{
									
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
						
					$netamount= ($value['Temp']['running'])*($allconstants['CBCADMINFEE']);
					$runningValue = $runningValue-$netamount;
					}
				}
				
				if ($value['Temp']['transaction_type']!= 'Recharge' && $value['Temp']['transaction_type']!= 'CardsIssued' && $value['Temp']['transaction_type']!= 'Refund'){
				$bracket=1;
					$runningValue = $runningValue-$netamount;
					if($value['Temp']['transaction_type']== 'MDC' || $value['Temp']['transaction_type']== 'CBC')
					$remarks = $value['Temp']['remarks'];
									
				}
						
			$transaction_type;
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[1],$heightdynamic, $transaction_type, 1,'L');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, date('d-M-Y', strtotime($value['Temp']['transaction_date'])), 1,'L');
			
		    $this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			$this->MultiCell($columnwidtharrays[3],$heightdynamic, $remarks , 1,'L');
			$this->SetY($y);  //Reset the write point
			 		
            $this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			if(isset($value['Temp']['issue_ref_date']) && $value['Temp']['issue_ref_date']!=''){
			$issue_ref_date = date('d-M-Y', strtotime($value['Temp']['issue_ref_date'])) ;
				} else {
			$issue_ref_date = 'N/A';
			
			}
			$this->MultiCell($columnwidtharrays[4],$heightdynamic ,$issue_ref_date, 1,'L');			
			$this->SetY($y); 
			$this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 


			$this->MultiCell($columnwidtharrays[5],$heightdynamic ,$cardno, 1,'R');
			$this->SetY($y);  
			
            $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			 $this->MultiCell($columnwidtharrays[6],$heightdynamic, $permit_refno, 1,'L');
			 
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			 $this->MultiCell($columnwidtharrays[7],$heightdynamic, $vehicleregno, 1,'L');
			
            $this->SetY($y); 
			
			$this->SetX($x+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			
			if($bracket==1) {
			$this->MultiCell($columnwidtharrays[8],$heightdynamic,'('.number_format($netamount, 2, '.', ',').')',  1,'R');
			}else {
			$this->MultiCell($columnwidtharrays[8],$heightdynamic,number_format($netamount, 2, '.', ','),  1,'R');
			}
            
			$this->SetY($y);
            $this->SetX($x+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			 
			$pos = strpos($runningValue,'-');
			if($pos!== false){
		           
				   $this->MultiCell($columnwidtharrays[9],$heightdynamic, "(".number_format($runningValue, 2, '.', ',').")", 1,'R');
		
			}else{
				$this->MultiCell($columnwidtharrays[9],$heightdynamic, number_format($runningValue, 2, '.', ','), 1,'R');
			}
			
			if($this->PageNo()==1){
			
				if($i%14==0 && $i>0){
						
				$this->AddPage();
			
			  }
			}else{
						
				if(($i)%16==0 && $i>16)	{
			
			
						  $this->AddPage();
			
				}
			           					
			}
			
					
			//$this->Ln();
			$i++;
			
		
        }
		
		
		$this->SetFont('Arial', 'B', 7);		
		$this->SetFillColor(191,191,191);
		
		
		
		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		

		$this->SetFont('Arial', 'B', 6);
	    $this->MultiCell(25, 8, ' ',0,'L',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+20);		
		
		$this->MultiCell(100, 8, '' ,0,'L',true);	
		

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+120);
		$this->SetFont('Arial', 'B', 6);
		$this->SetTextColor(0,0,255);
		$this->MultiCell(40, 8, ' Closing Balance (N$) ',0,'R',true);
        $this->SetTextColor(0,0,0);

		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+160);	
		
		$pos = strpos($runningValue,'-');
		if($pos!== false){
		   
		   $this->MultiCell(30, 8,"(". number_format($runningValue, 2, '.', ',').") " ,0,'R',true);
	
		}else{
			$this->MultiCell(30, 8, number_format($runningValue, 2, '.', ',')." " ,0,'R',true);
		
		}
		
		
		$this->Ln(2);
			
		
		
	 }
	 
	 
	  /*  
  
  
  function genrate_cbc_customerrechargepdf_right($columnsValues,$data,$allconstants,$Customer,$toDate=null,$fromDate=null) {
        
	
	
		$this->AddPage();
		$this->SetFont('Arial', 'B', 7);		
		$c=0;		
		$this->SetFillColor(191,191,191);		
		$length = count($columnsValues)-1;
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ){
		

		$this->SetFont('Arial', 'B', 6);
	    if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(25, 8, 'From Date : ',0,'L',true);
		else
		$this->MultiCell(25, 8, ' ',0,'L',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(100, 8, $fromDate ,0,'L',true);	
		else
		$this->MultiCell(100, 8, $fromDate ,0,'L',true);	
		

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(25, 8, 'To Date : ',0,'R',true);
		else
		$this->MultiCell(25, 8, ' ',0,'R',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(40, 8, $toDate ,0,'L',true);
		else		
		$this->MultiCell(40, 8, '' ,0,'L',true);
		$this->Ln(2);
		
		}
		}
		
		$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays = array(12,16,
			20,22,
			20,20,
			15,23,
			15,28); 
        foreach($columnsValues as $val) {
			//$this->Ln(0);
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0  ||$c==7 ){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		if($c==$length)
			 $this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			else
			 $this->MultiCell($columnwidtharrays[$c], 6, $val , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		
		$this->SetFont('Arial', '', 6);
		$i=0;
		$this->Ln();
		$heightdynamic=10;
		//echo '<pre>';
		//print_r($data);
		//die;
		$x  = $this->GetX();
		$y  = $this->GetY();
		foreach ($data as $val) {
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
			

            $this->MultiCell($columnwidtharrays[0], $heightdynamic, $i+1, 1,'C');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
		
			
			$entryDate =!empty($val['AccountRecharge']['dt_entry_date'])?
			date('d-M-Y', strtotime($val['AccountRecharge']['dt_entry_date'])):'';
            
		
			$this->MultiCell($columnwidtharrays[1],$heightdynamic, $entryDate, 1,'L');
		    
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
	
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, $val['AccountRecharge']['vc_ref_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$paymentDate =!empty($val['AccountRecharge']['dt_payment_date']) ?
														  date('d-M-Y', strtotime($val['AccountRecharge']['dt_payment_date'])):
														  'N/A';
														  
            $this->MultiCell($columnwidtharrays[3],$heightdynamic, $paymentDate, 1,'L');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 

			$this->MultiCell($columnwidtharrays[4],$heightdynamic , number_format($val['AccountRecharge']['nu_amount_un'], 2, '.', ','), 1,'R');
			
			$this->SetY($y);  
            $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 


			$this->MultiCell($columnwidtharrays[5],$heightdynamic ,
			number_format($val['AccountRecharge']['nu_amount'], 2, '.', ','), 1,'R');
			
			$this->SetY($y);  
            $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);  


            $this->MultiCell($columnwidtharrays[6],10, number_format($val['AccountRecharge']['nu_hand_charge'], 2, '.', ','), 1,'R');
			
			if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY04' && !empty($val['AccountRecharge']['nu_amount']) && (int)$val['AccountRecharge']['nu_amount'] > (int)$allconstants['CBCADMINFEE']){
					
				$novalue = number_format((($val['AccountRecharge']['nu_amount']) - (int)$allconstants['CBCADMINFEE']), 2, '.', ',');
						
			}
			else {
					
				$novalue = 'N/A';
						
			}
            $this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 

            $this->MultiCell($columnwidtharrays[7],$heightdynamic, $novalue, 1,'R');
			
            $this->SetY($y);  
			$this->SetX($x+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
            
			$this->MultiCell($columnwidtharrays[8],$heightdynamic,$allconstants[$val['AccountRecharge']['vc_recharge_status']],  1,'L');
			
			$this->SetY($y);
            $this->SetX($x+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);

            
			if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY05'){
					
						$vc_remarks=$val['AccountRecharge']['vc_remarks'];
					
			} else{
					
						$vc_remarks='N/A';
			}
			
            $this->MultiCell($columnwidtharrays[9],$heightdynamic, $vc_remarks, 1,'L');

			
			if((int)$this->GetY()>180 && $i>0)	{
			
				$this->AddPage();
			
			}				
			$i++;
			
		
        }
		
    }

    function genrate_cbc_customerrechargepdf_old($columnsValues,$data,$allconstants,$Customer,$toDate=null,$fromDate=null) {
        
		$this->AddPage();
		$this->SetFont('Arial', 'B', 7);		
		$c=0;		
		$this->SetFillColor(191,191,191);		
		$length = count($columnsValues)-1;
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ){
		

		$this->SetFont('Arial', 'B', 6);
	    if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(25, 8, 'From Date : ',0,'L',true);
		else
		$this->MultiCell(25, 8, ' ',0,'L',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		if(isset($fromDate) && !empty($fromDate))
		$this->MultiCell(100, 8, $fromDate ,0,'L',true);	
		else
		$this->MultiCell(100, 8, $fromDate ,0,'L',true);	
		

		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(25, 8, 'To Date : ',0,'R',true);
		else
		$this->MultiCell(25, 8, ' ',0,'R',true);
		
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		
		if(isset($toDate) && !empty($toDate))
		$this->MultiCell(40, 8, $toDate ,0,'L',true);
		else		
		$this->MultiCell(40, 8, '' ,0,'L',true);
		$this->Ln(2);
		
		}
		}
		
		$this->SetFont('Arial', 'B', 6);
		$columnwidtharrays = array(28,16,
			20,22,
			20,20,
			15,23,
			15,12); 
        foreach($columnsValues as $val) {
			//$this->Ln(0);
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0  ||$c==7 ){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		if($c==$length)
			 $this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			else
			 $this->MultiCell($columnwidtharrays[$c], 6, $val , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		
		$this->SetFont('Arial', '', 6);
		$i=0;
		$this->Ln();
		$heightdynamic=10;
		//echo '<pre>';
		//print_r($data);
		//die;
		$x  = $this->GetX();
		$y  = $this->GetY();
		foreach ($data as $val) {
			
			
			//print_r($val);
			if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY05'){
					
						$vc_remarks=$val['AccountRecharge']['vc_remarks'];
					
			} else{
					
						$vc_remarks='N/A';
			}
			
			$y1 = $this->GetY();
			//echo $vc_remarks;
			//die('hua');
            $this->MultiCell($columnwidtharrays[0], $heightdynamic, $vc_remarks, 1,'L');
			$y2 = $this->GetY();
			$rowHeight = $y2 - $y1;
						
			$this->SetXY($x + $columnwidtharrays[0], $this->GetY() - $rowHeight);
			//$yCurrent  = $this->GetY();
			//$rowHeight = $yCurrent - $yBeforeCell;
			//$diff      = $this->GetY() - $rowHeight;
			//$this->SetY($diff);  //Reset the write point
			 //$y=$diff;
            //$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			$heightdynamic = $rowHeight;
			$entryDate =!empty($val['AccountRecharge']['dt_entry_date'])?
			date('d-M-Y', strtotime($val['AccountRecharge']['dt_entry_date'])):'';
            
		
			$this->Cell($columnwidtharrays[1],$heightdynamic, $entryDate,'1', 0, 'L');
		   
			//$this->SetY($y);  //Reset the write point
           // $this->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->Cell($columnwidtharrays[2], $heightdynamic, $val['AccountRecharge']['vc_ref_no'],'1', 0, 'L');
			
			//$this->SetY($y);  //Reset the write point
            //$this->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$paymentDate =!empty($val['AccountRecharge']['dt_payment_date']) ?
														  date('d-M-Y', strtotime($val['AccountRecharge']['dt_payment_date'])):
														  'N/A';
														  
            $this->Cell($columnwidtharrays[3],$heightdynamic, $paymentDate,'1', 0, 'L');
			//$this->SetY($y);  //Reset the write point
            //$this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 

			$this->Cell($columnwidtharrays[4],$heightdynamic , number_format($val['AccountRecharge']['nu_amount_un'], 2, '.', ','),'1', 0, 'R');
			
			//$this->SetY($y);  
           // $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 


			$this->Cell($columnwidtharrays[5],$heightdynamic ,
			number_format($val['AccountRecharge']['nu_amount'], 2, '.', ','),'1', 0, 'R');
			
			//$this->SetY($y);  
            //$this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);  


            $this->Cell($columnwidtharrays[6],$heightdynamic, number_format($val['AccountRecharge']['nu_hand_charge'], 2, '.', ','),'1', 0, 'R');
			
			if($val['AccountRecharge']['vc_recharge_status'] == 'STSTY04' && !empty($val['AccountRecharge']['nu_amount']) && (int)$val['AccountRecharge']['nu_amount'] > (int)$allconstants['CBCADMINFEE']){
					
				$novalue = number_format((($val['AccountRecharge']['nu_amount']) - (int)$allconstants['CBCADMINFEE']), 2, '.', ',');
						
			}
			else {
					
				$novalue = 'N/A';
						
			}
           // $this->SetY($y);  //Reset the write point
           // $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 

            $this->Cell($columnwidtharrays[7],$heightdynamic, $novalue,'1', 0, 'R');
			
            //$this->SetY($y);  
			//$this->SetX($x+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
            
			$this->Cell($columnwidtharrays[8],$heightdynamic,$allconstants[$val['AccountRecharge']['vc_recharge_status']],'1', 0, 'L');
			
			//$this->SetY($y);
            //$this->SetX($x+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);

            
			$this->Cell($columnwidtharrays[9],$heightdynamic, $i.'='.$this->GetY(),'1', 0, 'R');

			
		
			
			if((int)$this->GetY()>180 && $i>0)	{
			
				$this->AddPage();
			
			}				
			$this->Ln();
			$i++;
			
		
        }
		
    }
	*/
	
	
	}

?>
