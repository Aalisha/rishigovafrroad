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

class InspectorreportpdfcreatorComponent extends FPDF {

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



    function Header() {
        
		//global $title;
		
       // $title = $this->ReportTitle;		
		$title= ' ';
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);
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
		$currentUser='';
		//$currentUser = $this->Member;
	//	print_r($currentUser);die;
        $this->Ln(10);
		//$this->SetFont('Arial', 'B', 12);
		
		if($this->PageNo()==1){
		
	/*	$this->SetFillColor(191,191,191);
		$x= $this->GetX();
		$y= $this->GetY();
		$this->SetFont('Arial', 'B', 7);
		$this->MultiCell(25, 8, 'Inspector Id : ',0,'','L',true);
		$this->SetFont('Arial','', 7);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);
		$this->MultiCell(164, 8, $currentUser['Member']['vc_username'] ,0,'','L',true);
		$this->Ln(2);
*/
		}
    }
	
	/*
	*Header Data
	*
	*/
	
	function headerData($title, $period = NULL,$customerInfo=array(), $toDate, $fromDate) {
        
		//$this->ReportTitle = $title;
        
		//$this->Member = $customerInfo;
		
		
    } 
	
	/*
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
	*Vehicle History Report
	*
	*/
	
	
	
	function genrate_inspectorvehiclehistorypdf($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name,$vehiclelicno=null) {
	  
		$columnwidtharrays = array(10,30,26,26,23,18,20,20,16);
		
		$heightdynamic =8;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, $vc_customer_name,0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
			$x = $this->GetX();			
			$y = $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(25, 8, 'Vehicle Register No. : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(164, 8, $vehiclelicno,0,'','L',true);	
			else
			$this->MultiCell(164 ,8, '',0,'','L',true);			
			
			$this->Ln(2);
			
		}
	}
		
	$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=0;
		
		$this->Ln();
		
		foreach ($data as $val) {
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();

		    $vc_customer_name  =		ucfirst($val['CustomerProfile']['vc_customer_name']);
		    $vc_vehicle_lic_no =		$val['VehicleDetail']['vc_vehicle_lic_no'];
		    $vc_vehicle_reg_no =		$val['VehicleDetail']['vc_vehicle_reg_no'];
		    $dt_created_date   =		date('d M Y', strtotime($val['VehicleDetail']['dt_created_date']));
		    $vc_prtype_name    =		$val['VEHICLETYPE']['vc_prtype_name'];
		    $vc_v_rating       =		number_format($val['VehicleDetail']['vc_v_rating']);
		    $vc_dt_rating      =		number_format($val['VehicleDetail']['vc_dt_rating']);
		    $vc_rate           =		number_format($val['VehicleDetail']['vc_rate'],2,'.',',');
			
			$font_size=7;
			
			$fillcolor= '255,250,250';
			
			$alignvalue='C';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $vc_customer_name, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $vc_vehicle_lic_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_reg_no, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $dt_created_date, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' => $vc_prtype_name, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		
			$alignvalue='R';
			
			$col[] = array('text' => $vc_v_rating, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' => $vc_dt_rating, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' =>$vc_rate, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
			
		}
	}
    
	
	
	function genrate_inspectorvehiclehistorypdf_old($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name) {
	
		$columnwidtharrays = array(10,30,26,26,23,18,20,20,16);
		
		$heightdynamic =12;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, $vc_customer_name,0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
	}
		$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=1;
		
		$this->Ln();
		
		
		foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
            
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, $i, 1,'C');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$explo    =    explode(" ",trim($val['CustomerProfile']['vc_customer_name']));
            
			$explolen = count($explo);     
          
            if($explolen>0)
				
				$customer_name = substr($explo[0], 0, 1).'. '.$explo[$explolen-1];
            
			else
				
				$customer_name = $val['CustomerProfile']['vc_customer_name'];
			
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, $customer_name, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, $val['VehicleDetail']['vc_vehicle_lic_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, $val['VehicleDetail']['vc_vehicle_reg_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[4], $heightdynamic, date('d M Y', strtotime($val['VehicleDetail']['dt_created_date'])), 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]); //Move X to $x + width of last cell

			$this->MultiCell($columnwidtharrays[5], $heightdynamic, $val['VEHICLETYPE']['vc_prtype_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic,  number_format($val['VehicleDetail']['vc_v_rating']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic, number_format($val['VehicleDetail']['vc_dt_rating']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]
			+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[8], $heightdynamic,number_format($val['VehicleDetail']['vc_rate'],2,'.',','), 1,'R');
			
			if($i%15==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			
			$i++;
		}

    }
	
	/*
	*
	*Vehicle Log Sheet PDF
	*
	*/
	
	function genrate_inspectorvehiclelogsheet_pdf($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name,$vehiclelicno=null) {
	
		$columnwidtharrays = array(17,20,15,15,18,14,13,13,15,25,25);
		
		$heightdynamic = 8;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);

			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);		
			
			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+125);			
			$this->SetFont('Arial', 'B', 6);
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, ucfirst($vc_customer_name),0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
			$x= $this->GetX();			
			$y= $this->GetY();			
			$this->SetFont('Arial', 'B', 6);		
			
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(25, 8, 'Vehicle Register No. : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			
			$this->SetFont('Arial','', 6);			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+25);
			
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(165, 8, $vehiclelicno,0,'','L',true);	
			else
			$this->MultiCell(165, 8, '',0,'','L',true);
			$this->Ln(2);
		}
	}
	
			$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();

		 if( $c == 0 ){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
			
			
			if($c == 4 || $c == 7 || $c == 8 || $c == 1|| $c == 9){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
				if($c==$length ){

					$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);

					$this->SetY($y);  //Reset the write point

					$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell

				}

				else{

					$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

					$this->SetY($y);  //Reset the write point

					$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
				}
		   }
		   
			$c++;
		
		}
		
		$this->SetFont('Arial', '', 5);
		
		$i=0;
		
		$this->Ln();
		
		foreach ($data as $val) {
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();

		    $LogDate = !empty ($val['VehicleLogDetail']['dt_log_date']) ? 
                        date('d M Y', strtotime($val['VehicleLogDetail']['dt_log_date'])):
                        '';
		    $vc_customer_name=		ucfirst($val['VehicleLogMaster']['vc_customer_name']);
		    $vc_vehicle_reg_no=		$val['VehicleDetail']['vc_vehicle_reg_no'];
		    $vc_vehicle_lic_no=		$val['VehicleLogDetail']['vc_vehicle_lic_no'];
		    $vc_driver_name=		$val['VehicleLogDetail']['vc_driver_name'];
			$StartOMet = 			isset($val['VehicleLogDetail']['nu_start_ometer']) ?$val['VehicleLogDetail']['nu_start_ometer']:'';
		    $EndOMet = 				isset($val['VehicleLogDetail']['nu_end_ometer']) ?$val['VehicleLogDetail']['nu_end_ometer']:'';
			
			if($val['VehicleLogDetail']['ch_road_type']==1){
			
			$origin = $val['VehicleLogDetail']['vc_other_road_orign_name'];
			$destination = $val['VehicleLogDetail']['vc_other_road_destination_name'];
			//$kmtravldnamroad = number_format($val['VehicleLogDetail']['nu_km_traveled']);
			$KmTraV = $val['VehicleLogDetail']['nu_other_road_km_traveled'];
			
			}else{
			
			$origin = $val['VehicleLogDetail']['vc_orign_name'];
			$destination = $val['VehicleLogDetail']['vc_destination_name'];
			$KmTraV = $val['VehicleLogDetail']['nu_km_traveled'];
			//$kmtrvldotheroad = number_format($val['VehicleLogDetail']['nu_other_road_km_traveled']);
			
			}
			if($val['VehicleLogDetail']['ch_road_type']==1)
			$ch_road_type= 'Other Road';
			else
			$ch_road_type=  'Namibian Road';
							
			
//			$vc_orign_name =		$val['VehicleLogDetail']['vc_orign_name'];
	//	    $vc_destination_name=	$val['VehicleLogDetail']['vc_destination_name'];
		//	$KmTraV = 				isset($val['VehicleLogDetail']['nu_km_traveled']) ?$val['VehicleLogDetail']['nu_km_traveled']:'';
		  //  $KmTravOth = 			isset($val['VehicleLogDetail']['nu_other_road_km_traveled']) ?$val['VehicleLogDetail']['nu_other_road_km_traveled']:'';

			$font_size = 7;
			
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $LogDate, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_customer_name, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $vc_vehicle_reg_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_lic_no, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_driver_name, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';
			
			$col[] = array('text' => number_format($StartOMet), 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => number_format($EndOMet), 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $ch_road_type, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			$col[] = array('text' => $origin, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' =>$destination, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';
			
			$col[] = array('text' =>number_format($KmTraV), 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			

			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
	
		}
	
	}
	
	
	
	

	function genrate_inspectorvehiclelogsheet_pdf_old($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name) {
	
		$columnwidtharrays = array(15,20,15,15,18,14,13,13,15,27,25);
		
		$heightdynamic = 12;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, $vc_customer_name,0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
	}
	
			$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();

		 if( $c == 0 ){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
			
			if($c==10){
			
				$this->SetFont('Arial', 'B', 5);
			
			}
			if($c == 4 || $c == 7 || $c == 8 || $c == 1){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
				if($c==$length ){

					$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);

					$this->SetY($y);  //Reset the write point

					$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell

				}

				else{

					$this->MultiCell($columnwidtharrays[$c], 8, $val , 1,'C',true);

					$this->SetY($y);  //Reset the write point

					$this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
				}
		   }
		   
			$c++;
		
		}
		
		$this->SetFont('Arial', '', 5);
		
		$i=1;
		
		$this->Ln();
		
		foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
			
			$LogDate = !empty ($val['VehicleLogDetail']['dt_log_date']) ? 
                        date('d M Y', strtotime($val['VehicleLogDetail']['dt_log_date'])):
                        '';
            
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, $LogDate, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$explo    =    explode(" ",trim($val['VehicleLogMaster']['vc_customer_name']));
            
			$explolen = count($explo);     
          
            if($explolen>0)
				
				$customer_name = substr($explo[0], 0, 1).'. '.$explo[$explolen-1];
            
			else
				
				$customer_name = $val['VehicleLogMaster']['vc_customer_name'];
			
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, $customer_name, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, $val['VehicleLogDetail']['vc_vehicle_reg_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, $val['VehicleLogDetail']['vc_vehicle_lic_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$explo    =    explode(" ",trim($val['VehicleLogDetail']['vc_driver_name']));
            
			$explolen = count($explo);     
          
            if($explolen>0)
				
				$driver_name = substr($explo[0], 0, 1).'. '.$explo[$explolen-1];
            
			else
				
				$driver_name = $val['VehicleLogDetail']['vc_driver_name'];
			
			$this->MultiCell($columnwidtharrays[4], $heightdynamic, $driver_name, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$StartOMet = isset($val['VehicleLogDetail']['nu_start_ometer']) ?$val['VehicleLogDetail']['nu_start_ometer']:'';

			$this->MultiCell($columnwidtharrays[5], $heightdynamic, number_format($StartOMet), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$EndOMet = isset($val['VehicleLogDetail']['nu_end_ometer']) ?$val['VehicleLogDetail']['nu_end_ometer']:'';
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic, number_format($EndOMet), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic, $val['VehicleLogDetail']['vc_orign_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]
			+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[8], $heightdynamic, $val['VehicleLogDetail']['vc_destination_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+
			$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$KmTraV = isset($val['VehicleLogDetail']['nu_km_traveled']) ?$val['VehicleLogDetail']['nu_km_traveled']:'';
			
			$this->MultiCell($columnwidtharrays[9], $heightdynamic,number_format($KmTraV), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+
			$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]
			+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$KmTravOth = isset($val['VehicleLogDetail']['nu_other_road_km_traveled']) ?$val['VehicleLogDetail']['nu_other_road_km_traveled']:'';
			
			$this->MultiCell($columnwidtharrays[10], $heightdynamic,number_format($KmTravOth), 1,'R');
			
			if($i%18==0 && $i>0){
			
			$this->AddPage();
			
			}				
			
			$i++;
		}

    }
	
	/*
	*
	*Vehicle Payment History PDF
	*
	*/
	
	
	function genrate_inspectorpaymenthistory_pdf($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name) {
	
		$columnwidtharrays = array(10,24,26,26,28,26,25,24);
		
		$heightdynamic = 12;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, $vc_customer_name,0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=0;
		
		$this->Ln();
		
		 foreach ($data as $val) {
		 
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();

		    $vc_assessment_no = 	$val['AssessmentVehicleMaster']['vc_assessment_no'];
		    $vc_customer_name=		$val['AssessmentVehicleMaster']['vc_customer_name'];
		    $dt_assessment_date=	date('d-M-y', strtotime($val['AssessmentVehicleMaster']['dt_assessment_date']));
		    $nu_total_payable_amount= number_format($val['AssessmentVehicleMaster']['nu_total_payable_amount'],2,'.',',');
		    $vc_mdc_paid=			number_format($val['AssessmentVehicleMaster']['vc_mdc_paid'],2,'.',',');
			$dt_received_date = 	date('d M Y',  strtotime($val['AssessmentVehicleMaster']['dt_received_date']));
		    $vc_prtype_name = 		$val['PaymentStatus']['vc_prtype_name'];

			$font_size = 7;
			
			$fillcolor= '255,250,250';
			
			$alignvalue='C';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $vc_assessment_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $vc_customer_name, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $dt_assessment_date, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'R';
			
			$col[] = array('text' => $nu_total_payable_amount, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_mdc_paid, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'L';
			
			$col[] = array('text' => $dt_received_date, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_prtype_name, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
			
		}
	}
	
	
	

	function genrate_inspectorpaymenthistory_pdf_old($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name) {
	
		$columnwidtharrays = array(10,24,26,26,28,26,25,24);
		
		$heightdynamic = 12;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, $vc_customer_name,0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=1;
		
		$this->Ln();
		
		 foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
            
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, $i, 1,'C');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, $val['AssessmentVehicleMaster']['vc_assessment_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$explo    =    explode(" ",trim($val['AssessmentVehicleMaster']['vc_customer_name']));
            
			$explolen = count($explo);     
          
            if($explolen>0)
				
				$customer_name = substr($explo[0], 0, 1).'. '.$explo[$explolen-1];
            
			else
				
				$customer_name = $val['AssessmentVehicleMaster']['vc_customer_name'];
			
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, $customer_name, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, date('d-M-y', strtotime($val['AssessmentVehicleMaster']['dt_assessment_date'])), 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[4], $heightdynamic, number_format($val['AssessmentVehicleMaster']['nu_total_payable_amount'],2,'.',','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[5], $heightdynamic, number_format($val['AssessmentVehicleMaster']['vc_mdc_paid'],2,'.',','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic, date('d M Y',  strtotime($val['AssessmentVehicleMaster']['dt_received_date'])), 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic, $val['PaymentStatus']['vc_prtype_name'], 1,'L');
			
			if($i%18==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			
			$i++;
		} 
	}
	
	/*
	*
	*Vehicle Assessment History PDF
	*
	*/
	
	function genrate_inspectorassessmenthistory_pdf($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name,$vehiclelicno=null) {
	
		$columnwidtharrays = array(7,15,15,15,14,16,
		                           12,13,12,12,21,11,
								   15,12);
		
		$heightdynamic = 8;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x = $this->GetX();			
			$y = $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);		
			
			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+125);			
			$this->SetFont('Arial', 'B', 6);
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);			
			$this->SetY($y);  //Reset the write point			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, ucfirst($vc_customer_name),0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
			$x = $this->GetX();			
			$y = $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(25, 8, 'Vehicle Register No.: ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(164, 8, $vehiclelicno,0,'','L',true);	
			else
			$this->MultiCell(164, 8, '',0,'','L',true);
			
			//$vehiclelicno
			$this->Ln(2);
			
		}
	}
		
		$this->SetFont('Arial', 'B', 6);
		
		$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFillColor(191,191,191);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();

			if($c==10){
			
				$this->SetFont('Arial', 'B', 5);
			
			}
			
			if( $c == 9 || $c == 11 || $c == 13 || $c == 12){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=0;
		
		$this->Ln();
		
		foreach ($data as $val) {
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();

		    $vc_customer_name = 	ucfirst($val['AssessmentVehicleMaster']['vc_customer_name']);
		    $dt_created_date=		date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date']));
		    $vc_assessment_no=		$val['AssessmentVehicleDetail']['vc_assessment_no'];
		    $vc_vehicle_lic_no= 	$val['AssessmentVehicleDetail']['vc_vehicle_lic_no'];
		    $vc_vehicle_reg_no=		$val['AssessmentVehicleDetail']['vc_vehicle_reg_no'];
			$vc_prtype_name = 		$val['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'];
		    $vc_pay_frequency = 	$val['AssessmentVehicleDetail']['vc_pay_frequency'];
		    $vc_prev_end_om = 		number_format($val['AssessmentVehicleDetail']['vc_prev_end_om']);
		    $vc_end_om = 			number_format($val['AssessmentVehicleDetail']['vc_end_om']);
		    $vc_km_travelled = 		number_format($val['AssessmentVehicleDetail']['vc_km_travelled']);
		    $vc_rate =			 	number_format($val['AssessmentVehicleDetail']['vc_rate'],2,'.',',');
		    $vc_payable =			number_format($val['AssessmentVehicleDetail']['vc_payable'],2,'.',',');
		    $vc_status =			$allconstants[$val['AssessmentVehicleMaster']['vc_status']];

			$font_size = 6;
			
			$fillcolor= '255,250,250';
			
			$alignvalue='C';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'L';
			
			$col[] = array('text' => $vc_customer_name, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $dt_created_date, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_assessment_no, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_lic_no, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_reg_no, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_prtype_name, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_pay_frequency, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'R';
			
			$col[] = array('text' => $vc_prev_end_om, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_end_om, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_km_travelled, 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' => $vc_rate, 'width' =>$columnwidtharrays[11], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_payable, 'width' =>$columnwidtharrays[12], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'L';
			
			$col[] = array('text' => $vc_status, 'width' =>$columnwidtharrays[13], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
			
		}
	
	}
	
	
	
	

	function genrate_inspectorassessmenthistory_pdf_old($columnsValues,$data,$allconstants,$profile,$toDate=null,$fromDate=null,$vc_customer_name) {
	
		$columnwidtharrays = array(7,15,15,15,14,13,12,13,12,12,22,11,17,11);
		
		$heightdynamic = 18;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vc_customer_name) && !empty($vc_customer_name)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(25, 8, 'Customer Name :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vc_customer_name) && !empty($vc_customer_name))
			$this->MultiCell(39, 8, $vc_customer_name,0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
	}
		
		$this->SetFont('Arial', 'B', 6);
		
		$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFillColor(191,191,191);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();

			if($c==10){
			
				$this->SetFont('Arial', 'B', 5);
			
			}
			
			if( $c == 9 || $c == 11 || $c == 13 || $c == 12){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=1;
		
		$this->Ln();
		
		foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
            
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, $i, 1,'C');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$explo    =    explode(" ",trim($val['AssessmentVehicleMaster']['vc_customer_name']));
            
			$explolen = count($explo);     
          
            if($explolen>0)
				
				$customer_name = substr($explo[0], 0, 1).'. '.$explo[$explolen-1];
            
			else
				
				$customer_name = $val['AssessmentVehicleMaster']['vc_customer_name'];
			
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, $customer_name, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date'])), 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, $val['AssessmentVehicleDetail']['vc_assessment_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[4], $heightdynamic, $val['AssessmentVehicleDetail']['vc_vehicle_lic_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]); //Move X to $x + width of last cell

			$this->MultiCell($columnwidtharrays[5], $heightdynamic, $val['AssessmentVehicleDetail']['vc_vehicle_reg_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic, $val['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic, $val['AssessmentVehicleDetail']['vc_pay_frequency'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]
			+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[8], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_prev_end_om']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+
			$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[9], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_end_om']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+
			$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[10], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_km_travelled']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[10]+$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+
			$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[11], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_rate'],2,'.',','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[11]+$columnwidtharrays[10]+$columnwidtharrays[9]+$columnwidtharrays[8]+
			$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[12], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_payable'],2,'.',','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[12]+$columnwidtharrays[11]+$columnwidtharrays[10]+$columnwidtharrays[9]+
			$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+
			$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);	
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[13], $heightdynamic, $allconstants[$val['AssessmentVehicleMaster']['vc_status']], 1,'L');
			
			if($i%13==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			
			$i++;
		}
	}

	/*
	*
	*Vehicle Vehicle Log History PDF
	*
	*/
	
	
	function genrate_inspectorvehicleloghistory_pdf($columnsValues,$data,$vehicletype,$allconstants,$profile,$toDate=null,$fromDate=null,$vehiclelicno=null) {
   
		$columnwidtharrays = array(15,17,16,20,15,15,15,15,27,16,18);
		
		$heightdynamic = 8;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vehicletype) && !empty($vehicletype)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			$this->SetY($y);  //Reset the write point
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(25, 8, 'Vehicle Type :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(39, 8, $allconstants[$vehicletype],0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(25, 8, 'Vehicle Register No. : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(164, 8, $vehiclelicno,0,'','L',true);	
			else
			$this->MultiCell(164, 8, '',0,'','L',true);
			$this->Ln(2);



			
			
			
			
		}
	}

		$c = 0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();
			
			 

		 if( $c == 0 || $c ==3 || $c ==6 || $c ==7|| $c ==9|| $c ==8){
			
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=0;
		
		$this->Ln();
		
		foreach ($data as $val) {
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();

		    $dt_log_date = 			date('d M Y', strtotime($val['VehicleLogDetail']['dt_log_date']));
		    $vc_vehicle_reg_no=		$val['VehicleLogDetail']['vc_vehicle_reg_no'];
		    $vc_vehicle_lic_no=		$val['VehicleLogDetail']['vc_vehicle_lic_no'];
		    $vc_driver_name= 		$val['VehicleLogDetail']['vc_driver_name'];
		    $nu_start_ometer=		number_format($val['VehicleLogDetail']['nu_start_ometer']);
			$nu_end_ometer = 		number_format($val['VehicleLogDetail']['nu_end_ometer']);
			
			if($val['VehicleLogDetail']['ch_road_type']==1){
				
				$origin = $val['VehicleLogDetail']['vc_other_road_orign_name'];
				$destination = $val['VehicleLogDetail']['vc_other_road_destination_name'];
				$nu_km_traveled = number_format($val['VehicleLogDetail']['nu_other_road_km_traveled']);
				
			}else{
			
				$origin = $val['VehicleLogDetail']['vc_orign_name'];
				$destination = $val['VehicleLogDetail']['vc_destination_name'];
				$nu_km_traveled = number_format($val['VehicleLogDetail']['nu_km_traveled']);
				
			}
			
			if($val['VehicleLogDetail']['ch_road_type']==1)
				$ch_road_type  =  'Other Road';
			else
				$ch_road_type  =  'Namibian Road';
							
		   // $vc_orign_name = 		$val['VehicleLogDetail']['vc_orign_name'];
		   // $vc_destination_name = 	$val['VehicleLogDetail']['vc_destination_name'];
		   // $nu_km_traveled = 		number_format($val['VehicleLogDetail']['nu_km_traveled']);
		   // $nu_other_road_km_traveled = number_format($val['VehicleLogDetail']['nu_other_road_km_traveled']);
		    $dt_created_date =		date('d M Y', strtotime($val['VehicleLogDetail']['dt_created_date']));

			$font_size = 6;
			
			$fillcolor= '255,250,250';
			
			$col[] = array('text' => $dt_log_date, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_reg_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $vc_vehicle_lic_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_driver_name, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'R';
			
			$col[] = array('text' => $nu_start_ometer, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $nu_end_ometer, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'L';
			$col[] = array('text' => $ch_road_type, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $origin, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $destination, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'R';
			
			$col[] = array('text' => $nu_km_traveled, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
	
			
			$alignvalue = 'L';
			
			$col[] = array('text' => $dt_created_date, 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
			
			}
	}
	
	
	
	
	
	function genrate_inspectorvehicleloghistory_pdf_old($columnsValues,$data,$vehicletype,$allconstants,$profile,$toDate=null,$fromDate=null) {
   
		$columnwidtharrays = array(15,17,16,20,15,15,15,15,27,16,18);
		
		$heightdynamic = 18;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vehicletype) && !empty($vehicletype)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(25, 8, 'Vehicle Type :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(39, 8, $allconstants[$vehicletype],0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
	}

		$c = 0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();
			
			 

		 if( $c == 0 || $c ==3 || $c ==6 || $c ==7){
			
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=1;
		
		$this->Ln();
		
		    foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
            
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, date('d M Y', strtotime($val['VehicleLogDetail']['dt_log_date'])), 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, $val['VehicleLogDetail']['vc_vehicle_reg_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, $val['VehicleLogDetail']['vc_vehicle_lic_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$explo    =    explode(" ",trim($val['VehicleLogDetail']['vc_driver_name']));
            
			$explolen = count($explo);     
          
            if($explolen>0)
				
				$driver_name = substr($explo[0], 0, 1).'. '.$explo[$explolen-1];
            
			else
				
				$driver_name = $val['VehicleLogDetail']['vc_driver_name'];
			
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, $driver_name, 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[4], $heightdynamic,  number_format($val['VehicleLogDetail']['nu_start_ometer']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]); //Move X to $x + width of last cell

			$this->MultiCell($columnwidtharrays[5], $heightdynamic,  number_format($val['VehicleLogDetail']['nu_end_ometer']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic, $val['VehicleLogDetail']['vc_orign_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic, $val['VehicleLogDetail']['vc_destination_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]
			+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[8], $heightdynamic,  number_format($val['VehicleLogDetail']['nu_km_traveled']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+
			$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[9], $heightdynamic,  number_format($val['VehicleLogDetail']['nu_other_road_km_traveled']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+
			$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[10], $heightdynamic, date('d M Y', strtotime($val['VehicleLogDetail']['dt_created_date'])), 1,'L');
			
			if($i%10==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			
			$i++;
		}
    }
	
	/*
	*
	*Vehicle Assessment History PDF
	*
	*/
	
	function genrate_assessmenthistory_pdf($columnsValues,$data,$vehicletype,$allconstants,$profile,$toDate=null,$fromDate=null,$vehiclelicno=null) {
	
		$columnwidtharrays = array(9,15,15,14,15,14,13,12,13,27,12,17,13);
		
		$heightdynamic = 8;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vehicletype) && !empty($vehicletype)) || 
		(isset($vehiclelicno) && !empty($vehiclelicno))){

			$x= $this->GetX();			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(25, 8, 'Vehicle Type :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(39, 8, $allconstants[$vehicletype],0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
			$x= $this->GetX();			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(25, 8, 'Vehicle Register No. : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($vehiclelicno) && !empty($vehiclelicno))
			$this->MultiCell(164, 8, $vehiclelicno,0,'','L',true);	
			else
			$this->MultiCell(164, 8, '',0,'','L',true);
			$this->Ln(2);
			//vehiclelicno
			
			
			
		}
	}
		
		$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();

		 if( $c == 0 || $c == 8 || $c == 10 || $c == 11 || $c == 12 ){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
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
		
		$this->SetFont('Arial', '', 6);
		
		$i=0;
		
		$this->Ln();
		
		 foreach ($data as $val) {
		 
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();

		    $dt_created_date   =	date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date']));
		    $vc_assessment_no  =	$val['AssessmentVehicleDetail']['vc_assessment_no'];
		    $vc_vehicle_lic_no =	$val['AssessmentVehicleDetail']['vc_vehicle_lic_no'];
		    $vc_vehicle_reg_no = 	$val['AssessmentVehicleDetail']['vc_vehicle_reg_no'];
		    $vc_prtype_name    =	$val['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'];
			$vc_pay_frequency  = 	$val['AssessmentVehicleDetail']['vc_pay_frequency'];
		    $vc_prev_end_om    =	number_format($val['AssessmentVehicleDetail']['vc_prev_end_om']);
		    $vc_end_om         =	number_format($val['AssessmentVehicleDetail']['vc_end_om']);
		    $vc_km_travelled = 		number_format($val['AssessmentVehicleDetail']['vc_km_travelled']);
		    $vc_rate = 				number_format($val['AssessmentVehicleDetail']['vc_rate'],2,'.',',');
		    $vc_payable = 				number_format($val['AssessmentVehicleDetail']['vc_payable'],2,'.',',');
		    $vc_status =		$allconstants[$val['AssessmentVehicleMaster']['vc_status']];

			$font_size = 6;
			
			$fillcolor= '255,250,250';
			
			$alignvalue='C';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $dt_created_date, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
			$col[] = array('text' => $vc_assessment_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_lic_no, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_vehicle_reg_no, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_prtype_name, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_pay_frequency, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'R';
			
			$col[] = array('text' => $vc_prev_end_om, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'R';
			
			$col[] = array('text' => $vc_end_om, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_km_travelled, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_rate, 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_payable, 'width' =>$columnwidtharrays[11], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue = 'L';
			
			$col[] = array('text' => $vc_status, 'width' =>$columnwidtharrays[12], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$columns[]=$col;
			
			$this->WriteTable($columns);   
			
			$i++;
			
			$alignvalue='L';
			
			
		}
		
	}
	
	
	
	function genrate_inspector_assessmentreport($columnsValues,$data,$constants,$net_outstanding=null) {

       $columnwidtharrays=array(20,18,
							     18,23,15,
							     15,15,
								 15,20,21);
		$this->AddPage();
	
		$heightdynamic=6;
		$c=0;
		
		$this->SetFillColor(139,137,137);
		
		$length = count($columnsValues)-1;
		
		
		if($this->PageNo()==1){
		
	    $this->Ln(4);
   
		}
		
	   $this->SetFont('Arial', '', 7);
	
			$x= $this->GetX();
		    $y= $this->GetY();
			$this->SetFillColor(255,255,255);

			$this->SetY($y);  //Reset the write point
            $this->SetX($x); //Mo
			$this->MultiCell(20, 6, 'Statement' , 0,'L',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +20); //Move X to $x + width of last cell
			
			$this->MultiCell(120, 6, '' , 0,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +140); //Move X to $x + width of last cell
			
			$this->MultiCell(40, 6,  date('d-M-Y')  , 0,'C',true);
			
			
			$this->Ln();
			$this->Ln();
			$x= $this->GetX();
		    $y= $this->GetY();
			$this->MultiCell(20, 6, 'Dear Customer,' , 0,'L',true);

			$this->SetY($y);  //Reset the write point
            $this->SetX($x +20); //Move X to $x + width of last cell
			$this->Ln();
			$x= $this->GetX();
		    $y= $this->GetY();
			$this->MultiCell(20, 3, '  ' , 0,'L',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +20); //Move X to $x + width of last cell
			$this->MultiCell(160, 2, 'Please find the following details of your submitted assessment no.for the listed vehicles.The assessment is reflecting the due amount' , 0,'L',true);
			$this->Ln(1);
			$x= $this->GetX();
		    $y= $this->GetY();
			
			$this->MultiCell(180, 2, 'N$ '.$net_outstanding.' payable by you. In order to get CONFIRMATION OF PAYMENT from us, please deposit the due amount.', 0,'L',true);


			$this->Ln();
			$this->Ln();
			
		$this->SetFont('Arial', 'B', 7);
		foreach($columnsValues as $value) {
			
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0){
			
			$this->MultiCell($columnwidtharrays[$c], 6, $value , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		 if($c==5 || $c==4|| $c==6)
			 $this->MultiCell($columnwidtharrays[$c], 12, $value , 1,'C',true);
			 else
			 $this->MultiCell($columnwidtharrays[$c], 6, $value , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		$this->SetFont('Arial', '', 5);
		$i=0;
		$this->Ln();$this->Ln();
		
		
		$totaloutstanding      = 0;
		$totalmdcpaid          = 0;
		$totalassessmentamount = 0;
		
		foreach ($data as $index=>$value) {
		
		$cnt=0;
				
		$outstanding_particularassessment =(float)$value['AssessmentVehicleMaster']['nu_total_payable_amount']-(float)$value['AssessmentVehicleMaster']['vc_mdc_paid'];
		
		if($value['AssessmentVehicleMaster']['nu_total_payable_amount']!=$value['AssessmentVehicleMaster']['vc_mdc_paid']){
				
		$totalmdcpaid          = $totalmdcpaid+$value['AssessmentVehicleMaster']['vc_mdc_paid'];
		$amount_paid           = number_format(trim($value['AssessmentVehicleMaster']['vc_mdc_paid']), 2, '.', ',');
		$totaloutstanding      = $totaloutstanding+((float)$value['AssessmentVehicleMaster']['nu_total_payable_amount']-(float)$value['AssessmentVehicleMaster']['vc_mdc_paid']);
					
		
		foreach($value['AssessmentVehicleDetail'] as $index =>$vehicledetails){
			
			$cnt++;	
			
			$x          = $this->GetX();
		    $y          = $this->GetY();
			
			$alignvalue = 'L';
			
			$columns    = array();
			$col        = array();
			
			$vc_ass_no        = $vehicledetails['vc_assessment_no'];
			$vc_ass_date      = date('d-M-y', strtotime($value['AssessmentVehicleMaster']['dt_process_date']));
			$vc_veh_lic_no    = $vehicledetails['vc_vehicle_lic_no'];
			$vc_veh_reg_no    = $vehicledetails['vc_vehicle_reg_no'];
			$vc_km_travelled  = $vehicledetails['vc_km_travelled'];
			$vc_km_travelled_by    = number_format((float)($vehicledetails['vc_km_travelled']/ 100), 2, '.', ',');
			$vc_rate               = $vehicledetails['vc_rate'];
			$amount_due            = number_format(trim($vehicledetails['vc_payable']), 2, '.', ',');
			$totalassessmentamount = $totalassessmentamount + $vehicledetails['vc_payable'];
			
			 //$outstanding_particularassessment =(float)$vehicledetails['vc_payable'] - (float)$value['AssessmentVehicleMaster']['vc_mdc_paid'];
			$amount_outstanding = number_format(trim($outstanding_particularassessment), 2, '.', ',');
			
			$font_size = 7;
			$fillcolor = '255,255,255';
			
			$col[]     = array('text' => $vc_ass_no, 'width' =>$columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

			$col[] = array('text' => $vc_ass_date, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_veh_lic_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
					
			$col[] = array('text' => $vc_veh_reg_no,'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' =>  $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			  
			  $alignvalue='R';
			
			$col[] = array('text' => $vc_km_travelled , 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' =>$vc_km_travelled_by , 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
					
			$alignvalue='R';
					
			$col[] = array('text' => $vc_rate, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');


			$col[] = array('text' => $amount_due, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		
			$alignvalue='R';
		
			if(count($value['AssessmentVehicleDetail']) == $cnt ){
		
			if($cnt==1){
			
			$col[] = array('text' => $amount_paid, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			}else{
			
			$col[] = array('text' => $amount_paid, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LBR');
			
			}
	
		}else{
			
			$col[] = array('text' => '', 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
		}

	if(count($value['AssessmentVehicleDetail']) == $cnt ){
	
		if($cnt==1){
		
		$col[] = array('text' => $amount_outstanding, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
		'linewidth' => '0', 'linearea' => 'LBTR');
		
		} else {
		
		$col[] = array('text' => $amount_outstanding, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
		'linewidth' => '0', 'linearea' => 'LBR');
		
		}
				
	}else{
		
		$col[] = array('text' => '', 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');		

		}			
			 
		$columns[]=$col;
		$this->WriteTable($columns);   
		$i++; 
	
	    } // for each of vehicle
	  }  // if of outstanding condition
	}  //foreach of assessment  
				
	//$this->Ln();
			
			$totaloutstanding      = number_format(trim($totaloutstanding), 2, '.', ',');
			$totalassessmentamount = number_format(trim($totalassessmentamount), 2, '.', ',');
	
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$this->SetFillColor(191,191,191);

			$this->SetY($y);  //Reset the write point
            $this->SetX($x); //Move X to $x + width of last cell
            $this->MultiCell(38, 10, 'Assessment Amount (N$):',  1,'R',true);

			$this->SetY($y);  //Reset the write point
            $this->SetX($x +38); //Move X to $x + width of last cell
			$this->MultiCell(25, 10,$totalassessmentamount,  1,'R',true); 
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +63); //Move X to $x + width of last cell
            $this->MultiCell(35, 10, 'MDC Paid (N$)',  1,'R',true); 
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +98); //Move X to $x + width of last cell
			$this->MultiCell(30, 10,number_format(trim($totalmdcpaid), 2, '.', ','),  1,'R',true); 
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +128); //Move X to $x + width of last cell
			$this->MultiCell(31, 10,'Net Outstanding (N$)',  1,'R',true); 		
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +159); //Move X to $x + width of last cell
			$this->MultiCell(21, 10,number_format(trim($net_outstanding), 2, '.', ','),  1,'R',true); 

	
    }
	
	
	
	function genrate_assessmenthistory_pdf_old($columnsValues,$data,$vehicletype,$allconstants,$profile,$toDate=null,$fromDate=null) {
	
		$columnwidtharrays = array(9,15,15,14,15,14,13,12,13,27,12,17,13);
		
		$heightdynamic = 18;
        
		$this->AddPage();
		
		if($this->PageNo()==1){
		
		$this->SetFillColor(191,191,191);
		
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) || 
		(isset($vehicletype) && !empty($vehicletype)) ){

			$x= $this->GetX();
			
			$y= $this->GetY();
			
			$this->SetFont('Arial', 'B', 6);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
			else
			$this->MultiCell(25, 8, '',0,'','L',true);
			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+25);		
			if(isset($fromDate) && !empty($fromDate))
			$this->MultiCell(50, 8, date('d M Y', strtotime($fromDate)),0,'','L',true);	
			else
			$this->MultiCell(50, 8, '',0,'','L',true);


			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+75);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, 'To Date :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+100);	
			
			if(isset($toDate) && !empty($toDate))
			$this->MultiCell(25, 8, date('d M Y', strtotime($toDate)),0,'','L',true);	
			else
			$this->MultiCell(25, 8,'',0,'','L',true);
			
			
			
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+125);
			
			$this->SetFont('Arial', 'B', 6);
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(25, 8, 'Vehicle Type :',0,'','R',true);
			else
			$this->MultiCell(25, 8, '',0,'','R',true);

			$this->SetFont('Arial','', 6);
			
			$this->SetY($y);  //Reset the write point
			
			$this->SetX($x+150);	
			
			if(isset($vehicletype) && !empty($vehicletype))
			$this->MultiCell(39, 8, $allconstants[$vehicletype],0,'','L',true);	
			else
			$this->MultiCell(39, 8,'',0,'','L',true);
			
			$this->Ln(2);
			
		}
	}
		
		$c=0;
		
		$this->SetFillColor(191,191,191);
		
		$length = count($columnsValues)-1;
		
		$this->SetFont('Arial', 'B', 6);
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    
			$y= $this->GetY();

		 if( $c == 0 || $c == 8 || $c == 10 || $c == 11 || $c == 12 ){
			
			$this->MultiCell($columnwidtharrays[$c], 16, $val , 1,'C',true);
			
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
		
		$this->SetFont('Arial', '', 5);
		
		$i=1;
		
		$this->Ln();
		
		 foreach ($data as $val) {
			
			$x  = $this->GetX();
		    
			$y  = $this->GetY();
            
			$this->MultiCell($columnwidtharrays[0], $heightdynamic, $i, 1,'C');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[1], $heightdynamic, date('d M Y', strtotime($val['AssessmentVehicleDetail']['dt_created_date'])), 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[2], $heightdynamic, $val['AssessmentVehicleDetail']['vc_assessment_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[3], $heightdynamic, $val['AssessmentVehicleDetail']['vc_vehicle_lic_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[4], $heightdynamic, $val['AssessmentVehicleDetail']['vc_vehicle_reg_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]); //Move X to $x + width of last cell

			$this->MultiCell($columnwidtharrays[5], $heightdynamic, $val['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[6], $heightdynamic, $val['AssessmentVehicleDetail']['vc_pay_frequency'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[7], $heightdynamic,  number_format($val['AssessmentVehicleDetail']['vc_prev_end_om']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]
			+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[8], $heightdynamic,  number_format($val['AssessmentVehicleDetail']['vc_end_om']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+
			$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); 
			//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[9], $heightdynamic,  number_format($val['AssessmentVehicleDetail']['vc_km_travelled']), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+
			$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+
			$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[10], $heightdynamic,  number_format($val['AssessmentVehicleDetail']['vc_rate'],2,'.',','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[10]+$columnwidtharrays[9]+$columnwidtharrays[8]+$columnwidtharrays[7]+
			$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+
			$columnwidtharrays[1]+$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[11], $heightdynamic, number_format($val['AssessmentVehicleDetail']['vc_payable'],2,'.',','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            
			$this->SetX($x +$columnwidtharrays[11]+$columnwidtharrays[10]+$columnwidtharrays[9]+$columnwidtharrays[8]+
			$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+
			$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);	//Move X to $x + width of last cell
			
			$this->MultiCell($columnwidtharrays[12], $heightdynamic, $allconstants[$val['AssessmentVehicleMaster']['vc_status']], 1,'L');
			
			if($i%10==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			
			$i++;
		}
	}
	}

?>
