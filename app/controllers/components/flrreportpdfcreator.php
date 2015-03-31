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

class FlrreportpdfcreatorComponent extends FPDF {

	   // Margins
   var $left = 10;
   var $right = 10;
   var $top = 10;
   var $bottom = 10;
	
	  function WriteTable($tcolums)
   {
      // go through all columns
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
	function headerData($title, $period = NULL,$customerInfo=array(),$vehicletype=null) {
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
		
		$this->SetFillColor(139,137,137);
		
		$x= $this->GetX();
		$y= $this->GetY();
		
		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Client Name : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		
		$this->MultiCell(100, 8, ucfirst($currentUser['Client']['vc_client_name']) ,0,'','L',true);	
		
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Tel. No.:',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(41, 8, $currentUser['Client']['vc_tel_no'] ,0,'','L',true);	
		$this->Ln(0);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			
		$address = trim(ucfirst($currentUser['Client']['vc_address1']));
		
		if(isset($currentUser['Client']['vc_address2']) && !empty($currentUser['Client']['vc_address2']))
		$address .= ','.trim(ucfirst($currentUser['Client']['vc_address2']));
		
		if(isset($currentUser['Client']['vc_address3']) && !empty($currentUser['Client']['vc_address3']))		
		$address .= ','.trim(ucfirst($currentUser['Client']['vc_address3']));
		

		 $this->MultiCell(25, 8, 'Address : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8,$address,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Email :',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(41, 8,$currentUser['Client']['vc_email'] ,0,'','L',true);	
		$this->Ln(0);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Mobile No. : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8,$currentUser['Client']['vc_cell_no'] ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, 'Fax No.  :',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(41, 8, $currentUser['Client']['vc_fax_no'],0,'','L',true);	
		$this->Ln(0);
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Client No. : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8,ltrim($currentUser['Client']['vc_client_no'],'01') ,0,'','L',true);
		 $this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '  ',0,'','R',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(41, 8, '  ',0,'','L',true);	
 
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
	
	function genrate_flr_claimdetail_pdf($columnsValues,$data,$allconstants,$claim,$toDate,$fromDate,$claimNo,$total_amount,$total_liters) {
	
	
	
	$columnwidtharrays=array(10,18,
							     18,18,25,
							     18,15,
								 15,20,19,15);
		$this->AddPage();
	
		$heightdynamic=10;
		$c=0;
		
		$this->SetFillColor(139,137,137);
		
		$length = count($columnsValues)-1;
		
		
		if($this->PageNo()==1){
		
		if(isset($claimNo) && !empty($claimNo)){
		$this->SetFillColor(139,137,137);
		
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Claim No. : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8, $claimNo ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		//$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '',0,'','R',true);
		//$this->SetFont('Arial','ddd', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(41, 8,'',0,'','L',true);	
		$this->Ln(3);
		}
		if(isset($fromDate) && !empty($fromDate)){

   $x= $this->GetX();
   
   $y= $this->GetY();
   
   $this->SetFont('Arial', 'B', 6);   
   
   $this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+25);  
   
   $this->MultiCell(100, 8, date('d M Y', strtotime($fromDate)),0,'','L',true); 
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+125);
   
   $this->SetFont('Arial', 'B', 6);
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(25, 8, 'To Date :',0,'','R',true);
   else
   $this->MultiCell(25, 8, '',0,'','R',true);
   
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+150); 
   
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(41, 8, date('d M Y', strtotime($toDate)),0,'','L',true); 
   else
   $this->MultiCell(41, 8,'',0,'','L',true); 
   
   $this->Ln(4);
   
  }
		}
	$this->SetFont('Arial', 'B', 7);
	
	foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		 if($c==$length  || $c==2 || $c==3 || $c==4|| $c==9)
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

