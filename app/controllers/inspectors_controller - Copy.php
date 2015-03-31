<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class InspectorsController extends AppController {

    /**
     *
     *
     */
    var $name = 'Inspectors';

    /**
     *
     *
     */
    var $components = array('Session', 'Auth', 'RequestHandler', 'Email', 'Inspectorreportpdfcreator', 'Assessmentreportpdfcreator');

    /**
     *
     *
     */
    var $uses = array('Inspector');

    /**
     *
     *
     */
    var $helpers = array('Session', 'Html', 'Form', 'Number', 'Getlogdate');

    /**
     *
     *
     */
    var $__userCode = null;

    /**
     *
     *
     */
    var $_testemail_Id = 'rishi.kapoor@essindia.co.in';

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

    /*
     *
     * beforeRender
     *
     * Called after controller action logic, but before the view is rendered.
     * This callback is not used often, but may be needed if you are calling render() manually
     * before the end of a given action.
     *
     * */

    function beforeRender() {


        parent::beforeRender();
    }

    /**
     *
     *
     */
    function index() {


        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

        $this->layout = 'inspector';

        $this->set('selectedType', $selectedType);

        $this->set('selectedTypeID', $type);

        $this->set('title_for_layout', strtoupper($selectedType) . " Inspector Profile  ");

        $this->set('FLA_TYPE', $selectList);
    }

    /**
     *
     *
     */
    public function login() {

        try {



            if (!empty($this->data) && $this->RequestHandler->isPost()) {


                if (isset($this->data['Inspector']['vc_captcha_code'])) :

                    $fieldset = array('fieldList' => array('vc_username', 'vc_password', 'vc_captcha_code'));

                else :

                    $fieldset = array('fieldList' => array('vc_username', 'vc_password'));

                endif;

                $this->Inspector->set($this->data);

                if ($this->Inspector->validates($fieldset)) {


                    $loginDetail = array('vc_username' => $this->data['Inspector']['vc_username'], 'vc_password' => $this->Auth->password(trim($this->data['Inspector']['vc_password'])));

                    $this->Auth->fields = array(
                        'username' => 'vc_username',
                        'password' => 'vc_password'
                    );

                    if ($this->Auth->login($loginDetail)) {

                        $this->data = null;

                        $this->Session->setFlash('You has been successfully logged in.!!', 'success');

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($user['Inspector']['vc_comp_code']);

                        $this->redirect(array('controller' => 'inspectors', 'action' => 'index'));
                    } else {

                        $this->data = null;

                        $this->Session->setFlash($this->Auth->loginError, 'error');
                    }
                }
            }

            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->mdc);

            $this->layout = 'registration';

            $this->set('selectedType', $selectedType);

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

            $this->Session->destroy();

            $this->Session->setFlash('You has been successfully logout.!!', 'success');

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
    public function registration() {

        try {


            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Inspector->create();

                $this->Inspector->set($this->data);

                if ($this->Inspector->validates(array(
                            'fieldList' => array(
                                'vc_email_id',
                                'vc_comp_code',
                                'vc_user_firstname',
                                'vc_captcha_code',
                                'vc_user_lastname')))) {

                    unset($this->data['Inspector']['vc_captcha_code']);

                    $this->Inspector->validate = null;

                    $VC_USERNAME = $this->userCodeID();

                    $VC_PASSWORD = strtoupper(substr(trim($this->data['Inspector']['vc_user_firstname']), 0, 2)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 7);

                    $VC_USER_NO = strtolower(str_replace('-', '', substr($VC_USERNAME, 4)));

                    switch ($this->data['Inspector']['vc_comp_code']) {

                        case $this->mdc :

                            $USer_Type_Label = $this->mdcLabel;

                            break;

                        case $this->cbc :

                            $USer_Type_Label = $this->cbcLabe;

                            break;

                        case $this->flr :


                            $USer_Type_Label = $this->flrLabel;

                            break;
                    }


                    $NU_USER_TYPE = 'USRLOGIN_INSP';

                    $this->data['Inspector']['vc_user_no'] = $VC_USER_NO;
                    $this->data['Inspector']['vc_username'] = $VC_USERNAME;
                    $this->data['Inspector']['vc_password'] = $this->Auth->password($VC_PASSWORD);
                    $this->data['Inspector']['vc_user_status'] = 'USRSTATUSINACT';
                    $this->data['Inspector']['vc_activation_request'] = 'USRACTREQACT';
                    $this->data['Inspector']['dt_user_created'] = date('d-M-Y H:i:s');
                    $this->data['Inspector']['vc_user_login_type'] = $NU_USER_TYPE;

                    if ($this->Inspector->save($this->data, false)) {

                        $encode_user_code = base64_encode($VC_USERNAME);

                        $encode_password = base64_encode($VC_PASSWORD);

                        $encode_type = base64_encode($this->data['Inspector']['vc_comp_code']);

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        ///$this->Email->to = trim($this->data['Inspector']['vc_email_id']);

                        $this->Email->to = $this->_testemail_Id;

                        $this->Email->subject = "$USer_Type_Label Inspector Registration Successful";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->data['Inspector']['vc_user_firstname'])) . ' ' . ucfirst(trim($this->data['Inspector']['vc_user_lastname'])));

                        $this->Email->delivery = 'smtp';

                        $mesage = "  You have been registered successfully . please <a href='" . WWW_HOST . "inspectors/activatemember/" . $encode_type . "/" . $encode_user_code . "/" . $encode_password . "'> click here to activate your account. </a>";

                        $this->Email->send($mesage);

                        $this->data = null;

                        unset($this->data);

                        $this->Session->setFlash(' You have been registered successfully , please check your mail.!! ', 'success');

                        $this->redirect(array('controller' => 'inspectors', 'action' => 'login', $this->data['Inspector']['vc_comp_code']));
                    } else {

                        $this->data = null;

                        unset($this->data);

                        $this->Session->setFlash(' Some error has been occurred Try again later ', 'error');

                        $this->redirect(array('controller' => 'inspectors', 'action' => 'registration', $this->data['Inspector']['vc_comp_code']));
                    }
                }
            }

            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->mdc);

            $this->layout = 'registration';
            $this->set('selectedType', $selectedType);
            $this->set('selectedTypeID', $type);
            $this->set('title_for_layout', strtoupper($selectedType) . " Inspector Registration ");
            $this->set('FLA_TYPE', $selectList);
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Inspector Activation Member Function
     *
     */
    function activatemember($type = null, $user_code = null, $password = null) {

        try {


            if ($type != null && $user_code != null && $password != null) {

                $type = base64_decode($type);

                $user_code = base64_decode($user_code);

                $password = base64_decode($password);

                list( $SelectTypeLabel, $type, $selectList ) = $this->getRFATypeDetail($type);

                $sqlResult = $this->Inspector->find('first', array(
                    'conditions' => array(
                        'vc_username' => $user_code,
                        'vc_password' => $this->Auth->password($password),
                        'vc_comp_code' => $type,
                        'vc_activation_request' => 'USRACTREQACT',
                        'vc_user_status' => 'USRSTATUSINACT'
                )));
                if ($sqlResult) {

                    $loginDetail = array('vc_username' => $sqlResult['Inspector']['vc_username'], 'vc_password' => $sqlResult['Inspector']['vc_password']);

                    $this->Auth->fields = array(
                        'username' => 'vc_username',
                        'password' => 'vc_password'
                    );

                    if ($this->Auth->login($loginDetail)) {

                        $sqlResult['Inspector']['vc_user_status'] = 'USRSTATUSACT';

                        $sqlResult['Inspector']['vc_activation_request'] = 'USRACTREQINACT';

                        $sqlResult['Inspector']['dt_user_modified'] = date('d-M-Y H:i:s');

                        $sqlResult['Inspector']['dt_user_created'] = date('d-M-Y H:i:s');

                        $this->Inspector->save($sqlResult, false);

                        /*                         * ********* Email Send To Inspector ********* */


                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        // $this->Email->to = trim($sqlResult['Inspector']['vc_email_id']);

                        $this->Email->to = $this->_testemail_Id;

                        $this->Email->subject = "$SelectTypeLabel Inspector Username and Password ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($sqlResult['Inspector']['vc_user_firstname'])) . ' ' . ucfirst(trim($sqlResult['Inspector']['vc_user_lastname'])));

                        $this->Email->delivery = 'smtp';

                        $mesage = " 	Your account has been activated. Please use below credentials to access portal : <br />
										 <br />
										 Username : " . $sqlResult['Inspector']['vc_username'] . " <br />
										 Password : " . $password . " <br />	
								";

                        $this->Email->send($mesage);

                        $this->Session->setFlash('Your profile has been activated successfully .Please check you mail for  username and password .!!', 'success');

                        $this->redirect(array('controller' => 'inspectors', 'action' => 'index'));
                    } else {

                        $this->Session->setFlash(' Authentication error has been occured ', 'error');

                        $this->redirect(array('controller' => 'inspectors', 'action' => 'registration', $type));
                    }
                } else {

                    $this->Session->setFlash(' Link has expired', 'error');

                    $this->redirect(array('controller' => 'inspectors', 'action' => 'registration', $type));
                }
            } else {


                $this->Session->setFlash(' Invalid parameter has  passed ', 'error');

                $this->redirect(array('controller' => 'home', 'action' => 'index'));
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


        if ($this->loggedIn && in_array($this->action, $this->Auth->allowedActions)) {

            if ($this->isMdc && !$this->isInspector) :

                $this->redirect(array('controller' => 'profiles', 'action' => 'index'));

            elseif ($this->isCbc) :

                if ($this->Session->read('Auth.Member.vc_cbc_customer_no') == '') :

                    $this->redirect(array('controller' => 'customers', 'action' => 'customer_profile', 'cbc' => true));

                elseif ($this->Session->read('Auth.Customer.ch_active') == 'STSTY05'):

                    $this->redirect(array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => true));

                else:

                    $this->redirect(array('controller' => 'customers', 'action' => 'view', 'cbc' => true));


                endif;


            elseif ($this->isFlr):

                $this->redirect(array('controller' => 'clients', 'action' => 'index', 'flr' => true));

            endif;
        }
    }

    /**
     *
     *
     */
    function captcha_image() {

        App::import('Vendor', 'captcha/captcha');
        $captcha = new captcha();
        $captcha->show_captcha();
    }

    /**
     *
     *
     */
    private function userCodeID() {

        try {

            list( $VC_USER_CODE, $type, $selectList ) = $this->getRFATypeDetail($this->data['Inspector']['vc_comp_code']);

            $countResult = $this->Inspector->find('count', array('conditions' => array('Inspector.vc_user_no like' => "$type%")));

            $userCode = 'INSP-' . strtoupper($type);

            $userCode .= '-' . ($countResult + 1);

            $this->__userCode = $userCode;

            $returnValue = $this->Inspector->find('count', array('conditions' => array('vc_username' => $userCode)));

            if ($returnValue == 0) {

                return $this->__userCode;
            } else {

                $i = (int) ($countResult + 1);

                while ($i >= 1) {

                    $userCode = 'INSP-' . strtoupper($type);

                    $userCode .= '-' . ($i + 1);

                    $returnValue = $this->Inspector->find('count', array('conditions' => array('Inspector.vc_username' => $userCode)));

                    if ($returnValue == 0) {

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
     * Inspector   Feedback   Form          
     *
     */
    function feedbackform() {

        try {

            $form_name = $this->params['action'];

            $this->set('form_name', $form_name);

            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                if (isset($this->data['vc_vehicle_lic_no']) && !empty($this->data['vc_vehicle_lic_no'])) {

                    $this->loadModel('VehicleLogMaster');

                    $this->loadModel('ParameterType');

                    $this->loadModel('VehicleLogDetail');

                    $this->loadModel('Profile');

                    $this->loadModel('VehicleDetail');

                    $this->loadModel('CustomerLocationDistance');

                    $detail = $this->VehicleDetail->find('first', array(
                        'conditions' => array('VehicleDetail.vc_vehicle_lic_no' => $this->data['vc_vehicle_lic_no'])));                  
                    
                    $nu_company_id = $detail['VehicleDetail']['nu_company_id'];
                    
                    if ($detail) {

                        $hdvehlogID = $this->VehicleLogMaster->getPrimaryKey();

                        $payFrequency = $this->ParameterType->find('first', array('conditions' => 
						array('ParameterType.vc_prtype_name' => $this->data['vc_pay_frequency']), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                        $logdetails = $detail['CustomerProfile'];

                        $logdetails['vc_vehicle_log_no'] = $hdvehlogID;
                        
                        $logdetails['vc_pay_frequency'] = $payFrequency['ParameterType']['vc_prtype_code'];

                        $logdetails['vc_vehicle_lic_no'] = $this->data['vc_vehicle_lic_no'];

                        $logdetails['dt_created_date'] = date('d-M-Y H:i:s');
						
						$filesissue=false;
//						pr($this->data['VehicleLogDetail']);
						foreach($this->data['VehicleLogDetail'] as $valuefile){
							
						if($valuefile['uploaddocs']['tmp_name']!='' && ((int)$valuefile['uploaddocs']['size']>2048000)){
							
							$filesissue = true;
							
							}
						}
						
						if($filesissue==false){
						
                        if ($this->VehicleLogMaster->save($logdetails, false)) {

                            $errcounter = 0;

                            $count = 0;

                            $newrowcheckedvalue = $this->data['newrowcheckbox'];

                            foreach ($this->data['VehicleLogDetail'] as $key => $vehicleLogData) {
                              
										
									if ($checkRequest = $this->VehicleLogDetail->find('count', array(
                                         'conditions' => array(
                                         'lower(VehicleLogDetail.vc_vehicle_lic_no)' => strtolower(trim($this->data['vc_vehicle_lic_no'])),
                                          array('OR' => array(
                                                    array('VehicleLogDetail.nu_start_ometer' => trim($vehicleLogData['nu_start_ometer'])),
                                                    array('VehicleLogDetail.nu_end_ometer' => trim($vehicleLogData['nu_end_ometer']))
                                        ))))) == 0) 	{
										

                                    $vc_log_detail_id = $this->VehicleLogDetail->getPrimaryKey();

                                    $vehicleLogData['vc_log_detail_id'] = $vc_log_detail_id;

                                    $tmp = null;
									
                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_from_code)' => strtolower(trim($vehicleLogData['vc_orign']))),
                                        'fields' => array('CustomerLocationDistance.loc_from')));

                                    $vehicleLogData['vc_orign_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_from'] : null;

                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_to_code)' => strtolower(trim($vehicleLogData['vc_destination']))),
                                        'fields' => array('CustomerLocationDistance.loc_to')));

                                    $vehicleLogData['vc_destination_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_to'] : null;

                                    /*
									$tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_from_code)' => strtolower(trim($vehicleLogData['vc_other_road_orign']))),
                                        'fields' => array('CustomerLocationDistance.loc_from')));

                                    $vehicleLogData['vc_other_road_orign_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_from'] : null;

                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_to_code)' => strtolower(trim($vehicleLogData['vc_other_road_destination']))),
                                        'fields' => array('CustomerLocationDistance.loc_to')));

                                    $vehicleLogData['vc_other_road_destination_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_to'] : null;

                                    unset($tmp);
									*/

                                    $vehicleLogData['dt_log_date'] = date('d-M-Y', strtotime($vehicleLogData['dt_log_date']));

                                    $vehicleLogData['dt_log_date'] = date('d-M-Y', strtotime($vehicleLogData['dt_log_date']));

                                    $vehicleLogData['ch_road_type']    = $vehicleLogData['selectedroad'];
                                    
                                    $vehicleLogData['nu_company_id']   = $nu_company_id;        

                                    $vehicleLogData['vc_comp_code']    = $detail['CustomerProfile']['vc_comp_code'];

                                    $vehicleLogData['vc_customer_no']  = $detail['CustomerProfile']['vc_customer_no'];

                                    $vehicleLogData['dt_created_date'] = date('d-M-Y H:i:s');

                                    $vehicleLogData['vc_pay_frequency'] = $payFrequency['ParameterType']['vc_prtype_code'];

                                    $vehicleLogData['vc_vehicle_lic_no'] = $this->data['vc_vehicle_lic_no'];

                                    $vehicleLogData['vc_status'] = 'STSTY01'; /* Active Now and  will be use any assessment  */

                                    $vehicleLogData['vc_vehicle_reg_no'] = $this->data['vc_vehicle_reg_no'];

                                    $vehicleLogData['vc_vehicle_log_no'] = $hdvehlogID;

                                    $vehicleLogData['vc_remark'] = $vehicleLogData['vc_remark'];
									
									$vehicleLogData['vc_other_road_destination'] = $vehicleLogData['vc_other_road_destination'];
                                    $vehicleLogData['vc_other_road_orign'] = $vehicleLogData['vc_other_road_orign'];
                                       

                                    if ($vehicleLogData['selectedroad'] == 0) {
										
										$vehicleLogData['vc_orign'] = $vehicleLogData['vc_orign'];
										$vehicleLogData['vc_destination'] = $vehicleLogData['vc_destination'];
										$vehicleLogData['nu_road_km_traveled'] = trim($vehicleLogData['nu_road_km_traveled']) == '' ? 0 : $vehicleLogData['nu_road_km_traveled'];
                                        $vehicleLogData['nu_other_road_km_traveled'] = 0;
										
                                    } else {
                                        
										$vehicleLogData['vc_orign'] = $vehicleLogData['vc_orign'];
										$vehicleLogData['vc_destination'] = $vehicleLogData['vc_destination'];
										$vehicleLogData['nu_other_road_km_traveled'] = trim($vehicleLogData['nu_road_km_traveled']) == '' ? 0 : $vehicleLogData['nu_road_km_traveled'];
				                        $vehicleLogData['nu_road_km_traveled'] = 0;                   
                                    }

                                    $vehicleLogData['vc_remark_by'] = 'USRTYPE01';

                                    $vehicleLogData['vc_vehicle_log_no'] = $hdvehlogID;

                                    $this->VehicleLogDetail->create();

                                    $this->VehicleLogDetail->set($vehicleLogData);

                                    //pr(c);die;
                                    $fincase = false;
                                    if ($newrowcheckedvalue != 1 && $count == 0) {
                                        $fincase = true;
                                    }
                                    if ($newrowcheckedvalue == 1 && $count == 0) {
                                        $fincase = true;
                                    }
                                    if ($newrowcheckedvalue == 1 && $count == 1) {
                                        $fincase = true;
                                    }
                                    if ($fincase == true) {

                                        $this->VehicleLogDetail->save($vehicleLogData, false);

                                        if (isset($vehicleLogData['uploaddocs']['name']) && trim($vehicleLogData['uploaddocs']['error']) == 0) {

                                            $this->loadModel('UploadDocumentLogInspector');

                                            $saveData = array();

                                            $saveData['UploadDocumentLogInspector']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                                            $saveData['UploadDocumentLogInspector']['vc_customer_no'] = $detail['CustomerProfile']['vc_customer_no'];

                                            $saveData['UploadDocumentLogInspector']['dt_date_uploaded'] = date('d-M-Y H:i:s');

                                            $saveData['UploadDocumentLogInspector']['vc_log_detail_id'] = $vc_log_detail_id;

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_for'] = 'Vehicle Log Detail';

                                            $filepath = trim($detail['CustomerProfile']['vc_customer_no']);

                                            $dir = WWW_ROOT . "uploadfile" . DS . "$filepath" . DS . 'log' . DS . trim($vc_log_detail_id);

                                            if (!file_exists($dir)) {

                                                mkdir($dir, 0777, true);
                                            }

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_path'] = $dir;

                                            $filename = date('YmdHis').'-'.$vehicleLogData['uploaddocs']['name'];

                                            if (file_exists($dir . DS . $filename)) {

                                                $filename = date('YmdHis').'-'.$filename;
                                            }

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_name'] = $filename;

                                            $saveData['UploadDocumentLogInspector']['vc_upload_id'] = $this->UploadDocumentLogInspector->getPrimaryKey();

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_type'] = $vehicleLogData['uploaddocs']['type'];
											
											$uploadstatus = move_uploaded_file($vehicleLogData['uploaddocs']['tmp_name'], 
											$dir.DS.$filename);
                                            
											if($uploadstatus==true){
											
												$this->UploadDocumentLogInspector->save($saveData, false);
											
											}
											

                                            $saveData = null;
                                        }
                                    }

                                    unset($vehicleLogData);


                                    $inspector_name = $this->Session->read('Auth.Member.vc_user_firstname') . "  " . $this->Session->read('Auth.Member.vc_user_lastname');


                                    $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                                    $this->Email->to = trim($logdetails['vc_email_id']);

                                    $this->Email->subject = "Log Added by Inspector";

                                    $this->Email->template = 'registration';

                                    $this->Email->sendAs = 'html';

                                    $this->set('name', $logdetails['vc_customer_name']);

                                    $this->Email->delivery = 'smtp';

                                    $mesage = "A log has been added for your vehicle on " . date('d-M-Y', strtotime($logdetails['dt_created_date'])) . ".<br/><br/> Licence No. :<b> " . $logdetails['vc_vehicle_lic_no'] . "</b><br/>Inspector Name : <b>" . $inspector_name . "</b>";

                                    $this->Email->send($mesage);
                                } else {


                                    $errcounter++;
                                }
                                $count++;
                            }


                            $this->data = null;

                            if ($errcounter == 0) {

                                $this->Session->setFlash('Log Details has been added successfully !!', 'success');
                            } else if ($errcounter == 1) {

                                $this->Session->setFlash(' Log Details has not been added  , Some duplicate data exist !!', 'info');
                            } else {

                                $this->Session->setFlash('Log Details has been added successfully ,Some duplicate data exist but not saved  !!', 'info');
                            }


                            $this->redirect($this->referer());
                        } else {

                            $this->data = null;

                            $this->Session->setFlash('Sorry Your data has not been submitted please try again ', 'error');

                            $this->redirect($this->referer());
                        }
					  } // file upload validate
						else{
						$this->Session->setFlash('Sorry file size cannot be more than 2 MB ', 'error');
							}
                    } else {

                        $this->data = null;

                        $this->Sesssion->setFlash('Sorry Your data has not been submitted please try again ', 'error');

                        $this->redirect($this->referer());
                    }
                } else {

                    $this->setFlash(' Invalid Customer License No / Registration No. ', 'error');
                    $this->redirect($this->referer());
                }
            }


            $this->loadModel('Profile');

            $this->loadModel('VehicleDetail');

            $this->layout = 'inspector';

            $this->set('title_for_layout', ' Inspector FeedBack Form ');

            $this->Profile->bindModel(array('hasOne' => array('Member' => array('className' => 'Member', 'foreignKey' => false))));

            $this->set('vehicleList', $this->VehicleDetail->find('list', array(
                        'conditions' => array('TRIM(VehicleDetail.vc_vehicle_status)' => trim('STSTY04')),
                        'fields' => array('TRIM(VehicleDetail.vc_vehicle_lic_no)', 'TRIM(VehicleDetail.vc_vehicle_reg_no)'))));
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Forgot Password Functionality
     *
     */
    public function forgotpassword($type = 0) {

        try {


            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Inspector->set($this->data);

                if ($this->Inspector->validates(array('fieldList' => array('vc_email_id_frgt', 'vc_comp_code]')))) {

                    $resultCheck = $this->Inspector->find('all', array(
                        'conditions' => array(
                            'Inspector.vc_email_id' => trim($this->data['Inspector']['vc_email_id_frgt']),
                            'Inspector.vc_comp_code' => $this->data['Inspector']['vc_comp_code'],
                            'Inspector.vc_user_status' => 'USRSTATUSACT'
                    )));

                    if (count($resultCheck) > 0) {

                        $userName = '';

                        foreach ($resultCheck as $val) {

                            $encode_type = base64_encode($this->data['Inspector']['vc_comp_code']);

                            $encode_user_code = base64_encode($val['Inspector']['vc_username']);

                            $userName .= "  	<a href='" . WWW_HOST . "inspectors/resetpassword/$encode_type/$encode_user_code' > " . $val['Inspector']['vc_username'] . " </a>  ";

                            $val['Inspector']['vc_password_reset'] = 'USRPSWDRSTACT';

                            $this->Inspector->set($val);

                            $this->Inspector->save($val, false);

                            unset($encode_type);

                            unset($encode_user_code);

                            unset($val);
                        }

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->data['Inspector']['vc_comp_code']);

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        //$this->Email->to = trim($this->data['Inspector']['vc_email_id_frgt']);

                        $this->Email->to = $this->_testemail_Id;
                        $this->Email->subject = "$selectedType Inspector Forgot Password ";

                        $this->Email->template = 'default';

                        $this->Email->sendAs = 'html';

                        $this->Email->delivery = 'smtp';

                        $mesage = " Please click on given link to reset your password " . $userName;

                        $this->Email->send($mesage);

                        $this->data = Null;

                        $this->Session->setFlash('An email has been sent to reset your password.', 'success');
                    } else {

                        $this->data = Null;

                        $this->Session->setFlash('Email id does not exist in RFA Database.', 'error');
                    }
                }
            }

            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($type);


            $this->layout = 'registration';

            $this->set('selectedType', $selectedType);

            $this->set('selectedTypeID', $type);

            $this->set('title_for_layout', strtoupper($selectedType) . " Inspector Forgot Password ");

            $this->set('FLA_TYPE', $selectList);
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
    function resetpassword($type = null, $user_code = null) {

        try {

            if ($type != null || $user_code != null) {

                $type = base64_decode($type);

                $user_code = base64_decode($user_code);

                list( $SelectTypeLabel, $type, $selectList ) = $this->getRFATypeDetail($type);

                $sqlResult = $this->Inspector->find('first', array(
                    'conditions' => array(
                        'Inspector.vc_username' => $user_code,
                        'Inspector.vc_comp_code' => $type,
                        'Inspector.vc_password_reset' => 'USRPSWDRSTACT',
                )));



                if ($sqlResult) {

                    $VC_PASSWORD = strtoupper(substr(trim($sqlResult['Inspector']['vc_user_firstname']), 0, 3)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 7);


                    $sqlResult['Inspector']['vc_user_status'] = 'USRSTATUSACT';

                    $sqlResult['Inspector']['vc_password'] = $this->Auth->password($VC_PASSWORD);

                    $sqlResult['Inspector']['vc_password_reset'] = 'USRPSWDRSTINACT';

                    $sqlResult['Inspector']['dt_user_modified'] = date('d-M-Y H:i:s');

                    $this->Inspector->save($sqlResult, false);

                    $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                    $this->Email->to = trim($sqlResult['Inspector']['vc_email_id']);

                    $this->Email->to = $this->_testemail_Id;

                    $this->Email->subject = "$SelectTypeLabel Inspector New Password ";

                    $this->Email->template = 'registration';

                    $this->Email->sendAs = 'html';

                    $this->set('name', ucfirst(trim($sqlResult['Inspector']['vc_user_firstname'])) . ' ' . ucfirst(trim($sqlResult['Inspector']['vc_user_lastname'])));

                    $this->Email->delivery = 'smtp';

                    $mesage = "      Your login credentials are as below: <br />
									 Username : " . $sqlResult['Inspector']['vc_username'] . " <br />
									 Password : " . $VC_PASSWORD . " <br />	
							";

                    $this->Email->send($mesage);

                    $this->Session->setFlash(' New password has been send at your email . ', 'success');
                } else {

                    $this->Session->setFlash(' Link has expired ', 'error');
                }

                $this->redirect(array('controller' => 'inspectors', 'action' => 'login', $type));
            } else {

                $this->Session->setFlash(' Invalid Access', 'error');

                $this->redirect(array('controller' => 'inspectors', 'action' => 'login', $type));
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *  Get Customer Detail 
     *
     */
    function getuserdetail($customerId = null) {

        $this->layout = false;

        $vehicle = '';

        if ($this->params['isAjax']) {

            $vehicle = (string) strtolower(trim($this->params['data']));
        }

        $this->loadModel('VehicleDetail');
        $this->loadModel('AssessmentVehicleMaster');
        $this->loadModel('AssessmentVehicleDetail');


        $sqlResult = $this->VehicleDetail->find('first', array(
            'conditions' => array(
                'OR' => array(
                    "lower(trim(VehicleDetail.vc_vehicle_lic_no)) = '{$vehicle}' ",
                    "lower(trim(VehicleDetail.vc_vehicle_reg_no)) = '{$vehicle}' "
                ),
                'VehicleDetail.vc_vehicle_status' => 'STSTY04'
        )));
        $vc_customer_no = $sqlResult['VehicleDetail']['vc_customer_no'];

        $total_header = $this->AssessmentVehicleDetail->find('all', array(
            'conditions' => array(
                'OR' => array(
                    "lower(trim(AssessmentVehicleDetail.vc_vehicle_lic_no)) = '{$vehicle}' ",
                    "lower(trim(AssessmentVehicleDetail.vc_vehicle_reg_no)) = '{$vehicle}' "
                ),
        )));
        //($total);
        $nu_total_payable_amount1 = 0;
        $vc_mdc_paid1 = 0;

        foreach ($total_header as $amount) {

            $nu_total_payable_amount1 = $nu_total_payable_amount1 + $amount['AssessmentVehicleMaster']['nu_total_payable_amount'];

            $vc_mdc_paid1 = $vc_mdc_paid1 + $amount['AssessmentVehicleMaster']['vc_mdc_paid'];
        }
        $balanceamt = 0;

        $this->set('total_header', $total_header);
        //	$this->set('data', $detail);
        //	$this->set('lic_no_search', $lic_no);
        $this->set('Totalnu_total_payable_amount1', $nu_total_payable_amount1);
        $this->set('Totalvc_mdc_paid1', $vc_mdc_paid1);
        $balanceamt = (float) $nu_total_payable_amount1 - (float) $vc_mdc_paid1;
        $this->set('balanceamt', $balanceamt);
        $this->set('data', $sqlResult);
        //$this->set('totaloutstanding', $totaloutstanding);

        /* 		$AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('all', array('conditions' => array('AssessmentVehicleMaster.vc_customer_no' => trim($vc_customer_no))));
          //pr($AssessmentVehicleMaster);

          $totaloutstanding=0;
          $majorcnt=0;
          foreach($AssessmentVehicleMaster as $index=>$value){

          $cnt      = 0;
          $outstand = ((float)$value['AssessmentVehicleMaster']['nu_total_payable_amount']-(float)$value['AssessmentVehicleMaster']['vc_mdc_paid']);

          if($value['AssessmentVehicleMaster']['nu_total_payable_amount']!=$value['AssessmentVehicleMaster']['vc_mdc_paid']){

          foreach($value['AssessmentVehicleDetail'] as $index =>$vehicledetails){

          $cnt++;


          if($cnt==count($value['AssessmentVehicleDetail'])){

          }else{

          $arrayAll['statement'][$majorcnt][$index]['outstanding']='';
          }

          }
          $totaloutstanding=$totaloutstanding+$outstand;
          }
          $majorcnt++;
          }
          $this->set('data', $sqlResult);
          $this->set('totaloutstanding', $totaloutstanding);

         */
    }

    /*
     *
     * Feedback user detail
     *
     */

    function feedbackgetuserdetail($customerId = null) {

        $this->layout = false;

        $vehicle = '';

        if ($this->params['isAjax']) {

            $vehicle = (string) strtolower(trim($this->params['data']));
        }

        $this->loadModel('VehicleDetail');

        $sqlResult = $this->VehicleDetail->find('first', array(
            'conditions' => array(
                'OR' => array(
                    "lower(trim(VehicleDetail.vc_vehicle_lic_no)) = '{$vehicle}' ",
                    "lower(trim(VehicleDetail.vc_vehicle_reg_no)) = '{$vehicle}' "
                ),
                'VehicleDetail.vc_vehicle_status' => 'STSTY04'
        )));

        $this->set('data', $sqlResult);
    }

    /**
     *
     * get Vehicle Detail by either Lic No / Registration No
     *
     *
     */
    function getvehicledetail($value = null, $comp_code = null, $customer_no = null) {

        $this->loadModel('VehicleDetail');

        if ($this->params['isAjax']) {

            $value = $this->params['form']['value'];

            $customer_no = $this->params['form']['customer_no'];
        }

        $sendOutPut = array(
            'vc_vehicle_lic_no' => '',
            'vc_pay_frequency' => '',
            'vc_vehicle_reg_no' => ''
        );

        $list = $this->VehicleDetail->find('first', array(
            'conditions' => array(
                'VehicleDetail.vc_customer_no' => $customer_no,
                'VehicleDetail.vc_vehicle_status' => 'STSTY04',
                'OR' => array(
                    'VehicleDetail.vc_vehicle_lic_no' => $value,
                    'VehicleDetail.vc_vehicle_reg_no' => $value
                )
            ),
            'fields' => array(
                'vc_vehicle_lic_no',
                'vc_vehicle_reg_no',
                'vc_pay_frequency',
                'PAYFREQUENCY.vc_prtype_name'
            )
        ));

        if ($list) {

            $sendOutPut['vc_vehicle_lic_no'] = $list['VehicleDetail']['vc_vehicle_lic_no'];

            $sendOutPut['vc_vehicle_reg_no'] = $list['VehicleDetail']['vc_vehicle_reg_no'];

            $sendOutPut['vc_pay_frequency'] = $list['PAYFREQUENCY']['vc_prtype_name'];
        }

        echo json_encode($sendOutPut);
        exit;
    }

    /**
     *
     * 
     *  Get Vehicle Natis details of last assessment 
     *
     */
    function getvehiclenatisdetail() {

        $this->loadModel('AssessmentVehicleMaster');

        $this->loadModel('AssessmentVehicleDetail');

        $detail = array();

        $this->layout = null;

        if ($this->params['isAjax']) {

            $lic_no = $this->params['form']['lic_no'];

            $reg_no = $this->params['form']['reg_no'];
        } else {

            $lic_no = '';
            $reg_no = '';
        }

        $this->loadModel('VehicleLogDetail');

        /*

          $this->VehicleLogDetail->bindModel(array('belongsTo'=>
          array('AssessmentVehicleDetail'=>array('className'=>'AssessmentVehicleDetail','foreignKey'=>false)))); */
        /* $this->AssessmentVehicleDetail->bindModel(array('belongsTo'=>		array('VehicleLogDetail'=>array('className'=>'VehicleLogDetail','foreignKey'=>false,'conditions'=>array('AssessmentVehicleDetail.vc_assessment_no=VehicleLogDetail.vc_assessment_no')))));

         */
        //$this-AssessmentVehicleMaster

        $sqlResult = $this->AssessmentVehicleDetail->find('first', array(
            'conditions' => array(
                'AssessmentVehicleDetail.vc_vehicle_lic_no' => $lic_no,
            //'AssessmentVehicleMaster.vc_payment_status'=>'STSTY04',
            //'AssessmentVehicleMaster.vc_status'=>'STSTY04',
            ),
            'order' => array('AssessmentVehicleDetail.dt_created_date DESC'),
        ));

        $this->set('natis', $sqlResult);

        $total = $this->AssessmentVehicleDetail->find('all', array(
            'conditions' => array(
                'AssessmentVehicleDetail.vc_vehicle_lic_no' => $lic_no,
        )));
        //($total);
        $nu_total_payable_amount = 0;
        $vc_mdc_paid = 0;

        foreach ($total as $amount) {

            $nu_total_payable_amount = $nu_total_payable_amount + $amount['AssessmentVehicleMaster']['nu_total_payable_amount'];

            $vc_mdc_paid = $vc_mdc_paid + $amount['AssessmentVehicleMaster']['vc_mdc_paid'];
        }



        $this->set('data', $detail);
        $this->set('lic_no_search', $lic_no);
        $this->set('Totalnu_total_payable_amount', $nu_total_payable_amount);
        $this->set('Totalvc_mdc_paid', $vc_mdc_paid);
    }

    /**
     *
     * 
     *  Get Vehicle Log Detail
     *
     */
    function getvehiclelog() {

        $detail = array();

        $this->layout = null;

        if ($this->params['isAjax']) {

            $lic_no = $this->params['form']['lic_no'];

            $reg_no = $this->params['form']['reg_no'];
        } else {

            $lic_no = '';
            $reg_no = '';
        }

        $this->loadModel('VehicleLogDetail');

        $sqlResult = $this->VehicleLogDetail->find('first', array(
            'conditions' => array(
                'VehicleLogDetail.vc_vehicle_lic_no' => $lic_no,
                'VehicleLogDetail.vc_vehicle_reg_no' => $reg_no,
            ),
            'order' => array('VehicleLogDetail.dt_log_date DESC'),
            'fields' => array('VehicleLogDetail.dt_log_date', 'VehicleLogDetail.nu_end_ometer')
        ));
        if ($sqlResult) {

            $this->set('start', $sqlResult['VehicleLogDetail']['nu_end_ometer']);
        } else {

            $this->loadModel('VehicleDetail');

            $sqlResult = $this->VehicleDetail->find('first', array(
                'conditions' => array(
                    'VehicleDetail.vc_vehicle_lic_no' => $lic_no,
                    'VehicleDetail.vc_vehicle_reg_no' => $reg_no,
                ),
                'fields' => array('VehicleDetail.vc_start_ometer')
            ));

            $this->set('start', $sqlResult['VehicleDetail']['vc_start_ometer']);
        }

        $this->loadModel('CustomerLocationDistance');

        $this->set('OriginCustomerLocationDistance', array('' => ' Select ') + $this->CustomerLocationDistance->find('list', array(
                    'fields' => array(
                        'CustomerLocationDistance.vc_loc_from_code',
                        'CustomerLocationDistance.loc_from'))));

        /* $this->set('DestinationCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
          'fields'=>array(
          'CustomerLocationDistance.vc_loc_to_code',
          'CustomerLocationDistance.loc_to')))); */

        $this->set('data', $detail);
    }

    /*
     *
     *  
     *  Same Function For 2nd Row
     *
     */

    function getvehiclelog2() {

        $detail = array();

        $this->layout = null;

        if ($this->params['isAjax']) {

            $lic_no = $this->params['form']['lic_no'];

            $reg_no = $this->params['form']['reg_no'];
        } else {

            $lic_no = '';
            $reg_no = '';
        }

        $this->loadModel('VehicleLogDetail');

        $sqlResult = $this->VehicleLogDetail->find('first', array(
            'conditions' => array(
                'VehicleLogDetail.vc_vehicle_lic_no' => $lic_no,
                'VehicleLogDetail.vc_vehicle_reg_no' => $reg_no,
            ),
            'order' => array('VehicleLogDetail.dt_log_date DESC'),
            'fields' => array('VehicleLogDetail.dt_log_date', 'VehicleLogDetail.nu_end_ometer')
        ));
        if ($sqlResult) {

            $this->set('start', $sqlResult['VehicleLogDetail']['nu_end_ometer']);
        } else {

            $this->loadModel('VehicleDetail');

            $sqlResult = $this->VehicleDetail->find('first', array(
                'conditions' => array(
                    'VehicleDetail.vc_vehicle_lic_no' => $lic_no,
                    'VehicleDetail.vc_vehicle_reg_no' => $reg_no,
                ),
                'fields' => array('VehicleDetail.vc_start_ometer')
            ));

            $this->set('start', $sqlResult['VehicleDetail']['vc_start_ometer']);
        }

        $this->loadModel('CustomerLocationDistance');

        $this->set('OriginCustomerLocationDistance', array('' => ' Select ') + $this->CustomerLocationDistance->find('list', array(
                    'fields' => array(
                        'CustomerLocationDistance.vc_loc_from_code',
                        'CustomerLocationDistance.loc_from'))));

        /* $this->set('DestinationCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
          'fields'=>array(
          'CustomerLocationDistance.vc_loc_to_code',
          'CustomerLocationDistance.loc_to')))); */

        $this->set('data', $detail);
    }

    /*
     *
     * Get New Table Row.
     *
     */

    function getnewtablerow() {

        $this->layout = null;

        if ($this->params['isAjax']) {

            $this->layout = null;

            if (isset($this->params['form']['rowCount'])) {

                $this->set('rowCount', (int) $this->params['form']['rowCount']);
            }
        }
    }

    /**
     *
     *
     *
     */
    function getassessmentlist() {

        try {

            $this->loadModel('Profile');

            $this->layout = 'inspector';

            $this->set('title_for_layout', ' Customer  Assesssment  Detail ');

            $this->set('users', $this->Profile->find('all', array('conditions' => array('Profile.ch_active' => 'STSTY04', 'Profile.vc_comp_code' => $this->mdc))));
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     *
     *
     * Get Assessment Detail By user no.
     *
     */

    function getassessmentdetail($customerId = null) {


        $this->layout = false;

        $this->loadModel('AssessmentVehicleMaster');

        if ($this->params['isAjax']) {

            $customerId = $this->params['data'];
        }

        $data = $this->AssessmentVehicleMaster->find('all', array(
            'conditions' => array(
                'AssessmentVehicleMaster.vc_customer_no' => $customerId,
                'AssessmentVehicleMaster.vc_status' => 'STSTY03'
        )));

        $this->set('data', $data);
    }

    /*     * *
     *  
     *  Get Vehicle List Report
     */

    public function vehiclelist() {

        try {


            $this->loadModel('VehicleDetail');

            /***** From Date ******** */


            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                        '';

            endif;

            /*             * Customer Name *** */

            if (isset($this->params['named']['vc_customer_name'])) :

                $vc_customer_name = trim($this->params['named']['vc_customer_name']);

            else :

                $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                        trim($this->data['Inspector']['vc_customer_name']) :
                        '';
            endif;


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date <=' => $toDate
                );

            endif;

            if ($vc_customer_name) :

                $conditions += array(
                    ' lower(CustomerProfile.vc_customer_name) LIKE' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;



            $this->set('SearchfromDate', $fromDate);

            $this->set('SearchtoDate', $toDate);

            $numberOfRows = 10;

            if (isset($this->params['named']['page'])) :

                $pageNo = trim($this->params['named']['page']);

            else :
                $pageNo = 1;

            endif;

            $start = (($pageNo - 1) * $numberOfRows) + 1;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('VehicleDetail.dt_created_date desc'),
                'limit' => $numberOfRows
            );

            $vehiclereport = $this->paginate('VehicleDetail');

            $this->set('start', $start);

            $this->set('vehiclereport', $vehiclereport);

            $this->set('fromDate', $fromDate);

            $this->set('toDate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $this->layout = 'inspector';

            $this->set('title_for_layout', ' Vehicle History Report');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Get Vehicle List PDF
     *
     */
    function vehiclelistpdf() {


        try {


            $this->loadModel('VehicleDetail');

            /*             * ** From Date ******** */


            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['toDate']) && !empty($this->data['Inspector']['toDate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['toDate'])) :
                        '';

            endif;

            /*             * Customer Name *** */

            if (isset($this->params['named']['vc_customer_name'])) :

                $vc_customer_name = trim(ucfirst($this->params['named']['vc_customer_name']));

            else :

                $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                        trim($this->data['Inspector']['vc_customer_name']) :
                        '';
            endif;


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date <=' => $toDate
                );

            endif;

            if ($vc_customer_name) :

                $conditions += array(
                    ' lower(CustomerProfile.vc_customer_name) LIKE' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;

            $vehiclereport = $this->VehicleDetail->find('all', array(
                'conditions' => $conditions,
                'order' => array('VehicleDetail.dt_created_date desc')));



            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $this->set('fromDate', $fromDate);

            $this->set('toDate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vehiclereport', $vehiclereport);

            Configure::write('debug', 0);

            $columnsValues = array('SI.No.', 'Customer Name',
                'Vehicle LIC. No.', 'Vehicle Reg. No.',
                'Registration Date', 'Vehicle Type',
                'V Rating', 'D/T Rating',
                'Rate(N$)');

            $this->Inspectorreportpdfcreator->headerData('Vehicle List Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate);

            $this->Inspectorreportpdfcreator->genrate_inspectorvehiclehistorypdf($columnsValues, $vehiclereport, $this->globalParameterarray, $this->Session->read('Auth.Profile'), $toDate, $fromDate, $vc_customer_name);

            $vc_cust_no = $this->Session->read('Auth.Profile.vc_customer_no');

            $this->Inspectorreportpdfcreator->output($vc_cust_no . '-Inspector-Vehicle-Report' . '.pdf', 'D');

            die;

            $this->layout = 'pdf';

            $this->set('title_for_layout', 'Customer Vehicle Report');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *    
     *  Vehicle Log Sheet
     *
     */
    public function logsheet() {

        try {

            $this->loadModel('VehicleLogDetail');


            /*             * ** From Date ******** */


            if (isset($this->params['named']['fromdate'])) :

                $fromDate = date('d-M-y', strtotime($this->params['named']['fromdate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                        '';

            endif;

            /** Vehicle Type *** */
            if (isset($this->params['named']['vc_customer_name'])) :


                $vc_customer_name = trim(ucfirst($this->params['named']['vc_customer_name']));

            else :

                $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                        trim($this->data['Inspector']['vc_customer_name']) :
                        '';
            endif;


            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date >=' => $fromDate
                );

            endif;

            if ($toDate) :

                $conditions += array('VehicleLogDetail.dt_log_date <=' => $toDate);

            endif;

            if ($vc_customer_name):

                $conditions += array(
                    ' lower(VehicleLogMaster.vc_customer_name) like ' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('VehicleLogDetail.dt_log_date desc'),
                'limit' => 10
            );

            $vehiclelogreport = $this->paginate('VehicleLogDetail');

            $this->layout = 'inspector';

            $this->set('vehiclelogreport', $vehiclelogreport);

            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $this->layout = 'inspector';

            $this->set('title_for_layout', 'Vehicle Log Report');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    public function logsheetpdf() {

        try {

            $this->loadModel('VehicleLogDetail');

            /*             * ** From Date ******** */

            $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                    date('d-M-y', strtotime($this->data['Inspector']['fromdate'])) :
                    '';


            /* **** To Date******** */

            $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                    date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                    '';

            /** Vehicle Type *** */

            $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                    trim($this->data['Inspector']['vc_customer_name']) :
                    '';

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date >=' => $fromDate
                );

            endif;

            if ($toDate) :

                $conditions += array('VehicleLogDetail.dt_log_date <=' => $toDate);

            endif;

            if ($vc_customer_name):

                $conditions += array(
                    ' lower(VehicleLogMaster.vc_customer_name) like ' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;

            $logreport = $this->VehicleLogDetail->find('all', array(
                'conditions' => $conditions,
                'order' => array('VehicleLogDetail.dt_log_date desc')));
            
            $this->set('logreport', $logreport);

            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vc_customer_name', $vc_customer_name);

            //Configure::write('debug', 0);

            $columnsValues = array('Log Date', 'Customer Name', 'Vehicle Reg. No.',
                'Vehicle LIC. No.', 'Driver Name',
                'Start Odometer', 'End Odometer', 'Road Type',
                'Origin', 'Destination',
                'KM Travelled ',
            );

            $this->Inspectorreportpdfcreator->headerData('Vehicle Log Sheet Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate);

            $this->Inspectorreportpdfcreator->genrate_inspectorvehiclelogsheet_pdf($columnsValues, $logreport, $this->globalParameterarray, $this->Session->read('Auth.Profile'), $toDate, $fromDate, $vc_customer_name);

            $vc_cust_no = $this->Session->read('Auth.Profile.vc_customer_no');

            $this->Inspectorreportpdfcreator->output($vc_cust_no . '-Inspector-Vehicle-Log_Sheet_Report' . '.pdf', 'D');

            die;

            $this->layout = 'pdf';

            $this->set('title_for_layout', 'Vehicle Log Report');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    function paymenthistory() {

        try {
            //pr($this->Session->read('Auth'));
            $this->loadModel('AssessmentVehicleMaster');

            /* * ** From Date ******** */


            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                        '';

            endif;

            /*             * Customer Name *** */

            if (isset($this->params['named']['vc_customer_name'])) :

                $vc_customer_name = trim(ucfirst($this->params['named']['vc_customer_name']));

            else :

                $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                        trim($this->data['Inspector']['vc_customer_name']) :
                        '';
            endif;


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date <=' => $toDate
                );

            endif;

            if ($vc_customer_name) :

                $conditions += array(
                    ' lower(AssessmentVehicleMaster.vc_customer_name) LIKE' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;

            $numberOfRows = 10;

            if (isset($this->params['named']['page'])) :

                $pageNo = trim($this->params['named']['page']);

            else :
                $pageNo = 1;

            endif;

            $start = (($pageNo - 1) * $numberOfRows) + 1;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('AssessmentVehicleMaster.dt_received_date' => 'desc'),
                'limit' => $numberOfRows
            );


            $this->set('paymentreport', $this->paginate('AssessmentVehicleMaster'));

            $this->set('start', $start);

            $this->set('fromDate', $fromDate);

            $this->set('toDate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $this->layout = 'inspector';

            $this->set('title_for_layout', 'Customer Payment History');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    function paymenthistorypdf() {

        try {

          //  Configure::write('debug',2);
            $this->loadModel('AssessmentVehicleMaster');

            $fromDate = isset($this->data['Inspector']['fromDate']) && !empty($this->data['Inspector']['fromDate']) ?
                    date('d-M-Y', strtotime($this->data['Inspector']['fromDate'])) :
                    '';

            $toDate = isset($this->data['Inspector']['toDate']) && !empty($this->data['Inspector']['toDate']) ?
                    date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['toDate'])) :
                    '';

            $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                    trim($this->data['Inspector']['vc_customer_name']) :
                    '';




            $conditions = array();

            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date <=' => $toDate
                );

            endif;

            if ($vc_customer_name) :

                $conditions += array(
                    ' lower( AssessmentVehicleMaster.vc_customer_name ) LIKE' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;


            $paymentreport = $this->AssessmentVehicleMaster->find('all', array(
                'conditions' => $conditions,
                'order' => array('AssessmentVehicleMaster.dt_received_date' => 'desc')));



            $this->set('paymentreport', $paymentreport);

            $this->set('fromDate', $fromDate);

            $this->set('toDate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $columnsValues = array('SI. No.', 'Assessment No.',
                'Customer Name', 'Assessment Date',
                'Payable Amount (N$)', 'Paid Amount (N$)',
                'Payment Date', 'Payment Status');

            $this->Inspectorreportpdfcreator->headerData('Payment History Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate);


            $this->Inspectorreportpdfcreator->genrate_inspectorpaymenthistory_pdf($columnsValues, $paymentreport, $this->globalParameterarray, $this->Session->read('Auth.Profile'), $toDate, $fromDate, $vc_customer_name);

            $vc_cust_no = $this->Session->read('Auth.Profile.vc_username');
            
            //die;

            $this->Inspectorreportpdfcreator->output($vc_cust_no . '-Inspector-Payment-History_Report' . '.pdf', 'D');

            die;

            $this->layout = 'pdf';
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Customer Assessment History
     *
     */
    function assessmenthistory() {

        try {

            $this->loadModel('AssessmentVehicleDetail');

            /*             * ** From Date ******** */

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                        '';

            endif;

            /*             * Customer Name *** */

            if (isset($this->params['named']['vc_customer_name'])) :

                $vc_customer_name = trim(ucfirst($this->params['named']['vc_customer_name']));

            else :

                $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                        trim($this->data['Inspector']['vc_customer_name']) :
                        '';
            endif;


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date <=' => $toDate
                );

            endif;

            if ($vc_customer_name) :

                $conditions += array(
                    ' lower( AssessmentVehicleMaster.vc_customer_name)  LIKE' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;

            $numberOfRows = 10;

            if (isset($this->params['named']['page'])) :

                $pageNo = trim($this->params['named']['page']);

            else :
                $pageNo = 1;

            endif;

            $start = (($pageNo - 1) * $numberOfRows) + 1;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc'),
                'limit' => $numberOfRows
            );

            $assessmentreport = $this->paginate('AssessmentVehicleDetail');


            foreach ($assessmentreport as $key => &$value) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $value['VehicleDetail']['vc_vehicle_type']),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));
                $value['VehicleDetail']['VEHICLETYPE'] = $getTypeResult['ParameterType'];
            }

            $this->set('assessmentreport', $assessmentreport);

            $this->set('start', $start);

            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate );

            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $this->layout = 'inspector';

            $this->set('title_for_layout', 'Customer Assessment Report');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Customer Assessment History PDF
     *
     */
    function assessmenthistorypdf() {


        try {
            $this->loadModel('AssessmentVehicleDetail');


            /*             * ** From Date ******** */

            $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                    date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                    '';

            /*             * * To Date******** */

            $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                    date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                    '';

            /*             * Customer Name *** */

            $vc_customer_name = isset($this->data['Inspector']['vc_customer_name']) && !empty($this->data['Inspector']['vc_customer_name']) ?
                    trim($this->data['Inspector']['vc_customer_name']) :
                    '';

            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date <=' => $toDate
                );

            endif;

            if ($vc_customer_name) :

                $conditions += array(
                    ' lower( AssessmentVehicleMaster.vc_customer_name) LIKE' => strtolower(trim($vc_customer_name)) . '%'
                );

            endif;

            $assessmentreport = $this->AssessmentVehicleDetail->find('all', array(
                'conditions' => $conditions,
                'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc'),
                'recursive' => 2
            ));



            foreach ($assessmentreport as $key => &$value) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $value['VehicleDetail']['vc_vehicle_type']),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));
                $value['VehicleDetail']['VEHICLETYPE'] = $getTypeResult['ParameterType'];
            }

            $this->set('assessmentreport', $assessmentreport);

            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate );

            $this->set('vc_customer_name', ucwords($vc_customer_name));

            $columnsValues = array('SI. No.', 'Customer Name',
                'Assessment Date', 'Assessment No.',
                'Vehicle LIC. No.', 'Vehicle Reg. No.',
                'Vehicle Type', 'Pay Frequency',
                'Prev. End OM', 'End OM',
                'KM Travel on Namibian Road Network', 'Rate(N$)',
                'Payable(N$)', 'Status');

            $this->Inspectorreportpdfcreator->headerData('Assessment History Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate);

            $this->Inspectorreportpdfcreator->genrate_inspectorassessmenthistory_pdf($columnsValues, $assessmentreport, $this->globalParameterarray, $this->Session->read('Auth.Profile'), $toDate, $fromDate, $vc_customer_name);

            $vc_cust_no = $this->Session->read('Auth.Profile.vc_customer_no');

            $this->Inspectorreportpdfcreator->output($vc_cust_no . '-Inspector-Assessment-History_Report' . '.pdf', 'D');

            die;

            $this->layout = 'pdf';
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    function vehiclelogsheet() {

        try {
            $this->loadModel('VehicleLogDetail');

            /*             * ** From Date ******** */

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                        '';

            endif;

            /*             * Customer Name *** */

            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

            else :

                $vehicletype = isset($this->data['Inspector']['vehicletype']) && !empty($this->data['Inspector']['vehicletype']) ?
                        trim($this->data['Inspector']['vehicletype']) :
                        '';
            endif;


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date >= ' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('VehicleLogDetail.dt_log_date' => 'desc'),
                'limit' => 10
            );

            $this->set('vehiclelogreport', $this->paginate('VehicleLogDetail'));

            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate );

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $vehicletype),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                $this->set('vehicletypename', $getTypeResult['ParameterType']['vc_prtype_name']);
            } else {

                $this->set('vehicletypename', '');
            }

            $this->layout = 'inspector';

            $this->set('title_for_layout', 'Vehicle Log Report');

            $this->set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' =>
                        array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'),
                        'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Get  Vehicle Log sheet PDF
     *
     */
    function vehiclelogsheetpdf() {

        try {

            $this->loadModel('VehicleLogDetail');

            /*             * ** From Date ******** */


            $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                    date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                    '';


            /*             * * To Date******** */

            $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                    date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                    '';



            /*             * Customer Name *** */

            $vehicletype = isset($this->data['Inspector']['vehicletype']) && !empty($this->data['Inspector']['vehicletype']) ?
                    trim($this->data['Inspector']['vehicletype']) :
                    '';


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date >= ' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;

            $vehiclelogreport = $this->VehicleLogDetail->find('all', array(
                'conditions' => $conditions,
                'order' => array('VehicleLogDetail.dt_log_date' => 'desc')));

            $this->set('vehiclelogreport', $vehiclelogreport);


            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate);

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $vehicletype),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                $this->set('vehicletypename', $getTypeResult['ParameterType']['vc_prtype_name']);
            } else {

                $this->set('vehicletypename', '');
            }

            $columnsValues = array('Log Date', 'Vehicle Reg. No.',
                'Vehicle LIC. No.', 'Driver Name',
                'Start Odometer', 'End Odometer',
                'Road Type', 'Origin', 'Destination',
                'KM Travelled', 'Created Date');

            $this->Inspectorreportpdfcreator->headerData('Inspector Vehicle Log Sheet Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate);

            $this->Inspectorreportpdfcreator->genrate_inspectorvehicleloghistory_pdf($columnsValues, $vehiclelogreport, $vehicletype, $this->globalParameterarray, $this->Session->read('Auth.Profile'), $toDate, $fromDate);

            $vc_cust_no = $this->Session->read('Auth.Profile.vc_customer_no');

            $this->Inspectorreportpdfcreator->output($vc_cust_no . '-Inspector-Vehicle-Log-History_Report' . '.pdf', 'D');

            die;

            $this->layout = 'pdf';
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    function vehicleassessment() {

        try {


            $this->loadModel('AssessmentVehicleDetail');

            /*             * ** From Date ******** */

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                        '';
            endif;

            /*             * * To Date******** */

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                        '';

            endif;

            /*             * Vehicle Type *** */

            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

            else :

                $vehicletype = isset($this->data['Inspector']['vehicletype']) && !empty($this->data['Inspector']['vehicletype']) ?
                        trim($this->data['Inspector']['vehicletype']) :
                        '';
            endif;


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date >= ' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;

            $numberOfRows = 10;

            if (isset($this->params['named']['page'])) :

                $pageNo = trim($this->params['named']['page']);

            else :
                $pageNo = 1;

            endif;

            $start = (($pageNo - 1) * $numberOfRows) + 1;


            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc'),
                'limit' => $numberOfRows
            );

            $assessmentreport = $this->paginate('AssessmentVehicleDetail');

            foreach ($assessmentreport as $key => &$value) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $value['VehicleDetail']['vc_vehicle_type']),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));
                $value['VehicleDetail']['VEHICLETYPE'] = $getTypeResult['ParameterType'];
            }

            $this->set('assessmentreport', $assessmentreport);

            $this->set('start', $start);

            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate );

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $vehicletype),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                $this->set('vehicletypename', $getTypeResult['ParameterType']['vc_prtype_name']);
            } else {

                $this->set('vehicletypename', '');
            }

            $this->set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' =>
                        array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'),
                        'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->layout = 'inspector';

            $this->set('title_for_layout', 'Report - Vehicle Assessment');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Get Vehicle Assessment PDF
     *
     */
    function vehicleassessmentpdf() {

        try {


            $this->loadModel('AssessmentVehicleDetail');

            /*             * ** From Date ******** */

            $fromDate = isset($this->data['Inspector']['fromdate']) && !empty($this->data['Inspector']['fromdate']) ?
                    date('d-M-Y', strtotime($this->data['Inspector']['fromdate'])) :
                    '';

            /*             * * To Date******** */

            $toDate = isset($this->data['Inspector']['todate']) && !empty($this->data['Inspector']['todate']) ?
                    date('d-M-Y 23:59:59', strtotime($this->data['Inspector']['todate'])) :
                    '';



            /*             * Vehicle Type *** */

            $vehicletype = isset($this->data['Inspector']['vehicletype']) && !empty($this->data['Inspector']['vehicletype']) ?
                    trim($this->data['Inspector']['vehicletype']) :
                    '';


            /*             * ***Conditions Start ****** */

            $conditions = array();

            if ($fromDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date >= ' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;


            $assessmentreport = $this->AssessmentVehicleDetail->find('all', array(
                'conditions' => $conditions,
                'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc'),
            ));


            foreach ($assessmentreport as $key => &$value) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $value['VehicleDetail']['vc_vehicle_type']),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));
                $value['VehicleDetail']['VEHICLETYPE'] = $getTypeResult['ParameterType'];
            }

            $this->set('assessmentreport', $assessmentreport);



            $this->set('fromdate', $fromDate);

            $this->set('todate', isset($toDate) && !empty($toDate) ? date('d M Y', strtotime($toDate)) : $toDate );

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $getTypeResult = $this->ParameterType->find('first', array('conditions' =>
                    array('ParameterType.vc_prtype_code' => $vehicletype),
                    'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                $this->set('vehicletypename', $getTypeResult['ParameterType']['vc_prtype_name']);
            } else {

                $this->set('vehicletypename', '');
            }

            $columnsValues = array('SI. No.',
                'Assessment Date', 'Assessment No.',
                'Vehicle LIC. No.', 'Vehicle Reg. No.',
                'Vehicle Type', 'Pay Frequency',
                'Prev. End OM', 'End OM',
                'KM Travel on Namibian Road Network', 'Rate(N$)',
                'Payable(N$)', 'Status');

            $this->Inspectorreportpdfcreator->headerData('Inspector Vehicle Assessment Report', $period = NULL, $this->Session->read('Auth'), $vehicletype, $toDate, $fromDate);

            $this->Inspectorreportpdfcreator->genrate_assessmenthistory_pdf($columnsValues, $assessmentreport, $vehicletype, $this->globalParameterarray, $this->Session->read('Auth.Profile'), $toDate, $fromDate);

            $vc_cust_no = $this->Session->read('Auth.Profile.vc_customer_no');

            $this->Inspectorreportpdfcreator->output($vc_cust_no . '-Inspector-Vehicle-Log-History_Report' . '.pdf', 'D');

            die;

            $this->layout = 'pdf';
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Get Customer Detail By  Search 
     *
     */
    function getcustomerdetailbysearch() {

        $this->loadModel('VehicleDetail');

        $this->layout = null;

        $data = '';

        $conditions = array();

        if ($this->params['isAjax'] && !empty($this->params['data'])) {


            $data .= strtolower(trim($this->params['data']));

            $conditions += array(
                'OR' => array(
                    "lower(TRIM(VehicleDetail.vc_vehicle_lic_no)) like '%$data%' ",
                    "lower(TRIM(VehicleDetail.vc_vehicle_reg_no)) like '%$data%' "));
        }


        $conditions += array('TRIM(VehicleDetail.vc_vehicle_status)' => trim('STSTY04'));

        $this->set('vehicleList', $this->VehicleDetail->find('list', array(
                    'conditions' => $conditions,
                    'fields' => array('TRIM(VehicleDetail.vc_vehicle_lic_no)', 'TRIM(VehicleDetail.vc_vehicle_reg_no)'))));

        /*
          $this->Profile->bindModel(array('hasOne' => array('Member'=>array('className'=>'Member','foreignKey' => false))));

          $this->set('users', $this->Profile->find('all', array(
          'conditions' => array(
          'Profile.ch_active' => 'STSTY04',
          'Profile.vc_comp_code' => $this->mdc,
          'Profile.vc_user_no = Member.vc_user_no ',
          'lower(Member.vc_user_login_type)'=> strtolower("USRLOGIN_CUST"),
          'OR'=>array(
          'Profile.vc_customer_name like'=>ucfirst($data).'%',
          'Profile.vc_customer_no like'=>$data.'%'
          ))))); */
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

    /*
     *
     *  Below function is use to register log for inactive or not registered vehicle mdc.
     *
     */

    function inactivevehicles_old() {

        $this->layout = 'inspector';

        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

        try {

            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->loadModel('CustomerInactiveVehicleLog');

                $this->CustomerInactiveVehicleLog->set($this->data);

                if ($this->CustomerInactiveVehicleLog->validates($this->data)) {


                    $this->CustomerInactiveVehicleLog->create();

                    $this->data['CustomerInactiveVehicleLog']['dt_log_date'] = date('d-M-Y H:i:s', strtotime($this->data['CustomerInactiveVehicleLog']['dt_log_date']));

                    $this->data['CustomerInactiveVehicleLog']['vc_comp_code'] = trim($this->Session->read('Auth.Member.vc_comp_code'));

                    $this->data['CustomerInactiveVehicleLog']['vc_log_detail_id'] = $this->CustomerInactiveVehicleLog->getPrimaryKey();

                    $this->data['CustomerInactiveVehicleLog']['vc_customer_no'] = null;
                    $this->data['CustomerInactiveVehicleLog']['vc_remark_by'] = 'USRTYPE01';

                    $this->data['CustomerInactiveVehicleLog']['dt_created_date'] = date('d-M-Y H:i:s');

                    if ($this->CustomerInactiveVehicleLog->save($this->data, false)) {

                        $this->data = null;

                        unset($this->data);

                        $this->Session->setFlash('Your vehicle log has been submitted successfully', 'success');

                        $this->redirect($this->referer());
                    }
                }
            }

            $this->loadModel('CustomerLocationDistance');

            $this->set('OriginCustomerLocationDistance', array('' => ' Select ') + $this->CustomerLocationDistance->find('list', array(
                        'fields' => array(
                            'CustomerLocationDistance.vc_loc_from_code',
                            'CustomerLocationDistance.loc_from'))));

            $this->set('DestinationCustomerLocationDistance', array());


            $this->set('title_for_layout', strtoupper($selectedType) . "  Inactive Vehicle Log Registration Form  ");
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }
	
	
	function inactivevehicles() {

        $this->layout = 'inspector';

        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

        try {
		//pr($this->data);die;
		    //checkvehicleresgisteredforInactive
			$this->loadModel('CustomerInactiveVehicleLog');

            if (!empty($this->data) && $this->RequestHandler->isPost()) {
					
				//	foreach()
                $this->CustomerInactiveVehicleLog->set($this->data['VehicleLogDetail'][0]);				
			
			//  pr($this->Session->read('Auth.Member'));
                
				if ($this->CustomerInactiveVehicleLog->validates($this->data['VehicleLogDetail'][0])) {
					
					if($this->checkvehicleresgisteredforInactive($this->data['VehicleLogDetail'][0]['vc_vehicle_lic_no'])>0){
				      $this->Session->setFlash('This vehicle already exist', 'error');
					  $this->redirect('inactivevehicles');	
					}
					
					$filesissue=false;
						//pr($this->data['VehicleLogDetail']);
					foreach($this->data['VehicleLogDetail'] as $valuefile){
						
						if($valuefile['uploaddocs']['tmp_name']!='' && ((int)$valuefile['uploaddocs']['size']>2048000)){
							
							$filesissue = true;
							$this->Session->setFlash('File should be less than 2 MB.', 'error');
							$this->redirect('inactivevehicles');	
							
							}
					}
					if($filesissue==false){
					
									//die('hua');

					if($checkRequest = $this->CustomerInactiveVehicleLog->find('count', array(
                                            'conditions' => array(
                                                'lower(CustomerInactiveVehicleLog.vc_vehicle_lic_no)' => 
												strtolower(trim($this->data['VehicleLogDetail'][0]['vc_vehicle_lic_no'])),
                                                array('OR' => array(
                                                    array('CustomerInactiveVehicleLog.nu_start_ometer' => trim($this->data['VehicleLogDetail'][0]['nu_start_ometer'])),
                                                    array('CustomerInactiveVehicleLog.nu_end_ometer' => trim($this->data['VehicleLogDetail'][0]['nu_end_ometer']))
                                        ))))) > 0){
										
						$this->Session->setFlash('Odometer details of this vehicle already exist,please enter the unique no.', 'error');					    
						$this->redirect('inactivevehicles');
					
					}
                    
					$this->CustomerInactiveVehicleLog->create();
                    
					$this->data['CustomerInactiveVehicleLog']['dt_log_date'] = date('d-M-Y H:i:s', strtotime($this->data['VehicleLogDetail'][0]['dt_log_date']));
                    
					$this->data['CustomerInactiveVehicleLog']['vc_comp_code'] = trim($this->Session->read('Auth.Member.vc_comp_code'));

                    $this->data['CustomerInactiveVehicleLog']['vc_log_detail_id'] = $this->CustomerInactiveVehicleLog->getPrimaryKey();
					
					$logid = $this->CustomerInactiveVehicleLog->getPrimaryKey();

                    $this->data['CustomerInactiveVehicleLog']['vc_customer_no'] = trim($this->Session->read('Auth.Member.vc_username'));
					
                    $this->data['CustomerInactiveVehicleLog']['vc_vehicle_reg_no'] = $this->data['VehicleLogDetail'][0]['vc_vehicle_reg_no'];
					
                    $this->data['CustomerInactiveVehicleLog']['vc_vehicle_lic_no'] = $this->data['VehicleLogDetail'][0]['vc_vehicle_lic_no'];
                    
					$this->data['CustomerInactiveVehicleLog']['vc_remark_by'] = 'USRTYPE01';
                    
					$this->data['CustomerInactiveVehicleLog']['ch_road_type']    = $this->data['VehicleLogDetail'][0]['selectedroad'];
                    
					$this->data['CustomerInactiveVehicleLog']['dt_created_date'] = date('d-M-Y H:i:s');
					
					$this->data['CustomerInactiveVehicleLog']['nu_start_ometer'] = $this->data['VehicleLogDetail'][0]['nu_start_ometer'];
					
					$this->data['CustomerInactiveVehicleLog']['nu_end_ometer']   = $this->data['VehicleLogDetail'][0]['nu_end_ometer'];
					
					$diff =  $this->data['CustomerInactiveVehicleLog']['nu_end_ometer']-$this->data['CustomerInactiveVehicleLog']['nu_start_ometer'] ;
					
                    
					if($this->data['VehicleLogDetail'][0]['selectedroad']==0){
					
					$this->data['CustomerInactiveVehicleLog']['vc_orign']        = $this->data['VehicleLogDetail'][0]['vc_orign'];
					
					$this->data['CustomerInactiveVehicleLog']['vc_destination'] = $this->data['VehicleLogDetail'][0]['vc_destination'];
					$this->data['CustomerInactiveVehicleLog']['nu_km_traveled'] = $diff;				
					
					}else{
					
					$this->data['CustomerInactiveVehicleLog']['vc_other_road_orign']        = $this->data['VehicleLogDetail'][0]['vc_orign'];
					
					$this->data['CustomerInactiveVehicleLog']['vc_other_road_destination'] = $this->data['VehicleLogDetail'][0]['vc_destination'];
					
					$this->data['CustomerInactiveVehicleLog']['nu_other_road_km_traveled'] = $diff;
					
					}				
					
					
					$this->data['CustomerInactiveVehicleLog']['vc_STATUS'] = 'STSTY03';		
					
					//$this->data['CustomerInactiveVehicleLog']['ch_type'] = 'I';		 // Inactive vehicle type			
					
                    $this->data['CustomerInactiveVehicleLog']['vc_remark'] = $this->data['VehicleLogDetail'][0]['vc_remark'];
                    if ($this->CustomerInactiveVehicleLog->save($this->data, false)) {
						
						// pr($this->data);
				
						if (isset($this->data['VehicleLogDetail'][0]['uploaddocs']['name']) && trim($this->data['VehicleLogDetail'][0]['uploaddocs']['error']) == 0) {

								$this->loadModel('UploadDocumentLogInspector');

								$saveData = array();
								
								$saveData['UploadDocumentLogInspector']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');
								
								$saveData['UploadDocumentLogInspector']['vc_customer_no'] = $this->Session->read('Auth.Member.vc_username');
								
								$saveData['UploadDocumentLogInspector']['dt_date_uploaded'] = date('d-M-Y H:i:s');
								
								$saveData['UploadDocumentLogInspector']['vc_log_detail_id'] = $logid;
								
								$saveData['UploadDocumentLogInspector']['vc_vehicle_lic_no'] = $this->data['VehicleLogDetail'][0]['vc_vehicle_lic_no'];

								$saveData['UploadDocumentLogInspector']['vc_uploaded_doc_for'] = 'Inactive Vehicle Log';

								$filepath = trim(trim($this->Session->read('Auth.Member.vc_username')));

								$dir = WWW_ROOT . "uploadfile" . DS . "$filepath" . DS . 'log' . DS . trim($logid);

								if (!file_exists($dir)) {

									mkdir($dir, 0777, true);
								}

								$saveData['UploadDocumentLogInspector']['vc_uploaded_doc_path'] = $dir;
								
								$filename = date('YmdHis').'-'.$this->data['VehicleLogDetail'][0]['uploaddocs']['name'];

								if (file_exists($dir . DS . $filename)) {

								$filename = date('YmdHis').'-'.$this->data['VehicleLogDetail'][0]['uploaddocs']['name'];
								}

								$saveData['UploadDocumentLogInspector']['vc_uploaded_doc_name'] = $filename;
								$saveData['UploadDocumentLogInspector']['vc_upload_id'] = $this->UploadDocumentLogInspector->getPrimaryKey();

								$saveData['UploadDocumentLogInspector']['vc_uploaded_doc_type'] = $this->data['VehicleLogDetail'][0]['uploaddocs']['type'];
								
								$uploadstatus = move_uploaded_file($this->data['VehicleLogDetail'][0]['uploaddocs']['tmp_name'],$dir.DS.$filename);
									//pr($saveData);die;		
								if($uploadstatus==true){
									
									$this->UploadDocumentLogInspector->save($saveData, false);
									//pr($saveData);
									//die;
								}
			
								 $saveData = null;
						  }
                        
						$this->data = null;

                        unset($this->data);

                        $this->Session->setFlash('Your vehicle log has been submitted successfully', 'success');

                        $this->redirect($this->referer());
                    }         // log save
                  }         // if of filesissue
				}       // CustomerInactiveVehicleLog 
            }

            $this->loadModel('CustomerLocationDistance');
            $this->set('OriginCustomerLocationDistance', array('' =>' Select ')+ $this->CustomerLocationDistance->find('list', array('fields' => array('CustomerLocationDistance.vc_loc_from_code','CustomerLocationDistance.loc_from'))));

            $this->set('DestinationCustomerLocationDistance', array());
            $this->set('title_for_layout', strtoupper($selectedType) . "  Inactive Vehicle Log Registration Form  ");
			
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
            exit;
        }
    }

    
	/**
     *
     *
     *
     *
     */
	 
    function checkvehicleresgistered() {

        Configure::write('debug', 2);
			
        if ($this->params['isAjax'] && isset($this->params['data']['VehicleLogDetail']) 
		&& !empty($this->params['data']['VehicleLogDetail'])) {

            $this->loadModel('VehicleDetail');
			
			// vc_vehicle_reg_no
		    if(isset($this->params['data']['VehicleLogDetail'][0]['vc_vehicle_lic_no']) && $this->params['data']['VehicleLogDetail'][0]['vc_vehicle_lic_no']!='')	
			$vc_vehicle_lic_no = trim($this->params['data']['VehicleLogDetail'][0]['vc_vehicle_lic_no']);
            
			if(isset($this->params['data']['VehicleLogDetail'][0]['vc_vehicle_reg_no']) && $this->params['data']['VehicleLogDetail'][0]['vc_vehicle_reg_no']!='')	
			$vc_vehicle_lic_no = trim($this->params['data']['VehicleLogDetail'][0]['vc_vehicle_reg_no']);
			
			
			//pr($this->params['data']['VehicleLogDetail']);die;
            
			$vc_vehicle_lic_no = strtolower($vc_vehicle_lic_no);
			$count = $this->VehicleDetail->find('count', array(
                'conditions' => array(
                    'OR' => array(
                        'lower(VehicleDetail.vc_vehicle_lic_no)' => "{$vc_vehicle_lic_no}",
                        'lower(VehicleDetail.vc_vehicle_reg_no)' => "{$vc_vehicle_lic_no}"
            ))));
			
            if ($count == 0) :
                echo "true";
            else :
                echo "false";
            endif;
			}
        else {

            echo "false";

        }

        exit;
    }
	
function checkvehicleresgisteredforInactive($vehlicno=null) {

        Configure::write('debug', 2);
		
        $this->loadModel('VehicleDetail');
		
        $string = strtolower(trim($vehlicno));

        $count = $this->VehicleDetail->find('count', array(
                'conditions' => array(
                    'OR' => array(
                        'lower(VehicleDetail.vc_vehicle_lic_no)' => "{$string}",
                        'lower(VehicleDetail.vc_vehicle_reg_no)' => "{$string}"
        ))));
        
		return $count;
    }
    /*
     *
     *
     * Get List of To Destination Location List 
     *
     */

    function getdistanceselectedlocationto() {

        Configure::write('debug', 0);

        $this->layout = null;

        $string = '';

        if ($this->params['isAjax'] && isset($this->params['data'])) :

            $data = isset($this->params['data']) && trim($this->params['data']) == '' ? NULL : $this->params['data'];

            $string = strtolower(trim($data));

        endif;

        $this->loadModel('CustomerLocationDistance');

        $conditions = array('lower(CustomerLocationDistance.vc_loc_from_code)' => "{$string}");

        $DestinationCustomerLocationDistance = $this->CustomerLocationDistance->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'CustomerLocationDistance.vc_loc_to_code',
                'CustomerLocationDistance.loc_to')));


        $this->set('DestinationCustomerLocationDistance', $DestinationCustomerLocationDistance);
    }

    /**
     *
     *
     *
     *
     */
    function calculatedistancelocation() {

        Configure::write('debug', 0);

        $this->layout = null;

        $vc_orign = '';

        $string = '';

        $k = 0;
        if ($this->params['isAjax'] && isset($this->params['form']['vc_orign']) && isset($this->params['data'])) :

            $string = strtolower(trim($this->params['data']));

            $vc_orign = strtolower(trim($this->params['form']['vc_orign']));

            $k = trim($this->params['form']['k']);

        endif;

        $this->loadModel('CustomerLocationDistance');

        $conditions = array(
            'lower(CustomerLocationDistance.vc_loc_from_code)' => "{$vc_orign}",
            'lower(CustomerLocationDistance.vc_loc_to_code)' => "{$string}",
        );

        $distance = $this->CustomerLocationDistance->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'CustomerLocationDistance.nu_distance')));


        $result = '';
        if ($distance):
            $result = current($distance['CustomerLocationDistance']);
        else:
            $result = 0;
        endif;

        $this->set('result', $result);

        $this->set('k', $k);

        $this->layout = false;
    }

    /**
     *
     *
     *
     *
     */
    function calculatedistancelocationother() {

        Configure::write('debug', 0);

        $this->layout = null;

        $vc_orign = '';

        $string = '';

        $k = 0;

        if ($this->params['isAjax'] && isset($this->params['form']['vc_orign']) && isset($this->params['data'])) :

            $string = strtolower(trim($this->params['data']));

            $vc_orign = strtolower(trim($this->params['form']['vc_orign']));

            $k = trim($this->params['form']['k']);

        endif;

        $this->loadModel('CustomerLocationDistance');

        $conditions = array();

        $conditions = array(
            'lower(CustomerLocationDistance.vc_loc_from_code)' => "{$vc_orign}",
            'lower(CustomerLocationDistance.vc_loc_to_code)' => "{$string}",
        );

        $distance = $this->CustomerLocationDistance->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'CustomerLocationDistance.nu_distance')));
        $result = '';
        if ($distance):
            $result = current($distance['CustomerLocationDistance']);
        else:
            $result = 0;
        endif;

        $this->set('result', $result);
        $this->set('k', $k);

        $this->layout = false;
    }

    /**
     * *
     * * View Vehicle Detials
     * *
     */
    function viewvehicledetail($assessmentno = null) {

        try {

            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                if (isset($this->data['vc_vehicle_lic_no']) && !empty($this->data['vc_vehicle_lic_no'])) {

                    $this->loadModel('VehicleLogMaster');

                    $this->loadModel('ParameterType');

                    $this->loadModel('VehicleLogDetail');

                    $this->loadModel('Profile');
					
                    $this->loadModel('VehicleDetail');

                    $this->loadModel('CustomerLocationDistance');

                    $detail = $this->VehicleDetail->find('first', array(
                        'conditions' => array(
                            'VehicleDetail.vc_vehicle_lic_no' => $this->data['vc_vehicle_lic_no'])));

                    if ($detail) {

                        $hdvehlogID = $this->VehicleLogMaster->getPrimaryKey();

                        $payFrequency = $this->ParameterType->find('first', array('conditions' => array('ParameterType.vc_prtype_name' => $this->data['vc_pay_frequency']), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                        $logdetails = $detail['CustomerProfile'];

                        $logdetails['vc_vehicle_log_no'] = $hdvehlogID;

                        $logdetails['vc_pay_frequency'] = $payFrequency['ParameterType']['vc_prtype_code'];

                        $logdetails['vc_vehicle_lic_no'] = $this->data['vc_vehicle_lic_no'];

                        $logdetails['dt_created_date'] = date('d-M-Y H:i:s');

                        if ($this->VehicleLogMaster->save($logdetails, false)) {

                            $errcounter = 0;

                            foreach ($this->data['VehicleLogDetail'] as $key => $vehicleLogData) {

                                if ($checkRequest = $this->VehicleLogDetail->find('count', array(
                                            'conditions' => array(
                                                'lower(VehicleLogDetail.vc_vehicle_lic_no)' => strtolower(trim($this->data['vc_vehicle_lic_no'])),
                                                'OR' => array(
                                                    'VehicleLogDetail.nu_start_ometer' => trim($vehicleLogData['nu_start_ometer']),
                                                    'VehicleLogDetail.nu_end_ometer' => trim($vehicleLogData['nu_end_ometer']),
                                        )))) == 0 && trim($vehicleLogData['nu_start_ometer']) != '' && trim($vehicleLogData['nu_end_ometer']) != '') {



                                    $vc_log_detail_id = $this->VehicleLogDetail->getPrimaryKey();

                                    $vehicleLogData['vc_log_detail_id'] = $vc_log_detail_id;

                                    $tmp = null;

                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_from_code)' => strtolower(trim($vehicleLogData['vc_orign']))),
                                        'fields' => array('CustomerLocationDistance.loc_from')));

                                    $vehicleLogData['vc_orign_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_from'] : null;

                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_to_code)' => strtolower(trim($vehicleLogData['vc_destination']))),
                                        'fields' => array('CustomerLocationDistance.loc_to')));

                                    $vehicleLogData['vc_destination_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_to'] : null;

                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_from_code)' => strtolower(trim($vehicleLogData['vc_other_road_orign']))),
                                        'fields' => array('CustomerLocationDistance.loc_from')));

                                    $vehicleLogData['vc_other_road_orign_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_from'] : null;

                                    $tmp = $this->CustomerLocationDistance->find('first', array(
                                        'conditions' => array(
                                            'lower(CustomerLocationDistance.vc_loc_to_code)' => strtolower(trim($vehicleLogData['vc_other_road_destination']))),
                                        'fields' => array('CustomerLocationDistance.loc_to')));

                                    $vehicleLogData['vc_other_road_destination_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_to'] : null;

                                    unset($tmp);

                                    $vehicleLogData['dt_log_date'] = date('d-M-Y', strtotime($vehicleLogData['dt_log_date']));

                                    $vehicleLogData['vc_comp_code'] = $detail['CustomerProfile']['vc_comp_code'];

                                    $vehicleLogData['vc_customer_no'] = $detail['CustomerProfile']['vc_customer_no'];

                                    $vehicleLogData['dt_created_date'] = date('d-M-Y H:i:s');

                                    $vehicleLogData['vc_pay_frequency'] = $payFrequency['ParameterType']['vc_prtype_code'];

                                    $vehicleLogData['vc_vehicle_lic_no'] = $this->data['vc_vehicle_lic_no'];

                                    $vehicleLogData['vc_status'] = 'STSTY01'; /* Active Now and  will be use any assessment  */

                                    $vehicleLogData['vc_vehicle_reg_no'] = $this->data['vc_vehicle_reg_no'];

                                    $vehicleLogData['vc_vehicle_log_no'] = $hdvehlogID;

                                    $vehicleLogData['vc_remark'] = $vehicleLogData['vc_remark'];

                                    $vehicleLogData['nu_other_road_km_traveled'] = trim($vehicleLogData['nu_other_road_km_traveled']) == '' ? 0 : $vehicleLogData['nu_other_road_km_traveled'];

                                    $vehicleLogData['vc_remark_by'] = 'USRTYPE01';

                                    $vehicleLogData['vc_vehicle_log_no'] = $hdvehlogID;

                                    $this->VehicleLogDetail->create();

                                    $this->VehicleLogDetail->set($vehicleLogData);

                                    if ($this->VehicleLogDetail->save($vehicleLogData, false)) {

                                        if (isset($vehicleLogData['uploaddocs']['name']) && trim($vehicleLogData['uploaddocs']['error']) == 0) {

                                            $this->loadModel('UploadDocumentLogInspector');

                                            $saveData = array();

                                            $saveData['UploadDocumentLogInspector']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

                                            $saveData['UploadDocumentLogInspector']['vc_customer_no'] = $detail['CustomerProfile']['vc_customer_no'];

                                            $saveData['UploadDocumentLogInspector']['dt_date_uploaded'] = date('d-M-Y H:i:s');

                                            $saveData['UploadDocumentLogInspector']['vc_log_detail_id'] = $vc_log_detail_id;

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_for'] = 'Vehicle Log Detail';

                                            $filepath = trim($detail['CustomerProfile']['vc_customer_no']);

                                            $dir = WWW_ROOT . "uploadfile" . DS . "$filepath" . DS . 'log' . DS . trim($vc_log_detail_id);

                                            if (!file_exists($dir)) {

                                                mkdir($dir, 0777, true);
                                            }

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_path'] = $dir;

                                            $filename = $vehicleLogData['uploaddocs']['name'];

                                            if (file_exists($dir . DS . $filename)) {

                                                $filename = date('YmdHis') . '-' . $filename;
                                            }

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_name'] = $filename;

                                            $saveData['UploadDocumentLogInspector']['vc_upload_id'] = $this->UploadDocumentLogInspector->getPrimaryKey();

                                            $saveData['UploadDocumentLogInspector']['vc_uploaded_doc_type'] = $vehicleLogData['uploaddocs']['type'];

                                            if ($this->UploadDocumentLogInspector->save($saveData, false)) {

                                                move_uploaded_file($vehicleLogData['uploaddocs']['tmp_name'], $dir . DS . $filename);
                                            }

                                            $saveData = null;
                                        }
                                    }

                                    unset($vehicleLogData);


                                    $inspector_name = $this->Session->read('Auth.Member.vc_user_firstname') . "  " . $this->Session->read('Auth.Member.vc_user_lastname');


                                    $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                                    $this->Email->to = trim($logdetails['vc_email_id']);

                                    $this->Email->subject = "Log Added by Inspector";

                                    $this->Email->template = 'registration';

                                    $this->Email->sendAs = 'html';

                                    $this->set('name', $logdetails['vc_customer_name']);

                                    $this->Email->delivery = 'smtp';

                                    $mesage = "A log has been added for your vehicle on " . date('d-M-Y', strtotime($logdetails['dt_created_date'])) . ".<br/><br/> Licence No. :<b> " . $logdetails['vc_vehicle_lic_no'] . "</b><br/>Inspector Name : <b>" . $inspector_name . "</b>";

                                    $this->Email->send($mesage);
                                } else {


                                    $errcounter++;
                                }
                            }


                            $this->data = null;

                            if ($errcounter == 0) {

                                $this->Session->setFlash('Log Details has been added successfully !!', 'success');
                            } else if ($errcounter == 1) {

                                $this->Session->setFlash(' Log Details has not been added successfully , Some duplicate data exist !!', 'info');
                            } else {

                                $this->Session->setFlash('Log Details has been added successfully ,Some duplicate data exist but not saved  !!', 'info');
                            }


                            $this->redirect($this->referer());
                        } else {

                            $this->data = null;

                            $this->Session->setFlash('Sorry Your data has not been submitted please try again ', 'error');

                            $this->redirect($this->referer());
                        }
                    } else {

                        $this->data = null;

                        $this->Sesssion->setFlash('Sorry Your data has not been submitted please try again ', 'error');

                        $this->redirect($this->referer());
                    }
                } else {

                    $this->setFlash(' Invalid Customer License No / Registration No. ', 'error');
                    $this->redirect($this->referer());
                }
            }


            $this->loadModel('Profile');

            $this->loadModel('VehicleDetail');

            $this->layout = 'inspector';

            $this->set('title_for_layout', ' View Vehicle Details Form ');

            $this->Profile->bindModel(array('hasOne' => array('Member' => array('className' => 'Member', 'foreignKey' => false))));

            $this->set('vehicleList', $this->VehicleDetail->find('list', array(
                        'conditions' => array('TRIM(VehicleDetail.vc_vehicle_status)' => trim('STSTY04')),
                        'fields' => array('TRIM(VehicleDetail.vc_vehicle_lic_no)', 'TRIM(VehicleDetail.vc_vehicle_reg_no)'))));
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     *
     *
     * Function to generate payment confirmation receipt statement
     *
     */

    /* function downloadPaymentReceipt(){

      $this->loadModel('AssessmentVehicleMaster');

      $this->loadModel('AssessmentVehicleDetail');

      $this->loadModel('VehicleLogDetail');

      $lic_no = $this->data['vc_vehicle_lic_no'];

      $reg_no = $this->data['vc_vehicle_reg_no'];

      $sqlResult = $this->AssessmentVehicleDetail->find('all', array(
      'conditions'=>array(
      'AssessmentVehicleDetail.vc_vehicle_lic_no'=>$lic_no,
      ),
      'order'=>array('AssessmentVehicleDetail.dt_created_date DESC')
      ));

      $this->set('data', $sqlResult);

      $total =$this->AssessmentVehicleDetail->find('all', array(
      'conditions'=>array(
      'AssessmentVehicleDetail.vc_vehicle_lic_no'=>$lic_no,
      )
      ));

      $nu_total_payable_amount=0;

      $vc_mdc_paid=0;

      foreach($total as $amount){

      $nu_total_payable_amount = $nu_total_payable_amount+$amount['AssessmentVehicleMaster']['nu_total_payable_amount'];

      $vc_mdc_paid = $vc_mdc_paid+$amount['AssessmentVehicleMaster']['vc_mdc_paid'];

      }

      $this->set('nu_total_payable_amount', $nu_total_payable_amount);

      $this->set('vc_mdc_paid',$vc_mdc_paid);

      $Outstanding = $nu_total_payable_amount - $vc_mdc_paid;

      $this->set('Outstanding',$Outstanding);

      $columnsValues=array('Assessment Number',
      'Assessment Date','Vehicle License No.',
      'Vehicle Registration No.','Total KM',
      'KM/100','Rate (N$)',
      'Amount Due(N$)','Amount Paid(N$)',
      'Outstanding Amount (N$)'
      );

      $this->Assessmentreportpdfcreator->headerData('',$this->Session->read('Auth'),$AssessmentVehicleMaster) ;
      //$columnsValues,$data,$constants,$net_outstanding=null
      $this->Assessmentreportpdfcreator->genrate_mdc_assessmentreport($columnsValues,$AssessmentVehicleMaster['AssessmentVehicleDetail'],$this->globalParameterarray,$net_outstanding=null,$net_out=null);
      $vc_cust_no = $this->Session->read('Auth.Client.vc_cust_no');


      $this->Assessmentreportpdfcreator->output($vc_cust_no.'-MDC_Assessment_Statement'.'.pdf', 'D');
      die;


      $this->layout = 'pdf';

      } */

    function downloadPaymentReceipt() {

        try {
            Configure::write('debug', 0);
            $this->loadModel('AssessmentVehicleMaster');
            $this->loadModel('VehicleDetail');
            $lic_no = $this->data['vc_vehicle_lic_no'];
            //pr($this->data);die;
            $list = $this->VehicleDetail->find('first', array('fields' => array('VehicleDetail.vc_vehicle_lic_no', 'VehicleDetail.vc_customer_no'), 'conditions' => array('VehicleDetail.vc_vehicle_lic_no' => $lic_no)));
            //	pr($list);
            //  die;
            if ($cron == 1) {
                $this->set('cron', $cron);
            } else {
                $this->set('cron', 0);
            }

            //print_r($list);
            $vc_customer_no = $list['VehicleDetail']['vc_customer_no'];
            $AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('all', array('conditions' => array('AssessmentVehicleMaster.vc_customer_no' => trim($vc_customer_no))));
            //	pr($AssessmentVehicleMaster);die;			
            $totaloutstanding = 0;

            foreach ($AssessmentVehicleMaster as $index => $value) {

                $cnt = 0;

                $outstand = ((float) $value['AssessmentVehicleMaster']['nu_total_payable_amount'] - (float) $value['AssessmentVehicleMaster']['vc_mdc_paid']);

                if ($value['AssessmentVehicleMaster']['nu_total_payable_amount'] != $value['AssessmentVehicleMaster']['vc_mdc_paid']) {

                    foreach ($value['AssessmentVehicleDetail'] as $index => $vehicledetails) {

                        $cnt++;


                        if ($cnt == count($value['AssessmentVehicleDetail'])) {
                            
                        } else {

                            $arrayAll['statement'][$majorcnt][$index]['outstanding'] = '';
                        }
                    }
                    $totaloutstanding = $totaloutstanding + $outstand;
                }
                $majorcnt++;
            }
            //die;
            //pr($AssessmentVehicleMaster);
            if ($AssessmentVehicleMaster) {

                $this->layout = 'pdf';
                $this->set('nettotaloutstanding', $totaloutstanding);

                $this->set('AssessmentVehicleMaster', $AssessmentVehicleMaster);
            } else {

                //$this->Session->setFlash('No record found.', 'error');
                //	$this->redirect($this->referer());
            }

            $columnsValues = array('Assessment
					Number', 'Assessment Date',
                'Vehicle License No.', 'Vehicle Registration No.',
                'Total KM', 'KM/100', 'Rate (N$)',
                'Amount Due(N$)', 'Amount Paid(N$)',
                'Outstanding Amount (N$)'
            );

            $this->Inspectorreportpdfcreator->headerData('', $this->Session->read('Auth'), $AssessmentVehicleMaster);
            //$totaloutstanding=222;
            $this->Inspectorreportpdfcreator->genrate_inspector_assessmentreport($columnsValues, $AssessmentVehicleMaster, $this->globalParameterarray, $totaloutstanding);



            $this->Inspectorreportpdfcreator->output($vc_customer_no . '-MDC_Assessment_Statement' . '.pdf', 'D');
            die;
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     *
     * Function to download pay proof
     *
     */

    function downloadPayProof() {

        try {

            $this->loadModel('AssessmentVehicleMaster');

            $this->loadModel('AssessmentVehicleDetail');

            $this->loadModel('VehicleLogDetail');

            $lic_no = $this->data['vc_vehicle_lic_no'];

            $sqlResult = $this->AssessmentVehicleDetail->find('first', array(
                'conditions' => array(
                    'AssessmentVehicleDetail.vc_vehicle_lic_no' => $lic_no,
                ),
                'order' => array('AssessmentVehicleDetail.dt_created_date DESC')
            ));

            $AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('first', array('conditions' => array(
                    'AssessmentVehicleMaster.vc_assessment_no' => trim($sqlResult['AssessmentVehicleDetail']['vc_assessment_no']))));

            $profile = $this->Profile->find('first', array('conditions' => array(
                    'Profile.vc_customer_no' => trim($sqlResult['AssessmentVehicleDetail']['vc_customer_no']))));

            $this->layout = 'pdf';

            $this->set('AssessmentVehicleMaster', $AssessmentVehicleMaster);

            $this->set('profile', $profile);
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

}
