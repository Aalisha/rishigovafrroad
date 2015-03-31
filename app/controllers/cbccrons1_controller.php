<?php

App::import('Sanitize');

/**
 *
 *
 *
 */
 App::import('Lib','FPDF');

class Cbccrons1Controller  extends AppController {

    /**
     *
     *
     *
     */
    var $name = 'Cbccrons';

    /**
     *
     *
     *
     */
	var $components = array('Session', 'Auth', 'RequestHandler', 'Email','Cbcreportpdfcreator');

    /**
     *
     *
     *
     */
    var $uses = array('Card', 'CustomerCard', 'AccountRecharge', 'Customer', 'DocumentUploadCbc', 'ActivationDeactivationCard', 'RequestCard', 'CardLogCbc', 'Profile', 'EntryExit', 'EntryExitMaster', 'EntryExitMasterView', 'CardRefund');
    
	var $left = 10;
    var $right = 10;
    var $top = 10;
    var $bottom = 10;
    /**
     *
     *
     *
     */
    var $helpers = array('Session', 'Html', 'Form');

    public function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();
        $this->Auth->allow('*');
    }

    
	/**
	 *
	 * Function for Opening balance 
	 *
	 */
	
	public function cbc_openingbalance($vc_cust_no=null,$fromdate=null){
	
			$this->loadModel('AccountRecharge');				
			//$vc_cust_no='040000128636';
			$fromdate = date('d-M-y',strtotime($fromdate));			
			$openingbalanceValue = $this->AccountRecharge->query("SELECT cf_cust_op_bal('$vc_cust_no', to_date('$fromdate', 'DD-MM-RRRR')) FROM DUAL");			
			//pr($openingbalanceValue[0][0]["cf_cust_op_bal('".$vc_cust_no."'"]);
			return $openingbalanceValue[0][0]["cf_cust_op_bal('".$vc_cust_no."'"];	
	}
	
	
	

	/**
	 *
	 * Function to generate pdf for customer statement report
	 *
	 */
	 
	
	public function cbc_customerstatements_pdf($vc_cust_no=null,$fromDate=null,$toDate=null,$num=null) {

	Configure::write('debug', 2);
	
	ini_set('memory_limit','5048M');
	set_time_limit(0);
	//ob_end_flush(); 
    //ob_flush(); 
    //flush(); 
    //ob_start(); 
	
	
	try {
	
	$customer='';		
	$customer = $this->Customer->find('first', array('conditions'=> array('Customer.vc_cust_no' => $vc_cust_no)));	 
    
	$vc_cust_no    = $customer['Customer']['vc_cust_no'];
	$vc_comp_code  = $customer['Customer']['vc_comp_code'];
	$vc_user_no    = $customer['Customer']['vc_user_no'];
	$vc_email_id   = $customer['Customer']['vc_email'];
	$customername  = $customer['Customer']['vc_first_name'].' '.$customer['Customer']['vc_surname'];
	
	$fromDate      = date('Y-m-d H:i:s', strtotime($fromDate));
	$toDate        = date('Y-m-d 23:59:59', strtotime($toDate));

	$openingbalance = $this->cbc_openingbalance($vc_cust_no,$fromDate,'',1,'','');
	
	/////////=====For account recharge using account_recharge table 

	$query = '';
	if ($toDate!='' && $fromDate!= '') {

	if (isset($vc_cust_no) && $vc_cust_no != '') {

	// Online account recharge using account_recharge_cbc table DT_PAYMENT_DATE between

	$joins = array();
	$conditions = array();
	$conditions = array(
		'AccountRecharge.nu_amount >'=>0,
		"AccountRecharge.vc_cust_no='$vc_cust_no'",
		'AccountRecharge.vc_recharge_status ' => 'STSTY04',
		'AccountRecharge.dt_payment_date IS NOT NULL',
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'AccountRecharge.dt_payment_date >= ' => $fromDate,
	);

	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'AccountRecharge.dt_payment_date <=' => $toDate,
	);

	endif;

	//AccountRecharge.ch_tran_type=\'23\' THEN \'1\' ELSE \'Recharge\' END  as
	$query .=  $this->accountRecharge($conditions,$vc_cust_no);

	$sumrecharge = $this->AccountRecharge->find('all', array('conditions' => $conditions,
	 'fields' => array('SUM(AccountRecharge.nu_amount) as sumRecharge'),
	));
	//pr($sumrecharge);
	 $TotalsumRecharge = $sumrecharge[0][0]['sumRecharge'];

	$Noofrecharge = $this->AccountRecharge->find('count', array('conditions' => $conditions,
	 //'fields' => array('AccountRecharge.nu_amount_un')
	));
	
	$conditions='';
	

	$query .= ' UNION ';

	//////// ===When User GOES IN CBC Case =============////////////////


	$conditions = array();
	$conditions = array(
	 'EntryExitMasterView.nu_cbc_entry_amount >'=>0,
	 "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
		 "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR EntryExitMasterView.ch_cancel_flg IS NULL )",
	 'EntryExitMasterView.dt_entry_date IS NOT NULL',
	 'OR' => array(
			'EntryExitMasterView.vc_payment_mode' =>'CARD',
			'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
	 ),
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'EntryExitMasterView.dt_entry_date >=' => $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'EntryExitMasterView.dt_entry_date <=' => $toDate,
	);
	endif;


	$query .= $this->inEntryExit($conditions,$vc_cust_no);

	$sumCBCamt = $this->EntryExitMasterView->find('all', array(
	 'fields' => array('SUM(EntryExitMasterView.nu_cbc_entry_amount) as totalcbcamt'),
		 'conditions'=>$conditions,
	));

	$totalcbcamt = $sumCBCamt[0][0]['totalcbcamt'];	

	// ======When  USER goes MDC OUTSIDE case===================== //
	//  and d.dt_exit_date between nvl(:from_date, d.dt_exit_date) and nvl(:to_date, 
	// d.dt_exit_date)

	$query .= ' UNION ';

	$joins = array();
	
	$conditions = array();

	$conditions = array(
	 'EntryExitMasterView.nu_mdc_paid_amount >'=>0,
	 "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
	 "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR 
	 EntryExitMasterView.ch_cancel_flg IS NULL )",
	 'EntryExitMasterView.dt_exit_date IS NOT NULL',
	 'OR' => array(
				'EntryExitMasterView.vc_payment_mode' => 'CARD',
				'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
	 ),
	);

	if (isset($fromDate) && $fromDate!='') :
		$conditions += array(
		'EntryExitMasterView.dt_exit_date >=' => $fromDate,
		);
	endif;

	if (isset($toDate) && $toDate!='') :
		$conditions += array(
		'EntryExitMasterView.dt_exit_date <=' => $toDate,
		);
	endif;


 	$query .= $this->outEntryExit($conditions,$vc_cust_no);
	
	$sumMDcamt = $this->EntryExitMasterView->find('all', array(
	'fields' => array('SUM(EntryExitMasterView.nu_mdc_paid_amount) as totalmdcamt'),
	'conditions'=>$conditions));

	$totalmdcamt = $sumMDcamt[0][0]['totalmdcamt'];
	
	


/* === For User card issue using     dt_cust_card_cbc ====== */

	$joins = array();
	$conditions = array();

	$conditions = array(
	 "CustomerCard.vc_cust_no='$vc_cust_no'",
	 'CustomerCard.dt_issue_date IS NOT NULL'
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'CustomerCard.dt_issue_date >=' => $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'CustomerCard.dt_issue_date <=' => $toDate,
	);
	endif;

	// total card issued
	$Totalcardsdatewise = $this->CustomerCard->find('all', array('conditions' => $conditions,
	 'fields' => array('CustomerCard.vc_card_no', 'CustomerCard.dt_mod_date'),
	 'order' => array('CustomerCard.dt_mod_date asc' ),
	 ));
		//$i = 0;
	$sumofcardsIssued = '';
	$sumofcardsIssued= sizeof($Totalcardsdatewise);

	///====For Cbc or mdc permit  refund  using CBC_MDC_REFUND_CBC table and DT_REFUND_DATE between :from_date and :to_date


	$query .= ' UNION ';
	$conditions = array();
	$conditions = array(
		'CardRefund.nu_approved_amt >'=>0 ,
		"CardRefund.vc_cust_no='$vc_cust_no'",
		'CardRefund.dt_refund_date IS NOT NULL ',
		'CardRefund.vc_status'=>'STSTY04',
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
		'CardRefund.dt_refund_date >=' => $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
		'CardRefund.dt_refund_date <=' => $toDate,
	);
	endif;

	$query .= $this->cbcMdcRefund($conditions,$vc_cust_no);

	$sumrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
		'fields' => array('SUM(CardRefund.nu_approved_amt) as sumrefund'),
	));

	$TotalsumRefund = $sumrefund[0][0]['sumrefund'];
	$this->set('TotalsumRefund', $TotalsumRefund);

	$NoOfrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
		'fields' => array('CardRefund.nu_approved_amt'),
	));

	$this->set('NoOfrefund', sizeof($NoOfrefund));

	$conditions='';

