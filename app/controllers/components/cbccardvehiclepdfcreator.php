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

class CbccardvehiclepdfcreatorComponent extends FPDF {

	
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
   function NbLines($w, $txt){
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

	
	function headerData($title, $period = NULL,$customerInfo=array()) {
        
		$this->ReportTitle = $title;
	
		$this->Customer = $customerInfo;
	}
	
	/*
	*
	*Header
	*
	*/
	
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
		

		$this->Ln(3);

		
		
		
		}
		
		
    }
	
	/*
	*
	*Footer
	*
	*/

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
	
	/*
	*
	*Card List pdf
	*
	*/
	
	function generate_card_list_pdf($columnsValues,$active_cards, $inactive_cards, $total_cards, $data, $allconstants,
	$Customer ){
	
		
		$columnwidtharrays = array(20,57,57,56);
		
		$heightdynamic =12;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
			$this->SetFillColor(191,191,191);

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			
			$this->MultiCell(25, 8, 'Active Cards : ',0,'','L',true);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			
			$this->MultiCell(40, 8, number_format($active_cards),0,'','L',true);
			
			$this->SetY($y);  //Reset the write point
		
			$this->SetX($x+65);
			
			$this->SetFont('Arial', 'B', 6);
			
			$this->MultiCell(25, 8, 'Inactive Cards :',0,'','R',true);
			
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+90);	
			
			$this->MultiCell(50, 8, number_format($inactive_cards),0,'','L',true);	

			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+140);
			
			$this->SetFont('Arial', 'B', 6);
			
			$this->MultiCell(25, 8, 'Total Cards :',0,'','R',true);
			
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+165);	
			
			$this->MultiCell(25, 8, number_format($total_cards),0,'','L',true);	
			
			$this->Ln(3);
			
		}

			$c=0;
		
			$this->SetFillColor(191,191,191);

			$length = count($columnsValues)-1;

			$this->SetFont('Arial', 'B', 7);

			foreach($columnsValues as $val) {
			
				$x= $this->GetX();

				$y= $this->GetY();
				
				
				if( $c == 0){

					$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

					$this->SetY($y);  //Reset the write point

					$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell

				}
				else
				{
					if($c==$length)

						$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

					else

						$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

						$this->SetY($y);  //Reset the write point

						$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
				}

				$c++;

			}
			
			$this->SetFont('Arial', '', 7);
		
			$i=0;
		
			$this->Ln();
			
		foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
			
			$alignvalue = 'L';
			
			$columns = array();
			
			$col = array();

		    $vc_card_no = 		$val['ActivationDeactivationCard']['vc_card_no'];
		    
			$issueDate=			!empty($val['ActivationDeactivationCard']['dt_issue_date']) ?
                                                  date('d-M-Y', strtotime($val['ActivationDeactivationCard']['dt_issue_date'])):
                                                  '';
			$vc_card_flag=		$allconstants[$val['ActivationDeactivationCard']['vc_card_flag']];

			$font_size = 6;
			
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_card_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $issueDate, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_card_flag, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
			
		}
	}
	
	
	
	
	
	function generate_card_list_pdf_old($columnsValues,$active_cards, $inactive_cards, $total_cards, $data, $allconstants,
	$Customer ){
	
		
		$columnwidtharrays = array(20,57,57,56);
		
		$heightdynamic =10;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
			$this->SetFillColor(191,191,191);

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			
			$this->MultiCell(25, 8, 'Active Cards : ',0,'','L',true);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			
			$this->MultiCell(40, 8, number_format($active_cards),0,'','L',true);
			
			$this->SetY($y);  //Reset the write point
		
			$this->SetX($x+65);
			
			$this->SetFont('Arial', 'B', 6);
			
			$this->MultiCell(25, 8, 'Inactive Cards :',0,'','R',true);
			
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+90);	
			
			$this->MultiCell(50, 8, number_format($inactive_cards),0,'','L',true);	

			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+140);
			
			$this->SetFont('Arial', 'B', 6);
			
			$this->MultiCell(25, 8, 'Total Cards :',0,'','R',true);
			
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+165);	
			
			$this->MultiCell(25, 8, number_format($total_cards),0,'','L',true);	
			
			$this->Ln(3);
			
		}

			$c=0;
		
			$this->SetFillColor(191,191,191);

			$length = count($columnsValues)-1;

			$this->SetFont('Arial', 'B', 7);

			foreach($columnsValues as $val) {

				$x= $this->GetX();

				$y= $this->GetY();
				
				
				if( $c == 0){

					$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

					$this->SetY($y);  //Reset the write point

					$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell

				}
				else
				{
					if($c==$length)

						$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

					else

						$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

						$this->SetY($y);  //Reset the write point

						$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
				}

				$c++;

			}
			
			$this->SetFont('Arial', '', 7);
		
			$i=1;
		
			$this->Ln();
			
			foreach ($data as $val) {
			
				$x  = $this->GetX();
				
				$y  = $this->GetY();
				
				$this->MultiCell($columnwidtharrays[0], $heightdynamic, $i, 1,'C');
				
				$this->SetY($y);  //Reset the write point
				
				$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
				
				$this->MultiCell($columnwidtharrays[1], $heightdynamic, $val['ActivationDeactivationCard']['vc_card_no'], 1,'L');
				
				$this->SetY($y);  //Reset the write point
				
				$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
				
				$issueDate=!empty($val['ActivationDeactivationCard']['dt_issue_date']) ?
                                                  date('d-M-Y', strtotime($val['ActivationDeactivationCard']['dt_issue_date'])):
                                                  '';
				
				$this->MultiCell($columnwidtharrays[2], $heightdynamic, $issueDate, 1,'L');
				
				$this->SetY($y);  //Reset the write point
				
				$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
				
				$this->MultiCell($columnwidtharrays[3], $heightdynamic, $allconstants[$val['ActivationDeactivationCard']['vc_card_flag']], 1,'L');

					if($i%15==0 && $i>0){
					
						$this->AddPage();
					
					}				
			
					$i++;
			}
	
	}
	
	/*
	*
	*Vehicle List pdf
	*
	*/
	
	function generate_vehicle_list_pdf($columnsValues,$total_vehicles,$data,$allconstants,$Customer){
	
	$heightdynamic =12;
		
		$columnwidtharrays = array(15,50,45,50,30);
		
		$this->AddPage();
		
		
		$this->SetFont('Arial', 'B', 6);		
		
		$c=0;
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
	
		
		
				
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Total Vehicles: ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8, $total_vehicles ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, '' ,0,'','L',true);	
		$this->Ln(6);
		
		
		}
		$this->SetFont('Arial', 'B', 6);
		
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
		$this->SetFont('Arial', '', 10);
		$i=0;
		$this->Ln();
	
		foreach ($data as $val) {
		
		$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();
		
		
			$vc_reg_no         = $val['ActivationDeactivationVehicle']['vc_reg_no'];
			$vc_chasis_no      = $val['ActivationDeactivationVehicle']['vc_chasis_no'];
			$vc_veh_type       = $allconstants[$val['ActivationDeactivationVehicle']['vc_veh_type']];
			$vc_status         = $allconstants[$val['ActivationDeactivationVehicle']['vc_status']];
			
			
			$font_size=7;
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_reg_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
		
			$col[] = array('text' => $vc_chasis_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			

			
			$col[] = array('text' => $vc_veh_type, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_status, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;
	
		}
	
	
	}
	
	
	function generate_vehicle_list_pdf_old($columnsValues,$total_vehicles,$data,$allconstants,$Customer){
	
		
		$heightdynamic =12;
		
		$columnwidtharrays = array(15,50,45,50,30);
		
		$this->AddPage();
		
		
		$this->SetFont('Arial', 'B', 6);		
		
		$c=0;
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
	
		
		
				
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Total Vehicles: ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8, $total_vehicles ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(40, 8, '' ,0,'','L',true);	
		$this->Ln(6);
		
		
		}
		$this->SetFont('Arial', 'B', 6);
		
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
		$this->SetFont('Arial', '', 6);
		$i=0;
		$this->Ln();
	
		foreach ($data as $val) {
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
            $this->MultiCell($columnwidtharrays[0],$heightdynamic , $i+1, 1,'C');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[1], $heightdynamic , $val['ActivationDeactivationVehicle']['vc_reg_no'], 1,'L');
			
			
			$this->SetY($y);  //Reset the write point
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[2], $heightdynamic , $val['ActivationDeactivationVehicle']['vc_chasis_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, $allconstants[$val['ActivationDeactivationVehicle']['vc_veh_type']], 1,'L');
			
			
			$this->SetY($y);  //Reset the write point
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->Multicell($columnwidtharrays[4], $heightdynamic, $allconstants[$val['ActivationDeactivationVehicle']['vc_status']], 1,'L');
			
			
			if($i%12==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			//$this->Ln();
			$i++;
			
			}
	}
	 
}

?>
