<?php

App::import('Sanitize');

/**
 *
 *
 *
 */
 
class CbccronsController extends AppController {

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
	 * Function to generate pdf for customer statement report
	 *
	 */
	 
	
	public function cbc_customerstatements_pdf($vc_cust_no=null,$fromDate=null,$toDate=null) {

	Configure::write('debug', 0);
	ini_set('memory_limit','5048M');
	set_time_limit(0);
	
	try {		
		
	$customer     = $this->Customer->find('first', array('conditions'=> array('Customer.vc_cust_no' => $vc_cust_no)));	 
    $vc_cust_no   = $customer['Customer']['vc_cust_no'];
	$vc_comp_code = $customer['Customer']['vc_comp_code'];
	$vc_user_no   = $customer['Customer']['vc_user_no'];
	$vc_email_id  = $customer['Customer']['vc_email'];
	$customername = $customer['Customer']['vc_first_name']. ' ' .$customer['Customer']['vc_surname'];
	$fromDate     = date('Y-m-d H:i:s', strtotime($fromDate));
	$toDate       = date('Y-m-d 23:59:59', strtotime($toDate));

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
	
	$columnsValues= array('SI.No.','Transaction  Type',	'Transaction Date','Remarks',
	'Issue/Ref.Date','Card No.','Permit/Ref.No.','Vehicle Reg. No.','Net Amount(N$)','Running Balance(N$)' );
	//ob_start();
	$this->Cbcreportpdfcreator->headerData('Customer Statement Report', $period = NULL,$customer);
	
	$this->Cbcreportpdfcreator->genrate_cbc_customerstatement_pdf($columnsValues,$storeallValues,$this->globalParameterarray,$customer,$toDate,$fromDate,$openingbalance,$TotalsumRefund,$totalmdcamt,$totalcbcamt,sizeof($NoOfrefund),$TotalsumRecharge,$Noofrecharge,$sumofcardsIssued,'S');
	
	$vc_cust_no = $customer['Customer']['vc_cust_no'];
	//ob_get_clean();		
    $this->Cbcreportpdfcreator->output(WWW_ROOT.'upload-files-for-cbc-mdc'.DS.$vc_cust_no.'-Customer-statement-Report'.'.pdf', 'F');
	//unset();
	//unset($this->Cbcreportpdfcreator);
		
}
} }catch (Exception $e) {

echo 'Caught exception: ', $e->getMessage(), "\n";

exit;
}

}
	/**
     *
     * Function for email shoot on approval and rejection of Vehicle profile in CBC
     *
     */
	 
	 
	 
    function cbc_vehicleApprovalRejection() {
        set_time_limit(0);
        $this->loadModel('Customer');
        $this->loadModel('AddVehicle');

        $fields = array('Customer.vc_first_name',
            'Customer.vc_surname',
            'Customer.vc_mobile_no',
            'Customer.vc_alter_email',
            'Customer.vc_cust_no',
            'Customer.vc_email',
            'AddVehicle.vc_vehicle_sr_no',
            'AddVehicle.vc_reg_no',
            'AddVehicle.vc_series_name',
            'AddVehicle.vc_make',
            'AddVehicle.vc_email',
            'AddVehicle.vc_remarks',
            'AddVehicle.vc_status',
            'AddVehicle.nu_vehicle_id',
        );


        $options['joins'] = array(
            array('table' => 'dt_vehicles_cbc',
                'alias' => 'AddVehicle',
                'type' => 'INNER',
                'conditions' => array(
                    array('AddVehicle.vc_email' => 'N'),
                    array('AddVehicle.vc_cust_no = Customer.vc_cust_no'),
                    'OR' => array(
                        array('AddVehicle.vc_status' => 'STSTY04'),
                        array('AddVehicle.vc_status' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Customer->find('all', $options);

        $sizeOf = sizeOf($customersEmailID);

        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                $ch_email_flag = $value['AddVehicle']['vc_email'];
                $vc_vehicle_status = $value['AddVehicle']['vc_status'];
                $vc_vehicle_reg_no = $value['AddVehicle']['vc_reg_no'];
                $nu_vehicle_id = $value['AddVehicle']['nu_vehicle_id'];
                $vc_remarks = $value['AddVehicle']['vc_remarks'];



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);
                $this->Email->reset();

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = trim($vc_alter_email);


                if ($vc_vehicle_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname))));
                $vc_customer_name = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));

                $this->Email->delivery = 'smtp';

                if ($vc_vehicle_status == 'STSTY05')
                    $mesage = " Your vehicle  has been rejected by RFA .";
                else
                    $mesage = " Your vehicle  has been approved by RFA .";

                $mesage .= '<br/><br/>Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Vehicle Registration No. : ' . trim($vc_vehicle_reg_no);

                if ($vc_vehicle_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';

                $this->Email->cc = '';
                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));

                $this->Email->to = trim($this->AdminCbcEmailID);

                if ($vc_vehicle_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($vc_vehicle_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  vehicle  has been rejected by RFA following are customer and vehicle details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "  vehicle  has been approved by RFA following are customer and vehicle details.";

                $mesage .= '<br/> <br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Vehicle Registration No. : ' . trim($vc_vehicle_reg_no);



                if ($vc_vehicle_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $this->Email->send($mesage);

                $mesage = '';

                /*                 * ******************** End Email********************** */

                // $data = array('AddVehicle.ch_email_flag' => 'Y');
                if ($customerEmailStatus == true) {

                    $this->AddVehicle->create();
                    $data['vc_email'] = 'Y';
                    $this->AddVehicle->id = $nu_vehicle_id;
                    $this->AddVehicle->set($data);
                    $this->AddVehicle->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            }
        }
    }

    /**
     *
     * Function for email shoot on approval and rejection of customer profile in cbc
     *
     */
    function cbc_profileApprovalRejection() {
       //die('kuch');
        set_time_limit(0);

        $this->loadModel('Customer');

        $customersEmailID = $this->Customer->find('all', array(
            'fields' => array('Customer.vc_first_name',
                'Customer.vc_surname',
                'Customer.vc_username',
                'Customer.ch_active',
                'Customer.vc_mobile_no',
                'Customer.vc_alter_email',
                'Customer.vc_remarks',
                'Customer.nu_cust_vehicle_card_id',
                'Customer.vc_comp_code',
                'Customer.ch_email_flag',
                'Customer.vc_cust_no',
                'Customer.vc_email'),
            'conditions' => array(
                array('Customer.ch_email_flag' => 'N'),
                'OR' => array(array('Customer.ch_active' => 'STSTY04'), array('Customer.ch_active' => 'STSTY05'))
            ),
            'limit' => 50,
                )
        );

        $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $ch_active = $value['Customer']['ch_active'];
                $ch_email_flag = $value['Customer']['ch_email_flag'];
                $vc_remarks = $value['Customer']['vc_remarks'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $nu_cust_vehicle_card_id = $value['Customer']['nu_cust_vehicle_card_id'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = array(trim($vc_alter_email));


                if ($ch_active == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname)));

                $this->Email->delivery = 'smtp';

                if ($ch_active == 'STSTY05')
                    $mesage = " Your profile has been rejected by RFA .";
                else
                    $mesage = " Your profile has been approved by RFA .";

                $mesage .= '<br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($ch_active == 'STSTY05')
                    $mesage .= '<br/> Remarks :  ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';
                /* ======End of email shoot for customer ============= */

                $this->Email->reset();

                /*                 * ****************Email Send To Admin************************** */
                $this->Email->from = ucfirst(trim($vc_first_name . ' ' . $vc_surname));

                $this->Email->to = trim($this->AdminCbcEmailID);
                $this->Email->cc = '';

                if ($ch_active == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';

                if ($ch_active == 'STSTY05')
                    $mesage .= trim(ucfirst($vc_first_name . ' ' . $vc_surname)) . " profile  has been rejected by RFA following are customer details.";
                else
                    $mesage .= trim(ucfirst($vc_first_name . ' ' . $vc_surname)) . " profile  has been approved by RFA following are customer details.";

                $mesage .= '<br/> Customer No.: ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No :  N/A ';

                if ($ch_active == 'STSTY05')
                    $mesage .= '<br/> Remarks :  ' . $vc_remarks;

                $this->Email->send($mesage);
                $mesage = '';

                /*                 * ******************** End Email********************** */

                $data = array('Customer.ch_email_flag' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->Customer->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->Customer->id = $nu_cust_vehicle_card_id;
                    $this->Customer->set($data);
                    $this->Customer->save($data, false);
                }
                $customerEmailStatus = '';
                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }

    /**
     *
     * Function for email shoot on approval and rejection of Refund of mDC or CBC permit no. in CBC
     *
     */
    function cbc_refundApprovalRejection() {
        set_time_limit(0);

        $this->loadModel('Customer');
        $this->loadModel('CardRefund');

        $fields = array('Customer.vc_first_name',
            'Customer.vc_surname',
            'Customer.vc_mobile_no',
            'Customer.vc_alter_email',
            'Customer.vc_cust_no',
            'Customer.vc_email',
            'CardRefund.nu_refund_id',
            'CardRefund.vc_refund_no',
            'CardRefund.vc_voucher_no',
            'CardRefund.nu_approved_amt',
            'CardRefund.ch_tran_type',
            'CardRefund.vc_email',
            'CardRefund.vc_remarks',
            'CardRefund.vc_status',
        );


        $options['joins'] = array(
            array('table' => 'cbc_mdc_refund_cbc',
                'alias' => 'CardRefund',
                'type' => 'INNER',
                'conditions' => array(
                    array('CardRefund.vc_email' => 'N'),
                    array('CardRefund.vc_cust_no = Customer.vc_cust_no'),
                    'OR' => array(
                        array('CardRefund.vc_status' => 'STSTY04'),
                        array('CardRefund.vc_status' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Customer->find('all', $options);


        echo 'sizeof==' . $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {


                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                $vc_refund_status = $value['CardRefund']['vc_status'];
                $nu_approved_amt = $value['CardRefund']['nu_approved_amt'];
                $ch_tran_type = $value['CardRefund']['ch_tran_type'];
                $vc_refund_no = $value['CardRefund']['vc_refund_no'];
                $nu_refund_id = $value['CardRefund']['nu_refund_id'];
                $vc_remarks = $value['CardRefund']['vc_remarks'];
                $vc_customer_name = ucfirst($vc_first_name . ' ' . $vc_surname);



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);
                $this->Email->reset();

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = trim($vc_alter_email);

                if ($vc_refund_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Refund Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Refund Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname))));

                $this->Email->delivery = 'smtp';

                if ($vc_refund_status == 'STSTY05')
                    $mesage = " Your refund  has been rejected by RFA .";
                else
                    $mesage = " Your refund  has been approved by RFA .";

                $mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No :  N/A ';


                if ($vc_refund_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                if ($vc_refund_status == 'STSTY04')
                    $mesage .= '<br/> Refund Amt. : (N$) ' . trim(number_format($nu_approved_amt, 2, '.', ','));

                if ($ch_tran_type == 'Refund')
                    $mesage .= '<br/> Refund Type : Account Closed';
                else
                    $mesage .= '<br/> Refund Type : ' . trim($ch_tran_type);




                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ***************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));

                $this->Email->to = trim($this->AdminCbcEmailID);

                if ($vc_refund_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Refund Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Refund Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($vc_refund_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . " refund has been rejected by RFA following are customer and  refund details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . " refund has been approved by RFA following are customer and refund details.";

                $mesage .= '<br/> <br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($vc_refund_status == 'STSTY04')
                    $mesage .= '<br/> Refund Amt. : (N$) ' . trim(number_format($nu_approved_amt, 2, '.', ','));

                if ($ch_tran_type == 'Refund')
                    $mesage .= '<br/> Refund Type : Account Closed';
                else
                    $mesage .= '<br/> Refund Type : ' . trim($ch_tran_type);




                if ($vc_refund_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $this->Email->send($mesage);

                $mesage = '';

                /*                 * ******************** End Email********************** */

                $data = array('CardRefund.vc_email' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->CardRefund->create();
                    $data['vc_email'] = 'Y';
                    $this->CardRefund->id = $nu_refund_id;
                    $this->CardRefund->set($data);
                    $this->CardRefund->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            }
        }
    }

// end of function

    /**
     *
     * Function for email shoot on approval and rejection of Account Recharge in CBC
     *
     */
    function cbc_accountRechargeApprovalRejection() {
        set_time_limit(0);

        $this->loadModel('Customer');
        $this->loadModel('AccountRecharge');

        $fields = array('Customer.vc_first_name',
            'Customer.vc_surname',
            'Customer.vc_mobile_no',
            'Customer.vc_alter_email',
            'Customer.vc_cust_no',
            'Customer.vc_email',
            'AccountRecharge.vc_ref_no',
            'AccountRecharge.ch_tran_type',
            'AccountRecharge.nu_amount',
            'AccountRecharge.ch_tran_type',
            'AccountRecharge.nu_acct_rec_id',
            'AccountRecharge.vc_email',
            'AccountRecharge.vc_recharge_status',
            'AccountRecharge.vc_remarks',
            'AccountRecharge.nu_amount_un',
        );


        $options['joins'] = array(
            array('table' => 'account_recharge_cbc',
                'alias' => 'AccountRecharge',
                'type' => 'INNER',
                'conditions' => array(
                    array('AccountRecharge.vc_email' => 'N'),
                    array('AccountRecharge.vc_cust_no = Customer.vc_cust_no'),
                    'OR' => array(
                        array('AccountRecharge.vc_recharge_status' => 'STSTY04'),
                        array('AccountRecharge.vc_recharge_status' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Customer->find('all', $options);


        echo 'sizeof==' . $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {


                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];

                $vc_recharge_status = $value['AccountRecharge']['vc_recharge_status'];
                $nu_approved_amt = $value['AccountRecharge']['nu_amount'];    // approved amount
                $nu_recharge_amt = $value['AccountRecharge']['nu_amount_un']; // recharge amount
                $vc_email = $value['AccountRecharge']['vc_email'];
                $ch_tran_type = $value['AccountRecharge']['ch_tran_type'];
                $vc_ref_no = $value['AccountRecharge']['vc_ref_no'];
                $nu_acct_rec_id = $value['AccountRecharge']['nu_acct_rec_id'];
                $vc_remarks = $value['AccountRecharge']['vc_remarks'];

                $vc_customer_name = ucfirst($vc_first_name . ' ' . $vc_surname);



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);
                $this->Email->reset();

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = trim($vc_alter_email);

                if ($vc_recharge_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Account Recharge Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Account Recharge Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname))));

                $this->Email->delivery = 'smtp';

                if ($vc_recharge_status == 'STSTY05')
                    $mesage = " Your account recharge request has been rejected by RFA .";
                else
                    $mesage = " Your account recharge request has been approved by RFA .";

                $mesage .= '<br/><br/>  Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';


                if ($vc_recharge_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $mesage .= '<br/> Recharge Amt. : (N$) ' . trim(number_format($nu_recharge_amt, 2, '.', ','));

                if ($vc_recharge_status == 'STSTY04')
                    $mesage .= '<br/> Approved Amt. : (N$) ' . trim(number_format($nu_approved_amt, 2, '.', ','));

                $mesage .= '<br/> Deposit Type : ' . $this->globalParameterarray[$ch_tran_type];
                $mesage .= '<br/> Ref No. : ' . $vc_ref_no;




                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));

                $this->Email->to = trim($this->AdminCbcEmailID);

                if ($vc_recharge_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Account Recharge  Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Account Recharge  Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($vc_recharge_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . " account recharge request has been rejected by RFA following are customer and  recharge details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . " account recharge request has been approved by RFA following are customer and recharge details.";

                $mesage .= '<br/> <br/> Customer No. :' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Recharge Amt. : (N$) ' . trim(number_format($nu_recharge_amt, 2, '.', ','));

                if ($vc_recharge_status == 'STSTY04')
                    $mesage .= '<br/> Approved Amt. : (N$) ' . trim(number_format($nu_approved_amt, 2, '.', ','));

                $mesage .= '<br/> Deposit Type : ' . $this->globalParameterarray[$ch_tran_type];
                $mesage .= '<br/> Ref No. : ' . $vc_ref_no;




                if ($vc_recharge_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $this->Email->send($mesage);

                $mesage = '';

                /*                 * ******************** End Email********************** */


                if ($customerEmailStatus == true) {

                    $this->AccountRecharge->create();
                    $data['vc_email'] = 'Y';
                    $this->AccountRecharge->id = $nu_acct_rec_id;
                    $this->AccountRecharge->set($data);
                    $this->AccountRecharge->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            }
        }
    }

// end of function

    /**
     *
     * Function for email shoot on approval and rejection of card issued in CBC
     *
     */
    function cbc_cardIssuedApprovalRejection() {
        set_time_limit(0);

        $this->loadModel('Customer');
        $this->loadModel('Card');

        $fields = array('Customer.vc_first_name',
            'Customer.vc_surname',
            'Customer.vc_mobile_no',
            'Customer.vc_alter_email',
            'Customer.vc_cust_no',
            'Customer.vc_email',
            'Card.nu_total_charges',
            'Card.nu_card_approved',
            'Card.card_request_id',
            'Card.vc_no_of_cards',
            'Card.vc_email',
            'Card.vc_status',
            'Card.vc_remarks',
        );


        $options['joins'] = array(
            array('table' => 'dt_cust_card_requests_cbc',
                'alias' => 'Card',
                'type' => 'INNER',
                'conditions' => array(
                    array('Card.vc_email' => 'N'),
                    array('Card.vc_cust_no = Customer.vc_cust_no'),
                    'OR' => array(
                        array('Card.vc_status' => 'STSTY04'),
                        array('Card.vc_status' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Customer->find('all', $options);


        echo 'sizeof==' . $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {
                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];
                $vc_status = $value['Card']['vc_status'];
                $vc_no_of_cards = $value['Card']['vc_no_of_cards'];    // requested amount
                $nu_card_approved = $value['Card']['nu_card_approved'];    // approved	 amount
                $vc_email = $value['Card']['vc_email'];
                $card_request_id = $value['Card']['card_request_id'];
                $vc_remarks = $value['Card']['vc_remarks'];
                $vc_customer_name = ucfirst($vc_first_name . ' ' . $vc_surname);


                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);
                $this->Email->reset();

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = trim($vc_alter_email);

                if ($vc_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Card request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Card request Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname))));

                $this->Email->delivery = 'smtp';

                if ($vc_status == 'STSTY05')
                    $mesage = " Your card request has been rejected by RFA .";
                else
                    $mesage = " Your card request has been approved by RFA .";

                $mesage .= '<br/><br/>  Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';


                if ($vc_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $mesage .= '<br/> No. of Cards Requested : ' . number_format($vc_no_of_cards);

                if ($vc_status == 'STSTY04')
                    $mesage .= '<br/> No. of Cards Approved : ' . number_format($nu_card_approved);

                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';

                /* ======End of email shoot for customer ============= */

                $this->Email->reset();

                /*                 * ***************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));
                $this->Email->to = trim($this->AdminCbcEmailID);

                if ($vc_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Card Request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Card Request Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';
                $this->set('name', $this->AdminName);
                $this->Email->delivery = 'smtp';

                if ($vc_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . " card request has been rejected by RFA following are customer and  card details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . " card request has been approved by RFA following are customer and card details.";

                $mesage .= '<br/> <br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> No. of Cards Requested : ' . number_format($vc_no_of_cards);

                if ($vc_status == 'STSTY04')
                    $mesage .= '<br/> No. of Cards Approved : ' . number_format($nu_card_approved);

                if ($vc_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $this->Email->send($mesage);

                $mesage = '';

                /*                 * ********************End Email********************** */

                if ($customerEmailStatus == true) {
                    $this->Card->create();
                    $data['vc_email'] = 'Y';
                    $this->Card->id = $card_request_id;
                    $this->Card->set($data);
                    $this->Card->save($data, false);
                }

                $counter++;
                if ($counter > 50)
                    break;
            }
        }
    }

    /**
     *
     * Function for email shoot on  exit of vehicles at border CBC
     *
     */
    function cbc_vehicleExitBorderPost() {
        set_time_limit(0);
        $this->loadModel('Customer');
        $this->loadModel('EntryExitMasterView');
        $this->loadModel('HeaderEntryExit');

        $fields = array('Customer.vc_first_name',
            'Customer.vc_surname',
            'Customer.vc_mobile_no',
            'Customer.vc_alter_email',
            'Customer.vc_cust_no',
            'Customer.vc_email',
            'EntryExitMasterView.vc_permit_mdc',
            'EntryExitMasterView.vc_permit_cbc',
            'EntryExitMasterView.nu_cbc_entry_amount',
            'EntryExitMasterView.vc_mdc_cbc',
            'EntryExitMasterView.ch_cbc',
            'EntryExitMasterView.ch_mdc',
            'EntryExitMasterView.vc_email_cbc',
            'EntryExitMasterView.vc_entry_no',
            'EntryExitMasterView.vc_reg_no',
            'EntryExitMasterView.vc_entry_point',
            'EntryExitMasterView.vc_exit',
            //'EntryExitMasterView.vc_exit_no',
            'EntryExitMasterView.dt_exit_date',
                //'EntryExitMasterView.nu_dt_entry_exit_cbc_id',
                //'EntryExitMasterView.vc_transaction_no'
        );


        $options['joins'] = array(
            array(
                'table' => 'vw_hd_entry_exit',
                'alias' => 'EntryExitMasterView',
                'type' => 'INNER',
                'conditions' => array(
                    array('EntryExitMasterView.vc_exit' => 'Y'),
                    array('EntryExitMasterView.vc_email_cbc' => 'N'),
                    array('EntryExitMasterView.vc_cust_no = Customer.vc_cust_no'),
                    array('EntryExitMasterView.dt_exit_date is not null'),
        )));

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Customer->find('all', $options);

        pr($customersEmailID);
        //die;


        $sizeOf = sizeOf($customersEmailID);

        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];


                $vc_no_of_cards = $value['EntryExitMasterView']['permit_no_cbc']; // permit no cbc
                $permit_no_mdc = $value['EntryExitMasterView']['permit_no_mdc']; // permit no mdc 
                $vc_email_cbc = $value['EntryExitMasterView']['vc_email_cbc'];
                $ch_cbc = $value['EntryExitMasterView']['ch_cbc'];
                $ch_mdc = $value['EntryExitMasterView']['ch_mdc'];
                $vc_reg_no = $value['EntryExitMasterView']['vc_reg_no'];
                $nu_cbc_entry_amount = $value['EntryExitMasterView']['nu_cbc_entry_amount'];
                $vc_entry_point = $value['EntryExitMasterView']['vc_entry_point'];
                $vc_exit_point = $value['EntryExitMasterView']['vc_exit_point'];
                $vc_entry_no = $value['EntryExitMasterView']['vc_entry_no'];
                $vc_transaction_no = $value['EntryExitMasterView']['vc_transaction_no'];

                $vc_customer_name = ucfirst($vc_first_name . ' ' . $vc_surname);

                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);
                $this->Email->reset();

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = trim($vc_alter_email);

                $this->Email->subject = strtoupper($selectedType) . " Vehicle  Exit at Borderpost  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname))));

                $this->Email->delivery = 'smtp';

                $mesage = " Your vehicle exited at borderpost.";

                $mesage .= '<br/><br/>  Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';


                $mesage .= '<br/>Vehicle Reg No. : ' . trim($vc_reg_no);


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));

                $this->Email->to = trim($this->AdminCbcEmailID);

                $this->Email->subject = strtoupper($selectedType) . " Vehicle Exit at BorderPost.  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';

                $mesage = ucfirst(trim($vc_customer_name)) . " vehicle exited at borderpost following are customer and vehicle details.";

                $mesage .= '<br/> <br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/>Vehicle Reg No. : ' . trim($vc_reg_no);

                $this->Email->send($mesage);

                $mesage = '';

                /*                 * ******************** End Email********************** */


                if ($customerEmailStatus == true) {

                    $this->HeaderEntryExit->create();
                    $data['vc_email_cbc'] = 'Y';
                    $this->HeaderEntryExit->id = $vc_entry_no;
                    $this->HeaderEntryExit->set($data);
                    $this->HeaderEntryExit->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            }
        }
    }

    /**
     *
     * Function for email shoot on  entry of vehicles at border MDC
     *
     */
    function cbc_vehicleEntryBorderPost() {
        set_time_limit(0);
        $this->loadModel('Customer');
        $this->loadModel('EntryExitMasterView');
        $this->loadModel('HeaderEntryExit');

        $fields = array('Customer.vc_first_name',
            'Customer.vc_surname',
            'Customer.vc_mobile_no',
            'Customer.vc_alter_email',
            'Customer.vc_cust_no',
            'Customer.vc_email',
            'EntryExitMasterView.vc_permit_cbc',
            'EntryExitMasterView.vc_permit_mdc',
            'EntryExitMasterView.nu_cbc_entry_amount',
            'EntryExitMasterView.vc_mdc_cbc',
            'EntryExitMasterView.ch_cbc',
            'EntryExitMasterView.ch_mdc',
            'EntryExitMasterView.vc_email_flag',
            'EntryExitMasterView.vc_email_mdc',
            'EntryExitMasterView.vc_reg_no',
            'EntryExitMasterView.vc_entry_point',
            'EntryExitMasterView.vc_entry_no',
            'EntryExitMasterView.vc_exit_point',
                //'EntryExitMasterView.vc_transaction_no',
//            //'EntryExitMasterView.nu_dt_entry_exit_cbc_id',
//            
        );

        $options['joins'] = array(
            array('table' => 'vw_hd_entry_exit',
                'alias' => 'EntryExitMasterView',
                'type' => 'INNER',
                'conditions' => array(
                    array('EntryExitMasterView.vc_exit is null'),
                    array('EntryExitMasterView.vc_email_mdc' => 'N'),
                    //array('EntryExitMasterView.vc_exit_no is null'),
                    array('EntryExitMasterView.vc_cust_no = Customer.vc_cust_no'),
        )));

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Customer->find('all', $options);
        pr($customersEmailID);

        $sizeOf = sizeOf($customersEmailID);

        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $email = $value['Customer']['vc_email'];
                $vc_cust_no = $value['Customer']['vc_cust_no'];
                $vc_mobile_no = $value['Customer']['vc_mobile_no'];
                $vc_first_name = $value['Customer']['vc_first_name'];
                $vc_surname = $value['Customer']['vc_surname'];
                $vc_comp_code = $value['Customer']['vc_comp_code'];
                $vc_alter_email = $value['Customer']['vc_alter_email'];
                $vc_permit_cbc = $value['EntryExitMasterView']['vc_permit_cbc']; // permit no cbc
                $permit_no_mdc = $value['EntryExitMasterView']['vc_permit_mdc']; // permit no mdc 
                $vc_email_mdc = $value['EntryExitMasterView']['vc_email_mdc'];
                $ch_cbc = $value['EntryExitMasterView']['ch_cbc'];
                $ch_mdc = $value['EntryExitMasterView']['ch_mdc'];
                $vc_email_flag = $value['EntryExitMasterView']['vc_email_flag'];
                $vc_reg_no = $value['EntryExitMasterView']['vc_reg_no'];
                $nu_cbc_entry_amount = $value['EntryExitMasterView']['nu_cbc_entry_amount'];
                $vc_entry_point = $value['EntryExitMasterView']['vc_entry_point'];
                $vc_exit_point = $value['EntryExitMasterView']['vc_exit_point'];
                $vc_entry_no = $value['EntryExitMasterView']['vc_entry_no'];
                //$nu_dt_entry_exit_cbc_id = $value['EntryExitMaster']['nu_dt_entry_exit_cbc_id'];
                // $vc_transaction_no = $value['EntryExitMasterView']['vc_transaction_no'];
                $vc_customer_name = ucfirst($vc_first_name . ' ' . $vc_surname);


                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);
                $this->Email->reset();
                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
                $this->Email->to = trim($email);

                if (isset($vc_alter_email) && $vc_alter_email != '')
                    $this->Email->cc = trim($vc_alter_email);
                $this->Email->subject = strtoupper($selectedType) . " Vehicle Entry at Borderpost  ";
                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname))));
                $this->Email->delivery = 'smtp';

                $mesage = " Your vehicle entered at borderpost.";

                $mesage .= '<br/><br/>  Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/>Vehicle Reg No. : ' . trim($vc_reg_no);

                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';

                /* ======End of email shoot for customer ============= */

                $this->Email->reset();

                /*                 * ***************Email Send To Admin************************** */
                $this->Email->from = ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname));
                $this->Email->to = trim($this->AdminCbcEmailID);
                $this->Email->subject = strtoupper($selectedType) . " Vehicle Entry at BorderPost.  ";
                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', $this->AdminName);
                $this->Email->delivery = 'smtp';
                $mesage = ucfirst(trim($vc_customer_name)) . " vehicle entered at borderpost following are customer and vehicle details.";
                $mesage .= '<br/> <br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/>Vehicle Reg No. : ' . trim($vc_reg_no);

                $this->Email->send($mesage);
                $mesage = '';

                /*                 * ******************* End Email********************** */

                if ($customerEmailStatus == true) {

                    $this->HeaderEntryExit->create();
                    $data['vc_email_mdc'] = 'Y';

                    //$data['vc_email_flag'] = 'Y';
                    $this->HeaderEntryExit->id = $vc_entry_no;
                    $this->HeaderEntryExit->set($data);
                    $this->HeaderEntryExit->save($data, false);
                }


                $counter++;

                if ($counter > 50)
                    break;
            }
        }
    }

