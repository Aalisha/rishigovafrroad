<?php

App::import('Sanitize');

/**
 *
 *
 */
class CbcreportsController extends AppController {

/**
 *
 *
 */
var $name = 'Cbcreports';

/**
 *
 *
 */
var $components = array('Session', 'Auth', 'RequestHandler', 'Email','Cbcreportpdfcreator');

/**
 *
 *
 */
var $helpers = array('Session', 'Html', 'Form');

/**
 *
 *
 */
var $uses = array('Customer', 'AccountRecharge', 'AddVehicle', 'Member','CardRefund', 'CustomerCard','EntryExitMasterView');
//var $uses = array('Customer', 'AccountRecharge', 'AddVehicle', 'Member','CardRefund', 'CustomerCard');

/**
 *
 *
 */
	function beforeFilter() {

		parent::beforeFilter();
		$currentUser = $this->checkUser();

		if (!$currentUser) {

		$this->Session->setFlash('You are not authorized to access that location');

		$this->redirect($this->Auth->logout());

		}

		if( $this->isInspector ) {

		$this->redirect(array('controller' => 'inspectors', 'action' => 'index'));

		}

         $this->layout = 'cbc_layout';
		
		$customername=$this->Session->read('Auth.Customer.vc_first_name').' '.$this->Session->read('Auth.Customer.vc_surname');
			
		$this->set('customername',$customername);
		
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
		$ch_active = $this->Session->read('Auth.Customer.ch_active');
		$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
		$vc_username = $this->Session->read('Auth.Member.vc_username');
		
		if($vc_username!='' && $ch_active=='STSTY04')	
		$this->Auth->allow('cbc_customerrecharge','cbc_customer_recharge_pdf',		'cbc_getrechargeremarksbyid','cbc_customerstatements','cbc_customerstatements_pdf',
		'cbc_vehicleslist','cbc_vehicleslist_pdf');
		
		/*	
		accountrecharge , cbcmdcrefund , cardissued ,inentryexit ,outentryexit ,setbranchcode ,	getadmindetail,checkuser , getrfatypedetail , unsetvalidatevariable,		getmdcnavigationheader , getcbcnavigationheader , inspectorheadernavigation,
		in_array_recursive , getflrheadernavigation , renameuploadfile		
		*/
		$this->loginRightCheck();
}


function loginRightCheck() {
		
        if ($this->loggedIn && !in_array($this->action, $this->Auth->allowedActions)) {

             $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        }
    }
/**
 *
 * Function for customer recharge report
 *
 */
 