/////////////////============card issued datewise=======///////////////

	$query .= ' UNION ';

	$joins = array();

	$conditions = array();
	$conditions = array(
	"CustomerCard.vc_cust_no='$vc_cust_no'",
	'CustomerCard.dt_issue_date IS NOT NULL',
		);
		
	if (isset($fromDate) && !empty($fromDate)) :

		$conditions += array(
			'CustomerCard.dt_issue_date >=' => $fromDate,
		);
	endif;

	if (isset($toDate) && !empty($toDate)):

		$conditions += array(
			'CustomerCard.dt_issue_date <=' => $toDate,
		);
	endif;
	
	$query .= $this->cardIssued($conditions,$vc_cust_no);
	//die;
	$storeallValues = $this->AccountRecharge->find('all', array(
			'fields' => array('Temp.transaction_type,
			Temp.Transaction_Date,
			Temp.CardNo,
			Temp.Permit_RefNo,
			Temp.Remarks,
			Temp.Issue_Ref_Date,
			Temp.VehicleRegNo,
			Temp.NetAmount,
			Temp.Running'),
			'joins' => array(
			array(
				'table' => "($query)",
				'alias' => 'Temp',
				'type' => 'right',                    
				'conditions' => array('AccountRecharge.vc_voucher_no = \'*noopapapapappapapapapappapapapapappapapapapapp*\'')
			)
		),
		'conditions' => array("1=1"),
		 'order' => array('Temp.Transaction_Date' => 'asc','Temp.transaction_type' => 'desc'),			
		));
	return $storeallValues;
	$columnsValues= array('SI.No.','Transaction  Type',	'Transaction Date','Remarks',
	'Issue/Ref.Date','Card No.','Permit/Ref.No.','Vehicle Reg. No.','Net Amount(N$)','Running Balance(N$)' );
	//ob_start();
	//$this->Cbcreportpdfcreator->headerData('Customer Statement Report', $num,$customer);
	

	//$this->Cbcreportpdfcreator->genrate_cbc_customerstatement_pdf($columnsValues,$storeallValues,$this->globalParameterarray,$customer,$toDate,$fromDate,$openingbalance,$TotalsumRefund,$totalmdcamt,$totalcbcamt,sizeof($NoOfrefund),$TotalsumRecharge,$Noofrecharge,$sumofcardsIssued,'S');
	
	
	//$vc_cust_no = $customer['Customer']['vc_cust_no'];
	//ob_get_clean();		
	
    //$this->Cbcreportpdfcreator->output(WWW_ROOT.'upload-files-for-cbc-mdc'.DS.$num.'-'.$vc_cust_no.'-Customer-statement-Report'.'.pdf', 'R');
	//unset();
	unset($customer);
	ob_end_clean();
		
}
} }catch (Exception $e) {

echo 'Caught exception: ', $e->getMessage(), "\n";

exit;
}

}



