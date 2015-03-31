<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class ClientsController extends AppController {

    /**
     *
     *
     */
    var $name = 'Clients';

    /**
     *
     *
     */
             
    var $uses = array('Client', 'Member','BankBranch','FuelOutlet','ClientHeader','ClientUploadDocs','ClientFuelOutlet','Bank','ParameterType','ClientChangeHistory','ClaimprocessData','ClientBank','ClientBankHistory');

    /**
     *
     *
     */
    public function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();
        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');
        if ($FRL_USER_TYPE == 'USRLOGIN_SUPL') {
            $this->redirect(array('controller' => 'suppliers', 'action' => 'index', 'flr' => true));
        }
        $this->layout = $this->Auth->params['prefix'] . '_layout';
       
		 $vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
		  $ch_active = $this->Session->read('Auth.Client.ch_active_flag');
		//$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
		  $vc_username = $this->Session->read('Auth.Member.vc_username');
	
		if($vc_username!='' && $ch_active=='STSTY04' && $FRL_USER_TYPE=='USRLOGIN_CLT')	
		$this->Auth->allow('flr_view','flr_changepassword',
		'flr_viewchangeofownership','flr_changeofownership','flr_viewbankdetailschanges','flr_bankdetailschanges','flr_downloadbankdoc','flr_downloadrefunddoc','flr_managefueloutlets','flr_getselectedoutletsdropdown','flr_getoutletsdropdown','flr_getbranchlist','flr_checkbussinessregid','flr_getRefundPercent','flr_checkcategoryexist','flr_confirmbankdetailschanges','flr_getbankremarksbyid','flr_getownershipremarksbyid');
		
		if($vc_username!='' && ( $ch_active=='STSTY06' || $ch_active=='STSTY07') &&  $FRL_USER_TYPE=='USRLOGIN_CLT')	
		$this->Auth->allow('flr_view','flr_changepassword','flr_downloadbankdoc','flr_downloadrefunddoc','flr_managefueloutlets','flr_getselectedoutletsdropdown','flr_getoutletsdropdown','flr_getbranchlist','flr_checkbussinessregid','flr_getRefundPercent','flr_checkcategoryexist');
	
			
		if($vc_username!='' && ($ch_active=='STSTY05' || $ch_active==''  )&& $FRL_USER_TYPE=='USRLOGIN_CLT' )
		$this->Auth->allow('flr_index','flr_view','flr_changepassword','flr_downloadbankdoc','flr_downloadrefunddoc','flr_getselectedoutletsdropdown','flr_getoutletsdropdown','flr_getbranchlist','flr_checkbussinessregid','flr_getRefundPercent','flr_checkcategoryexist');
		
		if($vc_username!='' && ($ch_active=='STSTY03') && $FRL_USER_TYPE=='USRLOGIN_CLT' )
		$this->Auth->allow('flr_view','flr_changepassword','flr_downloadbankdoc','flr_downloadrefunddoc','flr_getselectedoutletsdropdown','flr_getoutletsdropdown','flr_getbranchlist','flr_checkbussinessregid','flr_getRefundPercent','flr_checkcategoryexist');
				
		$this->loginRightCheck();
		

    }


    function loginRightCheck() {
		
       if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {
            $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        }
    }
	
	
	
	/**
	*
	*
	*
	*
	*/

	function flr_getbankremarksbyid(){

		Configure::write('debug', 0);
		
		$this->layout = null;
		
		if( $this->params['isAjax'] && isset($this->params['data']) ):
			
	     $this->loadModel('ClientBankHistory');
  
         $vc_client_no = trim($this->Session->read('Auth.Client.vc_client_no'));
		 
         $totalrequestAlready = $this->ClientBankHistory->find('first', array(
            'conditions' => array('ClientBankHistory.vc_bank_history_id' => base64_decode(trim($this->params['data']))),
           ));

		$this->set('data', $totalrequestAlready['ClientBankHistory']['vc_reason']);
		//pr($totalrequestAlready);die;		
			//	die;
		else :
	
		$totalrequestAlready  = array();	
		
		$this->set('data',  $totalrequestAlready);	

		endif;
	
	}
	function flr_getownershipremarksbyid(){

		Configure::write('debug', 0);
		
		$this->layout = null;
		
		if( $this->params['isAjax'] && isset($this->params['data']) ):
			
	     $this->loadModel('ClientChangeHistory');
  
         $vc_client_no = trim($this->Session->read('Auth.Client.vc_client_no'));
		 
         $totalrequestAlready = $this->ClientChangeHistory->find('first', array(
            'conditions' => array('ClientChangeHistory.vc_change_id' => base64_decode(trim($this->params['data']))),
           ));

		$this->set('data', $totalrequestAlready['ClientChangeHistory']['vc_remarks']);
		//echo $totalrequestAlready['ClientChangeHistory']['vc_remarks'];
		//pr($totalrequestAlready);
		//die;		
			//	die;
		else :
	
		$totalrequestAlready  = array();	
		
		$this->set('data',  $totalrequestAlready);	

		endif;
	
	}
	
    /**
     *
     *
     */
	 
    public function flr_index($id = null) {

        try {
				
            set_time_limit(0);
            $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');

            if ($FRL_USER_TYPE == 'USRLOGIN_SUPL') {
			
                $this->redirect('supplier');
            
			} else {

             

                if (isset($this->data) && !empty($this->data) ) {

					
                    $this->Client->set($this->data);

                    $this->ClientHeader->set($this->data);

                    $this->ClientUploadDocs->set($this->data);

                    $this->ClientBank->set($this->data);

                    $this->ClientFuelOutlet->set($this->data);

                    if ($this->Client->validates(array('fieldList' => array(
                                    'vc_id_no',
                                    'vc_client_name',
                                    'vc_contact_person',
                                    'vc_address1',
                                    'vc_address2',
                                    'vc_address3',
                                    'vc_postal_code1',
                                    'vc_tel_no',
                                    'vc_cell_no',
                                    'vc_fax_no',
                                    'vc_address4',
                                    'vc_address5',
                                    'vc_address6',
                                    'vc_postal_code2',
                                    'vc_tel_no2',
                                    'vc_cell_no',
                                    'vc_cell_no2',
                                    'vc_fax_no2',
                                    'vc_email2'
                        ))) && $this->ClientHeader->validates(array('fieldList' => array(
                                    'vc_cateogry',
                                    'nu_refund',
                                    'nu_fuel_usage',
                                    'nu_expected_usage',
                                    'nu_off_road_usage',
                                    'nu_off_expected_usage'))) &&
									$this->ClientBank->validates(array('fieldList' => array(
                                    'vc_account_holder_name',
                                    'vc_bank_account_no',
                                    'vc_account_type',
                                    'vc_bank_name',
                                    'vc_branch_code',
                                    'vc_bank_branch_name'
                        ))) && $this->ClientUploadDocs->validates(array('fieldList' => array(
                                    'fuelusagedoc',
                                    'bankdoc'
                        )))
                    ) {


                        //ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes

                        $client = $this->Client->getDataSource();

                        $ClientHeader = $this->ClientHeader->getDataSource();

                        $ClientBank = $this->ClientBank->getDataSource();


                        $client->begin();

                        $ClientHeader->begin();

                        $ClientBank->begin();

                        $id = $id == null ? null : base64_decode($id);

                        if ($id == null) {

                            $primaryKey =  $this->Client->getPrimaryKey();

                            $this->data['Client']['dt_date1'] = date('d-M-Y H:i:s');

                            $this->data['ClientBank']['dt_date1'] = date('d-M-Y H:i:s');

                            $this->data['ClientHeader']['dt_date2'] = date('d-M-Y H:i:s');
                        } else {

                            if ($this->Client->find('count', array('conditions' => array('Client.vc_client_no' => trim($id)))) > 0) {

                                $primaryKey = $id;

                                $this->data['Client']['dt_mod_date'] = date('d-M-Y H:i:s');

                                $this->data['ClientBank']['dt_mod_date'] = date('d-M-Y H:i:s');

                                $this->ClientHeader->deleteAll(array('ClientHeader.vc_client_no' => $primaryKey), false);

                                $this->ClientBank->deleteAll(array('ClientBank.vc_client_no' => $primaryKey), false);

                                $ClientHeader->commit();

                                $ClientBank->commit();
                            } else {

                                $this->Session->setFlash('Invalid parameter, please try again!!!', 'info');

                                $this->redirect($this->referer());
                            }
                        }


                        /*******Master Table MST_Client****************** */

                        $this->data['Client']['vc_comp_code'] = trim($this->Session->read('Auth.Member.vc_comp_code'));
                        $vc_cateogry = $this->data['ClientHeader']['vc_cateogry'];

                        if ($vc_cateogry == 'A' || $vc_cateogry == 'L') {

                            $this->data['ClientHeader']['nu_building_percnt'] = '';
                            $this->data['ClientHeader']['nu_civil_percnt'] = '';
                        } elseif ($vc_cateogry == 'B' || $vc_cateogry == 'C') {

                            $this->data['ClientHeader']['nu_agronomic_percnt'] = '';
                            $this->data['ClientHeader']['nu_livestock_percnt'] = '';
                        } else {

                            $this->data['ClientHeader']['nu_agronomic_percnt'] = '';
                            $this->data['ClientHeader']['nu_livestock_percnt'] = '';
                            $this->data['ClientHeader']['nu_building_percnt'] = '';
                            $this->data['ClientHeader']['nu_civil_percnt'] = '';
                        }

                        $this->data['Client']['ch_active_flag'] = 'STSTY03';

                        $this->data['Client']['vc_client_no'] = $primaryKey;

                        $this->data['Client']['vc_user_no'] = trim($this->Session->read('Auth.Member.vc_user_no'));

                        $this->data['Client']['vc_email'] = trim($this->Session->read('Auth.Member.vc_email_id'));
                        $this->data['Client']['vc_username'] = $this->Session->read('Auth.Member.vc_username');

                        $this->data['Client']['vc_cp_address'] = isset($this->data['Client']['checkbox2']) && !empty($this->data['Client']['checkbox2']) ? 'Y' : 'N';

                        /*                         * *********Header Registration Table HD_REGISTRATION_FLR ****************** */

                        $this->data['ClientHeader']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');
                        $this->data['ClientHeader']['vc_client_no'] = $primaryKey;

                        $category = $this->ParameterType->find('first', array(
                            'conditions' => array(
                                'ParameterType.vc_prtype_code like' => 'CATFLR%',
                                'ParameterType.vc_prtype_name' => $this->data['ClientHeader']['vc_cateogry']),
                            'fields' => array('ParameterType.vc_prtype_desc')));

                        $this->data['ClientHeader']['category'] = isset($category['ParameterType']['vc_prtype_desc']) ? $category['ParameterType']['vc_prtype_desc'] : '';

                        /***********Header Registration Table MST_BANK_FLR ****************** */

                        $this->data['ClientBank']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');
                        $this->data['ClientBank']['vc_client_no'] = $primaryKey;
                        $this->data['ClientBank']['vc_branch_code'] = trim($this->data['ClientBank']['vc_bank_branch_name']);
                        $vc_bank_branch_name = $this->BankBranch->find('first', array(
                            'conditions' => array(
                                'BankBranch.branch_code' => $this->data['ClientBank']['vc_bank_branch_name']),
                            'fields' => array('BankBranch.branch')));


                        $this->data['ClientBank']['vc_bank_branch_name'] = $vc_bank_branch_name['BankBranch']['branch'];


                        $vc_bank_branch_name = $this->BankBranch->find('first', array(
                            'conditions' => array(
                                'BankBranch.branch_code' => $this->data['ClientBank']['vc_bank_branch_name']),
                            'fields' => array('BankBranch.branch')));

                        $this->data['ClientBank']['vc_bank_code'] = $this->data['ClientBank']['vc_bank_name'];

                        $vc_bank_name = $this->Bank->find('first', array('conditions' => array(
                                'Bank.vc_struct_code' => $this->data['ClientBank']['vc_bank_name']),
                            'fields' => array('Bank.vc_description')));
                        $this->data['ClientBank']['vc_bank_name'] = $vc_bank_name['Bank']['vc_description'];


                        if ($this->Client->save($this->data, false) && $this->ClientHeader->save($this->data, false) && $this->ClientBank->save($this->data, false)
                        ) {
                           
						   /*
							
						   if($this->data['ClientHeader']['nu_civil_percnt']!='')
							$this->Session->write($this->Session->read('Auth.ClientHeader.nu_civil_percnt'),$this->data['ClientHeader']['nu_civil_percnt']);
							if($this->data['ClientHeader']['nu_building_percnt']!='')
							$this->Session->write($this->Session->read('Auth.ClientHeader.nu_building_percnt'),$this->data['ClientHeader']['nu_building_percnt']);
							if($this->data['ClientHeader']['nu_agronomic_percnt']!='')
							$this->Session->write($this->Session->read('Auth.ClientHeader.nu_agronomic_percnt'),$this->data['ClientHeader']['nu_agronomic_percnt']);
							if($this->data['ClientHeader']['nu_livestock_percnt']!='')
							$this->Session->write($this->Session->read('Auth.ClientHeader.nu_livestock_percnt'),$this->data['ClientHeader']['nu_livestock_percnt']);
                            $client->commit();
*/
                            $ClientHeader->commit();

                            $ClientBank->commit();


                            if ($id != null && trim($id) != '') {

                                $this->ClientFuelOutlet->deleteAll(array('ClientFuelOutlet.vc_client_no' => $primaryKey), false);

                                $this->ClientUploadDocs->deleteAll(array('ClientUploadDocs.vc_client_no' => $primaryKey), false);

                                $this->rrmdir(WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Bank');

                                $this->rrmdir(WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Refund');
                            }


                            /*                             * *********Upload Document Table MST_CLIENT_FUEL_FLR ****************** */

                            foreach ($this->data['ClientFuelOutlet']['fueloutlets'] as $value) {

                                $fuelOutLets['ClientFuelOutlet']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                                $fuelOutLets['ClientFuelOutlet']['vc_client_no'] = $primaryKey;

                                $fuelOutLets['ClientFuelOutlet']['vc_fuel_outlet'] = $value;
                                $fuelOutLets['ClientFuelOutlet']['vc_status'] = 'STSTY04';

                                $fuelOutLets['ClientFuelOutlet']['dt_created'] = date('d-M-Y H:i:s');

                                $this->ClientFuelOutlet->save($fuelOutLets, false);

                                unset($fuelOutLets);
                            }


                            /** *******Upload Document Table DT_CLIENT_UPLOAD_DOCS_FLR ****************** */
                            foreach ($this->data['ClientUploadDocs'] as $key => $value) {


                                $uploadDocs['ClientUploadDocs']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                                $uploadDocs['ClientUploadDocs']['dt_date_uploaded'] = date('d-M-Y H:i:s');

                                $uploadDocs['ClientUploadDocs']['vc_client_no'] = $primaryKey;

                                $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'] = $value['name'];

                                $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_type'] = $value['type'];

                                if (strtolower(trim($key)) == strtolower('fuelusagedoc')) :

                                    $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_for'] = 'Refund';

                                    $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'] = WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Refund';

                                    $uploadDocs['ClientUploadDocs']['vc_upload_id'] = $this->ClientUploadDocs->getPrimaryKey();

                                    $uploadDocs['ClientUploadDocs']['vc_is_bank'] = 'N';

                                    $uploadDocs['ClientUploadDocs']['vc_is_refund'] = 'Y';

                                elseif (strtolower(trim($key)) == strtolower('bankdoc')) :


                                    $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_for'] = 'Bank';

                                    $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'] = WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Bank';

                                    $uploadDocs['ClientUploadDocs']['vc_upload_id'] = $this->ClientUploadDocs->getPrimaryKey();

                                    $uploadDocs['ClientUploadDocs']['vc_is_bank'] = 'Y';

                                    $uploadDocs['ClientUploadDocs']['vc_is_refund'] = 'N';


                                endif;

                                if ($this->ClientUploadDocs->save($uploadDocs, false)) {

                                    $dir = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'];

                                    if (!file_exists($dir)) {

                                        mkdir($dir, 0777, true);
                                    }

                                    $filename = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'];

                                    if (file_exists($dir . DS . $filename)) {

                                        $filename = date('YmdHis') . '-' . $filename;
                                    }

                                    move_uploaded_file($value["tmp_name"], $dir . DS . $filename);
                                }

                                unset($uploadDocs);
                            }

                            $this->loadModel('Member');

                            $saveData = array();

                            $saveData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');

                            $saveData['Member']['vc_flr_customer_no'] = $primaryKey;

                            $saveData['Member']['vc_user_no'] = trim($this->Session->read('Auth.Member.vc_user_no'));

                            $this->Member->save($saveData, false);

                            unset($saveData);

                            /*                             * ******************************Email Functionality **************************** */


                            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                            $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                            $this->Email->bcc = array(trim($this->AdminFlrEmailID));

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                            $this->Email->delivery = 'smtp';

                            if ($id != null && trim($id) != '') {

                                $mesage = "Your account has been updated successfully, pending for approval from RFA !!";

                                $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                                $this->Email->subject = strtoupper($selectedType) . " Account Updated ";
                            } else {

                                $mesage = "Your account has been created successfully, pending for approval from RFA !!";

                                $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                                $this->Email->subject = strtoupper($selectedType) . " Account Created ";
                            }


                            $this->Email->send($mesage);

                            $this->Email->to = array();

                            $this->Email->bcc = array();

                            /*    *******************Email Send To Admin************************* */

                            /* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))) . '<' . trim($this->Session->read('Auth.Member.vc_email_id')) . '>';

                              $this->Email->to = trim($this->AdminEmailID);

                              $this->Email->template = 'registration';

                              $this->Email->sendAs = 'html';

                              $this->set('name', $this->AdminName);

                              $this->Email->delivery = 'smtp';

                              if ($id != null && trim($id) != '') {

                              $mesage = strtoupper($selectedType) . " Customer Profile Updation Request";

                              $this->Email->subject = strtoupper($selectedType) . " Customer Profile Updation Request";

                              } else {

                              $mesage = strtoupper($selectedType) . " Customer Profile Activation Request";

                              $this->Email->subject = strtoupper($selectedType) . " Customer Profile Activation Request";
                              }

                              $this->Email->send($mesage); */

                            /*                             * ******************************* End Email ***************************** */

                            $this->data = null;

                            $this->Session->write('Auth.Member.vc_flr_customer_no', $primaryKey);

                            if ($id != null && trim($id) != '') {

                                $this->Session->setFlash('Your account has been updated successfully, pending for approval from RFA !!', 'success');
                            } else {

                                $this->Session->setFlash('Your account has been created successfully, pending for approval from RFA !!', 'success');
                            }

                            $this->redirect(array('action' => 'view'));
                        } else {

                            $this->data = null;

                            $client->rollback();

                            $ClientHeader->rollback();

                            $ClientBank->rollback();

                            $this->Session->setFlash(' Your profile has not been created due to some error has occurred ', 'error');

                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }

                $this->set('accountType', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'ACCTYPEFLR%'), 'fields' => array('TRIM(ParameterType.vc_prtype_name)', 'TRIM(ParameterType.vc_prtype_desc)'))));

				$this->loadModel('FuelOutlet');
				$this->loadModel('BankBranch');
                $this->set('flrFuelOutLet', $this->FuelOutlet->find('list'));

                $this->set('flrBank', $this->Bank->find('list', array('fields' => array('TRIM(Bank.vc_struct_code)', 'TRIM(Bank.vc_description)'))));

                $this->set('flrCategory', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CATFLR%'), 'fields' => array('TRIM(ParameterType.vc_prtype_name)', 'TRIM(ParameterType.vc_prtype_desc)'))));

					///echo $this->Session->read('Auth.Member.vc_flr_customer_no');
					//echo $this->Session->read('Auth.Client.ch_active_flag');
                if (trim($this->Session->read('Auth.Member.vc_flr_customer_no')) == '') :

                    $this->set('bankbranch', $this->BankBranch->find('list', array('fields' => array('TRIM(BankBranch.branch_code)', 'TRIM(BankBranch.branch)'))));

                    $this->set('title_for_layout', " Add Client Profile ");

                    $this->render('flr_index');

                elseif (trim($this->Session->read('Auth.Client.ch_active_flag')) == 'STSTY05'):

                    $this->set('bankbranch', $this->BankBranch->find('list', array('conditions' => array('BankBranch.bank_code' => $this->Session->read('Auth.ClientBank.vc_bank_code')), 'fields' => array('TRIM(BankBranch.branch_code)', 'TRIM(BankBranch.branch)'))));

                    $this->set('title_for_layout', " Edit Client Profile ");

                    $this->render('flr_edit');

                else :

                    $this->redirect('view');

                endif;
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
    public function flr_view() {
        try {
		//pr($this->Session->read('Auth.Client'));
		//pr($this->Session->read('Auth.ClientHeader'));

            $this->loadModel('FuelOutlet');

            if ($this->Session->read('Auth.Member.vc_flr_customer_no') == '' || $this->Session->read('Auth.Client.ch_active_flag') == 'STSTY05') :

                $this->redirect('index');

            endif;

            $this->set('title_for_layout', " View Client Profile ");

            $this->set('flrFuelOutLet', $this->FuelOutlet->find('list'));
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     * 
     * Flr Change Client Password 
     *
     */
    public function flr_changepassword() {

        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');

        if ($FRL_USER_TYPE == 'USRLOGIN_SUPL') {


            $this->layout = 'flr_supplier';
        }

        try {

            $this->set('title_for_layout', " Change Password ");

            if (!empty($this->data) && $this->RequestHandler->isPost()) {
                $this->Client->set($this->data);
                /*                 * ************* Use this before any validation *********************************** */
                $setValidates = array(
                    'vc_old_password',
                    'vc_password',
                    'vc_confirm_password');

                /*                 * ******************************************************************************************* */

                $username = $this->Session->read('Auth.Member.vc_username');
                $newpassword = $this->data['Client']['vc_password'];

                if ($this->Client->validates(array('fieldList' => $setValidates))) {
                    $this->loadModel('Member');
                    $this->Member->validate = null;
                    $updateData['Member']['vc_password'] = $this->Auth->password(trim($this->data['Client']['vc_password']));
                    $updateData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');
                    $updateData['Member']['vc_user_no'] = $this->Session->read('Auth.Member.vc_user_no');

                    if ($this->Member->save($updateData)) {
                        $this->data = NUll;
                        /**                         * ******************************Email send to client*********************************** */
                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
                        $this->Email->subject = strtoupper($selectedType) . " Password Changed ";
                        $this->Email->template = 'registration';
                        $this->Email->sendAs = 'html';
                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));
                        $this->Email->delivery = 'smtp';
                        $mesage = " You have recently changed password on RFA portal ( " . strtoupper($selectedType) . " Section ). Please use the credentials mentioned below to login : ";
                        $mesage .= "<br><br> Username : " . trim($username);

                        $mesage .= "<br><br> Password : " . trim($newpassword);

                        $this->Email->send($mesage);


                        /**                         * **************************End email***************************** */
                        $this->Session->setFlash('Your password has been changed successfully !!', 'success');

                        $this->redirect($this->referer());
                    } else {

                        $this->data = NUll;

                        $this->Session->setFlash('Your password could not be changed, please try again later', 'error');
                    }
                }
            }

            $this->set('title_for_layout', " Change Password ");
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    public function flr_viewchangeofownership() {
        $this->loadModel('ParameterType');
        $this->loadModel('ClientChangeHistory');



        $vc_client_no = trim($this->Session->read('Auth.Client.vc_client_no'));

        $totalrequestAlready = $this->ClientChangeHistory->find('count', array(
            'conditions' => array(
                'ClientChangeHistory.vc_client_no' => $vc_client_no),
        ));

        $this->set('totalrequestAlready', $totalrequestAlready);
        $vc_comp_code = trim($this->Session->read('Auth.Member.vc_comp_code'));
        if ($totalrequestAlready > 0) {

            $this->paginate = array(
                'conditions' => array('ClientChangeHistory.vc_client_no' => $vc_client_no,
                    'ClientChangeHistory.vc_comp_code' => $vc_comp_code),
                'order' => array('ClientChangeHistory.dt_entry_date' => 'desc'),
                'limit' => 10
            );

            $this->set('allChangerequest', $this->paginate('ClientChangeHistory'));
        }

        $this->set('title_for_layout', 'View Bank details');
    }

    /**
     *
     * Flr Change of Ownership
     */
    public function flr_changeofownership() {

		   set_time_limit(0);
        $this->loadModel('ClientUploadDocs');

        $this->loadModel('ClientChangeHistory');


        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            $this->Client->create(false);

            $this->Client->set($this->data);

            $this->ClientChangeHistory->create(false);

            $this->ClientChangeHistory->set($this->data);

            $this->ClientUploadDocs->create(false);

            $this->ClientUploadDocs->set($this->data);

            if ($this->ClientChangeHistory->validates(array('fieldList' => array(
                            'vc_id_no',
                            'vc_client_name',
                            'vc_contact_person',
                            'vc_address1',
                            'vc_address2',
                            'vc_address3',
                            'vc_postal_code1',
                            'vc_tel_no',
                            'vc_cell_no',
                            'vc_fax_no',
                            'vc_address4',
                            'vc_address5',
                            'vc_address6',
                            'vc_postal_code2',
                            'vc_tel_no2',
                            'vc_cell_no',
                            'vc_cell_no2',
                            'vc_fax_no2',
                            'vc_cp_address'
                ))) && $this->ClientUploadDocs->validates(array('fieldList' => array('ownershipchange')))
            ) {

                if ($this->ClientChangeHistory->find('count', array(
                            'conditions' => array(
                                'ClientChangeHistory.vc_comp_code' => trim($this->Session->read('Auth.Client.vc_comp_code')),
                                'ClientChangeHistory.vc_client_no' => trim($this->Session->read('Auth.Client.vc_client_no')),
                                'ClientChangeHistory.vc_status' => 'STSTY03'
                    ))) == 0) {


                    if (trim($this->data['ClientChangeHistory']['type']) == '1') :

                        $this->data['ClientChangeHistory']['vc_change_type'] = 'name';

                    elseif (trim($this->data['ClientChangeHistory']['type']) == '2') :

                        $this->data['ClientChangeHistory']['vc_change_type'] = 'ownership';

                    else :

                        $this->data = null;

                        $this->Session->setFlash(' Invalid Client Amendment Type ', 'error');

                        $this->redirect($this->referer());

                    endif;
					
					$this->data['ClientChangeHistory']['vc_change_id'] = $this->ClientChangeHistory->getPrimaryKey();
					
					$this->data['ClientChangeHistory']['vc_comp_code'] = trim($this->Session->read('Auth.Client.vc_comp_code'));

                    $this->data['ClientChangeHistory']['vc_client_no'] = trim($this->Session->read('Auth.Client.vc_client_no'));

                    $this->data['ClientChangeHistory']['vc_client_name_old'] = $this->Session->read('Auth.Client.vc_client_name');

                    $this->data['ClientChangeHistory']['vc_id_no_old'] = $this->Session->read('Auth.Client.vc_id_no');

                    $this->data['ClientChangeHistory']['vc_contact_person_old'] = $this->Session->read('Auth.Client.vc_contact_person');

                    $this->data['ClientChangeHistory']['vc_status'] = 'STSTY03';
                    $this->data['ClientChangeHistory']['dt_entry_date'] = date('Y-m-d H:i:s');


                    if ($this->ClientChangeHistory->save($this->data['ClientChangeHistory'], false)) {

                        $uploadDocs['ClientUploadDocs']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                        $uploadDocs['ClientUploadDocs']['dt_date_uploaded'] = date('d-M-Y H:i:s');

                        $uploadDocs['ClientUploadDocs']['vc_client_no'] = trim($this->Session->read('Auth.Client.vc_client_no'));

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'] = $this->data['ClientUploadDocs']['ownershipchange']['name'];

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_type'] = $this->data['ClientUploadDocs']['ownershipchange']['type'];

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_for'] = 'Change Amendment';

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'] = WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Change Amendment';

                        $uploadDocs['ClientUploadDocs']['vc_upload_id'] = $this->ClientUploadDocs->getPrimaryKey();

                        $uploadDocs['ClientUploadDocs']['vc_is_change'] = 'Y';

                        if ($this->ClientUploadDocs->save($uploadDocs, false)) {

                            $dir = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'];

                            if (!file_exists($dir)) {

                                mkdir($dir, 0777, true);
                            }

                            $filename = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'];

                            if (file_exists($dir . DS . $filename)) {

                                $filename = time() . '-' . $filename;
                            }

                            move_uploaded_file($ClientUploadDocs['ownershipchange']["tmp_name"], $dir . DS . $filename);
                        }

                        $this->data = null;

                        unset($this->data);


                        /*                         * ******************** Email Send To Client ******************** */


                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                        $this->Email->bcc = array(trim($this->AdminFlrEmailID));

                        $this->Email->subject = strtoupper($selectedType) . "  Change of Name/Ownership";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Request for name/ownership change has been received , please wait for approval !!";

                        $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                        $mesage .= "<br> <br>RFA Account No. : " . trim($this->Session->read('Auth.Member.vc_flr_customer_no'));

                        $this->Email->send($mesage);

                        $this->Email->to = array();

                        $this->Email->bcc = array();


                        /*                         * ************************* Email Send To Admin************************** */


                        /* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))) . '<' . trim($this->Session->read('Auth.Member.vc_email_id')) . '>';

                          $this->Email->to = trim($this->AdminEmailID);

                          $this->Email->subject =strtoupper($selectedType)." "."  Name/Ownership Change Request ";

                          $this->Email->template = 'registration';

                          $this->Email->sendAs = 'html';

                          $this->set('name', $this->AdminName);

                          $this->Email->delivery = 'smtp';

                          $mesage = " Name/Ownership change request from a client !!";

                          $this->Email->send($mesage); */

                        $this->Session->setFlash(' Your request for name/ownership change has been sent, pending for approval from RFA !!', 'Success');

                        $this->redirect('changeofownership');
                    } else {

                        $this->data = null;

                        unset($this->data);

                        $this->Session->setFlash('Sorry, Your request could not be processed, please try again !!! ', 'error');

                        $this->redirect('changeofownership');
                    }
                } else {

                    $this->data = null;

                    unset($this->data);

                    $this->Session->setFlash('Sorry, you have already sent request for amendment, pending for approval from RFA !! ', 'info');

                    $this->redirect('changeofownership');
                }
            }
        }


        $this->set('title_for_layout', " Change Client Ownership or Name ");
    }
	
	public function flr_confirmbankdetailschanges(){
		Configure::write('debug', 0);

        $this->loadModel('ClientBankHistory');
        if(isset($this->data['ClientBankHistory']['vc_random_code']) && $this->data['ClientBankHistory']['vc_random_code']==''){
            $this->Session->setFlash('Please enter the verification pin','error');
            $this->redirect('confirmbankdetailschanges');
        }

        $noofrequest = $this->ClientBankHistory->find('count', array(
            'conditions' => array(
                'ClientBankHistory.vc_client_no' => trim($this->Session->read('Auth.Client.vc_client_no')),
                'ClientBankHistory.ch_active' => 'STSTY03',
		'ClientBankHistory.ch_verify_status'=>'N')));
        //die;
        $requestAlready = $this->ClientBankHistory->find('first', array(
            'conditions' => array(
                'ClientBankHistory.vc_client_no' => trim($this->Session->read('Auth.Client.vc_client_no')),
                'ClientBankHistory.ch_active' => 'STSTY03',
		'ClientBankHistory.ch_verify_status'=>'N')));

                $vc_random_code   = $requestAlready['ClientBankHistory']['vc_random_code'];
              //  pr($requestAlready);die;
		//$ch_verify_status = $requestAlready['ClientBankHistory']['ch_verify_status'];
		if(isset($noofrequest) && $noofrequest>0){
                
                if(isset($this->data['ClientBankHistory']['vc_random_code']) && !empty($this->data['ClientBankHistory']['vc_random_code'])){
		
                    if($vc_random_code==trim($this->data['ClientBankHistory']['vc_random_code'])){
									//$this->data = array('ClientBankHistory.ch_email_flag' => 'Y');

			//unset($this->data['ClientBankHistory']);
			$this->data['ClientBankHistory']['ch_verify_status'] =  'Y';
			$this->data['ClientBankHistory']['vc_bank_history_id'] =   $requestAlready['ClientBankHistory']['vc_bank_history_id'];
			$this->ClientBankHistory->create();
			$this->ClientBankHistory->set($this->data);
			if($this->ClientBankHistory->save($this->data,false)){
			
			 list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
						//$this->Email->to ='rishi.kapoor@essindia.co.in';
                        $this->Email->bcc = array(trim($this->AdminFlrEmailID));

                        $this->Email->subject = strtoupper($selectedType) . "  Change of Bank Details";
                       
                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Request for change of bank details has been received, please wait for approval from RFA !!";
					   

                        $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                        $mesage .= "<br> <br>RFA Account No. : " . trim($this->Session->read('Auth.Member.vc_flr_customer_no'));
						

                        $this->Email->send($mesage);

                        $this->Email->to = array();

                        $this->Email->bcc = array();

			
			}
			
			$this->Session->setFlash('You have successfully submitted the request ,please wait for approval from RFA','success');
			$this->redirect('viewbankdetailschanges');
                    }
			
		else{		
			
			$this->Session->setFlash('You have entered the invalid verification pin','error');
			$this->redirect('confirmbankdetailschanges');
		   }
                 }
	      }else{
			$this->redirect('viewbankdetailschanges');
		}
	
	}

    public function flr_viewbankdetailschanges() {
        $this->loadModel('ParameterType');

        $this->loadModel('ClientBank');

        $this->loadModel('ClientUploadDocs');

        $this->loadModel('ClientBankHistory');

        $this->loadModel('Bank');
        $vc_client_no = trim($this->Session->read('Auth.Client.vc_client_no'));
        $totalrequestAlready = $this->ClientBankHistory->find('count', array(
            'conditions' => array(
                'ClientBankHistory.vc_client_no' => $vc_client_no),
        ));

        $this->set('totalrequestAlready', $totalrequestAlready);
        $vc_comp_code = trim($this->Session->read('Auth.Member.vc_comp_code'));
        if ($totalrequestAlready > 0) {

            $this->paginate = array(
                'conditions' => array('ClientBankHistory.vc_client_no' => $vc_client_no,
                    'ClientBankHistory.vc_comp_code' => $vc_comp_code),
                'order' => array('ClientBankHistory.dt_date1' => 'desc'),
                'limit' => 10
            );

            $this->set('title_for_layout', 'View Bank details');
        }

        $this->set('allBankrequest', $this->paginate('ClientBankHistory'));
    }

    /**
     *
     * Flr Change Bank Detail
     */
    public function flr_bankdetailschanges() {

	   set_time_limit(0);
        $this->loadModel('ParameterType');

        $this->loadModel('ClientBank');

        $this->loadModel('ClientUploadDocs');

        $this->loadModel('ClientBankHistory');

        $this->loadModel('Bank');

        $noofrequestAlready = $this->ClientBankHistory->find('count', array(
            'conditions' => array(
                'ClientBankHistory.vc_client_no' => trim($this->Session->read('Auth.Client.vc_client_no')),
                'ClientBankHistory.ch_active' => 'STSTY03')));
        if($noofrequestAlready>0){
             $this->Session->setFlash('You have already send request for amendment !!!', 'info');

             $this->redirect('confirmbankdetailschanges');
        }



        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            $this->ClientUploadDocs->set($this->data);

            $this->ClientBank->set($this->data);

            if ((int)$noofrequestAlready > 0) {

                unset($this->data);

                $this->data = null;

                $this->Session->setFlash('You have already send request for amendment but pending for approval !!!', 'info');
            } else {


                if ($this->ClientBank->validates(array('fieldList' => array(
                                'vc_account_holder_name',
                                'vc_bank_account_no',
                                'vc_account_type',
                                'vc_bank_name',
                                'vc_branch_code',
                                'vc_bank_branch_name'
                    ))) && $this->ClientUploadDocs->validates(array('fieldList' => array(
                                'bankdoc'
                    )))
                ) {

                    $this->loadModel('BankBranch');

                    $this->data['ClientBank']['vc_client_no'] = trim($this->Session->read('Auth.Client.vc_client_no'));

                    $this->data['ClientBank']['ch_active'] = 'STSTY03';

                    $this->data['ClientBank']['vc_bank_history_id'] = $this->ClientBankHistory->getPrimaryKey();


                    $this->data['ClientBank']['dt_date1'] = date('d-M-Y H:i:s');

                    $this->data['ClientBank']['vc_comp_code'] = trim($this->Session->read('Auth.Client.vc_comp_code'));

                    $this->data['ClientBank']['vc_branch_code'] = trim($this->data['ClientBank']['vc_bank_branch_name']);

                    $vc_bank_branch_name = $this->BankBranch->find('first', array(
                        'conditions' => array(
                            'BankBranch.branch_code' => $this->data['ClientBank']['vc_bank_branch_name']),
                        'fields' => array('BankBranch.branch')));


                    $this->data['ClientBank']['vc_bank_branch_name'] = $vc_bank_branch_name['BankBranch']['branch'];


                    $vc_bank_branch_name = $this->BankBranch->find('first', array(
                        'conditions' => array(
                            'BankBranch.branch_code' => $this->data['ClientBank']['vc_bank_branch_name']),
                        'fields' => array('BankBranch.branch')));

                    $this->data['ClientBank']['vc_bank_code'] = $this->data['ClientBank']['vc_bank_name'];
		            
					$randomnogenrater = rand(100000,190000);
                    $this->data['ClientBank']['vc_random_code'] = $randomnogenrater;
                    $this->data['ClientBank']['ch_verify_status'] = 'N';

                    $vc_bank_name = $this->Bank->find('first', array('conditions' => array(
                            'Bank.vc_struct_code' => $this->data['ClientBank']['vc_bank_name']),
                        'fields' => array('Bank.vc_description')));
                    $this->data['ClientBank']['vc_bank_name'] = $vc_bank_name['Bank']['vc_description'];
	

                    $this->ClientBankHistory->create();
					
					
                    if ($this->ClientBankHistory->save($this->data['ClientBank'], false)) {

                        $uploadDocs['ClientUploadDocs']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                        $uploadDocs['ClientUploadDocs']['dt_date_uploaded'] = date('d-M-Y H:i:s');

                        $uploadDocs['ClientUploadDocs']['vc_client_no'] = trim($this->Session->read('Auth.Client.vc_client_no'));

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'] = $this->data['ClientUploadDocs']['bankdoc']['name'];

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_type'] = $this->data['ClientUploadDocs']['bankdoc']['type'];

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_for'] = 'Bank Amendment';

                        $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'] = WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Bank Amendment';

                        $uploadDocs['ClientUploadDocs']['vc_upload_id'] = $this->ClientUploadDocs->getPrimaryKey();

                        $uploadDocs['ClientUploadDocs']['vc_is_bank_amendment'] = 'Y';

                        if ($this->ClientUploadDocs->save($uploadDocs, false)) {

                            $dir = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'];

                            if (!file_exists($dir)) {

                                mkdir($dir, 0777, true);
                            }

                            $filename = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'];

                            if (file_exists($dir . DS . $filename)) {

                                $filename = date('YmdHis') . '-' . $filename;
                            }

                            move_uploaded_file($value["tmp_name"], $dir . DS . $filename);
                        }

                        unset($uploadDocs);

                        $this->data = null;

                        unset($this->data);

                        /*   *****************Email to client*********************************** */


                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                       $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
						//$this->Email->to ='rishi.kapoor@essindia.co.in';
                        //$this->Email->bcc = array(trim($this->AdminFlrEmailID));

                       // $this->Email->subject = strtoupper($selectedType) . "  Change of Bank Details";
                        $this->Email->subject = strtoupper($selectedType) . " Verification details for Change of Bank Details";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                       // $mesage = " Request for change of bank details has been received, please wait for approval from RFA !!";
					    $mesage = "Please find the verification pin number for change of bank details!!";


                        $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                        $mesage .= "<br> <br>RFA Account No. : " . trim($this->Session->read('Auth.Member.vc_flr_customer_no'));
						 $mesage .= "<br> <br>Verification  No. : ".$randomnogenrater;


                        $this->Email->send($mesage);

                        $this->Email->to = array();

                        //$this->Email->bcc = array();


                        /************************** Email Send To Admin************************** */


                        /* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))) . '<' . trim($this->Session->read('Auth.Member.vc_email_id')) . '>';

                          $this->Email->to = trim($this->AdminEmailID);

                          $this->Email->subject =strtoupper($selectedType)." "."  Bank Details Change Request ";

                          $this->Email->template = 'registration';

                          $this->Email->sendAs = 'html';

                          $this->set('name', $this->AdminName);

                          $this->Email->delivery = 'smtp';

                          $mesage = " Bank details change request from a client !!";

                          $this->Email->send($mesage); 
						  */


                        /************************End email************************************ */


                        //$this->Session->setFlash('Your bank amendment request has been sent successfully, pending for approval from RFA !!', 'success');

                        $this->redirect('confirmbankdetailschanges');
                    }
                }
            }
        }

        $this->set('flrBank', $this->Bank->find('list', array('fields' => array('TRIM(Bank.vc_struct_code)', 'TRIM(Bank.vc_description)'))));

        $this->set('accountType', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'ACCTYPEFLR%'), 'fields' => array('TRIM(ParameterType.vc_prtype_name)', 'TRIM(ParameterType.vc_prtype_desc)'))));

        $this->set('title_for_layout', " Change Client Bank Detail ");
    }

    /*
     *
     * Get Branch List by Bank Code
     *
     */

    public function flr_getbranchlist() {


        $this->loadModel('BankBranch');

        $conditions = array();

        $this->layout = false;

        if (isset($this->params['url']['data']) && !empty($this->params['url']['data'])):

            $conditions += array('BankBranch.bank_code' => trim($this->params['url']['data']));

        endif;

        if (count($conditions) > 0) {
            $this->set('bankbranch', $this->BankBranch->find('list', array(
                        'conditions' => $conditions,
                        'fields' => array(
                            'TRIM(BankBranch.branch_code)',
                            'TRIM(BankBranch.branch)'))));
        } else {

            $this->set('bankbranch', array());
        }
    }

    /*
     *
     * 
     * Check Category Exist Along with mail 
     * 
     *
     */

    function flr_checkcategoryexist() {

        Configure::write('debug', 0);

        $this->loadModel('ClientHeader');

        $conditions = array();

        $this->layout = false;

        $count = NULL;

        if (isset($this->params['isAjax']) && $this->params['isAjax']) :

            if (isset($this->params['form']['id']) && !empty($this->params['form']['id'])) :

                $conditions += array('lower(Client.vc_user_no) !=' => strtolower(base64_decode(trim($this->params['form']['id']))));

            endif;


            if (isset($this->params['data']['ClientHeader']['vc_cateogry']) && !empty($this->params['data']['ClientHeader']['vc_cateogry'])) :

                $conditions += array('lower(ClientHeader.vc_cateogry)' => trim(strtolower($this->params['data']['ClientHeader']['vc_cateogry'])));

            endif;

            if (isset($this->params['form']['emailId']) && !empty($this->params['form']['emailId'])) :

                $conditions += array('lower(Client.vc_email)' => strtolower(trim(base64_decode($this->params['form']['emailId']))));

            endif;


        endif;

        $count = $this->ClientHeader->find('count', array('conditions' => $conditions));

        if ($count == 0) :

            echo "true";

        else :

            echo "false";

        endif;

        exit(0);
    }

    /*
     * Check Bussiness Id is exist or not
     * 
     */

    function flr_checkbussinessregid() {

          $conditions = array();

        $this->layout = false;

        $count = null;

        if ($this->params['isAjax']) :


            if (isset($this->params['form']['id']) && !empty($this->params['form']['id'])) :

                $conditions += array('lower(Client.vc_user_no) !=' => strtolower(base64_decode(trim($this->params['form']['id']))));

            endif;

            if (isset($this->params['data']['Client']['vc_id_no'])&& !empty($this->params['data']['Client']['vc_id_no'])) :
				
				$id_no = strtolower(trim($this->params['data']['Client']['vc_id_no']));
				
                $conditions += array("lower(Client.vc_id_no) = '{$id_no}' ");


            endif;

            $count = $this->Client->find('count', array('conditions' => $conditions));

        endif;
        if ($count == 0) :

            echo "true";

        else :

            echo "false";

        endif;

        exit(0);

		
		/*
		$conditions = array();

        $this->layout = false;

        $count = null;

        if ($this->params['isAjax']) :

            if (isset($this->params['form']['id'])) :

                $conditions += array('lower(Client.vc_user_no) !=' => strtolower(base64_decode(trim($this->params['form']['id']))));

            endif;

            if (isset($this->params['data']['Client']['vc_id_no'])) :

                $id_no = trim(strtolower($this->params['data']['Client']['vc_id_no']));

                $conditions += array("lower(Client.vc_id_no) = '{$id_no}' ");


            endif;

            $count = $this->Client->find('count', array('conditions' => $conditions));

        endif;

        if ($count == 0) :

            echo "true";

        else :

            echo "false";

        endif;

        exit(0);*/
    }

    /*
     *
     * Get OutLets Drop Down
     *
     */

    function flr_getoutletsdropdown() {

        Configure::write('debug', 0);

        $this->layout = false;

        $this->loadModel('FuelOutlet');

        if (isset($this->params['data']) && !empty($this->params['data'])):


            $flrFuelOutLet = array('' => 'Select') + $this->FuelOutlet->find('list', array('conditions' => array(
                            'FuelOutlet.vc_fuel_outlet NOT ' => count($this->params['data']) == 1 ? current($this->params['data']) : $this->params['data']
            )));

        else :

            $flrFuelOutLet = array('' => 'Select');

        endif;

        $this->set('flrFuelOutLet', $flrFuelOutLet);
    }

    /*
     *
     *
     *
     */

    function flr_downloadbankdoc() {

        Configure::write('debug', 0);

        $this->layout = NULL;

        $this->loadModel('ClientUploadDocs');

        $client_no = trim($this->Session->read('Auth.Client.vc_client_no'));

        $comp_code = trim($this->Session->read('Auth.Client.vc_comp_code'));

        $DownloadFile = $this->ClientUploadDocs->find('first', array(
            'conditions' => array(
                'ClientUploadDocs.vc_comp_code' => $comp_code,
                'ClientUploadDocs.vc_client_no' => $client_no,
                'ClientUploadDocs.vc_is_bank' => 'Y'),
            'order' => array('ClientUploadDocs.dt_date_uploaded' => 'desc')));

        if ($DownloadFile && file_exists($DownloadFile['ClientUploadDocs']['vc_uploaded_doc_path'] . DS . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name'])) {

            $path = $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_path'] . DS . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name'];

            header('Expires: 0');

            header('Pragma: public');

            header('Content-type:' . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_type']);

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Content-Disposition: attachment; filename="' . basename($DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name']) . '"');

            header('Content-Transfer-Encoding: binary');

            @readfile($path);

            exit(0);
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect($this->referer());
        }
    }

    /*
     *
     *
     *
     */

    function flr_downloadrefunddoc() {

        Configure::write('debug', 0);

        $this->layout = NULL;

        $this->loadModel('ClientUploadDocs');

        $client_no = trim($this->Session->read('Auth.Client.vc_client_no'));

        $comp_code = trim($this->Session->read('Auth.Client.vc_comp_code'));

        $DownloadFile = $this->ClientUploadDocs->find('first', array(
            'conditions' => array(
                'ClientUploadDocs.vc_comp_code' => $comp_code,
                'ClientUploadDocs.vc_client_no' => $client_no,
                'lower(ClientUploadDocs.vc_is_refund)' => strtolower('Y')),
            'order' => array('ClientUploadDocs.dt_date_uploaded' => 'desc')));

        if ($DownloadFile && file_exists($DownloadFile['ClientUploadDocs']['vc_uploaded_doc_path'] . DS . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name'])) {

            $path = $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_path'] . DS . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name'];

            header('Expires: 0');

            header('Pragma: public');

            header('Content-type:' . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_type']);

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Content-Disposition: attachment; filename="' . basename($DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name']) . '"');

            header('Content-Transfer-Encoding: binary');

            @readfile($path);

            exit(0);
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect($this->referer());
        }
    }

    /**
     *
     * Remove Folder and its files 
     *
     */
    function rrmdir($dir) {

        foreach (glob($dir . '/*') as $file) {

            if (is_dir($file))
                rrmdir($file);
            else
                unlink($file);
        }

        rmdir($dir);
    }

    /**
     *
     * get Flr Refund percent
     *
     */
    function flr_getRefundPercent() {

        $this->layout = false;



        if ($this->params['isAjax']) {
            $param = $this->params['data'];
        }

        $this->loadModel('ClaimprocessData');

        $refundRate = $this->ClaimprocessData->find('first', array('conditions' => array('ClaimprocessData.VC_FUEL_TYPE' => $param)));

        $sendOutput = array('nu_refund' => $refundRate['ClaimprocessData']['nu_refund_prcnt']);

        echo json_encode($sendOutput);
        exit;
    }

    public function flr_managefueloutlets($id = null) {

		set_time_limit(0);      
	    $this->loadModel('FuelOutlet');
        $this->loadModel('ClientFuelOutlet');

        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            $this->ClientFuelOutlet->set($this->data);

            $fuelOutLets = array();

            foreach ($this->data['ClientFuelOutlet']['fueloutlets'] as $key => $value) {

                $fuelOutLets[$key]['ClientFuelOutlet']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                $fuelOutLets[$key]['ClientFuelOutlet']['vc_client_no'] = $this->Session->read('Auth.Client.vc_client_no');

                $fuelOutLets[$key]['ClientFuelOutlet']['vc_fuel_outlet'] = $value;

                $fuelOutLets[$key]['ClientFuelOutlet']['vc_status'] = 'STSTY04';

                $fuelOutLets[$key]['ClientFuelOutlet']['dt_created'] = date('d-M-Y H:i:s');
            }



            if ($this->ClientFuelOutlet->saveAll($fuelOutLets, false)) {

                unset($fuelOutLets);
                $this->Session->setFlash('Your fuel outlets have been saved, pending for approval !!', 'success');
                $this->redirect($this->referer());
            } else {

                unset($this->data);
                unset($fuelOutLets);
                $this->Session->setFlash('Your fuel outlets could not be saved, please try again later', 'error');
            }
        }

        $limit = 10;
        $this->paginate = array(
            'conditions' => array(
                'ClientFuelOutlet.vc_client_no' => trim($this->Session->read('Auth.Client.vc_client_no')),
                'ClientFuelOutlet.vc_comp_code' => trim($this->Session->read('Auth.Client.vc_comp_code'))),
            'order' => array('ClientFuelOutlet.dt_created' => 'desc'),
            'limit' => $limit
        );

        $FuelOutList = $this->paginate('ClientFuelOutlet');

        $this->set('FuelOutList', $FuelOutList);
        $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;
        $this->set('pagecounter', $pagecounter);
        $this->set('limit', $limit);

        foreach ($FuelOutList as $val) {
            $outlet[] = $val['ClientFuelOutlet']['vc_fuel_outlet'];
        }

        $conditions = count($FuelOutList) == 0 ? $outlet = array() : array('NOT' => array('FuelOutLet.vc_fuel_outlet' => $outlet));

        $flrFuelOutLet = $this->FuelOutlet->find('list', array('conditions' => $conditions));

        $this->set('flrFuelOutLet', $flrFuelOutLet);
    }

    /**
     * Mannage selected outlets
     * 
     */
    function flr_getselectedoutletsdropdown() {

        Configure::write('debug', 0);

        $this->layout = false;

        $this->loadModel('FuelOutlet');

        if (isset($this->params['data']) && !empty($this->params['data'])):


            foreach ($this->Session->read('Auth.ClientFuelOutlet') as $val) {
                $outlet[] = $val['vc_fuel_outlet'];
            }

            foreach ($this->params['data'] as $value) {

                $outlet[] = $value;
            }

            $flrFuelOutLet = array('' => 'Select') + $this->FuelOutlet->find('list', array('conditions' => array(
                            'FuelOutlet.vc_fuel_outlet NOT ' => $outlet
            )));

        else :

            $flrFuelOutLet = array('' => 'Select');

        endif;

        $this->set('flrFuelOutLet', $flrFuelOutLet);
    }

}