	public function cbc_customerrecharge() {
		ini_set('memory_limit','5048M');
		set_time_limit(0);
		$this->layout = 'cbc_layout';		
		 

		$customername = $this->Session->read('Auth.Customer.vc_first_name').' '.$this->Session->read('Auth.Customer.vc_surname');

		$this->set('customername', $customername);

		$this->loadModel('AccountRecharge');
		

		$no_of_rows = 10;

		if (isset($this->params['named']['fromDate'])) :

			$fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

		else :

			$fromDate = isset($this->data['Cbcreport']['fromdate'])
			&&!empty($this->data['Cbcreport']['fromdate']) ?
			date('d-M-Y', strtotime($this->data['Cbcreport']['fromdate'])) :'';

		endif;

		if (isset($this->params['named']['toDate'])) :

			$toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));

		else :

			$toDate = isset($this->data['Cbcreport']['todate'])
			&&!empty($this->data['Cbcreport']['todate']) ?
			date('d-M-Y', strtotime($this->data['Cbcreport']['todate'])) :'';

		endif;

		if (isset($this->params['named']['page'])) :

			$pageno = trim($this->params['named']['page']);

		else :

			$pageno = 1;

		endif;

			$start = ((($pageno-1) * $no_of_rows) + 1);

			$this->set('start', $start);

			$conditions = array('AccountRecharge.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'));

		if ($fromDate) :

			$conditions += array(
			'AccountRecharge.dt_entry_date >=' => $fromDate,
			);
			
		endif;

		if ($toDate) :

			$conditions += array(
			'AccountRecharge.dt_entry_date <=' => $toDate,
			);
			
		endif;
			$this->paginate = array('conditions' => $conditions,
			 'order' => array('AccountRecharge.dt_entry_date' => 'desc'),
			 'limit' => $no_of_rows
			);
			$report = $this->paginate('AccountRecharge');
			//pr($report);


			$this->set('vc_customer_name', $this->Session->read('Auth.Customer.vc_first_name').' '.$this->Session->read('Auth.Customer.vc_surname'));

			$this->set('report', $report);
			 

			$this->set('SearchfromDate', $fromDate);

			$this->set('SearchtoDate', $toDate);
	}

 /**
 *
 * Function to generate pdf for customer recharge report
 *
 */
 
	public function cbc_customer_recharge_pdf() {
				Configure::write('debug',0);
	try {
		
			ini_set('memory_limit','5048M');
			set_time_limit(0);
	    	$this->loadModel('AccountRecharge');

		if (isset($this->params['named']['fromDate'])) :

			$fromDate = date('d-M-Y', strtotime($this->params['named']['fromdate']));

		else :

			$fromDate = isset($this->data['Cbcreport']['fromdate'])
			&&!empty($this->data['Cbcreport']['fromdate']) ?
			date('d-M-Y', strtotime($this->data['Cbcreport']['fromdate'])) :'';
			
		endif;


		if (isset($this->params['named']['toDate'])) :

			$toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));

		else :

			$toDate = isset($this->data['Cbcreport']['todate'])
			&&!empty($this->data['Cbcreport']['todate']) ?
			date('d-M-Y', strtotime($this->data['Cbcreport']['todate'])) :'';

		endif;
		
		$conditions = array('AccountRecharge.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'));
		
		if ($fromDate) :

			$conditions += array(
			'AccountRecharge.dt_entry_date >=' => $fromDate,
			);
			
		endif;

		if ($toDate) :

			$conditions += array(
			'AccountRecharge.dt_entry_date <=' => $toDate,
			);
			
		endif;
		

			$report = $this->AccountRecharge->find('all', array(
				'conditions' => $conditions,
				'order' => array('AccountRecharge.dt_entry_date' => 'desc')));

			$this->set('customername', $this->Session->read('Auth.Customer.vc_first_name').' '.$this->Session->read('Auth.Customer.vc_surname'));

			$this->set('report', $report);

			$this->set('fromDate', $fromDate);

			$this->set('toDate', $toDate);
			
			$columnsValues= array('SI.NO.',"Recharge Date",
			'Cheque/Bank Ref.No.','Cheque/Bank Ref. Date',
			'Recharge Amount (N$)','Approved Amount (N$)',
			'Admin Fee (N$)','Net Amount (N$)',
			'Recharge Status','Reason');
			
			$this->Cbcreportpdfcreator->headerData('Customer Recharge Report', $period = NULL,$this->Session->read('Auth'),'',$toDate,$fromDate) ;
			
			//pr($report);
			//die;
			//$this->Cbcreportpdfcreator->LineItems($columnsValues,$report,
			//$this->globalParameterarray,$this->Session->read('Auth.Customer'),$toDate,$fromDate);
			
			$this->Cbcreportpdfcreator->genrate_cbc_customerrechargepdf($columnsValues,$report,$this->globalParameterarray,$this->Session->read('Auth.Customer'),$toDate,$fromDate);
			
			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
			
            $this->Cbcreportpdfcreator->output($vc_cust_no.'-Customer-Recharge-Report'.'.pdf', 'D');

            die;

			$this->layout = 'pdf';

		} 
		
		catch (Exception $e) {

			echo 'Caught exception: ', $e->getMessage(), "\n";

			exit;
		}
	}
	
	/*
	*
	*
	*
	*/
	
	function cbc_getrechargeremarksbyid(){

		Configure::write('debug', 0);
		
		$this->layout = null;
		
		if( $this->params['isAjax'] && isset($this->params['data']) ):
			
			$data = $this->AccountRecharge->find('first', array('conditions'=>array(
													'AccountRecharge.nu_acct_rec_id'=>base64_decode(trim($this->params['data']))
											)));
				
		else :
		
			$data  = array();	
				
		endif;

		$this->set('data', $data);	
	}

	/**
	 *
	 * Function for Opening balance 
	 *
	 */
	public  function cbc_openingbalance($vc_cust_no=null,$fromdate=null){
			
			
			$this->loadModel('AccountRecharge');
				
			//$vc_cust_no='040000128636';
			$fromdate = date('d-M-y',strtotime($fromdate));
			
			$openingbalanceValue = $this->AccountRecharge->query("SELECT cf_cust_op_bal('$vc_cust_no', to_date('$fromdate', 'DD-MM-RRRR')) FROM DUAL");
			
			//pr($openingbalanceValue[0][0]["cf_cust_op_bal('".$vc_cust_no."'"]);
			return $openingbalanceValue[0][0]["cf_cust_op_bal('".$vc_cust_no."'"];
	
	}


	