// start of fpdf functions //
    function Footer() {
        // Position at 1.5 cm from bottom
		$pdf = new FPDF();
        $pdf->SetY(-15);
        // Arial italic 8
        $pdf->SetFont('Arial', 'I', 8);
        // Text color in gray
        $pdf->SetTextColor(128);
        // Page number
        $pdf->Cell(50, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'L');
        $pdf->Cell(0, 10, 'Date ' . date('d-M-Y'), 0, 0, 'R');
    }
	function headerData($title, $period = NULL,$customerInfo=array(),$vehicletype=null,$todate=null,$fromdate=null) {
        $this->ReportTitle = $title;
		$this->Customer = $customerInfo;
		$this->vehicletype = $vehicletype;
    }
	function CheckPageBreak($h)	{
		global $pdf;
		$pdf = new FPDF();
		
        
	if($pdf->GetY()+$h>$pdf->PageBreakTrigger)
        $pdf->AddPage($pdf->CurOrientation);
	}

	 function WriteTable($tcolums)	 {
      // go through all colums
	  global $pdf;
		$pdf = new FPDF();
		
      for ($i = 0; $i < sizeof($tcolums); $i++)
      {
         $current_col = $tcolums[$i];
         $height = 0;
         
         // get max height of current col
         $nb=0;
         for($b = 0; $b < sizeof($current_col); $b++)
         {
            // set style
            $pdf->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
            $color = explode(",", $current_col[$b]['fillcolor']);
            $pdf->SetFillColor($color[0], $color[1], $color[2]);
            $color = explode(",", $current_col[$b]['textcolor']);
            $pdf->SetTextColor($color[0], $color[1], $color[2]);            
            $color = explode(",", $current_col[$b]['drawcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            $pdf->SetLineWidth($current_col[$b]['linewidth']);
                        
            $nb = max($nb, $this->NbLines(2, $current_col[$b]['text']));            
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
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            
            // set style
            $pdf->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
            $color = explode(",", $current_col[$b]['fillcolor']);
            $pdf->SetFillColor($color[0], $color[1], $color[2]);
            $color = explode(",", $current_col[$b]['textcolor']);
            $pdf->SetTextColor($color[0], $color[1], $color[2]);            
            $color = explode(",", $current_col[$b]['drawcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            $pdf->SetLineWidth($current_col[$b]['linewidth']);
            
            $color = explode(",", $current_col[$b]['fillcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            
            
            // Draw Cell Background
            $pdf->Rect($x, $y, $w, $h, 'FD');
            
            $color = explode(",", $current_col[$b]['drawcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            
            // Draw Cell Border
            if (substr_count($current_col[$b]['linearea'], "T") > 0)
            {
               $pdf->Line($x, $y, $x+$w, $y);
            }            
            
            if (substr_count($current_col[$b]['linearea'], "B") > 0)
            {
               $pdf->Line($x, $y+$h, $x+$w, $y+$h);
            }            
            
            if (substr_count($current_col[$b]['linearea'], "L") > 0)
            {
               $pdf->Line($x, $y, $x, $y+$h);
            }
                        
            if (substr_count($current_col[$b]['linearea'], "R") > 0)
            {
               $pdf->Line($x+$w, $y, $x+$w, $y+$h);
            }
            
            
            // Print the text
            $pdf->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);
            
            // Put the position to the right of the cell
            $pdf->SetXY($x+$w, $y);         
         }
         
         // Go to the next line
         $pdf->Ln($h);          
      }                  
   }
   
  function NbLines($w, $txt)
   {
      global $pdf;
		$pdf = new FPDF();
	
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
      $w=$this->w-$pdf->rMargin-$pdf->x;
      
	  $wmax=($w-2*$pdf->cMargin)*1000/10;
      
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
   
   
     function NbLines1($w, $txt)  {
	   global $pdf;
		$pdf = new FPDF();
	
      $cw=&$pdf->CurrentFont['cw'];
      if($w==0)
         $w=$pdf->w-$this->rMargin-$pdf->x;
      $wmax=($w-2*$pdf->cMargin)*1000/$pdf->FontSize;
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
	
	
	function cbc_testpdf($vc_cust_no,$fromDate,$toDate){
		
		Configure::write('debug',2);		
		global $pdf;
		$pdf = new FPDF();
		$customer = $this->Customer->find('first', array('conditions'=> array('Customer.vc_cust_no' => $vc_cust_no)));	 
		$customerarray = $customer;
		$allconstants=$this->globalParameterarray;
		// Add the page to the current PDF
		
		$pdf->AddPage();
		$title = 'Customer statement Report';		
        $pdf->SetFont('Arial', 'B', 12);
        $w = $pdf->GetStringWidth($title) + 6;
        $pdf->SetX((210 - $w) / 2);
        $pdf->SetLineWidth(1);
		$pdf->Image(WWW_ROOT.'img/logo.jpg', 10, 5, 15, 20);

        $pdf->Cell($w, 9, $title, 0, 1, 'C');
		$currentUser = $customer;
		$pdf->Ln(10);
		//$this->SetFont('Arial', 'B', 12);
			//code to start query//
	
	$openingbalance = $this->cbc_openingbalance($vc_cust_no,$fromDate,'',1,'','');
	
	/////////=====For account recharge using account_recharge table 

	$query = '';


	// Online account recharge using account_recharge_cbc table DT_PAYMENT_DATE between

	$joins = array();
	$conditions = array();
	$conditions = array(
		'AccountRecharge.nu_amount >'=>0,
		"AccountRecharge.vc_cust_no='$vc_cust_no'",
		'AccountRecharge.vc_recharge_status ' => 'STSTY04',
		'AccountRecharge.dt_payment_date IS NOT NULL',
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'AccountRecharge.dt_payment_date >= ' => $fromDate,
	);

	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'AccountRecharge.dt_payment_date <=' => $toDate,
	);

	endif;

	//AccountRecharge.ch_tran_type=\'23\' THEN \'1\' ELSE \'Recharge\'                 END  as
	$query .=  $this->accountRecharge($conditions,$vc_cust_no);

	$sumrecharge = $this->AccountRecharge->find('all', array('conditions' => $conditions,
	 'fields' => array('SUM(AccountRecharge.nu_amount) as sumRecharge'),
	));
	//pr($sumrecharge);
	 $TotalsumRecharge = $sumrecharge[0][0]['sumRecharge'];

	$Noofrecharge = $this->AccountRecharge->find('count', array('conditions' => $conditions,
	 //'fields' => array('AccountRecharge.nu_amount_un')
	));
	$conditions='';
	

	 $query .= ' UNION ';

	//////// ===When User GOES IN CBC Case =============////////////////


	$conditions = array();
	$conditions = array(
	 'EntryExitMasterView.nu_cbc_entry_amount >'=>0,
	 "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
		 "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR 
		 EntryExitMasterView.ch_cancel_flg IS NULL )",
	 'EntryExitMasterView.dt_entry_date IS NOT NULL',
	 'OR' => array(
			'EntryExitMasterView.vc_payment_mode' =>'CARD',
			'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
	 ),
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'EntryExitMasterView.dt_entry_date >=' => $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'EntryExitMasterView.dt_entry_date <=' => $toDate,
	);
	endif;


	$query .= $this->inEntryExit($conditions,$vc_cust_no);

	$sumCBCamt = $this->EntryExitMasterView->find('all', array(
	 'fields' => array('SUM(EntryExitMasterView.nu_cbc_entry_amount) as totalcbcamt'),
		 'conditions'=>$conditions,
	));

	$totalcbcamt = $sumCBCamt[0][0]['totalcbcamt'];

	

	// ======When  USER goes MDC OUTSIDE case===================== //
	//  and d.dt_exit_date between nvl(:from_date, d.dt_exit_date) and nvl(:to_date, 
	// d.dt_exit_date)


	$query .= ' UNION ';

	$joins = array();

	$conditions = array();

	$conditions = array(
	 'EntryExitMasterView.nu_mdc_paid_amount >'=>0,
	 "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
	 "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR 
	 EntryExitMasterView.ch_cancel_flg IS NULL )",
	 'EntryExitMasterView.dt_exit_date IS NOT NULL',
	 'OR' => array(
				'EntryExitMasterView.vc_payment_mode' => 'CARD',
				'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
	 ),
	);

	if (isset($fromDate) && $fromDate!='') :

		$conditions += array(
		'EntryExitMasterView.dt_exit_date >=' => $fromDate,
		);
	endif;

	if (isset($toDate) && $toDate!='') :

		$conditions += array(
		'EntryExitMasterView.dt_exit_date <=' => $toDate,
		);
	endif;


 	$query .= $this->outEntryExit($conditions,$vc_cust_no);
	
	$sumMDcamt = $this->EntryExitMasterView->find('all', array(
	'fields' => array('SUM(EntryExitMasterView.nu_mdc_paid_amount) as totalmdcamt'),
	'conditions'=>$conditions));

	$totalmdcamt = $sumMDcamt[0][0]['totalmdcamt'];
	
	


/* === For User card issue using     dt_cust_card_cbc ====== */

	$joins = array();
	$conditions = array();

	$conditions = array(
	 "CustomerCard.vc_cust_no='$vc_cust_no'",
	 'CustomerCard.dt_issue_date IS NOT NULL'
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'CustomerCard.dt_issue_date >=' => $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'CustomerCard.dt_issue_date <=' => $toDate,
	);
	endif;

	// total card issued
	$Totalcardsdatewise = $this->CustomerCard->find('all', array('conditions' => $conditions,
	 'fields' => array('CustomerCard.vc_card_no', 'CustomerCard.dt_mod_date'),
	 'order' => array('CustomerCard.dt_mod_date asc' ),
	 ));
	 


		//$i = 0;
	$sumofcardsIssued = '';
	$sumofcardsIssued= sizeof($Totalcardsdatewise);

	///====For Cbc or mdc permit  refund  using CBC_MDC_REFUND_CBC table and DT_REFUND_DATE between :from_date and :to_date


	$query .= ' UNION ';
	$conditions = array();
	$conditions = array(
		'CardRefund.nu_approved_amt >'=>0 ,
		"CardRefund.vc_cust_no='$vc_cust_no'",
		'CardRefund.dt_refund_date IS NOT NULL ',
		'CardRefund.vc_status'=>'STSTY04',
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
		'CardRefund.dt_refund_date >=' => $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
		'CardRefund.dt_refund_date <=' => $toDate,
	);
	endif;

	$query .= $this->cbcMdcRefund($conditions,$vc_cust_no);

	$sumrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
		'fields' => array('SUM(CardRefund.nu_approved_amt) as sumrefund'),
	));

	$TotalsumRefund = $sumrefund[0][0]['sumrefund'];
	$this->set('TotalsumRefund', $TotalsumRefund);

	$NoOfrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
		'fields' => array('CardRefund.nu_approved_amt'),
	));

	$this->set('NoOfrefund', sizeof($NoOfrefund));

	$conditions='';

     /////////////////============card issued datewise=======///////////////

	$query .= ' UNION ';

	$joins = array();

	$conditions = array();
	$conditions = array(
	"CustomerCard.vc_cust_no='$vc_cust_no'",
	'CustomerCard.dt_issue_date IS NOT NULL',
		);
		
	if (isset($fromDate) && !empty($fromDate)) :

		$conditions += array(
			'CustomerCard.dt_issue_date >=' => $fromDate,
		);
	endif;

	if (isset($toDate) && !empty($toDate)):

		$conditions += array(
			'CustomerCard.dt_issue_date <=' => $toDate,
		);
	endif;
	
	$query .= $this->cardIssued($conditions,$vc_cust_no);
	//die;
	$data = $this->AccountRecharge->find('all', array(
			'fields' => array('Temp.transaction_type,
			Temp.Transaction_Date,
			Temp.CardNo,
			Temp.Permit_RefNo,
			Temp.Remarks,
			Temp.Issue_Ref_Date,
			Temp.VehicleRegNo,
			Temp.NetAmount,
			Temp.Running'),
			'joins' => array(
			array(
				'table' => "($query)",
				'alias' => 'Temp',
				'type' => 'right',                    
				'conditions' => array('AccountRecharge.vc_voucher_no = \'*noopapapapappapapapapappapapapapappapapapapapp*\'')
			)
		),
		'conditions' => array("1=1"),
		 'order' => array('Temp.Transaction_Date' => 'asc','Temp.transaction_type' => 'desc'),			
		));
		
		// code to end query //
		
		$pdf->SetLineWidth(0);

		if($pdf->PageNo()==1){
		
			$pdf->SetFillColor(191,191,191);		
			$x = $pdf->GetX();
			$y = $pdf->GetY();		
			$pdf->SetFont('Arial', 'B', 6);			
			$pdf->MultiCell(25, 8, 'Customer Name : ',0,'L',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+25);	
			$pdf->MultiCell(100, 8, ucfirst($currentUser['Customer']['vc_first_name'] . ' ' .$currentUser['Customer']['vc_surname']) ,0,'L',true);		
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+125);		
			$pdf->SetFont('Arial', 'B', 6);
			$pdf->MultiCell(25, 8, 'Tel. No.  :',0,'R',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+150);	
			$pdf->MultiCell(40, 8, $currentUser['Customer']['vc_tel_no'] ,0,'L',true);	
			$pdf->Ln(0);
		
			$x= $pdf->GetX();
			$y= $pdf->GetY();
			$pdf->SetFont('Arial', 'B', 6);			
			$address = trim(ucfirst($currentUser['Customer']['vc_address1']));
		
			if(isset($currentUser['Customer']['vc_address2']) && !empty($currentUser['Customer']['vc_address2']))
			$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address2']));
			
			if(isset($currentUser['Customer']['vc_address3']) && !empty($currentUser['Customer']['vc_address3']))		
			$address .= ','.trim(ucfirst($currentUser['Customer']['vc_address3']));			

			$pdf->MultiCell(25, 8, 'Address : ',0,'L',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+25);		
			$pdf->MultiCell(100, 8,$address,0,'L',true);
			
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+125);
			$pdf->SetFont('Arial', 'B', 6);
			$pdf->MultiCell(25, 8, 'Email :',0,'R',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+150);	
			$pdf->MultiCell(40, 8,$currentUser['Customer']['vc_email'] ,0,'L',true);	
			$pdf->Ln(0);
		
			$x= $pdf->GetX();
			$y= $pdf->GetY();		
			$pdf->SetFont('Arial', 'B', 6);			
			$pdf->MultiCell(25, 8, 'Mobile No. : ',0,'L',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+25);		
			$pdf->MultiCell(100, 8,$currentUser['Customer']['vc_mobile_no'] ,0,'L',true);	
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+125);
			$pdf->SetFont('Arial', 'B', 6);
			$pdf->MultiCell(25, 8, 'Fax No.  :',0,'R',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+150);	
			$pdf->MultiCell(40, 8, $currentUser['Customer']['vc_fax_no'],0,'L',true);	
			
			$x= $pdf->GetX();
			$y= $pdf->GetY();
			$pdf->SetFont('Arial', 'B', 6);
			$pdf->MultiCell(25, 8, 'Company : ',0,'L',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+25);		
			$pdf->MultiCell(100, 8,$currentUser['Customer']['vc_company'] ,0,'L',true);	
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+125);
			$pdf->SetFont('Arial', 'B', 6);
			$pdf->MultiCell(25, 8, 'Account No.  :',0,'R',true);
			$pdf->SetFont('Arial','', 6);
			$pdf->SetY($y);  //Reset the write point
			$pdf->SetX($x+150);	
			$pdf->MultiCell(40, 8, $currentUser['Customer']['vc_cust_no'],0,'L',true);
			$pdf->Ln(5);
			
			
			////////////// start of header values
			$columnwidtharrays=array(27,23,//50
			                     22,22, //44
  								 23,23,//46
								 23,27,//50
								 ); 
								 //190
		$c=0;
		$heightdynamic = 10;
		
		$pdf->SetFillColor(191,191,191);
		
		
		
		// start for opening balance section in header
		$columnsofheader=array('Opening Balance (N$)','Recharge (N$)','Admin Fees (N$)',
		'Card Issue (N$)','CBC Total (N$)','MDC Total (N$)','Refund (N$)',
		'Account Balance (N$)');
		
		$x= $pdf->GetX();
		$y= $pdf->GetY();
		 $heightdynamic=5;
		// $this="$pdf";
		$pdf->SetFont('Arial','B',6);

		$pdf->MultiCell($columnwidtharrays[0], $heightdynamic,$columnsofheader[0],1,'C',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[0]);		
		$pdf->MultiCell($columnwidtharrays[1],$heightdynamic,$columnsofheader[1],1,'C',true);

		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$pdf->MultiCell($columnwidtharrays[2], $heightdynamic,$columnsofheader[2],1,'C',true);
		
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[3], $heightdynamic,$columnsofheader[3],1,'C',true);
		
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[4], $heightdynamic,$columnsofheader[4],1,'C',true);
		
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[5], $heightdynamic,$columnsofheader[5],1,'C',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
	    $pdf->SetTextColor(208,121,121);

		$pdf->MultiCell($columnwidtharrays[6], $heightdynamic,$columnsofheader[6],1,'C',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+     $columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		 $pdf->SetTextColor(0,0,0);

		 $pdf->MultiCell($columnwidtharrays[7], $heightdynamic,$columnsofheader[7],1,'C',true);

		 $pdf->Ln(0);
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
		    
		$x= $pdf->GetX();
		$y= $pdf->GetY();
		
		$pdf->SetFont('Arial', 'B', 6);
		$pdf->SetTextColor(0,0,255);

		$pdf->MultiCell($columnwidtharrays[0], $heightdynamic,number_format($funcopeningbalance, 2, '.', ','),1,'R',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[0]);		
		$pdf->MultiCell($columnwidtharrays[1],$heightdynamic,number_format($TotalsumRecharge, 2, '.', ','),1,'R',true);
		
		
        $pdf->SetTextColor(208,21,21);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$pdf->MultiCell($columnwidtharrays[2], $heightdynamic,number_format($Noofrecharge, 2, '.', ','),1,'R',true);
		
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[3], $heightdynamic,number_format($sumofcardsIssuedcost, 2, '.', ','),1,'R',true);
		
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[4], $heightdynamic,number_format($totalcbcamt, 2, '.', ','),1,'R',true);
		
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[5], $heightdynamic,number_format($totalmdcamt, 2, '.', ','),1,'R',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		
		$pdf->MultiCell($columnwidtharrays[6], $heightdynamic,number_format($TotalsumRefund, 2, '.', ','),1,'R',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+$columnwidtharrays[6]+$columnwidtharrays[5]+$columnwidtharrays[4]+$columnwidtharrays[3]+$columnwidtharrays[2]+$columnwidtharrays[1]+$columnwidtharrays[0]);
		$pos = strpos($nu_account_balance,'-');
		$pdf->SetTextColor(0,0,255);
					
		if($pos!== false){
		
		$pdf->MultiCell($columnwidtharrays[7], $heightdynamic,"(".number_format($nu_account_balance, 2, '.', ',').")",1,'R',true);
		
		} else {				
						
		$pdf->MultiCell($columnwidtharrays[7], $heightdynamic,number_format($nu_account_balance, 2, '.', ','),1,'R',true);
				
		}
		
        $pdf->SetTextColor(0,0,0);

		$pdf->Ln(2);		

			///////////end of header values
		}
		
		$pdf->SetLineWidth(0);
		$openingbalance = $this->cbc_openingbalance($currentUser['Customer']['vc_cust_no'],$fromDate,'',1,'','');
		// Online account recharge using account_recharge_cbc table DT_PAYMENT_DATE between
		
		///start of grid code
		$pdf->SetTextColor(0,0,0);

		$pdf->Ln(2);

		
		if($pdf->PageNo()==1){
		
		$pdf->SetFillColor(191,191,191);
		$x= $pdf->GetX();
		$y= $pdf->GetY();
		if((isset($fromDate) && !empty($fromDate)) || (isset($toDate) && !empty($toDate)) ){
		

		$pdf->SetFont('Arial', 'B', 6);
	    if(isset($fromDate) && !empty($fromDate))
		$pdf->MultiCell(25, 8, 'From Date : ',0,'L',true);
		else
		$pdf->MultiCell(25, 8, ' ',0,'L',true);
		
		$pdf->SetFont('Arial','', 6);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+25);		
		if(isset($fromDate) && !empty($fromDate))
		$pdf->MultiCell(100, 8, date('d-M-Y',strtotime($fromDate)) ,0,'','L',true);	
		else
		$pdf->MultiCell(100, 8,'' ,0,'','L',true);	
		

		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+125);
		$pdf->SetFont('Arial', 'B', 6);
		if(isset($toDate) && !empty($toDate))
		$pdf->MultiCell(25, 8, 'To Date : ',0,'','R',true);
		else
		$pdf->MultiCell(25, 8, ' ',0,'','R',true);
		
		$pdf->SetFont('Arial','', 6);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+150);	
		
		if(isset($toDate) && !empty($toDate))
		$pdf->MultiCell(40, 8, date('d-M-Y',strtotime($toDate)) ,0,'L',true);
		else		
		$pdf->MultiCell(40, 8, '' ,0,'L',true);
		
		$pdf->Ln(2);
		
		}
		}
		$pdf->SetFont('Arial','', 5);
		$i=0;
		$pdf->Ln();
		$runningValue ='';
		$runningValue = $funcopeningbalance;
		$heightdynamic=10;
		// start of foreach data loop for display of all records
		
			//	$pdf->SetFont('Arial','B', 6);

			$columnwidtharrays	= array(12,15,16,30,18,17,18,19,20,25);
			
			$columnsValues		= array('SI.No.','Transaction  Type','Transaction Date','Remarks','Issue/Ref.Date','Card No.','Permit/Ref.No.','Vehicle Reg. No.','Net Amount(N$)','Running Balance(N$)');
			//ob_start();
			$length = count($columnsValues)-1;
			$c = 0;
			$pdf->SetFont('Arial','B',6);
			
			foreach($columnsValues as $val) {		
			
			$x = $pdf->GetX();
		    $y = $pdf->GetY();

			if($c==1||$c==2){
			
			$pdf->MultiCell($columnwidtharrays[$c], 7, $val , 1,'C',true);
			$pdf->SetY($y);  //Reset the write point
            $pdf->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
			
			}
			else
			{
			
    		 $pdf->MultiCell($columnwidtharrays[$c], 14, $val , 1,'C',true);			 
			 $pdf->SetY($y);  //Reset the write point
             $pdf->SetX($x +$columnwidtharrays[$c]); //Move X to $x + width of last cell
		   
		   }
		   $c++;		  

		}
		
		$pdf->SetFont('Arial', '', 5);
		$i=0;
		$pdf->Ln();
		$runningValue ='';
		$runningValue = $funcopeningbalance;
		 $heightdynamic=5;
		if(count($data)>0){
		
		foreach ($data as $value) {	
						//print_r($value);die;
						$x= $pdf->GetX();
						$y= $pdf->GetY();
						$heightdynamic=10;
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
							//echo $allconstants['CBCADMINFEE'];
							//die('rishi');
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
					
			$x  = $pdf->GetX();
		    $y  = $pdf->GetY();
			$alignvalue = 'L';
			$columns = array();
			$col = array();
			
			//$vc_veh_type      = $allconstants[$val['AddVehicle']['vc_veh_type']];
			$transaction_date = $value['Temp']['transaction_date'];			
			$font_size=7;
			$fillcolor= '255,250,250';
			
			
			//echo $i+1;
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
							
				/*
							
			*/
				$columns[]=$col;
	//	start $this->WriteTable($columns);   
		$tcolums=$columns;
		for ($i2 = 0; $i2 < sizeof($tcolums); $i2++)
      {
         $current_col = $tcolums[$i2];
         $height = 0;
         
         // get max height of current col
         $nb=0;
         for($b = 0; $b < sizeof($current_col); $b++)
         {
            // set style
            $pdf->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
            $color = explode(",", $current_col[$b]['fillcolor']);
            $pdf->SetFillColor($color[0], $color[1], $color[2]);
            $color = explode(",", $current_col[$b]['textcolor']);
            $pdf->SetTextColor($color[0], $color[1], $color[2]);            
            $color = explode(",", $current_col[$b]['drawcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            $pdf->SetLineWidth($current_col[$b]['linewidth']);
                        //start of nblines
						//$current_col[$b]['text'];
						$cw=&$this->CurrentFont['cw'];
					//	$current_col[$b]['width'], $current_col[$b]['text'];
					$w=$current_col[$b]['width'];
					$txt=$current_col[$b]['text'];
					
      if($w==0)
         $w=$pdf->w-$pdf->rMargin-$pdf->x;
      $wmax=($w-2*$pdf->cMargin)*1000/$pdf->FontSize;
      $s=str_replace("\r", '', $txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
         $nb--;
      $sep=-1;
      $i1=0;
      $j1=0;
      $l=0;
      $nl=1;
      while($i1<$nb)
      {
         $c=$s[$i1];
         if($c=="\n")
         {
            $i1++;
            $sep=-1;
            $j1=$i1;
            $l=0;
            $nl++;
            continue;
         }
         if($c==' ')
            $sep=$i1;
         $l+=$cw[$c];
         if($l>$wmax)
         {
            if($sep==-1)
            {
               if($i1==$j1)
                  $i1++;
            }
            else
               $i1=$sep+1;
            $sep=-1;
            $j1=$i1;
            $l=0;
            $nl++;
         }
         else
            $i1++;
      }
		//   return $nl;
	  // end of nblines
       $nb = max($nb, $nl);            
            $height = $current_col[$b]['height'];
         }  
         $h=$height*$nb;
         
         
         // Issue a page break first if needed
        // start of $this->CheckPageBreak($h);
		if($pdf->GetY()+$h>$pdf->PageBreakTrigger)
        $pdf->AddPage($pdf->CurOrientation);
		//end of $this->CheckPageBreak($h);
         
         // Draw the cells of the row
         for($b = 0; $b < sizeof($current_col); $b++)
         {
            $w = $current_col[$b]['width'];
            $a = $current_col[$b]['align'];
            
            // Save the current position
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            
            // set style
            $pdf->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
            $color = explode(",", $current_col[$b]['fillcolor']);
            $pdf->SetFillColor($color[0], $color[1], $color[2]);
            $color = explode(",", $current_col[$b]['textcolor']);
            $pdf->SetTextColor($color[0], $color[1], $color[2]);            
            $color = explode(",", $current_col[$b]['drawcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            $pdf->SetLineWidth($current_col[$b]['linewidth']);
            
            $color = explode(",", $current_col[$b]['fillcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            
            
            // Draw Cell Background
            $pdf->Rect($x, $y, $w, $h, 'FD');
            
            $color = explode(",", $current_col[$b]['drawcolor']);            
            $pdf->SetDrawColor($color[0], $color[1], $color[2]);
            
            // Draw Cell Border
            if (substr_count($current_col[$b]['linearea'], "T") > 0)
            {
               $pdf->Line($x, $y, $x+$w, $y);
            }            
            
            if (substr_count($current_col[$b]['linearea'], "B") > 0)
            {
               $pdf->Line($x, $y+$h, $x+$w, $y+$h);
            }            
            
            if (substr_count($current_col[$b]['linearea'], "L") > 0)
            {
               $pdf->Line($x, $y, $x, $y+$h);
            }
                        
            if (substr_count($current_col[$b]['linearea'], "R") > 0)
            {
               $pdf->Line($x+$w, $y, $x+$w, $y+$h);
            }
            
            
            // Print the text
            $pdf->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);
            
            // Put the position to the right of the cell
            $pdf->SetXY($x+$w, $y);         
         }
         
         // Go to the next line
         $pdf->Ln($h);          
      }       
		//	end of $this->WriteTable($columns);   
			$i++;
		//		$this->Footer();
		}  // end of foreach data loop
		
		}
		
		if($i==0){
		$pdf->Ln(2);
		}
		$pdf->SetFont('Arial', 'B', 7);		
		$pdf->SetFillColor(191,191,191);
		$x= $pdf->GetX();
		$y= $pdf->GetY();
		$pdf->SetFont('Arial', 'B', 6);
	    $pdf->MultiCell(25, 8, ' ',0,'L',true);		
		$pdf->SetFont('Arial','', 6);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+20);		
		$pdf->MultiCell(100, 8, '' ,0,'L',true);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+120);
		$pdf->SetFont('Arial','B', 6);
		$pdf->SetTextColor(0,0,255);
		$pdf->MultiCell(40, 8, ' Closing Balance (N$) ',0,'R',true);
        $pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','', 6);
		$pdf->SetY($y);  //Reset the write point
        $pdf->SetX($x+160);	
		
		$pos = strpos($runningValue,'-');
		if($pos!== false){
		   
		   $pdf->MultiCell(30, 8,"(". number_format($runningValue, 2, '.', ',').") " ,0,'R',true);
	
		}else{
			$pdf->MultiCell(30, 8, number_format($runningValue, 2, '.', ',')." " ,0,'R',true);
		
		}
		// if($i==0) {
		
		// $this->Footer();
		// }
		
		
		// end of grid code

		//$this->Footer();
		//
		// $pdf->SetY($y-15);
        // Arial italic 8
        // $pdf->SetFont('Arial', 'I', 8);
        // Text color in gray
        // $pdf->SetTextColor(128);
        // Page number
        // $pdf->Cell(50, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'L');
        //  $pdf->Cell(0, 10, 'Date ' . date('d-M-Y'), 0, 0, 'R');
		//
		$temp = WWW_ROOT.'upload-files-for-cbc-mdc/'.$vc_cust_no.'.pdf';

		//output the file into the local folder
		$pdf->Output($temp, 'F');

	
}
	 
	 
	 
    
  
  

// end of function

    

// end of user login function
    //$this->dbConnect($cbc);
   
   public function cbc_newcronscustomerstatementspdf() {
        set_time_limit(0);
        Configure::write('debug', 2);
        $this->loadModel('Customer');
        $this->loadModel('EntryExitMasterView');

        $customersEmailID = $this->Customer->find('all', array(
            'fields' => array('Customer.vc_first_name', 'Customer.vc_surname',
                'Customer.ch_active',
                'Customer.vc_mobile_no',
                'Customer.vc_alter_email',
                'Customer.vc_remarks',
                'Customer.nu_cust_vehicle_card_id',
                'Customer.statement_cycle',
                'Customer.statement_date',
                'Customer.dt_created',
                'Customer.vc_comp_code',
                'Customer.ch_email_flag',
                'Customer.vc_cust_no',
                'Customer.vc_email'),
            'conditions' => array(
                'OR' => array(
                    array('Customer.ch_active' => 'STSTY04')
                    , array('Customer.ch_active' => 'STSTY05')
                )
            ),
            'limit' => 50,
                )
        );

        $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;
            foreach ($customersEmailID as $index => $value) {

                $statement_cycle = $value['Customer']['statement_cycle'];

                if ($statement_cycle == 'M')
                    $noOfdays = 30;

                if ($statement_cycle == 'W')
                    $noOfdays = 7;

                if ($statement_cycle == 'Q')
                    $noOfdays = 120;

                if ($statement_cycle == 'H')
                    $noOfdays = 180;

                if ($statement_cycle == 'A')
                    $noOfdays = 365;


                $statement_date = $value['Customer']['statement_date'];
                $dt_created = $value['Customer']['dt_created'];
                $nu_cust_vehicle_card_id = $value['Customer']['nu_cust_vehicle_card_id'];
                $vc_email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                if ($statement_date != '' && !empty($statement_date))
                    $statement_date_cycle = strtotime("+$noOfdays days", strtotime($statement_date));
                else
                    $statement_date_cycle = strtotime("+$noOfdays days", strtotime($dt_created));

                $nextstatementdueDate = date('Y-m-d H:i:s', $statement_date_cycle);
                $currentdate = date('Y-m-d H:i:s');

                if ($statement_date != '' && !empty($statement_date))
                    $statement_date_to = $statement_date;
                else
                    $statement_date_to = $dt_created;

                // $timedifference
                // diff between curent date and next statement date
                if (strtotime($currentdate) > strtotime($nextstatementdueDate)) {
              

                    $customer = $this->Customer->find('first', array('conditions'=>array('Customer.vc_cust_no' => $vc_cust_no)));
                    
                    $fromDate      = date('Y-m-d H:i:s', strtotime($statement_date_to));
                    //$fromDate = '2013-01-02 23:59:59'; 
                    $toDate        = $currentdate;
                    //$toDate   = '2013-12-05 23:59:59'; 

                    $vc_first_name = $customer['Customer']['vc_first_name'];
                    $vc_surname    = $customer['Customer']['vc_surname'];
					$customerdata  = $customer['Customer'];

                     $customername = $vc_first_name . ' ' . $vc_surname;
					 $num=1;
					 $this->cbc_testpdf($vc_cust_no,$fromDate,$toDate);
					//  $this->cbc_customerstatements_pdf($vc_cust_no,$statement_date_to,$currentdate,$num) ;
					// $num=2;
					 //$this->cbc_customerstatements_pdf($vc_cust_no,$statement_date_to,$currentdate,$num) ;
					
                }
            } // end of for each eamilids
            // pdf code ends here				

            $fromDate = date('d-M-Y', strtotime($fromDate));
            $toDate = date('d-M-Y', strtotime($toDate));
           
        }  // end of if of size of emailids
    } // end of new pdf customer statement function
	
    public function cbc_cronscustomerstatementspdf() {
        set_time_limit(0);
        Configure::write('debug', 2);
        $this->loadModel('Customer');
        $this->loadModel('EntryExitMasterView');

        $customersEmailID = $this->Customer->find('all', array(
            'fields' => array('Customer.vc_first_name', 'Customer.vc_surname',
                'Customer.ch_active',
                'Customer.vc_mobile_no',
                'Customer.vc_alter_email',
                'Customer.vc_remarks',
                'Customer.nu_cust_vehicle_card_id',
                'Customer.statement_cycle',
                'Customer.statement_date',
                'Customer.dt_created',
                'Customer.vc_comp_code',
                'Customer.ch_email_flag',
                'Customer.vc_cust_no',
                'Customer.vc_email'),
            'conditions' => array(
                'OR' => array(
                    array('Customer.ch_active' => 'STSTY04')
                    , array('Customer.ch_active' => 'STSTY05')
                )
            ),
            'limit' => 50,
                )
        );

        $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $statement_cycle = $value['Customer']['statement_cycle'];

                if ($statement_cycle == 'M')
                    $noOfdays = 30;

                if ($statement_cycle == 'W')
                    $noOfdays = 7;

                if ($statement_cycle == 'Q')
                    $noOfdays = 120;

                if ($statement_cycle == 'H')
                    $noOfdays = 180;

                if ($statement_cycle == 'A')
                    $noOfdays = 365;


                $statement_date = $value['Customer']['statement_date'];
                $dt_created = $value['Customer']['dt_created'];
                $nu_cust_vehicle_card_id = $value['Customer']['nu_cust_vehicle_card_id'];
                $vc_email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                if ($statement_date != '' && !empty($statement_date))
                    $statement_date_cycle = strtotime("+$noOfdays days", strtotime($statement_date));
                else
                    $statement_date_cycle = strtotime("+$noOfdays days", strtotime($dt_created));

                $nextstatementdueDate = date('Y-m-d H:i:s', $statement_date_cycle);
                $currentdate = date('Y-m-d H:i:s');

                if ($statement_date != '' && !empty($statement_date))
                    $statement_date_to = $statement_date;
                else
                    $statement_date_to = $dt_created;

                // $timedifference
                // diff between curent date and next statement date
                if (strtotime($currentdate) > strtotime($nextstatementdueDate)) {

                    $this->layout = 'pdf';

                    $crons = 1;
                    App:: import('Controller', 'Cbcreports');
                    $Cbcreports = new CbcreportsController();
                    $this->set('crons', $crons);

                    $customer = $this->Customer->find('first', array('conditions'
                        => array('Customer.vc_cust_no' => $vc_cust_no)));
                    $this->set('customer', $customer);

                    $fromDate = date('Y-m-d H:i:s', strtotime($statement_date_to));
                    //$fromDate = '2013-01-02 23:59:59'; 
                    $toDate = $currentdate;
                    //$toDate   = '2013-12-05 23:59:59'; 

                    $vc_first_name = $customer['Customer']['vc_first_name'];
                    $vc_surname = $customer['Customer']['vc_surname'];

                    $customername = $vc_first_name . ' ' . $vc_surname;
                    $this->set('customername', $customername);
                    $openingbalance = $Cbcreports->cbc_openingbalance($vc_cust_no, $fromDate);

                    if (isset($openingbalance) && $openingbalance > 0)
                        $this->set('funcopeningbalance', $openingbalance);
                    else
                        $this->set('funcopeningbalance', 0);

                    $this->set('customer', $customer);
                    $this->set('SearchfromDate', date('d-m-Y', strtotime($fromDate)));
                    $this->set('SearchtoDate', date('d-m-Y', strtotime($toDate)));

                    /////////=====For account recharge using account_recharge table 

                    $query = '';


                    // Online account recharge using account_recharge_cbc table DT_PAYMENT_DATE between

                    $joins = array();
                    $conditions = array();
                    $conditions = array(
                        'AccountRecharge.nu_amount >' => 0,
                        "AccountRecharge.vc_cust_no='$vc_cust_no'",
                        'AccountRecharge.vc_recharge_status >= ' => 'STSTY04',
                        'AccountRecharge.dt_payment_date IS NOT NULL',
                    );

                    if (isset($fromDate) && $fromDate != '') :

                        $conditions += array(
                            'AccountRecharge.dt_ref_date >= ' => $fromDate,
                        );

                    endif;

                    if (isset($toDate) && $toDate != '') :

                        $conditions += array(
                            'AccountRecharge.dt_ref_date <=' => $toDate,
                        );

                    endif;

                    //AccountRecharge.ch_tran_type=\'23\' THEN \'1\' ELSE \'Recharge\'                 END  as
                    $query .= $Cbcreports->accountRecharge($conditions, $vc_cust_no);

                    $sumrecharge = $this->AccountRecharge->find('all', array('conditions' => $conditions,
                        'fields' => array('SUM(AccountRecharge.nu_amount) as sumRecharge'),
                    ));
                    $TotalsumRecharge = $sumrecharge[0][0]['sumRecharge'];

                    $Noofrecharge = $this->AccountRecharge->find('count', array('conditions' => $conditions,
                            //'fields' => array('AccountRecharge.nu_amount_un')
                    ));

                    $conditions = '';
                    $this->set('TotalsumRecharge', $TotalsumRecharge);
                    $this->set('Noofrecharge', $Noofrecharge);

                    $query .= ' UNION ';

                    //////// ===When User GOES IN CBC Case =============////////////////


                    $conditions = array();
                    $conditions = array(
                        'EntryExitMasterView.nu_cbc_entry_amount >' => 0,
                        "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
                        //'EntryExitMasterView.vc_cust_no' => $vc_cust_no,
                        "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR EntryExitMasterView.ch_cancel_flg IS NULL )",
                        'EntryExitMasterView.dt_entry_date IS NOT NULL',
                        'OR' => array(
                            'EntryExitMasterView.vc_payment_mode' => 'CARD',
                            'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
                        ),
                    );

                    if (isset($fromDate) && $fromDate != '') :

                        $conditions += array(
                            'EntryExitMasterView.dt_entry_date >=' => $fromDate,
                        );
                    endif;

                    if (isset($toDate) && $toDate != '') :

                        $conditions += array(
                            'EntryExitMasterView.dt_entry_date <=' => $toDate,
                        );
                    endif;


                    $query .= $Cbcreports->inEntryExit($conditions, $vc_cust_no);

                    $sumCBCamt = $this->EntryExitMasterView->find('all', array(
                        'fields' => array('SUM(EntryExitMasterView.nu_cbc_entry_amount) as totalcbcamt'),
                        'conditions' => $conditions,
                    ));

                    $totalcbcamt = $sumCBCamt[0][0]['totalcbcamt'];

                    if (count($sumCBCamt) > 0) {
                        $this->set('totalcbcamt', $totalcbcamt);
                    } else {
                        $this->set('totalcbcamt', 0);
                    }


                    // ======When  USER goes  OUTSIDE case===================== //
                    //        and d.dt_exit_date between nvl(:from_date, d.dt_exit_date) and nvl(:to_date, d.dt_exit_date)


                    $query .= ' UNION ';

                    $joins = array();

                    $conditions = array();

                    $conditions = array(
                        'EntryExitMasterView.nu_mdc_paid_amount >' => 0,
                        "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
                        "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR EntryExitMasterView.ch_cancel_flg IS NULL )",
                        'EntryExitMasterView.dt_exit_date IS NOT NULL',
                        'OR' => array(
                            'EntryExitMasterView.vc_payment_mode' => 'CARD',
                            'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
                        ),
                    );

                    if (isset($fromDate) && $fromDate != '') :

                        $conditions += array(
                            'EntryExitMasterView.dt_exit_date >=' => $fromDate,
                        );
                    endif;

                    if (isset($toDate) && $toDate != '') :

                        $conditions += array(
                            'EntryExitMasterView.dt_exit_date <=' => $toDate,
                        );
                    endif;


                    $query .= $Cbcreports->outEntryExit($conditions, $vc_cust_no);
                    $sumMDcamt = $this->EntryExitMasterView->find('all', array(
                        'fields' => array('SUM(EntryExitMasterView.nu_mdc_paid_amount) as totalmdcamt'),
                        'conditions' => $conditions));

                    $totalmdcamt = $sumMDcamt[0][0]['totalmdcamt'];
                    $this->set('totalmdcamt', $totalmdcamt);



                    /* === For User card issue using     dt_cust_card_cbc ====== */

                    $joins = array();
                    $conditions = array();

                    $conditions = array(
                        "CustomerCard.vc_cust_no='$vc_cust_no'",
                        'CustomerCard.dt_mod_date IS NOT NULL'
                    );

                    if (isset($fromDate) && $fromDate != '') :

                        $conditions += array(
                            'CustomerCard.dt_issue_date >=' => $fromDate,
                        );
                    endif;

                    if (isset($toDate) && $toDate != '') :

                        $conditions += array(
                            'CustomerCard.dt_issue_date <=' => $toDate,
                        );
                    endif;

                    // total card issued
                    $Totalcardsdatewise = $this->CustomerCard->find('all', array('conditions' => $conditions,
                        'fields' => array('CustomerCard.vc_card_no', 'CustomerCard.dt_mod_date'),
                        'order' => array('CustomerCard.dt_mod_date asc'),
                    ));


                    //$i = 0;
                    $sumofcardsIssued = '';
                    $sumofcardsIssued = sizeof($Totalcardsdatewise);

                    if ($sumofcardsIssued > 0)
                        $this->set('sumofcardsIssued', $sumofcardsIssued);
                    else
                        $this->set('sumofcardsIssued', 0);

                    ///====For Cbc or mdc permit  refund  using CBC_MDC_REFUND_CBC table and DT_REFUND_DATE between :from_date and :to_date


                    $query .= ' UNION ';

                    $conditions = array();
                    $conditions = array(
                        'CardRefund.nu_approved_amt >' => 0,
                        "CardRefund.vc_cust_no='$vc_cust_no'",
                        'CardRefund.dt_refund_date IS NOT NULL ',
                        'CardRefund.vc_status' => 'STSTY04',
                    );

                    if (isset($fromDate) && $fromDate != '') :
                        $conditions += array(
                            'CardRefund.dt_refund_date >=' => $fromDate,
                        );
                    endif;

                    if (isset($toDate) && $toDate != '') :

                        $conditions += array(
                            'CardRefund.dt_refund_date <=' => $toDate,
                        );
                    endif;

                    $query .= $Cbcreports->cbcMdcRefund($conditions, $vc_cust_no);

                    $sumrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
                        'fields' => array('SUM(CardRefund.nu_approved_amt) as sumrefund'),
                    ));

                    $TotalsumRefund = $sumrefund[0][0]['sumrefund'];
                    $this->set('TotalsumRefund', $TotalsumRefund);

                    $NoOfrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
                        'fields' => array('CardRefund.nu_approved_amt'),
                    ));

                    $this->set('NoOfrefund', sizeof($NoOfrefund));

                    $conditions = '';

                    /////////////////=======card issued datewise=======///////////////

                    $query .= ' UNION ';

                    $joins = array();

                    $conditions = array();
                    $conditions = array(
                        "CustomerCard.vc_cust_no='$vc_cust_no'",
                        'CustomerCard.dt_mod_date IS NOT NULL',
                    );
                    if (isset($fromDate) && !empty($fromDate)) :

                        $conditions += array(
                            'CustomerCard.dt_mod_date >=' => $fromDate,
                        );
                    endif;

                    if (isset($toDate) && !empty($toDate)):

                        $conditions += array(
                            'CustomerCard.dt_mod_date <=' => $toDate,
                        );
                    endif;

                    $query .= $Cbcreports->cardIssued($conditions, $vc_cust_no);

                    $storeallValues = $this->AccountRecharge->find('all', array(
                        'fields' => array('Temp.transaction_type,
				Temp.Transaction_Date,
				Temp.CardNo,
				Temp.Permit_RefNo,
				Temp.Remarks,
				Temp.Issue_Ref_Date,
				Temp.VehicleRegNo,
				Temp.NetAmount,
				Temp.Running'),
                        'joins' => array(
                            array(
                                'table' => "($query)",
                                'alias' => 'Temp',
                                'type' => 'right',
                                'conditions' => array('AccountRecharge.vc_voucher_no = \'*noopapapapappapapapapappapapapapappapapapapapp*\'')
                            )
                        ),
                        'conditions' => array("1=1"),
                        'order' => array('Temp.Transaction_Date' => 'asc', 'Temp.transaction_type' => 'desc'),
                    ));

                    $this->set('storeallValues', $storeallValues);

                    //   For Opening Balance 
                    //   $this->openingBalance($previousDate);

                    $this->set('report', $report);
                    $this->set('fromDate', $fromDate);
                    $this->set('toDate', $toDate);
                    $this->set('totalrows', count($storeallValues));
                    $this->layout = 'pdf';
                }
            } // end of for each eamilids
            // pdf code ends here				

            $fromDate = date('d-M-Y', strtotime($fromDate));
            $toDate = date('d-M-Y', strtotime($toDate));
            foreach ($customersEmailID as $index => $value) {

                $statement_cycle = $value['Customer']['statement_cycle'];

                if ($statement_cycle == 'M')
                    $noOfdays = 30;

                if ($statement_cycle == 'W')
                    $noOfdays = 7;

                if ($statement_cycle == 'Q')
                    $noOfdays = 120;

                if ($statement_cycle == 'H')
                    $noOfdays = 180;

                if ($statement_cycle == 'A')
                    $noOfdays = 365;


                $statement_date = $value['Customer']['statement_date'];
                $dt_created = $value['Customer']['dt_created'];
                $nu_cust_vehicle_card_id = $value['Customer']['nu_cust_vehicle_card_id'];
                $vc_email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                if ($statement_date != '' && !empty($statement_date))
                    $statement_date_cycle = strtotime("+$noOfdays days", strtotime($statement_date));
                else
                    $statement_date_cycle = strtotime("+$noOfdays days", strtotime($dt_created));

                $nextstatementdueDate = date('Y-m-d H:i:s', $statement_date_cycle);
                $currentdate = date('Y-m-d H:i:s');

                if ($statement_date != '' && !empty($statement_date))
                    $statement_date_to = $statement_date;
                else
                    $statement_date_to = $dt_created;

                // $timedifference
                // diff between curent date and next statement date
                if (strtotime($currentdate) > strtotime($nextstatementdueDate)) {

                    if (file_exists(WWW_ROOT . 'upload-files-for-cbc-mdc/' . trim($vc_cust_no) . '-CustomerStatement-Report.pdf')) {

                        /*  * ***Email Shoot to Customer***************** */

                        list($selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        //$this->Email->to = trim($vc_email);
                        $this->Email->to = 'rishi.kapoor@essindia.co.in';

                        $this->Email->subject = strtoupper($selectedType) . " Customer Statement report ";
                          sleep(20);
                        $this->Email->attachments = array("$vc_cust_no-CustomerStatement-Report.pdf" =>
                            WWW_ROOT . 'upload-files-for-cbc-mdc/' . trim($vc_cust_no) . '-CustomerStatement-Report.pdf');


                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname)));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Please find the transactions between  $fromDate and  $toDate .";

                        $mesage .= '<br/> Customer No. : ' . trim($vc_cust_no);

                      //  $customerEmailStatus = $this->Email->send($mesage);

                        $mesage = '';
                        /* ======End of email shoot for customer ============= */

                        $this->Email->reset();

                        /*                         * ****************Email Send To Admin************************** */

                        if ($customerEmailStatus == true) {

                            $this->Customer->create();
                            $data['statement_date'] = date('Y-m-d');
                            $this->Customer->id = $nu_cust_vehicle_card_id;
                            $this->Customer->set($data);
                            $this->Customer->save($data, false);
                        }


                        /*                         * ******************** End Email********************** */
                    }
                }
            }     // foreach for customerrmailids
        }  // end of if of size of emailids
    }
	
	function accountRecharge($conditions=array(),$vc_cust_no=null){
	

	$dbo = $this->AccountRecharge->getDataSource();
	$subQuery = $dbo->buildStatement(
	array(
	'fields' => array(' \'Recharge\'   as   transaction_type,
					AccountRecharge.dt_payment_date AS Transaction_Date,
					AccountRecharge.vc_ref_no AS Permit_RefNo,					
					AccountRecharge.dt_ref_date AS Issue_Ref_Date,					
					AccountRecharge.vc_reason AS Remarks,
					AccountRecharge.vc_voucher_no  as CardNo ,
					AccountRecharge.vc_recharge_status  AS  VehicleRegNo,
					case  when AccountRecharge.nu_amount = 0   THEN 0  
					ELSE AccountRecharge.nu_amount  END AS NetAmount,
					AccountRecharge.nu_hand_charge AS Running'),
	 'table' => 'ACCOUNT_RECHARGE_CBC',
	 'alias' => 'AccountRecharge',
	 'conditions' => $conditions,
	 ), $this->ACCOUNT_RECHARGE_CBC
	);
	return $subQuery;
 

}

function cbcMdcRefund($conditions=array(),$vc_cust_no=null){
	$this->loadModel('CardRefund');
	$dbo = $this->CardRefund->getDataSource();
	$subQuery = $dbo->buildStatement(
	//case  when   CardRefund.ch_tran_type=\'23\' THEN \'1\' ELSE \'Refund\' END as transaction_type
	array(
	'fields' => array('	\'Refund\' as transaction_type,
							CardRefund.dt_refund_date AS Transaction_Date,
							CardRefund.vc_permit_no AS Permit_RefNo,
							CardRefund.dt_entry_date AS Issue_Ref_Date,
							CardRefund.vc_reason AS Remarks,
							CardRefund.vc_voucher_no AS CardNo,
							CardRefund.vc_status AS  VehicleRegNo,
							CardRefund.nu_approved_amt AS NetAmount,
							CardRefund.nu_approved_amt AS Running'),
	 'table' => 'CBC_MDC_REFUND_CBC',
	 'alias' => 'CardRefund',
	 'conditions' => $conditions,
	 ), $this->CBC_MDC_REFUND_CBC
	);
	return 	 $subQuery;

}


function cardIssued($conditions=array(),$vc_cust_no=null){

	$this->loadModel('CustomerCard');
		  $dbo      = $this->CustomerCard->getDataSource();
          $subQuery = $dbo->buildStatement(
					  array(
						'fields' => array('
						\'CardsIssued\' as transaction_type,
                        CustomerCard.dt_issue_date AS Transaction_Date,
                         \'NA\' AS Permit_RefNo,
                        CustomerCard.dt_issue_date AS Issue_Ref_Date,
                        \'Card issue charge\' AS Remarks,
                        CustomerCard.vc_card_no  AS CardNo,
                        \'NA\' AS  VehicleRegNo,
                        NULL AS NetAmount,
                        1 AS Running'), 
						'table' => 'DT_CUST_CARD_CBC', 
						'alias' => 'CustomerCard', 
						'conditions' =>$conditions ,
					   // 'group' => array('CustomerCard.dt_mod_date'),
                    ), $this->DT_CUST_CARD_CBC
            );


return $subQuery ;
}

function inEntryExit($conditions=array(),$vc_cust_no=null){
	$this->loadModel('EntryExitMasterView');
	$dbo = $this->EntryExitMasterView->getDataSource();
	$subQuery = $dbo->buildStatement(
	array(
	'fields' => array(' \'CBC\' as transaction_type,
							EntryExitMasterView.dt_entry_date AS Transaction_Date,
							EntryExitMasterView.vc_permit_cbc AS Permit_RefNo,
							EntryExitMasterView.dt_entry_date AS Issue_Ref_Date,
							EntryExitMasterView.vc_reason AS Remarks,
							EntryExitMasterView.vc_card_no AS CardNo,
							EntryExitMasterView.vc_reg_no AS  VehicleRegNo,
							EntryExitMasterView.nu_cbc_entry_amount AS NetAmount,
							EntryExitMasterView.nu_cbc_entry_amount AS Running'),
	 'table' => 'vw_hd_entry_exit',
	 'alias' => 'EntryExitMasterView',	 
     'conditions' =>$conditions ,
	 
	 

	), $this->vw_hd_entry_exit
	);

	return $subQuery;
}

function outEntryExit($conditions=array(),$vc_cust_no=null){
	$this->loadModel('EntryExitMasterView');

	$dbo = $this->EntryExitMasterView->getDataSource();
	$subQuery = $dbo->buildStatement(
	array('fields' => array(' \'MDC\' as transaction_type,
							EntryExitMasterView.dt_exit_date AS Transaction_Date,
							EntryExitMasterView.vc_permit_mdc AS Permit_RefNo,
							EntryExitMasterView.dt_exit_date AS Issue_Ref_Date,
							EntryExitMasterView.vc_reason AS Remarks,
							EntryExitMasterView.vc_card_no AS CardNo,
							EntryExitMasterView.vc_reg_no AS  VehicleRegNo,
							EntryExitMasterView.nu_mdc_paid_amount AS NetAmount,
							EntryExitMasterView.nu_mdc_amount AS Running'),
	 'table' => 'vw_hd_entry_exit',
	 'alias' => 'EntryExitMasterView',
     'conditions' =>$conditions ,
	 
	 ), $this->vw_hd_entry_exit
	);

	return $subQuery;
}


}

// end of class
?>