	foreach ($data as $claims) {
	
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col     = array();
			
			$vc_claim_no      = $claims['ClaimHeader']['vc_claim_no'];
			$party_claim_no   = $claims['ClaimHeader']['vc_party_claim_no'];
			$vc_invoice_no    = $claims['ClaimDetail']['vc_invoice_no'];
			$invoice_date     =	!empty($claims['ClaimDetail']['dt_invoice_date']) ? date('d M Y', strtotime($claims['ClaimDetail']['dt_invoice_date'])) : '';

			$vc_outlet_code   = $claims['ClaimDetail']['vc_outlet_code'];
			$liters = !empty($claims['ClaimDetail']['nu_litres']) ? number_format($claims['ClaimDetail']['nu_litres'],2,'.',',') : number_format(0,2,'.',',');
			$nu_refund_rate   = $claims['ClaimDetail']['nu_refund_rate'];
			$vc_status        = $allconstants[$claims['ClaimDetail']['vc_status']];
			$vc_reasons       = $claims['ClaimDetail']['vc_reasons'];
			$nu_amount        = number_format($claims['ClaimDetail']['nu_amount'], 2, '.', ',');
			$total_liters= $total_liters + $claims['ClaimDetail']['nu_litres'];
			$sum1 = !empty($total_liters) ? number_format($total_liters, 2, '.', ',') : number_format(0, 2, '.', ',');
			$total_amount = $total_amount + $claims['ClaimDetail']['nu_amount'];
			$sum = !empty($total_amount) ? number_format($total_amount, 2, '.', ',') : number_format(0, 2, '.', ',');
			
			$font_size=7;
			$fillcolor= '255,250,250';

		
	$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

	$col[] = array('text' => $vc_claim_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

	$col[] = array('text' => $vc_invoice_no, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
	$col[] = array('text' => $invoice_date, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
	$col[] = array('text' => $vc_outlet_code,'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		$alignvalue='R';
	
	$col[] = array('text' => $liters , 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
	
	$col[] = array('text' =>$nu_refund_rate , 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
		$alignvalue='L';
			
	$col[] = array('text' => $vc_status, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');


	$col[] = array('text' => $vc_reasons, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
	
		$alignvalue='R';
	
	$col[] = array('text' => $nu_amount, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
	$col[] = array('text' => $party_claim_no, 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');

			$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;
	
	 
	}
	
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$this->SetY($y);  //Reset the write point
            $this->SetX($x); //Move X to $x + width of last cell
            $this->MultiCell(89, 10, 'Total litres',  1,'R');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +89); //Move X to $x + width of last cell
			$this->MultiCell(32, 10,$sum1,  1,'C'); 
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +121); //Move X to $x + width of last cell
            $this->MultiCell(36, 10, 'Total Amount (N$)',  1,'R');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +157); //Move X to $x + width of last cell
			$this->MultiCell(34, 10,$sum,  1,'C');
	
	
	}
	
	
    function genrate_flr_claimdetail_pdf_old($columnsValues,$data,$allconstants,$claim,$toDate,$fromDate,$claimNo) {
		
		$columnwidtharrays=array(10,20,
							     20,18,30,
							     20,15,
								 15,23,20);
		$this->AddPage();
	
		
		$c=0;
		
		$this->SetFillColor(139,137,137);
		
		$length = count($columnsValues)-1;
		
		
		if($this->PageNo()==1){
		
		if(isset($claimNo) && !empty($claimNo)){
		$this->SetFillColor(139,137,137);
		
		
		$x= $this->GetX();
		$y= $this->GetY();		

		$this->SetFont('Arial', 'B', 6);			

		$this->MultiCell(25, 8, 'Claim No : ',0,'','L',true);
		$this->SetFont('Arial','', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+25);		
		$this->MultiCell(100, 8, $claimNo ,0,'','L',true);	
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+125);
		//$this->SetFont('Arial', 'B', 6);
		$this->MultiCell(25, 8, '',0,'','R',true);
		//$this->SetFont('Arial','ddd', 6);
		$this->SetY($y);  //Reset the write point
        $this->SetX($x+150);	
		$this->MultiCell(41, 8,'',0,'','L',true);	
		$this->Ln(0);
		}
		if(isset($fromDate) && !empty($fromDate)){

   $x= $this->GetX();
   
   $y= $this->GetY();
   
   $this->SetFont('Arial', 'B', 6);   
   
   $this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+25);  
   
   $this->MultiCell(100, 8, date('d M Y', strtotime($fromDate)),0,'','L',true); 
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+125);
   
   $this->SetFont('Arial', 'B', 6);
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(25, 8, 'To Date :',0,'','R',true);
   else
   $this->MultiCell(25, 8, '',0,'','R',true);
   
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+150); 
   
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(41, 8, date('d M Y', strtotime($toDate)),0,'','L',true); 
   else
   $this->MultiCell(41, 8,'',0,'','L',true); 
   
   $this->Ln(4);
   
  }
		}
	$this->SetFont('Arial', 'B', 7);
	
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'','C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		 if($c==$length||$c==1|| $c==2||$c==3||$c==4)
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
		
		foreach ($data as $claims) {
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
            $this->MultiCell($columnwidtharrays[0], 10, $i, 1,'C');
           // $this->MultiCell(10, 10, $val['AccountRecharge']['nu_acct_rec_id'], 1,'C');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[1], 10, $claims['ClaimHeader']['vc_claim_no'], 1,'L');
			
			
			$this->SetY($y);
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[2], 10, $claims['ClaimDetail']['vc_invoice_no'], 1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$invoice_date = !empty($claims['ClaimDetail']['dt_invoice_date']) ? date('d M Y', strtotime($claims['ClaimDetail']['dt_invoice_date'])) : '';
            //$this->Cell(20, 6, $entryDate , 1);
			$this->MultiCell($columnwidtharrays[3], 10, $invoice_date , 1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[4], 10,$claims['ClaimDetail']['vc_outlet_code'], 1,'L');
			
           
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$liters = !empty($claims['ClaimDetail']['nu_litres']) ? number_format($claims['ClaimDetail']['nu_litres'],2,'.',',') : number_format(0,2,'.',',');
            $this->MultiCell($columnwidtharrays[5], 10, $liters, 1,'R');
			

			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[6], 10, number_format($claims['ClaimDetail']['nu_refund_rate'], 2, '.', ','), 1,'R');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
            $this->MultiCell($columnwidtharrays[7], 10, $allconstants[$claims['ClaimDetail']['vc_status']],  1,'L');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
            $this->MultiCell($columnwidtharrays[8], 10, $claims['ClaimDetail']['vc_reasons'],  1,'R');
			
            $this->SetY($y);  //Reset the write point
            $this->SetX($x+$columnwidtharrays[8]+$columnwidtharrays[7]+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3] +$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[9], 10, number_format($claims['ClaimDetail']['nu_amount'] ,2, '.', ','),  1,'R');
			
			
			if(count($data)==$i+1)
			{
			//$this->Ln();
			//$this->Ln();
			//$this->SetY($y);  //Reset the write point
            //$this->SetX($x +150); //Move X to $x + width of last cell
            //$this->MultiCell(20, 10, 'Total',  1,'R');
			//$this->SetY($y);  //Reset the write point
            //$this->SetX($x +170); //Move X to $x + width of last cell
			//$this->MultiCell(20, 10, number_format(390 ,2, '.', ','),  1,'L');
			
			}
			if($i%15==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			//$this->Ln();
			$i++;
			
		
        }
		
    }
	
	function genrate_flr_claimsummary_pdf($columnsValues,$data,$allconstants,$claim,$toDate,$fromDate,$total_amount=null) {
    
	$columnwidtharrays=array(15,20,18,36,19,24,18,21,20);
		
		$heightdynamic = 12;
		$this->AddPage();
		$this->SetFont('Arial', 'B', 7);
		
		$c=0;
		
		$this->SetFillColor(139,137,137);
		
		$length = count($columnsValues)-1;
		
	if($this->PageNo()==1){
		
	if(isset($fromDate) && !empty($fromDate)){

   $x= $this->GetX();
   
   $y= $this->GetY();
   
   $this->SetFont('Arial', 'B', 6);   
   
   $this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+25);  
   
   $this->MultiCell(100, 8, date('d M Y', strtotime($fromDate)),0,'','L',true); 
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+125);
   
   $this->SetFont('Arial', 'B', 6);
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(25, 8, 'To Date :',0,'','R',true);
   else
   $this->MultiCell(25, 8, '',0,'','R',true);
   
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+150); 
   
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(40, 8, date('d M Y', strtotime($toDate)),0,'','L',true); 
   else
   $this->MultiCell(40, 8,'',0,'','L',true); 
   
   $this->Ln(4);
   
  }
		
	}
			
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0 || $c==4){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		 if($c==$length|| $c==1|| $c==2||$c==3||$c==4||$c==5||$c==6||$c==7||$c==8)
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
		
		foreach ($data as $claimsummary) {
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();
			
			
			$vc_claim_no      = $claimsummary['ClaimHeader']['vc_claim_no'];
			$claim_date       = !empty($claimsummary['ClaimHeader']['dt_entry_date']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_entry_date'])) : '';
			$claim_from = !empty($claimsummary['ClaimHeader']['dt_claim_from']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_claim_from'])) : '';
			$claim_to = !empty($claimsummary['ClaimHeader']['dt_claim_to']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_claim_to'])) : '';
			$fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : 
			0;
			
			$vc_no_in    = count($claimsummary['ClaimDetail']);
			$fuelcalimed = 0;
			foreach($claimsummary['ClaimDetail'] as $key) {
            if($key['vc_status']!='STSTY05')
            $fuelcalimed = $fuelcalimed+$key['nu_litres'];
			}
			$fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : number_format(0,2,'.',',');
			$vc_status   = $allconstants[$claimsummary['ClaimHeader']['vc_status']];
			$vc_party_claim_no = $claimsummary['ClaimHeader']['vc_party_claim_no'];
			
			if ($claimsummary['ClaimHeader']['vc_status'] != 'STSTY05') {
            $Amount = !empty($claimsummary['ClaimHeader']['nu_tot_amount']) ? 
			number_format($claimsummary['ClaimHeader']['nu_tot_amount'], '2', '.', ',') : number_format(0,'2', '.', '');
				} else {
            $Amount = "0.00";
			}
			
			if ($claimsummary['ClaimHeader']['vc_status'] != 'STSTY05') {
            $total_amount = $total_amount + $claimsummary['ClaimHeader']['nu_tot_amount'];
			}
			$sum = !empty($total_amount) ? number_format($total_amount, 2, '.', ',') : number_format(0, 2, '.', ',');
			
			$font_size=7;
			$fillcolor= '255,250,250';
			
			$alignvalue='C';
			
			$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='L';
			
			$col[] = array('text' => $vc_claim_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
		
			$col[] = array('text' => $claim_date, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			

			
			$col[] = array('text' => $claim_from.' - '.$claim_to, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
			$alignvalue='R';
			
			$col[] = array('text' => $vc_no_in, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

			
			
			$col[] = array('text' => $fuelLiters, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		
			$alignvalue='L';
			
			$col[] = array('text' => $vc_status, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
				
			$alignvalue='R';
			
			$col[] = array('text' => $Amount, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
			$col[] = array('text' => $vc_party_claim_no, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
				
			$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;
		}
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$this->SetY($y);  //Reset the write point
            $this->SetX($x); //Move X to $x + width of last cell
            $this->MultiCell(150, 10, 'Total Amount (N$)',  1,'R');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +150); //Move X to $x + width of last cell
			$this->MultiCell(41, 10,$sum,  1,'C'); 
	
	
	
	}
	
	
	function genrate_flr_claimsummary_pdf_old($columnsValues,$data,$allconstants,$claim,$toDate,$fromDate) {
        $columnwidtharrays=array(15,22,
							     22,40,
							     23,26,
								 18,25);
		$this->AddPage();
		$this->SetFont('Arial', 'B', 7);
		
		$c=0;
		
		$this->SetFillColor(139,137,137);
		
		$length = count($columnsValues)-1;
		
	if($this->PageNo()==1){
		
	if(isset($fromDate) && !empty($fromDate)){

   $x= $this->GetX();
   
   $y= $this->GetY();
   
   $this->SetFont('Arial', 'B', 6);   
   
   $this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+25);  
   
   $this->MultiCell(100, 8, date('d M Y', strtotime($fromDate)),0,'','L',true); 
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+125);
   
   $this->SetFont('Arial', 'B', 6);
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(25, 8, 'To Date :',0,'','R',true);
   else
   $this->MultiCell(25, 8, '',0,'','R',true);
   
   
   $this->SetFont('Arial','', 6);
   
   $this->SetY($y);  //Reset the write point
   
   $this->SetX($x+150); 
   
   if(isset($toDate) && !empty($toDate))
   $this->MultiCell(40, 8, date('d M Y', strtotime($toDate)),0,'','L',true); 
   else
   $this->MultiCell(40, 8,'',0,'','L',true); 
   
   $this->Ln(4);
   
  }
		
	}
			
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0 || $c==4){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'','C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {
    		 if($c==$length|| $c==1|| $c==2||$c==3||$c==4||$c==5||$c==6||$c==7)
			 $this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'','C',true);
			 else
			 $this->MultiCell($columnwidtharrays[$c], 6, $val , 1,'','C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		
		$this->SetFont('Arial', '', 5);
		$i=1;
		$this->Ln();
		
		foreach ($data as $claimsummary) {
			
			$x  = $this->GetX();
		    $y  = $this->GetY();
            $this->MultiCell($columnwidtharrays[0], 10, $i, 1,'C');
           // $this->MultiCell(10, 10, $val['AccountRecharge']['nu_acct_rec_id'], 1,'C');
			
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[1], 10, $claimsummary['ClaimHeader']['vc_claim_no'], 1,'L');
			
			$this->SetY($y);
			$this->SetX($x +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$claim_date = !empty($claimsummary['ClaimHeader']['dt_entry_date']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_entry_date'])) : '';
			$this->MultiCell($columnwidtharrays[2], 10, $claim_date , 1,'L');
			
			
			$this->SetY($y);
			$this->SetX($x+$columnwidtharrays[2] +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$claim_from = !empty($claimsummary['ClaimHeader']['dt_claim_from']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_claim_from'])) : '';
			$claim_to = !empty($claimsummary['ClaimHeader']['dt_claim_to']) ?
                date('d M Y', strtotime($claimsummary['ClaimHeader']['dt_claim_to'])) : '';

			$this->MultiCell($columnwidtharrays[3], 10, $claim_from.'-'.$claim_to , 1,'L');
	
			$this->SetY($y);
			$this->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2] +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : 
			0;
			$this->MultiCell($columnwidtharrays[4], 10,  count($claimsummary['ClaimDetail']), 1,'L');
			
			
			$fuelcalimed = 0;
			foreach($claimsummary['ClaimDetail'] as $key) {
            if($key['vc_status']!='STSTY05')
            $fuelcalimed = $fuelcalimed+$key['nu_litres'];
			}
			
			$this->SetY($y);
			$this->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2] +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : number_format(0,2,'.',',');
			
			
			
			$this->MultiCell($columnwidtharrays[5], 10, $fuelLiters , 1,'R');
			
			$this->SetY($y);
			$this->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2] +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[6], 10, $allconstants[$claimsummary['ClaimHeader']['vc_status']] ,  1,'L');
			
			if ($claimsummary['ClaimHeader']['vc_status'] != 'STSTY05') {
            $Amount = !empty($claimsummary['ClaimHeader']['nu_tot_amount']) ? 
			number_format($claimsummary['ClaimHeader']['nu_tot_amount'], '2', '.', ',') : number_format(0,'2', '.', '');
				} else {
            $Amount = "0.00";
			}
			$this->SetY($y);
			$this->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2] +$columnwidtharrays[1]+$columnwidtharrays[0]); //Move X to $x + width of last cell
			$this->MultiCell($columnwidtharrays[7], 10, $Amount , 1,'R');
        	 
		if($i%16==0 && $i>0)	{
			
			$this->AddPage();
			
			}				
			//$this->Ln();
			$i++;	
		}
	}

	/*****
	****
	***Payment Details
	****
	*****/
	function genrate_flr_paymentdetials_pdf($columnsValues,$data,$allconstants,$client,$toDate,$fromDate) {
	
	$columnwidtharrays=array(12,21,
							     18,32,20,
							     20,15,
								 18,18,16);
		$heightdynamic=12;						 
		$this->AddPage();
		$this->SetFont('Arial', 'B', 6);
		
		$c=0;
		
		$this->SetFillColor(139,137,137);
		
		$length = count($columnsValues)-1;
		
		if($this->PageNo()==1){
		
			if(isset($fromDate) && !empty($fromDate)){

		   $x= $this->GetX();
		   
		   $y= $this->GetY();
		   
		   $this->SetFont('Arial', 'B', 6);   
		   
		   $this->MultiCell(25, 8, 'From Date : ',0,'','L',true);
		   
		   $this->SetFont('Arial','', 6);
		   
		   $this->SetY($y);  //Reset the write point
		   
		   $this->SetX($x+25);  
		   
		   $this->MultiCell(100, 8, date('d M Y', strtotime($fromDate)),0,'','L',true); 
		   
		   $this->SetY($y);  //Reset the write point
		   
		   $this->SetX($x+125);
		   
		   $this->SetFont('Arial', 'B', 6);
		   if(isset($toDate) && !empty($toDate))
		   $this->MultiCell(25, 8, 'To Date :',0,'','R',true);
		   else
		   $this->MultiCell(25, 8, '',0,'','R',true);
		   
		   
		   $this->SetFont('Arial','', 6);
		   
		   $this->SetY($y);  //Reset the write point
		   
		   $this->SetX($x+150); 
		   
		   if(isset($toDate) && !empty($toDate))
		   $this->MultiCell(40, 8, date('d M Y', strtotime($toDate)),0,'','L',true); 
		   else
		   $this->MultiCell(40, 8,'',0,'','L',true); 
		   
		   $this->Ln(4);
		   
		  }
		
	}
		
        foreach($columnsValues as $val) {
			
			$x= $this->GetX();
		    $y= $this->GetY();

		 if($c==0){
			
			$this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
		 else
		   {  //0,4,8
    		 if($c==6||$c==7)
			 $this->MultiCell($columnwidtharrays[$c], 6, $val , 1,'C',true);
			 else
			 $this->MultiCell($columnwidtharrays[$c], 12, $val , 1,'C',true);
			 
			 $this->SetY($y);  //Reset the write point
             $this->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   }
		   $c++;
		  

		}
		$this->SetFont('Arial', '', 5);
		$i=0;
		$this->Ln();
		
		foreach ($data as $paymentreport) {
		
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();
			
			$vc_claim_no      =$paymentreport['ClaimHeader']['vc_claim_no'];
			$claim_date = !empty($paymentreport['ClaimHeader']['dt_entry_date']) ?
                date('d M Y', strtotime($paymentreport['ClaimHeader']['dt_entry_date'])) : '';
			$claim_from = !empty($paymentreport['ClaimHeader']['dt_claim_from']) ?
                date('d M Y', strtotime($paymentreport['ClaimHeader']['dt_claim_from'])) : '';
			$claim_to = !empty($paymentreport['ClaimHeader']['dt_claim_to']) ?
                date('d M Y', strtotime($paymentreport['ClaimHeader']['dt_claim_to'])) : '';
				
			$fuelcalimed = 0;
			
			foreach($paymentreport['ClaimDetail'] as $key) {
            if($key['vc_status']!='STSTY05')
            $fuelcalimed = $fuelcalimed+$key['nu_litres'];
			}
			$fuelLiters = !empty($fuelcalimed)? number_format($fuelcalimed,2,'.',',') : 
			0;
			if ($paymentreport['ClaimHeader']['vc_status'] != 'STSTY05') {
            $claim_amount = !empty($paymentreport['ClaimHeader']['nu_tot_amount'])?number_format($paymentreport['ClaimHeader']['nu_tot_amount'],'2','.',','):number_format(0,'2','.','');
        } else {
           $claim_amount =  "0.00";
        }
			
			$vc_status         = $allconstants[$paymentreport['ClaimHeader']['vc_status']];
			$vc_party_claim_no = $paymentreport['ClaimHeader']['vc_party_claim_no'];
			$PaymentAmount = !empty($paymentreport['ClaimHeader']['nu_payment_amount'])?number_format($paymentreport['ClaimHeader']['nu_payment_amount'],'2','.',','):number_format(0,'2','.',',');
			$PayMentDate = !empty($paymentreport['ClaimHeader']['dt_payment_date'])?date('d M Y',strtotime($paymentreport['ClaimHeader']['dt_payment_date'])):'';
			$tot_payment_amount   =   $tot_payment_amount + $paymentreport['ClaimHeader']['nu_payment_amount'];
			$payment_sum = !empty($tot_payment_amount)?number_format($tot_payment_amount,2,'.',','):number_format(0,'2','.',',');
        if($paymentreport['ClaimHeader']['vc_status']!='STSTY05') 
        {
            $tot_claim_amount   =   $tot_claim_amount + $paymentreport['ClaimHeader']['nu_tot_amount'];
        }
		$calim_sum = !empty($tot_claim_amount)?number_format($tot_claim_amount,2,'.',','):number_format(0,'2','.',',');
			
			
			$font_size=7;
			$fillcolor= '255,250,250';
		
		$alignvalue='C';
		
		$col[] = array('text' => $i+1, 'width' => $columnwidtharrays[0], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' =>$fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		$alignvalue='L';	
		$col[] = array('text' => $vc_claim_no, 'width' =>$columnwidtharrays[1], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
		
		
		$col[] = array('text' => $claim_date, 'width' =>$columnwidtharrays[2], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			

			
		$col[] = array('text' =>  $claim_from.' - '.$claim_to, 'width' =>$columnwidtharrays[3], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');
			
		$alignvalue='R';	
			
		$col[] = array('text' => $fuelLiters, 'width' =>$columnwidtharrays[4], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0', 'linearea' => 'LTBR');

		
		
		$col[] = array('text' => $claim_amount, 'width' =>$columnwidtharrays[5], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		$alignvalue='L';
			
		$col[] = array('text' => $vc_status, 'width' =>$columnwidtharrays[6], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
				
			
		$alignvalue='R';
			
		$col[] = array('text' => $PaymentAmount, 'width' =>$columnwidtharrays[7], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
			
		$alignvalue='L';	
			
		$col[] = array('text' =>$PayMentDate, 'width' =>$columnwidtharrays[8], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		
		$alignvalue='R';
		$col[] = array('text' =>$vc_party_claim_no, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			'linewidth' => '0', 'linearea' => 'LTBR');
		$alignvalue='L';	
			
			
			
		//$col[] = array('text' =>$payment_sum, 'width' =>$columnwidtharrays[9], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			//'linewidth' => '0', 'linearea' => 'LTBR');

		//$col[] = array('text' =>$calim_sum, 'width' =>$columnwidtharrays[10], 'height' => $heightdynamic, 'align' => $alignvalue, 'font_name' => 'Arial', 'font_size' => $font_size, 'font_style' => '', 'fillcolor' => $fillcolor, 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 
			//'linewidth' => '0', 'linearea' => 'LTBR');

		
		$columns[]=$col;
			$this->WriteTable($columns);   
			$i++;

		
		}
			
			// $this->Ln();
			$x  = $this->GetX();
		    $y  = $this->GetY();
			$this->SetY($y);  //Reset the write point
            $this->SetX($x); //Move X to $x + width of last cell
            $this->MultiCell(103, 10, 'Total Amount (N$)',  1,'R');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +103); //Move X to $x + width of last cell
			$this->MultiCell(20, 10,$calim_sum,  1,'R'); 
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +123); //Move X to $x + width of last cell
            $this->MultiCell(15, 10, 'Total (N$)',  1,'R');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +138); //Move X to $x + width of last cell
			$this->MultiCell(32, 10,$payment_sum,  1,'C');
			$this->SetY($y);  //Reset the write point
            $this->SetX($x +170); //Move X to $x + width of last cell
			$this->MultiCell(20, 10,' ' ,  1,'C');
	
	
	
	
	
	}
	
	}


?>