/**
 *
 * Function for customer statement report
 *
 */
public function cbc_customerstatements() {
	
	//Configure::write('debug',2);
	ini_set('memory_limit','5048M');
	set_time_limit(0);
	
	
	$this->layout = 'cbc_layout';
	
	$no_of_rows   = 5;	

	$vc_cust_no   = $this->Session->read('Auth.Customer.vc_cust_no');
	
	$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');

	$vc_user_no   = $this->Session->read('Auth.Customer.vc_user_no');

	$vc_email_id  = $this->Session->read('Auth.Customer.vc_email');

	$customer     = $this->Customer->find('first', array('conditions'=> array('Customer.vc_cust_no'=> $vc_cust_no)));
	
	
	if (isset($this->params['named']['vc_from_date'])) :

	$fromDate = date('Y-m-d H:i:s', strtotime($this->params['named']['vc_from_date']));

	else :

	$fromDate = (isset($this->data['Customer']['vc_from_date']) && !empty($this->data['Customer']['vc_from_date'])) ?
	date('Y-m-d H:i:s', strtotime($this->data['Customer']['vc_from_date'])) : '';

	endif;

	if (isset($this->params['named']['vc_to_date'])) :

	$toDate = date('Y-m-d 23:59:59', strtotime($this->params['named']['vc_to_date']));

	else :

	$toDate = (isset($this->data['Customer']['vc_to_date']) &&
	!empty($this->data['Customer']['vc_to_date']))? date('Y-m-d 23:59:59', strtotime($this->data['Customer']['vc_to_date'])) : '';

	endif; 

	$pagecounter = (!empty($this->params['named']['page']) && $this->params['named']['page'] > 1)?$this->params['named']['page'] : 1;

	$this->set('pagecounter', $pagecounter);
	$this->set('limit',$no_of_rows);
	$this->set('customer', $customer);
	$this->set('SearchfromDate', $fromDate);
	$this->set('SearchtoDate', $toDate);
	$subQuery = '';


	$query = '';
	if($fromDate!='' && $toDate!='') {

	if (isset($vc_cust_no) && $vc_cust_no != '') {

	//// =====For CBC or MDC refund  using CBC_MDC_REFUND_CBC table and DT_REFUND_DATE between //:from_date and :to_date

	$conditions = array();
	$conditions = array(
	'CardRefund.nu_approved_amt >'=>0,
	"CardRefund.vc_cust_no='$vc_cust_no'",
	  'CardRefund.vc_status'=>'STSTY04',
	 'CardRefund.dt_refund_date IS NOT NULL ',
	 
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

	//$query='';

    $query .= $this->cbcMdcRefund($conditions,$vc_cust_no);
//	$query .= $subQuery;
	//pr($query);

	$sumrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
	 'fields' => array('SUM(CardRefund.nu_approved_amt) as sumrefund'),
	));

	$TotalsumRefund = $sumrefund[0][0]['sumrefund'];
	$this->set('TotalsumRefund', $TotalsumRefund);

	$NoOfrefund = $this->CardRefund->find('all', array('conditions' => $conditions,
	 'fields' => array('CardRefund.nu_approved_amt'),
	));
	$conditions='';

	$this->set('NoOfrefund', sizeof($NoOfrefund));


	////=====For account recharge using account_recharge_cbc table 
	
	$query .= ' UNION ';
	
	//DT_PAYMENT_DATE between
	$joins = array();
	$conditions = array();
	$conditions = array(
	'AccountRecharge.nu_amount >'=>0,
	"AccountRecharge.vc_cust_no='$vc_cust_no'",
	//'AccountRecharge.vc_cust_no' => $vc_cust_no,
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
	
	$query .=  $this->accountRecharge($conditions,$vc_cust_no);

	$sumrecharge = $this->AccountRecharge->find('all', array('conditions' => $conditions,
	 'fields' => array('SUM(AccountRecharge.nu_amount) as sumRecharge'),
	));
	 $TotalsumRecharge = $sumrecharge[0][0]['sumRecharge'];

	$Noofrecharge = $this->AccountRecharge->find('count', array('conditions' => $conditions,
	 //'fields' => array('AccountRecharge.nu_amount_un')
	));

	$this->set('TotalsumRecharge', $TotalsumRecharge);
	$this->set('Noofrecharge', $Noofrecharge);

	
	//////// ===When User GOES IN CBC Case =============////////////////

	$query .= ' UNION ';
	
	$conditions = array();
	$conditions = array(
	 'EntryExitMasterView.nu_cbc_entry_amount >'=>0,
	 "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
	 "(EntryExitMasterView.ch_cancel_flg!= 'Y' OR EntryExitMasterView.ch_cancel_flg IS NULL )",
	 'EntryExitMasterView.dt_entry_date IS NOT NULL',
	 'OR' => array('EntryExitMasterView.vc_payment_mode' => 'CARD',
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

	if(count($sumCBCamt)>0){
		$totalcbcamt = $sumCBCamt[0][0]['totalcbcamt'];
		$this->set('totalcbcamt', $totalcbcamt);
	}else {
		$this->set('totalcbcamt', 0);
	}

	// ======When  USER goes  OUTSIDE case===================== //
	//        and d.dt_exit_date between nvl(:from_date, d.dt_exit_date) and nvl(:to_date, d.dt_exit_date)


	$query .= ' UNION ';
	
	$conditions = array();	
	$conditions = array(
		'EntryExitMasterView.nu_mdc_paid_amount >'=>0,
		 "EntryExitMasterView.vc_cust_no='$vc_cust_no'",
		"(EntryExitMasterView.ch_cancel_flg!= 'Y' OR EntryExitMasterView.ch_cancel_flg IS NULL )",		 'EntryExitMasterView.dt_exit_date IS NOT NULL',
		 'OR' => array('EntryExitMasterView.vc_payment_mode' =>'CARD',
		              'EntryExitMasterView.vc_mdc_pay_mode' => 'CARD',
		          
	));

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
	'conditions'=>$conditions,
	));

	$totalmdcamt = $sumMDcamt[0][0]['totalmdcamt'];
	
	if($totalmdcamt>0)
	$this->set('totalmdcamt', $totalmdcamt);
	else
	$this->set('totalmdcamt', 0);
	
	
	/* === For User Card Issue using     dt_cust_card_cbc ====== */

	$query .= ' UNION ';
	
	$joins = array();
	$conditions = array();

	$conditions = array(
	"CustomerCard.vc_cust_no='$vc_cust_no'",
	//'CustomerCard.vc_card_flag' => 'STSTY01',
	'CustomerCard.dt_issue_date IS NOT NULL'
	);

	if (isset($fromDate) && $fromDate!='') :

	$conditions += array(
	'CustomerCard.dt_issue_date >='=> $fromDate,
	);
	endif;

	if (isset($toDate) && $toDate!='') :

	$conditions += array(
	'CustomerCard.dt_issue_date <='=> $toDate,
	);
	endif;
	

		
	$query .= $this->cardIssued($conditions,$vc_cust_no);
	
	// total card issued
	$Totalcardsdatewise = $this->CustomerCard->find('all', array('conditions' => $conditions,
	 'fields' => array('CustomerCard.vc_card_no', 'CustomerCard.dt_mod_date'),
	 'order' => array('CustomerCard.dt_mod_date asc' ),
		));
		
		 
	$sumofcardsIssued= sizeof($Totalcardsdatewise);
   
	$i = 0;

	if($sumofcardsIssued>0)
	$this->set('sumofcardsIssued', $sumofcardsIssued);
	else
	$this->set('sumofcardsIssued', 0);


	$joins = array();

	$this->paginate = array(
	'fields' => array('Temp.transaction_type,
                Temp.Transaction_Date,                
                Temp.Permit_RefNo,				
                Temp.Issue_Ref_Date,
                Temp.Remarks,
				Temp.CardNo,
                Temp.VehicleRegNo,
                Temp.NetAmount,
                Temp.Running'),
				'joins' => array(
					array(
					'table' => "($query)",
					'alias' => 'Temp',
					'type' => 'right',
					'conditions' =>
					array('AccountRecharge.vc_voucher_no = \'*noopapabcdefghijklloppqrzz*\'')
					),
				//'order'=>array('Temp.Transaction_Date asc ');
			),
	'conditions' => array("1=1"),
	'order' => array('Temp.Transaction_Date' => 'asc','Temp.transaction_type'=>'desc'),
	'limit' => $no_of_rows
	);

	
	$storeallValues = $this->paginate('AccountRecharge');

	$openingbalance = $this->cbc_openingbalance($vc_cust_no,$fromDate,$toDate,$pagecounter,$no_of_rows,'');
	
	
	if(isset($openingbalance) && $openingbalance!='')
	$this->set('funcopeningbalance', $openingbalance);
	else
	$this->set('funcopeningbalance', 0);
	
	//$openingbalancepaging = '';
	
	//$openingbalancepaging = $this->cbc_openingbalance_page($vc_cust_no,$fromDate,$toDate,$pagecounter,$no_of_rows,'');
	
	if($pagecounter > 1 )
	$this->set('pageopeningbalance', 0);
	else
	$this->set('pageopeningbalance', 0);
	
	$i = 0;
  
   } // if of vc_cust_no

  } // to date and from date


                
	if (isset($storeallValues) && count($storeallValues) > 0)
	$this->set('storeallValues', $storeallValues);
	else
	$this->set('storeallValues', '');
	
	if (isset($storeallValues))
	$this->set('totalrows', count($storeallValues));


}



/**
 *
 * Function to generate pdf for customer statement report
 *
 */
public function cbc_customerstatements_pdf($cronvalue=0,$cronfromdate=null,$crontodate=null,$croncustno=null,$customerdata=array()) {

	Configure::write('debug', 0);
	ini_set('memory_limit','5048M');
	set_time_limit(0);
	
	try {
	
	
    if($cronvalue==0){
	
    
	
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');
		$vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');
		$vc_email_id = $this->Session->read('Auth.Customer.vc_email');
		$customer = $this->Customer->find('first', array('conditions'
		 => array('Customer.vc_cust_no' => $vc_cust_no)));
		$this->set('customer', $customer);	 
		$vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');
	
		if (isset($this->params['named']['fromdate'])) 
		   $fromDate = date('Y-m-d H:i:s', strtotime($this->params['named']['fromdate']));
		else
		   $fromDate = (isset($this->data['Cbcreport']['fromdate']) && !empty($this->data['Cbcreport']['fromdate'])) ? date('Y-m-d H:i:s', strtotime($this->data['Cbcreport']['fromdate'])) : '';


		if (isset($this->params['named']['todate'])) 
		   $toDate = date('Y-m-d 23:59:59', strtotime($this->params['named']['todate']));
		else
		   $toDate = (isset($this->data['Cbcreport']['todate']) &&
		!empty($this->data['Cbcreport']['todate']))? date('Y-m-d 23:59:59', strtotime($this->data['Cbcreport']['todate'])) : '';
		
		$customername = $this->Session->read('Auth.Customer.vc_first_name') . ' ' . $this->Session->read('Auth.Customer.vc_surname');
		
	}else{
	
		//pr($customerdata);die;
	   $vc_cust_no    =  $croncustno;
	   $vc_comp_code  = $customerdata['Customer']['vc_comp_code'];
	   $vc_user_no    = $customerdata['Customer']['vc_user_no'];
	   $vc_email_id   = $customerdata['Customer']['vc_email'];
	   $toDate = date('Y-m-d 23:59:59', strtotime($crontodate));	  
	   $fromDate = date('Y-m-d H:i:s', strtotime($cronfromdate));
	
	}


	$openingbalance = $this->cbc_openingbalance($vc_cust_no,$fromDate,'',1,'','');

	if(isset($openingbalance) && $openingbalance>0 )
	$this->set('funcopeningbalance', $openingbalance);
	else
	$this->set('funcopeningbalance', 0);

	$this->set('customer', $customer);
	$this->set('SearchfromDate', date('d-m-Y', strtotime($fromDate)));
	$this->set('SearchtoDate', date('d-m-Y', strtotime($toDate)));
	$subQuery = '';

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
		'AccountRecharge.vc_recharge_status' => 'STSTY04',
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
	$this->set('TotalsumRecharge', $TotalsumRecharge);
	$this->set('Noofrecharge', $Noofrecharge);

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

	if(count($sumCBCamt)>0){
		$this->set('totalcbcamt', $totalcbcamt);
	}else {
		$this->set('totalcbcamt', 0);
	}


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
	
	if($totalmdcamt>0)
	$this->set('totalmdcamt', $totalmdcamt);
    else
	$this->set('totalmdcamt',0);
    $this->loadModel('CustomerCard');
	//App::import('Model', 'CustomerCard');



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
	 'fields' => array('CustomerCard.vc_card_no','CustomerCard.dt_mod_date'),
	 'order' => array('CustomerCard.dt_mod_date asc'),
	 ));
	

	//$i = 0;
	$sumofcardsIssued = '';
	$sumofcardsIssued= sizeof($Totalcardsdatewise);
	
	if($sumofcardsIssued>0)
	$this->set('sumofcardsIssued', $sumofcardsIssued);
	else
	$this->set('sumofcardsIssued', 0);

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

 $this->set('storeallValues', $storeallValues);

	//pr($storeallValues);
	//die;

//   For Opening Balance 

//   $this->openingBalance($previousDate);



	
	$this->set('customername', $customername);
	$this->set('report', $report);
	$this->set('fromDate', $fromDate);
	$this->set('toDate', $toDate);
	$this->set('totalrows', count($storeallValues));
	
	
			$columnsValues= array('SI.No.','Transaction  Type',
			'Transaction Date','Remarks',
			'Issue/Ref.Date','Card No.',
			'Permit/Ref.No.','Vehicle Reg. No.',
			'Net Amount(N$)','Running Balance(N$)' );
			if($cronvalue==0){
			
			$this->Cbcreportpdfcreator->headerData('Customer Statement Report', $period = NULL,$this->Session->read('Auth'));
			
            $this->Cbcreportpdfcreator->genrate_cbc_customerstatement_pdf($columnsValues,$storeallValues,$this->globalParameterarray,$this->Session->read('Auth'),
			$toDate,$fromDate,$openingbalance,$TotalsumRefund,$totalmdcamt,$totalcbcamt,sizeof($NoOfrefund),$TotalsumRecharge,$Noofrecharge,$sumofcardsIssued,'S');			
			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');			
            //$this->Cbcreportpdfcreator->output($vc_cust_no.'-Customer-statement-Report'.'.pdf', 'D');
			            $this->Cbcreportpdfcreator->output(WWW_ROOT.$vc_cust_no.'-Customer-statement-Report'.'.pdf', 'F');

			
			}else{
			
			$this->Cbcreportpdfcreator->headerData('Customer Statement Report', $period = NULL,$customerdata);			
            $this->Cbcreportpdfcreator->genrate_cbc_customerstatement_pdf($columnsValues,$storeallValues,$this->globalParameterarray,$customerdata,$toDate,$fromDate,$openingbalance,$TotalsumRefund,$totalmdcamt,$totalcbcamt,sizeof($NoOfrefund),$TotalsumRecharge,$Noofrecharge,$sumofcardsIssued,'S');			
            $this->Cbcreportpdfcreator->output(WWW_ROOT.$vc_cust_no.'-Customer-statement-Report'.'.pdf', 'F');
			
			}
			die;

	$this->layout = 'pdf';
}
} }catch (Exception $e) {

echo 'Caught exception: ', $e->getMessage(), "\n";

exit;
}

}