// end of function

    /**
     *
     * Function for cron of User not loggedIn from 3 months  in cbc
     *
     */
    function cbc_userNotLoggedIn() {
        set_time_limit(0);

        $this->loadModel('Member');
        $this->loadModel('UserLoginDetail');
        $vc_comp_code = $this->cbc;

        $loggedUserdetails = $this->UserLoginDetail->find(
                'all', array(
            'fields' => array('max(UserLoginDetail.dt_login_datetime) as loggeddate',
                'UserLoginDetail.vc_user_no'),
            'conditions' => array('UserLoginDetail.vc_comp_code' => $vc_comp_code),
            'group' => array('UserLoginDetail.vc_user_no'),
            'limit' => 50,
                )
        );

        if (sizeof($loggedUserdetails) > 0) {

            $counter = 0;

            foreach ($loggedUserdetails as $index => $value) {
                $loggeddate = $value[0]['loggeddate'];
                $loggeddate_3months = strtotime("+3 months", strtotime($loggeddate));
                $datebeforethreeMonthsLogged = date('Y-m-d', $loggeddate_3months);
                $currentdate = date('Y-m-d');

                if (strtotime($datebeforethreeMonthsLogged) < strtotime($currentdate)) {

                    $userNo = $value['UserLoginDetail']['vc_user_no'];
//				$nu_id =  $value['UserLoginDetail']['nu_id'];

                    $Userdetails = $this->Member->find('all', array(
                        'conditions' => array('Member.vc_user_no' => $userNo),
                    ));


                    $vc_email_id = $Userdetails[0]['Member']['vc_email_id'];
                    $vc_first_name = $Userdetails[0]['Member']['vc_user_firstname'];
                    $vc_surname = $Userdetails[0]['Member']['vc_user_lastname'];
                    $vc_cbc_customer_no = $Userdetails[0]['Member']['vc_cbc_customer_no'];
                    $vc_cbc_customer_no = $Userdetails[0]['Member']['vc_cbc_customer_no'];
                    $last_email_login_date = $Userdetails[0]['Member']['last_email_login_date'];

                    $this->Email->reset();
                    $last_email_login_date = strtotime("+3 months", strtotime($last_email_login_date));
                    $datebeforelast_email_login_date = date('Y-m-d', $last_email_login_date);
                    //$currentdate = date('Y-m-d');

                    if (strtotime($datebeforelast_email_login_date) < strtotime($currentdate)) {

                        /*                         * *************Email Shoot to Customer***************** */
                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($vc_email_id);

                        $this->Email->subject = strtoupper($selectedType) . " Customer Login Reminder  ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname)));

                        $this->Email->delivery = 'smtp';

                        $mesage = " You has not logged in last three months  .";

                        $mesage .= '<br/> RFA Account No. : ' . trim($vc_cbc_customer_no);

                        $customerEmailStatus = $this->Email->send($mesage);

                        $mesage = '';
                        /* ======End of email shoot for customer ============= */

                        $this->Email->reset();

                        /*                         * ****************Email Send To Admin************************** */
                        $this->Email->from = ucfirst(trim($vc_first_name . ' ' . $vc_surname));

                        $this->Email->to = trim($this->AdminCbcEmailID);
                        $this->Email->cc = '';

                        $this->Email->subject = strtoupper($selectedType) . " Customer Login Reminder ";


                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', $this->AdminName);

                        $this->Email->delivery = 'smtp';

                        $mesage .= trim(ucfirst($vc_first_name . ' ' . $vc_surname)) . " has not logged in last three months.";

                        $mesage .= '<br/> RFA Account No. : ' . trim($vc_cbc_customer_no);

                        $this->Email->send($mesage);
                        $mesage = '';

                        /*                         * ******************** End Email********************** */

                        if ($customerEmailStatus == true) {

                            $this->Member->create();
                            $data['last_email_login_date'] = date('Y-m-d');
                            $this->Member->id = $userNo;
                            $this->Member->set($data);
                            $this->Member->save($data, false);
                        }
                        //echo  'pls send me email its less tha ';
                    }
                    $counter++;

                    if ($counter > 50)
                        break;
                } // end of foreach
            }// end of if
        }
    }

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
                    
                    $fromDate = date('Y-m-d H:i:s', strtotime($statement_date_to));
                    //$fromDate = '2013-01-02 23:59:59'; 
                    $toDate = $currentdate;
                    //$toDate   = '2013-12-05 23:59:59'; 

                    $vc_first_name   = $customer['Customer']['vc_first_name'];
                    $vc_surname      = $customer['Customer']['vc_surname'];
					$customerdata    = $customer['Customer'];

                    $customername = $vc_first_name . ' ' . $vc_surname;
				
                    $this->cbc_customerstatements_pdf($vc_cust_no,$statement_date_to,$currentdate) ;
					
                }
            } // end of for each eamilids
            // pdf code ends here				

            $fromDate = date('d-M-Y', strtotime($fromDate));
            $toDate   = date('d-M-Y', strtotime($toDate));
            foreach($customersEmailID as $index => $value) {

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


                $statement_date  = $value['Customer']['statement_date'];
                $dt_created      = $value['Customer']['dt_created'];
                $nu_cust_vehicle_card_id = $value['Customer']['nu_cust_vehicle_card_id'];
                $vc_email       = $value['Customer']['vc_email'];
                $vc_cust_no     = $value['Customer']['vc_cust_no'];
                $vc_mobile_no   = $value['Customer']['vc_mobile_no'];
                $vc_first_name  = $value['Customer']['vc_first_name'];
                $vc_surname     = $value['Customer']['vc_surname'];
                $vc_comp_code   = $value['Customer']['vc_comp_code'];
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
				
				$fromDate = date('Y-m-d H:i:s', strtotime($statement_date_to));
                    //$fromDate = '2013-01-02 23:59:59'; 
                 $toDate = $currentdate;
					

                // $timedifference
                // diff between curent date and next statement date
                if (strtotime($currentdate) > strtotime($nextstatementdueDate)) {
					echo '-newboy---<br>'.$nu_cust_vehicle_card_id.'==='.$vc_email ;

					sleep(2);
					echo '<br>path=='.$path = WWW_ROOT.'upload-files-for-cbc-mdc'.DS.trim($vc_cust_no).'-Customer-statement-Report.pdf';
                    
					if (file_exists($path)) {

                        /*                         * ***Email Shoot to Customer***************** */

                        list($selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                       // $this->Email->to = trim($vc_email);
                       //$this->Email->to = 'rishi.kapoor@essindia.co.in';

                        $this->Email->subject = strtoupper($selectedType) . " Customer Statement report ";
                          sleep(2);
                        $this->Email->attachments = array("$vc_cust_no-CustomerStatement-Report.pdf" =>$path);


                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($vc_first_name)) . ' ' . ucfirst(trim($vc_surname)));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Please find the transactions between  $fromDate and  $toDate .";

                        $mesage .= '<br/> Customer No. : ' . trim($vc_cust_no);

                        $customerEmailStatus = $this->Email->send($mesage);
						

                        $mesage = '';
                        /* ======End of email shoot for customer ============= */

                        $this->Email->reset();

                        /* ********Email Send To Admin******************** */

                        if ($customerEmailStatus == true) {

                            $this->Customer->create();
                            $data['statement_date'] = date('Y-m-d');
                            $this->Customer->id = $nu_cust_vehicle_card_id;
                            $this->Customer->set($data);
                        //    $this->Customer->save($data, false);
							//unlink($path);
                        }


                        /******************* End Email********************** */
                    }
                }
            }     // foreach for customerrmailids
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

                        $customerEmailStatus = $this->Email->send($mesage);

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
