<?php

App::import('Sanitize');

/**
 *
 *
 *
 */
class FlrcronsController extends AppController {

    /**
     *
     *
     *
     */
    var $name = 'Flrcrons';

    /**
     *
     *
     *
     */
    var $components = array('Session', 'RequestHandler', 'Email');

    /**
     *
     *
     *
     */
    var $uses = array('Client');

    /**
     *
     *
     *
     */
    var $helpers = array('Session', 'Html', 'Form');

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow('*');
    }
	
	
	function flr_cronsemail(){
	
				$email = "rishi.kapoor@essindia.co.in";
				$this->Email->from = 'kapoor.rishi07@gmail.com';
                $this->Email->to = trim($email);

                $this->Email->subject = " Client Profile Approval  ";
                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->Email->delivery = 'smtp';
                $mesage = " testing batch file dear Your profile has been approved by RFA .";

                $mesage .= '<br/> Mobile No. :  N/A ';

                echo '<br>email-status==' . $ClientEmailStatus = $this->Email->send($mesage);
	
	}
	
    function flr_profileApprovalRejection() {

        $ClientsEmailId = $this->Client->find('all', array(
            'fields' => array(
                'Client.vc_client_name', 'Client.ch_active_flag', 'Client.vc_remarks',
                'Client.vc_cell_no', 'Client.vc_tel_no', 'Client.vc_fax_no', 'Client.vc_email',
                'Client.vc_address1', 'Client.vc_address2', 'Client.vc_address3', 'Client.vc_postal_code1',
                'Client.vc_contact_person', 'Client.vc_user_no', 'Client.ch_email_flag', 'Client.vc_comp_code'),
            'conditions' => array(
                array('Client.ch_email_flag' => 'N'),
                'OR' => array(array('Client.ch_active_flag' => 'STSTY04'), array('Client.ch_active_flag' => 'STSTY05'))
            ),
            'limit' => 50
        ));


        pr($ClientsEmailId); //die;

        $sizeOf = sizeOf($ClientsEmailId);


        if ($sizeOf) {

            $counter = 0;

            foreach ($ClientsEmailId as $index => $value) {

                $this->Email->reset();

                $email = $value['Client']['vc_email'];
                $client_No = $value['Client']['vc_client_no'];
                $client_Name = $value['Client']['vc_client_name'];
                $active_flag = $value['Client']['ch_active_flag'];
                $remarks = $value['Client']['vc_client_name'];
                $email_flag = $value['Client']['ch_email_flag'];
                $mobile = $value['Client']['vc_cell_no'];
                $comp_code = $value['Client']['vc_comp_code'];

                /**                 * ************ Email Shoot to Client ***************** */
                /*                 * ************* Email Shoot to Client ***************** */

                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($comp_code);

                echo $this->AdminEmailID;
                echo $this->AdminName;

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
                $this->Email->to = trim($email);

                if ($active_flag == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Client Profile Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Client Profile Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($client_Name)));

                $this->Email->delivery = 'smtp';

                if ($active_flag == 'STSTY05')
                    $mesage = " Your profile has been rejected by RFA .";
                else
                    $mesage = " Your profile has been approved by RFA .";


                $mesage .= '<br/> FLR Client No. : ' . ltrim($client_No,'01');

                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($active_flag == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $remarks;

                echo '<br>email-status==' . $ClientEmailStatus = $this->Email->send($mesage);
//die;
                $mesage = '';

                /*                 * *********** End of email shoot for Client ************ */

                /*                 * ************ End of email shoot for Admin ************ */


                /*                 * ************ End of email shoot for Admin ************ */

                $this->Email->reset();

                $this->Email->from = ucfirst($client_Name);

                $this->Email->to = trim($this->AdminFlrEmailID);

                if ($active_flag == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Client Profile Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Client Profile Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($active_flag == 'STSTY05')
                    $mesage = " Profile has been rejected by RFA .";
                else
                    $mesage = " Profile has been approved by RFA .";


                if ($active_flag == 'STSTY05')
                    $mesage .= trim(ucfirst($client_Name)) . " profile  has been rejected by RFA following are client details.";
                else
                    $mesage .= trim(ucfirst($client_Name)) . " profile  has been approved by RFA following are client details.";



				                $mesage .= '<br/> FLR Client No. : ' . ltrim($client_No,'01');


                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';


                if ($active_flag == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $remarks;


                $this->Email->send($mesage);

                $mesage = '';

                /*                 * *********************** End Mail ************************ */


                if ($ClientEmailStatus == true) {

                    $this->Client->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->Client->id = $client_No;
                    $this->Client->set($data);
                    $this->Client->save($data, false);
                }

                $ClientEmailStatus = '';

                $counter++;

                if ($counter > 50)
                    break;
            }
        }
    }

    function flr_claimApprovalRejection() {

        $this->loadModel('ClaimHeader');
        $this->loadModel('Client');

        $this->ClaimHeader->unbindModel(array('hasMany' => array('ClaimDetail')));
        $this->Client->unbindModel(array('belongsTo' => array('ParameterType'), 'hasOne' => array('ClientHeader', 'ClientBank'), 'hasMany' => array('ClientFuelOutlet')));

        $fields = array('ClaimHeader.vc_comp_code', 'ClaimHeader.vc_claim_no', 'ClaimHeader.vc_client_no',
            'ClaimHeader.dt_claim_from', 'ClaimHeader.dt_claim_to', 'ClaimHeader.dt_party_claim_date',
            'ClaimHeader.nu_tot_amount', 'ClaimHeader.nu_tot_litres', 'ClaimHeader.vc_reason',
            'ClaimHeader.vc_status', 'ClaimHeader.dt_entry_date', 'ClaimHeader.ch_hold', 'ClaimHeader.nu_payment_amount',
            'ClaimHeader.nu_refund_prcnt', 'ClaimHeader.nu_admin_fee', 'ClaimHeader.nu_refund_rate', 'ClaimHeader.ch_email_flag',
            'Client.vc_client_no', 'Client.vc_id_no', 'Client.vc_client_name', 'Client.vc_cell_no',
            'Client.vc_email', 'Client.vc_comp_code'
        );

        $options['joins'] = array(
            array('table' => 'HD_CLAIM_FLR',
                'alias' => 'ClaimHeader',
                'type' => 'INNER',
                'conditions' => array(
                    array('ClaimHeader.ch_email_flag' => 'N'),
                    array('ClaimHeader.vc_client_no = Client.vc_client_no'),
                    'OR' => array(
                        array('ClaimHeader.vc_status' => 'STSTY04'),
                        array('ClaimHeader.vc_status' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;
        $ClientsEmailID = $this->Client->find('all', $options);

        $sizeOf = sizeof($ClientsEmailID);

        if ($sizeOf > 0) {
            $counter = 0;
            foreach ($ClientsEmailID as $index => $value) {
                $client_no = $value['Client']['vc_client_no'];
                $client_id = $value['Client']['vc_id_no'];
                $mobile = $value['Client']['vc_cell_no'];
                $email = $value['Client']['vc_email'];
                $client_name = $value['Client']['vc_client_name'];
                $comp_code = $value['Client']['vc_comp_code'];
                $claim_no = $value['ClaimHeader']['vc_claim_no'];
                $claim_status = $value['ClaimHeader']['vc_status'];
                $claim_from = !empty($value['ClaimHeader']['dt_claim_from']) ? date('d-M-Y', strtotime($value['ClaimHeader']['dt_claim_from'])) : '';
                $claim_to = !empty($value['ClaimHeader']['dt_claim_to']) ? date('d-M-Y', strtotime($value['ClaimHeader']['dt_claim_to'])) : '';
                $party_claim_date = $value['ClaimHeader']['dt_party_claim_date'];
                $total_amount = $value['ClaimHeader']['nu_tot_amount'];
                $payment_amount = $value['ClaimHeader']['nu_payment_amount'];
                $total_liters = $value['ClaimHeader']['nu_tot_litres'];
                $VC_REASON = $value['ClaimHeader']['vc_reason'];


                /*                 * *************Email Shoot to Client***************** */
                echo $this->AdminEmailID;
                echo $this->AdminName;
                echo $client_no . '' . $email;
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($comp_code);
                $this->Email->reset();
                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
                $this->Email->to = trim($email);


                if ($claim_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Claim request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Claim request Approval  ";

                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', ucfirst(trim($client_name)));
                $this->Email->delivery = 'smtp';

                if ($claim_status == 'STSTY05')
                    $mesage = " Your claim request has been rejected by RFA .";
                else
                    $mesage = " Your claim request has been approved by RFA .";

                $mesage .= '<br/> FLR Client No. : ' . ltrim($client_no,'01');


                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($claim_status == 'STSTY05') {
                    $mesage .= '<br/> Claim No. : ' . $claim_no;
                    $mesage .= '<br/> Claim Period  : ' . " From " . $claim_from . "  to  " . $claim_to;
                    $mesage .= '<br/> Remarks : ' . $VC_REASON;
                }

                if ($claim_status == 'STSTY04') {
                    $mesage .= '<br/> Claim No. : ' . $claim_no;
                    $mesage .= '<br/> Claim Period  : ' . " From " . $claim_from . "  to  " . $claim_to;
                }

                echo 'clinetstatus--' . $ClientsEmailID = $this->Email->send($mesage);
                $mesage = '';

                /* ======End of email shoot for customer ============= */
                $this->Email->reset();

                /*                 * ****************Email Send To Admin************************** */
                $this->Email->from = ucfirst(trim($client_name));
                $this->Email->to = trim($this->AdminFlrEmailID);

                if ($claim_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Claim Request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Claim Request Approval  ";

                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', $this->AdminName);
                $this->Email->delivery = 'smtp';

                if ($claim_status == 'STSTY05')
                    $mesage = ucfirst(trim($client_name)) . " claim request has been rejected by RFA following are clients and  card details.";
                else
                    $mesage = ucfirst(trim($client_name)) . " claim request has been approved by RFA following are clients and card details.";


               // $mesage .= '<br/> <br/> Flr Client No. : ' . trim($client_no);
				                $mesage .= '<br/> FLR Client No. : ' . ltrim($client_no,'01');

                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($claim_status == 'STSTY04')
                    $mesage .= '<br/> Claim Approved : ' . $claim_no;
                $mesage .= '<br/> Claim Period  : ' . " From " . $claim_from . "  to  " . $claim_to;

                if ($claim_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $VC_REASON;

                $this->Email->send($mesage);
                $mesage = '';

                /*                 * ******************* End Email********************** */

                if ($ClientsEmailID == true) {

                    $this->ClaimHeader->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->ClaimHeader->id = $claim_no;
                    $this->ClaimHeader->set($data);
                    $this->ClaimHeader->save($data, false);
                }

                $counter++;
                if ($counter > 50)
                    break;
            }
        }
    }

    function flr_paymentApprovalRejection() {

        $this->loadModel('ClaimHeader');
        $this->loadModel('Client');

        $this->ClaimHeader->unbindModel(array('hasMany' => array('ClaimDetail')));
        $this->Client->unbindModel(array('belongsTo' => array('ParameterType'), 'hasOne' => array('ClientHeader', 'ClientBank'), 'hasMany' => array('ClientFuelOutlet')));

        $fields = array('ClaimHeader.vc_comp_code', 'ClaimHeader.vc_claim_no', 'ClaimHeader.vc_client_no',
            'ClaimHeader.nu_tot_amount', 'ClaimHeader.nu_payment_amount', 'ClaimHeader.dt_expected_date',
            'ClaimHeader.vc_payment_status', 'ClaimHeader.nu_payment_amount', 'ClaimHeader.ch_email_flag',
            'ClaimHeader.vc_reason',
            'Client.vc_client_no', 'Client.vc_id_no', 'Client.vc_client_name', 'Client.vc_cell_no',
            'Client.vc_email', 'Client.vc_comp_code'
        );

        $options['joins'] = array(
            array('table' => 'HD_CLAIM_FLR',
                'alias' => 'ClaimHeader',
                'type' => 'INNER',
                'conditions' => array(
                    array('ClaimHeader.ch_email_flag' => 'N'),
                    array('ClaimHeader.vc_client_no = Client.vc_client_no'),
                    'OR' => array(
                        array('ClaimHeader.vc_payment_status' => 'STSTY04'),
                        array('ClaimHeader.vc_payment_status' => 'STSTY05')
                    )
        )));


        $options['fields'] = $fields;
        $ClientsEmailID = $this->Client->find('all', $options);
//pr($ClientsEmailID);

        $sizeOf = sizeof($ClientsEmailID);

        if ($sizeOf > 0) {
            $counter = 0;
            foreach ($ClientsEmailID as $index => $value) {
                $client_no = $value['Client']['vc_client_no'];
                $client_id = $value['Client']['vc_id_no'];
                $comp_code = $value['Client']['vc_comp_code'];
                $mobile = $value['Client']['vc_cell_no'];
                $email = $value['Client']['vc_email'];
                $client_name = $value['Client']['vc_client_name'];
                $total_amount = $value['ClaimHeader']['nu_tot_amount'];
                $claim_no = $value['ClaimHeader']['vc_claim_no'];
                $payment_amount = $value['ClaimHeader']['nu_payment_amount'];
                $expected_date = !empty($value['ClaimHeader']['dt_expected_date']) ? date('d-M-Y', strtolower($value['ClaimHeader']['dt_expected_date'])) : '';
                $payment_status = $value['ClaimHeader']['vc_payment_status'];
                $reason = $value['ClaimHeader']['vc_reason'];

                /*                 * *************Email Shoot to Client***************** */

                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($comp_code);
                $this->Email->reset();
                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
                $this->Email->to = trim($email);

                if ($payment_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Payment request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Payment request Approval  ";

                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', ucfirst(trim($client_name)));
                $this->Email->delivery = 'smtp';

                if ($payment_status == 'STSTY05')
                    $mesage = " Your payment request has been rejected by RFA .";
                else
                    $mesage = " Your payment request has been approved by RFA .";

                $mesage .= '<br/><br/>  FLR Client No. : ' . ltrim($client_no,'01');

                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($payment_status == 'STSTY05') {
                    $mesage .= '<br/> Claim No. : ' . $claim_no;
                    $mesage .= '<br/> Remarks : ' . $reason;
                }

                if ($payment_status == 'STSTY04') {
                    $mesage .= '<br/> Claim No. : ' . $claim_no;
                    $mesage .= '<br/> Claim Amount : ' . $total_amount;
                    $mesage .= '<br/> Payment Amount : ' . $payment_amount;
                    $mesage .= '<br/> Expected Date : ' . $expected_date;
                }


                $ClientsEmailID = $this->Email->send($mesage);
                $mesage = '';

                /* ======End of email shoot for customer ============= */

                $this->Email->reset();

                /*                 * ****************Email Send To Admin************************** */
                $this->Email->from = ucfirst(trim($client_name));
                $this->Email->to = trim($this->AdminFlrEmailID);

                if ($payment_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Payment Request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Payment Request Approval  ";

                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', $this->AdminName);
                $this->Email->delivery = 'smtp';

                if ($payment_status == 'STSTY05')
                    $mesage = ucfirst(trim($client_name)) . " payment request has been rejected by RFA following are client and  card details.";
                else
                    $mesage = ucfirst(trim($client_name)) . " payment request has been approved by RFA following are client and card details.";


                $mesage .= '<br/> <br/> Flr Client No. : ' . ltrim($client_no,'01');

                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($payment_status == 'STSTY04')
                    $mesage .= '<br/> Payment Approved For  : ' . $claim_no;

                if ($payment_status == 'STSTY05')
                    $mesage .= '<br/> Remark : ' . $reason;

                $this->Email->send($mesage);
                $mesage = '';

                /*                 * ******************* End Email********************** */

                if ($ClientsEmailID == true) {

                    $this->ClaimHeader->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->ClaimHeader->id = $claim_no;
                    $this->ClaimHeader->set($data);
                    $this->ClaimHeader->save($data, false);
                }

                $counter++;
                if ($counter > 50)
                    break;
            }
        }
		$this->flr_bankdetailchangeApprovalRejection();
		$this->flr_namechangeApprovalRejection();
    }
    
    
    
    
    
    function flr_bankdetailchangeApprovalRejection() {

        $this->loadModel('ClientBankHistory');
        $this->loadModel('Client');

        $this->Client->unbindModel(array('belongsTo' => array('ParameterType'), 'hasOne' => array('ClientHeader', 'ClientBank'), 'hasMany' => array('ClientFuelOutlet')));

        $fields = array('ClientBankHistory.vc_comp_code', 'ClientBankHistory.vc_bank_code', 
                        'ClientBankHistory.vc_account_holder_name','ClientBankHistory.vc_bank_account_no', 
                        'ClientBankHistory.vc_account_type', 'ClientBankHistory.vc_bank_name',
                        'ClientBankHistory.vc_bank_branch_name','ClientBankHistory.vc_branch_code',
                        'ClientBankHistory.vc_client_no','ClientBankHistory.dt_date1','ClientBankHistory.ch_active',
                        'ClientBankHistory.vc_entry_user','ClientBankHistory.ch_email_flag',
                        'ClientBankHistory.vc_reason','ClientBankHistory.vc_bank_history_id',
                        'Client.vc_client_no', 'Client.vc_id_no', 'Client.vc_client_name', 'Client.vc_cell_no',
                        'Client.vc_email', 'Client.vc_comp_code'
        );

        $options['joins'] = array(
            array('table' => 'MST_BANK_HIST_FLR',
                'alias' => 'ClientBankHistory',
                'type' => 'INNER',
                'conditions' => array(
                    array('ClientBankHistory.ch_email_flag' => 'N'),
                    array('ClientBankHistory.vc_client_no = Client.vc_client_no'),
                    'OR' => array(
                        array('ClientBankHistory.ch_active' => 'STSTY04'),
                        array('ClientBankHistory.ch_active' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;
        $ClientsEmailID = $this->Client->find('all', $options);
        
        
      //pr($ClientsEmailID); die;

        $sizeOf = sizeof($ClientsEmailID);

        if ($sizeOf > 0) {
            $counter = 0;
            foreach ($ClientsEmailID as $index => $value) {
                $client_no = $value['Client']['vc_client_no'];
                $client_id = $value['Client']['vc_id_no'];
                $mobile = $value['Client']['vc_cell_no'];
                $email = $value['Client']['vc_email'];
                $client_name = $value['Client']['vc_client_name'];
                $comp_code = $value['Client']['vc_comp_code'];
                
                $Status = $value['ClientBankHistory']['ch_active'];
                $Reason = $value['ClientBankHistory']['vc_reason'];
                $AccHolderName = $value['ClientBankHistory']['vc_account_holder_name'];
                $ChangeReqDate = !empty($value['ClientBankHistory']['dt_date1']) ? date('d-M-Y', strtotime($value['ClientBankHistory']['dt_date1'])) : '';
                $AccType       = $value['ClientBankHistory']['vc_account_type'];
                $BankName      = $value['ClientBankHistory']['vc_bank_name'];
                $BankBranchName      = $value['ClientBankHistory']['vc_bank_branch_name'];
                $BankBranchCode      = $value['ClientBankHistory']['vc_branch_code'];
                $ID                  = $value['ClientBankHistory']['vc_bank_history_id'];
            
                /***************Email Shoot to Client***************** */
              
                
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($comp_code);
                $this->Email->reset();
                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
                $this->Email->to = trim($email);

                if ($Status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Bank detail change request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Bank detail change request Approval  ";

                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', ucfirst(trim($client_name)));
                $this->Email->delivery = 'smtp';

                if ($Status == 'STSTY05')
                    $mesage = " Your bank details change request has been rejected by RFA .";
                else
                    $mesage = " Your bank details change request has been approved by RFA .";

                $mesage .= '<br/><br/>  FLR Client No. : ' . ltrim($client_no,'01');

                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';
                

                if ($Status == 'STSTY05') 
                {
                    $mesage .= '<br/>Account Holder Name   : ' . $AccHolderName;
                    $mesage .= '<br/>Bank Name             : ' . $BankName;
                    $mesage .= '<br/>Requested Date        : ' . $ChangeReqDate;
                    $mesage .= '<br/>Remarks               : ' . $Reason;
                }

                if ($Status == 'STSTY04') 
                {
                    $mesage .= '<br/>Account Holder Name   : ' . $AccHolderName;
                    $mesage .= '<br/> Bank Name : ' . $BankName;
                    $mesage .= '<br/> Requested Date : ' . $ChangeReqDate;
                }
             
               $ClientsEmailID = $this->Email->send($mesage);
               $mesage = '';

                /* ======End of email shoot for customer ============= */
                $this->Email->reset();

                /******************Email Send To Admin************************** */
                $this->Email->from = ucfirst(trim($client_name));
                $this->Email->to = trim($this->AdminEmailID);

                
                if ($Status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Bank details change request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Bank details change request Approval  ";
                

                $this->Email->template = 'registration';
                $this->Email->sendAs = 'html';
                $this->set('name', $this->AdminName);
                $this->Email->delivery = 'smtp';

                if ($Status == 'STSTY05')
                     $mesage = ucfirst(trim($client_name)) . " Bank details change has been rejected by RFA following are the Client and Bank details";
                else
                    $mesage = ucfirst(trim($client_name)) . " Bank details change has been approved by RFA following are the Client and Bank details";
                    

                $mesage .= '<br/> <br/> Flr Client No. : ' . ltrim($client_no,'01');

                if ($mobile != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($mobile);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';
                
                
                
                if ($Status == 'STSTY04') 
                {
                    $mesage .= '<br/>Account Holder Name   : ' . $AccHolderName;
                    $mesage .= '<br/> Bank Name : ' . $BankName;
                    $mesage .= '<br/> Requested Date : ' . $ChangeReqDate;
                }   
                
                if ($Status == 'STSTY05') 
                {
                    $mesage .= '<br/>Account Holder Name   : ' . $AccHolderName;
                    $mesage .= '<br/> Bank Name : ' . $BankName;
                    $mesage .= '<br/> Requested Date : ' . $ChangeReqDate;
                    $mesage .= '<br/> Remarks : ' . $Reason;
                }
                
                
                $this->Email->send($mesage);
                $mesage = '';

                /******************** End Email********************** */

                if ($ClientsEmailID == true) {

                    $this->ClientBankHistory->create();
                    $data['ch_email_flag'] = 'Y';
                    $data['dt_date2'] = date('d-m-Y');/* request approval/rejecttion date */
                    $this->ClientBankHistory->id = $ID;
                    $this->ClientBankHistory->set($data);
                    $this->ClientBankHistory->save($data, false);
                }

                $counter++;
                if ($counter > 50)
                    break;
            }
        }
    }
    
	/*
	*
	*cron function for name/ownership change
	*
	*/
    
	function flr_namechangeApprovalRejection() {

        $this->loadModel('ClientChangeHistory');
        
		$this->loadModel('Client');

        $this->Client->unbindModel(array('belongsTo' => array('ParameterType'), 'hasOne' => array('ClientHeader', 'ClientBank'), 'hasMany' => array('ClientFuelOutlet')));

        $fields = array('ClientChangeHistory.vc_client_name',
                        'ClientChangeHistory.vc_change_type',
                        'ClientChangeHistory.vc_remarks',
                        'ClientChangeHistory.vc_client_no',
                        'ClientChangeHistory.vc_change_id',
                        'ClientChangeHistory.vc_cell_no',
						'ClientChangeHistory.dt_change_date',
						'ClientChangeHistory.vc_email',
						'ClientChangeHistory.vc_status',
						'ClientChangeHistory.ch_email_flag',
                        'Client.vc_client_no', 
						'Client.vc_id_no',
						'Client.vc_client_name',
						'Client.vc_cell_no',
                        'Client.vc_email', 
						'Client.vc_comp_code'
        );

        $options['joins'] = array(
            array('table' => 'MST_CLIENT_CHANGE_FLR',
                'alias' => 'ClientChangeHistory',
                'type' => 'INNER',
                'conditions' => array(
                    array('ClientChangeHistory.ch_email_flag' => 'N'),
                    array('ClientChangeHistory.vc_client_no = Client.vc_client_no'),
                    'OR' => array(
                        array('ClientChangeHistory.vc_status' => 'STSTY04'),
                        array('ClientChangeHistory.vc_status' => 'STSTY05')
                    )
        )));

        $options['fields'] = $fields;
		
        $ClientsEmailID = $this->Client->find('all', $options);

        $sizeOf = sizeof($ClientsEmailID);

        if ($sizeOf > 0) {
		
            $counter = 0;
        
		foreach ($ClientsEmailID as $index => $value) {
			
                $client_no     = $value['Client']['vc_client_no'];
                $client_id     = $value['Client']['vc_id_no'];
                $mobile        = $value['Client']['vc_cell_no'];
                $email         = $value['Client']['vc_email'];
                $client_name   = $value['Client']['vc_client_name'];
                $comp_code     = $value['Client']['vc_comp_code'];                
		$ch_email_flag = $value['ClientChangeHistory']['ch_email_flag'];	
                $Status        = $value['ClientChangeHistory']['vc_status'];
                $Remarks       = $value['ClientChangeHistory']['vc_remarks'];
                $NewClientName = $value['ClientChangeHistory']['vc_client_name'];
                $new_mobile_no = $value['ClientChangeHistory']['vc_cell_no'];
		
                $ChangeReqDate = !empty($value['ClientChangeHistory']['dt_change_date']) ? date('d-M-Y', strtotime($value['ClientChangeHistory']['dt_change_date'])) : '';
                $ChangeType    = $value['ClientChangeHistory']['vc_change_type'];
                $ID            = $value['ClientChangeHistory']['vc_change_id'];
		$vc_amend_email_id  = $value['ClientChangeHistory']['vc_email'];
	 
                /***************Email Shoot to Client******************/
				
					 list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($comp_code);

					$this->Email->from =   $this->AdminName . '<' . $this->AdminEmailID . '>';

					$this->Email->to = trim($email);
										
					if($Status=='STSTY05' && $ChangeType=='name')
					$this->Email->subject = strtoupper($selectedType) . " Name Rejection  ";
					else if($Status=='STSTY04' && $ChangeType=='name')
					$this->Email->subject = strtoupper($selectedType) . " Name Approval  ";
					else if($Status=='STSTY04' && $ChangeType=='ownership')
					$this->Email->subject = strtoupper($selectedType) . " Ownership Approval  ";
					else 
					$this->Email->subject = strtoupper($selectedType) . " Ownership Rejection  ";
					
					$this->Email->template = 'registration';
					
					$this->Email->sendAs = 'html';

					$this->set('name', ucfirst(trim($client_name))) ;

					$this->Email->delivery = 'smtp';

                                        if($Status=='STSTY05')
					$mesage = " Your request has been rejected by RFA.";
					else
					$mesage = " Your request has been approved by RFA.";
					
					
					if($ChangeType == 'name'){
					
					$mesage .= '<br/><br/> <u><b>Name Change Details</b></u> : ';
					
					$mesage.='<br/></br>Client Name :   '.trim($NewClientName);
					
					$mesage.='<br/></br>Client No. :   '.ltrim($client_no,'01');
					
					}else{
                                            
					$mesage .= '<br/><br/> <u><b>Ownership Change Details</b></u> : ';
					
					$mesage .= '<br/><br/>Client Name. : '.trim($NewClientName);
					
					$mesage.='<br/></br>Client Mobile:   '.trim($new_mobile_no);
					
					$mesage.='<br/></br>Client Email-id:   '.trim($vc_amend_email_id);
					
					}
					
					
					$mesage .='<br/><br/> <u><b>Requested by</b></u> : ';
					
					$mesage .='<br/>Client No.:'.ltrim($client_no,'01');
					
					if($mobile!='')
					$mesage .= '<br/> Mobile No. : '.trim($mobile);
					else
					$mesage .= '<br/> Mobile No. :  N/A ';
					
					if($Status=='STSTY05')					
					$mesage .= '<br/> Remarks : '.$Remarks;
				

					$customerEmailStatus = $this->Email->send($mesage);

					$mesage = '';

					
					/*======End of email shoot for Client =============*/
					
					
					$this->Email->reset();
					
					
					/******************Email Send To Admin***************************/
					
					$this->Email->from = ucfirst(trim($client_name));
					
					$this->Email->to = trim($this->AdminMdcEmailID);
					
					if($Status=='STSTY05' && $ChangeType=='name')
					$this->Email->subject = strtoupper($selectedType) . " Name Rejection  ";
					else if($Status=='STSTY04' && $ChangeType=='name')
					$this->Email->subject = strtoupper($selectedType) . " Name Approval  ";
					else if($Status=='STSTY04' && $ChangeType=='ownership')
					$this->Email->subject = strtoupper($selectedType) . " Ownership Approval  ";
					else 
					$this->Email->subject = strtoupper($selectedType) . " Ownership Rejection  ";
					
					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', $this->AdminName);

					$this->Email->delivery = 'smtp';

                                        if($Status=='STSTY05')
					$mesage = ucfirst(trim($client_name ))."  Request has been rejected by RFA following are client details.";
					else
					$mesage = ucfirst(trim($client_name ))."  Request has been approved by RFA following are client details.";

					//$mesage .= '<br/> <br/>Client No. : '.ltrim($client_no);
					
					
					if($ChangeType=='name'){
					
						$mesage .= '<br/><br/> <u><b>Name Change Details</b></u> : ';
						
						$mesage.='<br/></br>Client Name :   '.trim($NewClientName);
						
						$mesage.='<br/></br>Client No. :   '.ltrim($client_no,'01');

					}else{
					
						$mesage .= '<br/><br/> <u><b>Ownership Change Details</b></u> : ';
						
						$mesage .= '<br/><br/> Client Name. : '.trim($NewClientName);
						
						$mesage.='<br/></br>Client Mobile:   '.trim($mobile);
						
						$mesage.='<br/></br>Client Email-id:   '.trim($vc_amend_email_id);

					}
					
					
					$mesage .='<br/><br/> <u><b>Requested by</b></u> : ';
					
					$mesage .='<br/>Client No.:'.ltrim($client_no,'01');
					
					
					if($new_mobile_no!='')
					$mesage .= '<br/> Mobile No. : '.trim($new_mobile_no);
					else
					$mesage .= '<br/> Mobile No. :  N/A ';
					
					
					if($Status=='STSTY05')
					$mesage .= '<br/> Remarks : '.$Remarks;	

					$this->Email->send($mesage);
					
					$mesage = '';
					
					/********************** End Email***********************/
 
						$data = array('ClientChangeHistory.ch_email_flag' => 'Y');
                        
						if ($customerEmailStatus == true) {
						
							$this->ClientChangeHistory->create();
							$data['ch_email_flag'] = 'Y';
							$this->ClientChangeHistory->id = $ID;					
							$this->ClientChangeHistory->set($data);						
							$this->ClientChangeHistory->save($data, false);
						
						}
						
						$counter++;
						
						if($counter>50)
                         break;						
								
            }
        }
    }

}