/* ========== Vehicle list reports ================ */

/**
 *
 *
 *
 **/
	public function cbc_vehicleslist() {
		ini_set('memory_limit','5048M');
		set_time_limit(0);


			$this->layout = 'cbc_layout';


			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');


			$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');


			$vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');


			$vc_email_id = $this->Session->read('Auth.Customer.vc_email');


			$customer = $this->Customer->find('first', array('conditions' => array('Customer.vc_cust_no' => $vc_cust_no)));

			$this->set('customer', $customer);

			$customername = $this->Session->read('Auth.Customer.vc_first_name') . ' ' . $this->Session->read('Auth.Customer.vc_surname');


			$this->set('customername', $customername);


			$this->loadModel('AddVehicle');

			$no_of_rows = 10;


			try {


			$conditions = array('AddVehicle.vc_cust_no' => $vc_cust_no,'AddVehicle.vc_status' => 'STSTY04');



			if (isset($this->params['named']['vehicletype'])) :
			$vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

			else :

			$vehicletype = isset($this->data['Cbcreport']['vehicletype'])
			&&!empty($this->data['Cbcreport']['vehicletype']) ?
			trim($this->data['Cbcreport']['vehicletype']) :
			'';
			endif;

			$conditions += array(
			'AddVehicle.vc_comp_code' => $vc_comp_code,
			);

			if ($vehicletype) :

			$conditions += array(

			'AddVehicle.vc_veh_type' => $vehicletype
			);
			
			$conditions += array(

			'AddVehicle.vc_status' => 'STSTY04'
			);
			
			endif;

			if (isset($this->params['named']['page'])) :

			$pageno = trim($this->params['named']['page']);

			else :

			$pageno = 1;



			endif;

			$this->paginate = array('conditions' => $conditions,
			 'limit' => $no_of_rows
			);


			$cbc = $this->paginate('AddVehicle');
        
			$this->set('vehiclereport', $cbc);


			$start = ((($pageno - 1) * $no_of_rows) + 1);

			$this->set('start', $start);
					
			$vehiclelist = $this->AddVehicle->find('list', array(
                'conditions' => array(
                    'AddVehicle.vc_comp_code' => $vc_comp_code,
                    'AddVehicle.vc_cust_no' => $vc_cust_no,
                    'AddVehicle.vc_status' => 'STSTY04'
                ),
                'fields' => array('vc_veh_type', 'vc_veh_type')
                    ));
				
					
			 if (count($vehiclelist) == 0):

                $vehiclelist = null;

            endif;

            
			$impVehiltype='';
			if(count($vehiclelist)>0){
			foreach($vehiclelist as $value) {
			$impVehiltype .= "'".$value."',";
			}
			$impVehiltype = trim($impVehiltype,',');
			}
            if (count($vehiclelist) == 0):

                $vehiclelist = null;

            endif;

			
			if (!empty($vehicletype)) {

			$getTypeResult = $this->ParameterType->find('first', array('conditions' =>
			 array('ParameterType.vc_prtype_code' => $vehicletype),
			 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

			$this->set('vehicletypename', $getTypeResult['ParameterType']['vc_prtype_name']);
			
			} else {

			$this->set('vehicletypename', '');
			}
			
			

			$this->set('vehicletype', $vehicletype);
			if(count($vehiclelist)>0){
			$this->set('vehiclelist', array('' => 'All') +
			$this->ParameterType->find('list', array('conditions' =>
			 array('ParameterType.vc_prtype_code IN ( '.$impVehiltype.' )',),
			 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
				
			}else{
			
						$this->set('vehiclelist', array(''));

			}
			
			

			
			} catch (Exception $e) {

			echo 'Caught exception: ', $e->getMessage(), "\n";

			exit;
			}
			}



/**
 *
 *
 *
 */
/* ======= Pdf for vehicle list ============== */


public function cbc_vehicleslist_pdf() {
	ini_set('memory_limit','5048M');
	set_time_limit(0);

$this->layout = 'cbc_layout';

$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');

$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');

$vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');

$vc_email_id = $this->Session->read('Auth.Customer.vc_email');

$customer = $this->Customer->find('first', array('conditions' => array('Customer.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'))));

$this->set('customer', $customer);

$customername = $this->Session->read('Auth.Customer.vc_first_name') . ' ' . $this->Session->read('Auth.Customer.vc_surname');


$this->set('customername', $customername);


$this->loadModel('AddVehicle');

try {

$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
$conditions = array('AddVehicle.vc_cust_no' =>$vc_cust_no );


if (isset($this->params['named']['vehicletype'])) :

$vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

else :
$vehicletype = isset($this->data['Cbcreport']['vehicletype']) && !empty($this->data['Cbcreport']['vehicletype'])?
trim($this->data['Cbcreport']['vehicletype']) :'';
endif;

$conditions += array(
'AddVehicle.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
'AddVehicle.vc_status' => 'STSTY04'
);

if ($vehicletype) :

$conditions += array(
	'AddVehicle.vc_veh_type' => $vehicletype,
	
);
endif;

$vehiclereport = $this->AddVehicle->find('all', array(
				'conditions' => $conditions,
				));

$this->set('vehiclereport', $vehiclereport);

$this->set('vehicletype', $vehicletype);

if (!empty($vehicletype)) {

$getTypeResult = $this->ParameterType->find('first', array('conditions' =>
 array('ParameterType.vc_prtype_code' => $vehicletype),
 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

$this->set('vehicletypename', $getTypeResult['ParameterType']['vc_prtype_name']);
} else {
$this->set('vehicletypename', '');
}
			
			$columnsValues= array('SI.No.','Vehicle Type',
			'Vehicle Reg. No.','Type No.',
			'Vehicle Make','No. of Axles',
			'Series Name','Engine No.',
			'Chassis No.','V Rating',
			'D/T Rating');
			
			$this->Cbcreportpdfcreator->headerData('Vehicle List Report', $period = NULL,$this->Session->read('Auth'),$vehicletype) ;
            $this->Cbcreportpdfcreator->genrate_cbc_vehiclelist_pdf($columnsValues,$vehiclereport,$this->globalParameterarray,$this->Session->read('Auth'),$vehicletype);
			
			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
			
            $this->Cbcreportpdfcreator->output($vc_cust_no.'-Customer-VehicleList-Report'.'.pdf', 'D');
			
			die;

$this->layout = 'pdf';

} catch (Exception $e) {

echo 'Caught exception: ', $e->getMessage(), "\n";

exit;
}

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
?>
