<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class MembersController extends AppController {

    /**
     *
     *
     */
    var $name = 'Members';

    /**
     *
     *
     */
    var $components = array('Session', 'Auth', 'RequestHandler', 'Email');

    /**
     *
     *
     */
    var $uses = array('Member');

    /**
     *
     *
     */
    var $helpers = array('Session', 'Html', 'Form');

    /**
     *
     *
     */
    var $__userCode = null;

    /**
     *
     *
     */
    function beforeFilter() {

        $this->Auth->allow('login', 'registration', 'forgotpassword', 'activatemember', 'captcha_image', 'resetpassword', 'checkUserAccess');

        parent::beforeFilter();

        $currentUser = $this->checkUser();


        $loginRightCheck = $this->loginRightCheck();
		
    }

    /**
     *
     *
     */
    function index() {

        $this->redirect('registration');
    }

    /**
     *
     *
     */
    public function login($type = null) {


        try {
            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                unset($this->data['Member']['password']);

                $this->Member->set($this->data);

                if ($this->Member->validates(array('fieldList' => array('vc_username', 'vc_password', 'vc_comp_code', 'vc_captcha_code')))) {

                    $user = $this->Member->find('first', array(
                        'conditions' => array(
                            'Member.vc_username' => trim($this->data['Member']['vc_username']),
                            'Member.vc_password' => $this->Auth->password(trim($this->data['Member']['vc_password'])),
                            'Member.vc_comp_code' => trim($this->data['Member']['vc_comp_code']),
                            'Member.vc_user_status' => 'USRSTATUSACT',
                            'Member.vc_user_login_type !=' => 'USRLOGIN_INSP'
                        )
                    ));

                    $loginDetail = array('vc_username' => $user['Member']['vc_username'], 'vc_password' => $user['Member']['vc_password']);

                    $this->Auth->fields = array(
                        'username' => 'vc_username',
                        'password' => 'vc_password'
                    );

                    if ($user && $this->Auth->login($loginDetail)) {

                        unset($saveData);

                        $this->loadModel('UserLoginDetail');

                        $id = $this->UserLoginDetail->getPrimaryKey();

                        $SaveData['UserLoginDetail']['vc_comp_code'] = $user['Member']['vc_comp_code'];

                        $SaveData['UserLoginDetail']['vc_user_no'] = $user['Member']['vc_user_no'];

                        $SaveData['UserLoginDetail']['dt_login_datetime'] = date('d-M-Y H:i:s');

                        $SaveData['UserLoginDetail']['vc_login_ip_address'] = $this->RequestHandler->getClientIp();

                        $SaveData['UserLoginDetail']['nu_id'] = $id;

                        if ($this->UserLoginDetail->save($SaveData, false)) {

                            $this->Session->write('Auth.UserLoginDetail.nu_id', $id);
                        }

                        $this->data = null;

                        $this->Session->setFlash('You have been successfully logged in !!', 'success');

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($user['Member']['vc_comp_code']);

                        if ($user['Member']['vc_comp_code'] == $this->mdc) :

                            $this->redirect(array('controller' => 'profiles', 'action' => 'index'));

                        elseif ($user['Member']['vc_comp_code'] == $this->cbc) :


                            if ($this->Session->read('Auth.Member.vc_cbc_customer_no') == '') :

                                $this->redirect(array('controller' => 'customers', 'action' => 'customer_profile', 'cbc' => true));

                            elseif ($this->Session->read('Auth.Customer.ch_active') == 'STSTY05'):

                                $this->redirect(array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => true));

                            else:

                                $this->redirect(array('controller' => 'customers', 'action' => 'view', 'cbc' => true));


                            endif;


                        elseif ($user['Member']['vc_comp_code'] == $this->flr):

                            if ($this->Session->read('Auth.Member.vc_flr_customer_no') == '') :

                                $this->redirect(array('controller' => 'clients', 'action' => 'index', 'flr' => true));

                            else:

                                $this->redirect(array('controller' => 'clients', 'action' => 'view', 'flr' => true));

                            endif;

                        endif;
                    } else {

                        $this->data = null;

                        $this->Session->setFlash($this->Auth->loginError, 'error');
                    }
                }
            }
            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($type);

            $this->layout = 'registration';
		    if(Configure::read('companyCodemdc')==$type){
				  $this->set('selectedType', ($this->globalParameterarray['DESIGN-LABEL-MDC']));

				 }
				 else{
				 $this->set('selectedType', ($selectedType));

				 }
				//die;

            $this->set('selectedTypeID', $type);

            $this->set('title_for_layout', strtoupper($selectedType) . " Login ");

            $this->set('FLA_TYPE', $selectList);
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
    public function logout() {

        try {

            $this->loadModel('UserLoginDetail');

            $SaveData['UserLoginDetail']['dt_logout_datetime'] = date('d-M-Y H:i:s');

            $SaveData['UserLoginDetail']['nu_id'] = $this->Session->read('Auth.UserLoginDetail.nu_id');

            $this->UserLoginDetail->save($SaveData, false);

            $this->Session->destroy();

            $this->Session->setFlash('You have been successfully logged out !!', 'success');

            $this->redirect($this->Auth->logout());
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
    public function registration($type = null) {
        try {
            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Member->set($this->data);

                /*                 * ************** Use this before any validation *********************************** */
				if($this->data['Member']['wholesaler_supplier']==1){
				$this->data['Member']['vc_user_firstname']=$this->data['Member']['vc_user_firstname1'];

						$setValidates = 
						array('vc_email_id','vc_comp_code','vc_user_firstname1','vc_captcha_code');
					
				}else{
				$this->data['Member']['vc_user_firstname']=$this->data['Member']['vc_user_firstname'];
						$setValidates = array(
							'vc_email_id','vc_comp_code',
							'vc_user_firstname','vc_captcha_code','vc_user_lastname');
				}
                

                $this->unsetValidateVariable($setValidates, array_keys($this->Member->validate), &$this->Member);

                /*                 * ************************************************************************************* */

                if ($this->Member->validates()) {

                    unset($this->data['Member']['vc_captcha_code']);

                    unset($this->Member->validate);

                    $type = $this->data['Member']['vc_comp_code'];

                    $VC_USERNAME = $this->userCodeID();

                    $VC_PASSWORD = strtoupper(substr(trim($this->data['Member']['vc_user_firstname']), 0, 2)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 7);

                    $VC_USER_NO = strtolower(str_replace('-', '', substr($VC_USERNAME, 3)));

                    if (trim($this->data['Member']['vc_comp_code']) == $this->cbc) {
                        unset($this->Member->hasOne['Profile']);
                    }

                    $wholesaler_supplier = $this->data['Member']['wholesaler_supplier'];

                    switch ($this->data['Member']['vc_comp_code']) {

                        case $this->mdc :

                            $NU_USER_TYPE = 'USRLOGIN_CUST';
                            $USer_Type_Label = $this->mdcLabel;

                            break;

                        case $this->cbc :

                            $NU_USER_TYPE = 'USRLOGIN_CUST';
                            $USer_Type_Label = $this->cbcLabel;

                            break;

                        case $this->flr :

                            if ($wholesaler_supplier == 1) {
							
                                $NU_USER_TYPE = 'USRLOGIN_SUPL';
								
                            } else {

                                $NU_USER_TYPE = 'USRLOGIN_CLT';
                            }

                            $USer_Type_Label = $this->flrLabel;

                            break;
                    }

                    $saveData['Member']['vc_user_no'] = $VC_USER_NO;

                    $saveData['Member']['vc_username'] = $VC_USERNAME;

                    $saveData['Member']['vc_password'] = $this->Auth->password($VC_PASSWORD);

                    $saveData['Member']['vc_user_status'] = 'USRSTATUSINACT';

                    $saveData['Member']['vc_activation_request'] = 'USRACTREQACT';

                    $saveData['Member']['vc_user_login_type'] = $NU_USER_TYPE;

                    $saveData['Member']['vc_user_firstname'] = trim($this->data['Member']['vc_user_firstname']);

                    $saveData['Member']['vc_user_lastname'] = trim($this->data['Member']['vc_user_lastname']);

                    $saveData['Member']['vc_email_id']      = trim($this->data['Member']['vc_email_id']);

                    $saveData['Member']['vc_comp_code']     = trim($this->data['Member']['vc_comp_code']);

                    $saveData['Member']['dt_user_created']  = date('Y-m-d H:i:s');
					
				
                    if ($this->Member->save($saveData)) {

                        unset($saveData);

                        $encode_user_code = base64_encode($VC_USERNAME);

                        $encode_password = base64_encode($VC_PASSWORD);

                        $encode_type = base64_encode($this->data['Member']['vc_comp_code']);
						
						/*
                        if ($this->data['Member']['vc_comp_code'] == Configure::read('companyCodecbc'))
                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        if ($this->data['Member']['vc_comp_code'] == Configure::read('companyCodemdc'))
                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        if ($this->data['Member']['vc_comp_code'] == Configure::read('companyCodeflr'))
                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
						
						*/
						
						$this->Email->from = $this->AdminName.'<'.$this->AdminEmailID.'>';						

                        $this->Email->to = trim($this->data['Member']['vc_email_id']);
							if($this->data['Member']['wholesaler_supplier']==1){
							 $this->Email->subject = "$USer_Type_Label Supplier Registration Activation Link";
							} else {
							$this->Email->subject = "$USer_Type_Label Registration Activation Link";
							
							}

                        if ($type == $this->cbc)
                            $this->Email->attachments = array('Prepaid-Payment-Method-application-form.docx' => WWW_ROOT . 'document/Prepaid-Payment-Method-application-form.docx');

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->data['Member']['vc_user_firstname'])) . ' ' . ucfirst(trim($this->data['Member']['vc_user_lastname'])));

                        $this->Email->delivery = 'smtp';


                        if ($wholesaler_supplier == 1) {

                            $encode_user_type = base64_encode($NU_USER_TYPE);

                            $mesage = "Your account has been created for $USer_Type_Label. Please <a href= '" . WWW_HOST . "members/activatemember/" . $encode_type . "/" . $encode_user_code . "/" . $encode_password . "/" . $encode_user_type . "' > click here to activate your account. </a>";
                        } else {
                            $mesage = "Your account has been created for $USer_Type_Label. Please <a href= '" . WWW_HOST . "members/activatemember/" . $encode_type . "/" . $encode_user_code . "/" . $encode_password . "' > click here to activate your account. </a>";
                        }

                        $chekstatus= $this->Email->send($mesage);
						
                        $this->data = null;

                        $this->Session->setFlash(' You have been  registered successfully, please check your email to activate the account. ', 'success');

                        $this->redirect(array('controller' => 'members', 'action' => 'login', $type));
                    } else {

                        $this->data = null;

                        $this->Session->setFlash('Error while saving date, please try again later.', 'error');

                        $this->redirect('registration');
                    }
                }
            }

            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($type);

            $this->layout = 'registration';

            $this->set('selectedType', $selectedType);

            $this->set('selectedTypeID', $type);

            $this->set('title_for_layout', strtoupper($selectedType) . " Member Registration ");

            $this->set('FLA_TYPE', $selectList);
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
    public function forgotpassword($type = 0) {

        try {
			$this->loadModel('ClientHeader');

            if (!empty($this->data) && $this->RequestHandler->isPost()) {


                $this->Member->set($this->data);

                if ($this->Member->validates(array('fieldList' => array('vc_email_id_frgt', 'vc_comp_code]')))) {

                    $resultCheck = $this->Member->find('all', array(
                        'conditions' => array(
                            'Member.vc_email_id' => trim($this->data['Member']['vc_email_id_frgt']),
                            'Member.vc_comp_code' => $this->data['Member']['vc_comp_code'],
                            'Member.vc_user_status' => 'USRSTATUSACT'
                    )));
					if($this->data['Member']['vc_comp_code']==$this->flr){
					 
					 $flrCategory = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CATFLR%'), 'fields' => array('TRIM(ParameterType.vc_prtype_name)', 'TRIM(ParameterType.vc_prtype_desc)')));
					 }
					
					 
                    if (count($resultCheck) > 0) {

                        $userName = '';

                        foreach ($resultCheck as $val) {

                            $encode_type = base64_encode($this->data['Member']['vc_comp_code']);

                            $encode_user_code = base64_encode($val['Member']['vc_username']);
							$vc_flr_customer_no = $val['Member']['vc_flr_customer_no'];

                            //$VC_CLIENT_NO = base64_encode($val['Client']['VC_CLIENT_NO']);
					   
							//echo 'is--',$this->flr;
							//	pr($resultCheck['Member']['vc_user_login_type']);
							$vc_user_login_type = $val['Member']['vc_user_login_type'];
						
								//die;
							if($this->data['Member']['vc_comp_code'] == $this->flr){

								$resultCheckcategory = $this->ClientHeader->find('first', array(
								'conditions' => array(
									'ClientHeader.vc_client_no' => trim($vc_flr_customer_no),
                           
								)));
								
								if(count($resultCheckcategory)>0){
								
									$categorynamecode = $resultCheckcategory['ClientHeader']['vc_cateogry']; 
								    $fullcategoryname = $flrCategory[$categorynamecode];
															 
								}else{
							  
									$fullcategoryname='N/A';
							  
								}
								
							if($vc_flr_customer_no==''){
							
								$vc_flr_customer_no='N/A';
							
							}
								
							 if($vc_user_login_type =='USRLOGIN_SUPL'){	
								
								$userName .= " <br /><a href='" . WWW_HOST . "members/resetpassword/$encode_type/$encode_user_code' >  Reset Password  </a> &nbsp; &nbsp; Username ". $val['Member']['vc_username'] . " &nbsp; &nbsp;Client No.&nbsp; &nbsp; ".$vc_flr_customer_no."  &nbsp;  User Type:Supplier &nbsp; &nbsp; ";
								
								}else{
								
								$userName .= " <br /><a href='".WWW_HOST."members/resetpassword/$encode_type/$encode_user_code' >  Reset Password  </a> &nbsp; &nbsp; Username ". $val['Member']['vc_username'] . " &nbsp; &nbsp;Client No&nbsp; &nbsp; ".$vc_flr_customer_no." &nbsp;  Category ".$fullcategoryname." &nbsp; &nbsp; ";
								
								}
							
								}else{
								
								$userName .= " <br />   ".$val['Member']['vc_username'] . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='" . WWW_HOST . "members/resetpassword/$encode_type/$encode_user_code' >  Reset Password  </a>  ";
								}
							
								}
								}

                            $sqlQueryCustom = "UPDATE PR_DT_USERS_DETAILS_ALL SET vc_password_reset = 'USRPSWDRSTACT' WHERE vc_username ='" . trim($val['Member']['vc_username']) . "'";

                            $this->Member->query($sqlQueryCustom);

                            unset($sqlQueryCustom);
                            unset($encode_type);
                            unset($encode_user_code);
                        

                        $SendDetail = $this->Member->find('first', array(
                            'conditions' => array(
                                'Member.vc_email_id' => trim($this->data['Member']['vc_email_id_frgt']),
                                'Member.vc_comp_code' => $this->data['Member']['vc_comp_code'],
                        )));

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->data['Member']['vc_comp_code']);


                       /* 
					   if ($this->data['Member']['vc_comp_code'] == Configure::read('companyCodecbc'))
                            $this->Email->from = $this->AdminName . '<' . $this->AdminCbcEmailID . '>';

                        if ($this->data['Member']['vc_comp_code'] == Configure::read('companyCodemdc'))
                            $this->Email->from = $this->AdminName . '<' . $this->AdminMdcEmailID . '>';

                        if ($this->data['Member']['vc_comp_code'] == Configure::read('companyCodeflr'))
                            $this->Email->from = $this->AdminName . '<' . $this->AdminFlrEmailID . '>';
						
						*/
					$this->Email->from = $this->AdminName.'<'.$this->AdminEmailID.'>';
					

                        $this->Email->to = trim($this->data['Member']['vc_email_id_frgt']);

                        $this->Email->subject = "$selectedType Reset Password Request ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($SendDetail['Member']['vc_user_firstname'])) . ' ' . ucfirst(trim($SendDetail['Member']['vc_user_lastname'])));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Please click on given link to reset your password " . $userName;


                        if (isset($this->data['Member']['vc_email_id_frgt']) && $this->data['Member']['vc_email_id_frgt'] != '')
                            $this->Email->send($mesage);

                        $this->data = Null;

                        $this->Session->setFlash('An email has been sent to reset your password ', 'success');
                    } else {

                        $this->data = Null;

                        $this->Session->setFlash('Email id does not exist in RFA Database. ', 'error');
                    }
                }
            

            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($type);


            $this->layout = 'registration';

            $this->set('selectedType', $selectedType);

            $this->set('selectedTypeID', $type);

            $this->set('title_for_layout', strtoupper($selectedType) . " Forgot Password ");

            $this->set('FLA_TYPE', $selectList);
            unset($this->data['Member']);
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
    private function userCodeID() {

        try {

            list( $VC_USER_CODE, $type, $selectList ) = $this->getRFATypeDetail($this->data['Member']['vc_comp_code']);

            $countResult = $this->Member->find('count', array('conditions' => array('Member.vc_user_no like' => "$type%")));
            $countResultallvalues = $this->Member->find('all', array('conditions' => array('Member.vc_user_no like' => "$type%")));
            $newarrray = array();
			//pr (count($countResultallvalues));
			foreach($countResultallvalues as $value){
			
			$newarrray[]= ltrim($value['Member']['vc_user_no'],$type);
			
			}
			//pr($newarrray);
			if(count($newarrray)>0)
			$maxnovalue= max($newarrray);
			else
			$maxnovalue=0;
			
			$userCode = 'RFA-' . strtoupper($type);

            $userCode .= '-' . ($maxnovalue + 1);
			
			$vc_user_no = $type.($maxnovalue + 1);


            $this->__userCode = $userCode;
			$this->loadModel('Profile');
            $returnValue = $this->Member->find('count', array('conditions' => array('Member.vc_username' => $userCode)));
            $returnValueProfile = $this->Profile->find('count', array('conditions' => array('Profile.vc_user_no' => $vc_user_no)));

            if ($returnValue == 0 && $returnValueProfile ==0) {

                return $this->__userCode;
            } else {

                $i = (int) ($countResult + 1);

                while ($i >= 1) {

                    $userCode = 'RFA-' . strtoupper($type);
					$newivalue=($i + 1);
                    $userCode .= '-' . ($newivalue);

                    $returnValue = $this->Member->find('count', array('conditions' => array('Member.vc_username' => $userCode)));
					
					$vc_user_no = $type.$newivalue;
					
					
					if($type=='cm1')
					$returnValueProfile = $this->Profile->find('count', array('conditions' => array('Profile.vc_user_no' => $vc_user_no)));
					
					if($type=='cm2')
					$returnValueProfile = $this->Customer->find('count', array('conditions' => array('Customer.vc_user_no' => $vc_user_no)));
					
					if($type=='cm3')
					$returnValueProfile = $this->Client->find('count', array('conditions' => array('Client.vc_user_no' => $vc_user_no)));
					
                    if ($returnValue == 0 && $returnValueProfile==0) {

                        $this->__userCode = $userCode;

                        break;
                    }

                    $i++;
                }

                return $this->__userCode;
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
    function activatemember($type = null, $user_code = null, $password = null, $user_type = null) {

        try {
            if ($type != null && $user_code != null && $password != null) {

                $type = base64_decode($type);

                $user_code = base64_decode($user_code);

                $password = base64_decode($password);
               
                if ($user_type != null) {

                    $user_type = base64_decode($user_type);

                    $sqlResult = $this->Member->find('first', array(
                        'conditions' => array(
                            'Member.vc_user_login_type' => $user_type,
                            'Member.vc_password' => $this->Auth->password($password),
                            'Member.vc_comp_code' => $type,
                            'Member.vc_activation_request' => 'USRACTREQACT',
                            'Member.vc_user_status' => 'USRSTATUSINACT'),
                        'fields' => array(
                            "Member.dt_user_created",
                            'Member.vc_username',
                            'Member.vc_password',
                            'vc_email_id',
                            'Member.vc_user_firstname',
                            'Member.vc_comp_code',
                            'Member.vc_user_lastname',
                            'Member.vc_user_no',
                            'Member.vc_user_login_type')));
                } else {
                    $sqlResult = $this->Member->find('first', array(
                        'conditions' => array(
                            'Member.vc_password' => $this->Auth->password($password),
                            'Member.vc_comp_code' => $type,
                            'Member.vc_activation_request' => 'USRACTREQACT',
                            'Member.vc_user_status' => 'USRSTATUSINACT'),
                        'fields' => array(
                            "Member.dt_user_created",
                            'Member.vc_username',
                            'Member.vc_password',
                            'vc_email_id',
                            'Member.vc_user_firstname',
                            'Member.vc_comp_code',
                            'Member.vc_user_lastname',
                            'Member.vc_user_no')));
                }


                if ($sqlResult) {
                    $currentdate = strtotime(date('d-M-Y'));

                    $expirydate = strtotime("+2 day", strtotime($sqlResult['Member']['dt_user_created']));

                    if ($currentdate <= $expirydate) {

                        unset($this->Member->validate);

                        $updateData['Member']['vc_user_status'] = 'USRSTATUSACT';

                        $updateData['Member']['vc_activation_request'] = 'USRACTREQINACT';

                        $updateData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');

                        $updateData['Member']['dt_user_created'] = date('Y-m-d H:i:s');

                        $updateData['Member']['vc_user_no'] = trim($sqlResult['Member']['vc_user_no']);

                        $this->Member->id = trim($sqlResult['Member']['vc_user_no']);

                        $this->Member->save($updateData);

                        $loginDetail = array('vc_username' => $sqlResult['Member']['vc_username'], 'vc_password' => $sqlResult['Member']['vc_password']);

                        $this->Auth->fields = array(
                            'username' => 'vc_username',
                            'password' => 'vc_password'
                        );

                        list( $SelectTypeLabel, $type, $selectList ) = $this->getRFATypeDetail($type);

                        if ($this->Auth->login($loginDetail)) {
						
						/*
                            if ($type == Configure::read('companyCodecbc'))
                                $this->Email->from = $this->AdminName . '<' . $this->AdminCbcEmailID . '>';

                            if ($type == Configure::read('companyCodemdc'))
                                $this->Email->from = $this->AdminName . '<' . $this->AdminMdcEmailID . '>';

                            if ($type == Configure::read('companyCodeflr'))
                                $this->Email->from = $this->AdminName . '<' . $this->AdminFlrEmailID . '>';
						*/
						$this->Email->from = $this->AdminName.'<'.$this->AdminEmailID.'>';
					

                            $this->Email->to = trim($sqlResult['Member']['vc_email_id']);

                            $this->Email->subject = "$SelectTypeLabel Member Username and Password ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($sqlResult['Member']['vc_user_firstname'])) . ' ' . ucfirst(trim($sqlResult['Member']['vc_user_lastname'])));

                            $this->Email->delivery = 'smtp';

                            $mesage = " Your account has been activated, 
                                        please use the credentials mentioned below : <br />
                                        Username : " . $sqlResult['Member']['vc_username'] . " <br />
					Password : " . $password . " <br />";
                            
                           
                            $this->Email->send($mesage);

                            $this->loadModel('UserLoginDetail');

                            $id = $this->UserLoginDetail->getPrimaryKey();

                            $SaveData['UserLoginDetail']['vc_comp_code'] = $sqlResult['Member']['vc_comp_code'];

                            $SaveData['UserLoginDetail']['vc_user_no'] = $sqlResult['Member']['vc_user_no'];

                            $SaveData['UserLoginDetail']['dt_login_datetime'] = date('d-M-Y H:i:s');

                            $SaveData['UserLoginDetail']['vc_login_ip_address'] = $this->RequestHandler->getClientIp();

                            $SaveData['UserLoginDetail']['nu_id'] = $id;

                            if ($this->UserLoginDetail->save($SaveData, false)) {

                                $this->Session->write('Auth.UserLoginDetail.nu_id', $id);
                            }

                            $this->Session->setFlash('Your profile has been activated, kindly check your email for username and password !!', 'success');

                            if ($type == $this->mdc) :

                                $this->redirect(array('controller' => 'profiles', 'action' => 'index'));

                            elseif ($type == $this->cbc) :


                                if ($this->Session->read('Auth.Member.vc_cbc_customer_no') == '') :

                                    $this->redirect(array('controller' => 'customers', 'action' => 'customer_profile', 'cbc' => true));

                                elseif ($this->Session->read('Auth.Customer.ch_active') == 'STSTY05'):

                                    $this->redirect(array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => true));

                                else:

                                    $this->redirect(array('controller' => 'customers', 'action' => 'view', 'cbc' => true));


                                endif;

                            elseif ($type == $this->flr):
									// elseif ($this->Session->read('Auth.Client.ch_active') == 'STSTY05'):
                                $this->redirect(array('controller' => 'clients', 'action' => 'index', 'flr' => true));

                            endif;
                        } else {

                            $this->Member->rollback();

                            $this->Session->setFlash(' Authentication error has been occured ', 'error');

                            $this->redirect(array('controller' => 'members', 'action' => 'registration', $type));
                        }
                    } else {

                        $this->Member->id = $sqlResult['Member']['vc_user_no'];
                        $this->Member->delete();
                        $this->Session->setFlash(' Link has deactivated please registration again . ', 'error');
                        $this->redirect(array('controller' => 'members', 'action' => 'registration', $type));
                    }
                } else {

                    /*$this->Member->delete($sqlResult['Member']['vc_user_no']);*/
					

                    unset($sqlResult);

                    $this->Session->setFlash(' Your link has expired please register again ', 'info');


                    $this->redirect(array('controller' => 'members', 'action' => 'registration', $type));
                }
            } else {


                $this->Session->setFlash(' Invalid parameter has  passed ', 'error');

                $this->redirect(array('controller' => 'members', 'action' => 'registration'));
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
    function loginRightCheck() {
	/*	pr($this->Auth->allowedActions);
		pr($this->action);
		pr($this->loggedIn);
		*/
//pr($this->Session->read('Auth.Client.ch_active_flag'));die;
        if ($this->loggedIn && in_array($this->action, $this->Auth->allowedActions)) {

            if ($this->isMdc && !$this->isInspector) :

                $this->redirect(array('controller' => 'profiles', 'action' => 'index'));

            elseif ($this->isMdc && $this->isInspector) :

                $this->redirect(array('controller' => 'inspectors', 'action' => 'index'));

            elseif ($this->isCbc) :

                if ($this->Session->read('Auth.Member.vc_cbc_customer_no') == '') :

                    $this->redirect(array('controller' => 'customers', 'action' => 'customer_profile', 'cbc' => true));

                elseif ($this->Session->read('Auth.Customer.ch_active') == 'STSTY05'):

                    $this->redirect(array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => true));

                else:

                    $this->redirect(array('controller' => 'customers', 'action' => 'view', 'cbc' => true));


                endif;


            elseif ($this->isFlr):
			//echo $this->isFlr.'--'.$this->isInspector.'=='.$this->isCbc;die;
							
				if($this->Session->read('Auth.Client.ch_active_flag')=='STSTY04' || $this->Session->read('Auth.Client.ch_active_flag')=='STSTY03')
                $this->redirect(array('controller' => 'clients', 'action' => 'view', 'flr' => true));
				else
                $this->redirect(array('controller' => 'clients', 'action' => 'index', 'flr' => true));
			
            endif;
        }
    }

    /**
     *
     * Get Captcha Image
     *
     */
    function captcha_image() {

        App::import('Vendor', 'captcha/captcha');

        $captcha = new captcha();

        $captcha->show_captcha();

        exit(0);
    }

    /**
     *
     *
     *
     */
    function resetpassword($type = null, $user_code = null) {

        try {

            if ($type != null || $user_code != null) {

                $type = base64_decode($type);

                $user_code = base64_decode($user_code);

                list( $SelectTypeLabel, $type, $selectList ) = $this->getRFATypeDetail($type);

                $sqlResult = $this->Member->find('first', array(
                    'conditions' => array(
                        'Member.vc_username' => $user_code,
                        'Member.vc_comp_code' => $type,
                        'Member.vc_password_reset' => 'USRPSWDRSTACT',
                )));


                if ($sqlResult) {

                    /* $date1 = $sqlResult['Member']['dt_user_created'];
                      $date2 = date('d-M-Y');

                      $ts1 = strtotime($date1);
                      $ts2 = strtotime($date2);

                      $seconds_diff = $ts2 - $ts1;

                      echo floor($seconds_diff/3600/24);

                      pr($sqlResult);
                      exit;
                     */

                    $VC_PASSWORD = strtoupper(substr(trim($sqlResult['Member']['vc_user_firstname']), 0, 3)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 7);

                    $sqlQueryCustom = "UPDATE PR_DT_USERS_DETAILS_ALL SET
														vc_user_status = 'USRSTATUSACT' , 
														vc_password = '" . $this->Auth->password($VC_PASSWORD) . "',
														vc_password_reset = 'USRPSWDRSTINACT',
														dt_user_modified = current_date 
														WHERE vc_username ='" . $sqlResult['Member']['vc_username'] . "'";


                    $this->Member->query($sqlQueryCustom);
				/*
                    if ($type == Configure::read('companyCodecbc'))
                        $this->Email->from = $this->AdminName . '<' . $this->AdminCbcEmailID . '>';

                    if ($type == Configure::read('companyCodemdc'))
                        $this->Email->from = $this->AdminName . '<' . $this->AdminMdcEmailID . '>';

                    if ($type == Configure::read('companyCodeflr'))
                        $this->Email->from = $this->AdminName . '<' . $this->AdminFlrEmailID . '>';
                    
					*/
					
					$this->Email->from = $this->AdminName.'<'.$this->AdminEmailID.'>';
					
                    $this->Email->to = trim($sqlResult['Member']['vc_email_id']);
                    $this->Email->subject = "$SelectTypeLabel New  Password ";
                    $this->Email->template = 'registration';
                    $this->Email->sendAs = 'html';
                    $this->set('name', ucfirst(trim($sqlResult['Member']['vc_user_firstname'])) . ' ' . ucfirst(trim($sqlResult['Member']['vc_user_lastname'])));
                    $this->Email->delivery = 'smtp';
                    $mesage = " 
									Your below credential to access portal <br />
									Your login credential are  : <br />
									 Username : " . $sqlResult['Member']['vc_username'] . " <br />
									 Password : " . $VC_PASSWORD . " <br />	
							";

                    $this->Email->send($mesage);

                    $this->Session->setFlash(' New password has been sent to your email .  ', 'success');
                } else {

                    $this->Session->setFlash(' Link has expired ', 'error');
                }

                $this->redirect(array('controller' => 'members', 'action' => 'login', $type));
            } else {

                $this->Session->setFlash(' Invalid Access', 'error');

                $this->redirect(array('controller' => 'members', 'action' => 'login', $type));
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     *
     * Function Check User Is login or not 
     *
     */

    function checkUserAccess() {

        if ($this->Session->check('Auth.Member')) {

            echo 'yes';
        } else {


            echo 'no';
        }

        exit;
    }

}