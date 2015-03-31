<?php

App::import('Sanitize');

/**
 * 
 *
 */
class ProfilesController extends AppController {

    /**
     *
     *
     */
    
	var $name = 'Profiles';

    /**
     *
     *
     */
    
	var $components = array('Session', 'Auth', 'RequestHandler', 'Email');

    /**
     *
     *
     */
	 
    var $helpers = array('Session', 'Html', 'Form');

    /**
     *
     *
     */
    
	var $uses = array('Member', 'Profile', 'Bank', 'DocumentUpload', 'Company');

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

        if ($this->isInspector) {

            $this->redirect(array('controller' => 'inspectors', 'action' => 'index'));
        }
		
		$vc_comp_code       = $this->Session->read('Auth.Member.vc_comp_code');		
		$ch_active          = $this->Session->read('Auth.Profile.ch_active');
		$vc_mdc_customer_no = $this->Session->read('Auth.Member.vc_mdc_customer_no');
		$vc_username        = $this->Session->read('Auth.Member.vc_username');
		
		if($vc_username!='' && $ch_active=='STSTY04' && $this->mdc==$vc_comp_code)	
		$this->Auth->allow('index','changepassword','edit_company','view_company','download','checkcustomerid','checkbusinessregID','checkbusinessregIDCompany','checkcompanyname','checkcompanynameTable','add_more_company');
		
		if($vc_username!='' && ($ch_active=='STSTY05' || $ch_active=='')  && $this->mdc==$vc_comp_code)	
		$this->Auth->allow('index','changepassword','download','checkcustomerid','checkbusinessregID','checkbusinessregIDCompany','checkcompanyname','checkcompanynameTable');
		
		if($vc_username!='' && $ch_active=='STSTY03'  && $this->mdc==$vc_comp_code)	
		$this->Auth->allow('index','changepassword','download','checkcustomerid','checkbusinessregID','checkbusinessregIDCompany','checkcompanyname','checkcompanynameTable');
		$this->loginRightCheck();
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

    function loginRightCheck() {
	//pr($this->Auth->allowedActions);
	//pr($this->action);die;
        if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {

            $this->redirect(array('controller' => 'members', 'action' => 'login', @$this->Auth->params['prefix'] => false));
        }
    }

    /**
     *
     *
    */
	 
    public function index() {

        try {
            
			//pr($this->data);
			set_time_limit(0);
			$nu_company_id = $this->Session->read('nu_company_id');// session
		
			$this->set('nu_company_id', $nu_company_id);

            if (isset($this->data) && !empty($this->data)) {

                $this->Profile->create(false);

                $this->Company->create(false);

                $this->Profile->set($this->data['Profile']);

                $this->Company->set($this->data['Company']);

                $this->DocumentUpload->create(false);

                $this->DocumentUpload->set($this->data['DocumentUpload']);

                /* ******* Use this before any validation ****************** */

                $setValidates = array(
                    'vc_customer_id',
                    'vc_business_reg',
                    'vc_cust_type',
                    'vc_bank_struct_code',
                    'vc_account_no',
                    'vc_address1',
                    'vc_mobile_no');

                $setcompany = array('vc_company_name');

                $profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

                $setValidatesDocUpd = array('vc_uploaded_doc_name','vc_municipal_doc_name','vc_business_reg_doc');

                if ($this->Profile->validates(array('fieldList' => $setValidates)) && $this->DocumentUpload->validates(array('fieldList' => $setValidatesDocUpd)) && $this->Company->validates(array('fieldList' => $setcompany))) {
                    $vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');

                    if ($profile['Profile']['ch_active'] != 'STSTY05') {

                        $this->data['Company']['nu_company_id'] = $this->Company->getPrimaryKey();

                        $this->data['Profile']['nu_company_id'] = $this->data['Company']['nu_company_id'];
                    }

                    $vc_company_name = $this->data['Company']['vc_company_name'];

                    $this->data['Company']['vc_bank_struct_code'] = $this->data['Profile']['vc_bank_struct_code'];

                    $this->data['Company']['vc_customer_name'] = $this->data['Profile']['vc_customer_name'];

                    $this->data['Company']['vc_business_reg'] = $this->data['Profile']['vc_business_reg'];

                    $this->data['Company']['vc_cust_type'] = $this->data['Profile']['vc_cust_type'];

                    $this->data['Company']['vc_account_no'] = $this->data['Profile']['vc_account_no'];
                  //  if(isset($this->data['Profile']['vc_bank_supportive_doc']) && !empty($this->data['Profile']['vc_bank_supportive_doc']))
                    $this->data['Company']['vc_bank_supportive_doc'] = $this->data['Profile']['vc_bank_supportive_doc'];

                    $this->data['Company']['vc_address1'] = $this->data['Profile']['vc_address1'];

                    $this->data['Company']['vc_address2'] = $this->data['Profile']['vc_address2'];

                    $this->data['Company']['vc_address3'] = $this->data['Profile']['vc_address3'];

                    $this->data['Company']['vc_tel_no'] = $this->data['Profile']['vc_tel_no'];

                    $this->data['Company']['vc_fax_no'] = $this->data['Profile']['vc_fax_no'];

                    $this->data['Company']['vc_mobile_no'] = $this->data['Profile']['vc_mobile_no'];

                    $this->data['Company']['vc_email_id'] = $this->data['Profile']['vc_email_id'];
                    $this->data['Company']['vc_town'] = $this->data['Profile']['vc_town'];
					
					if(isset($this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"])&& $this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"]!='') 					
					$this->data['Company']['ch_municipal_type']='Y';
					
					if($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]=='' && $this->data['Profile']['vc_cust_type']=='CUSTYPE02' ){
					$this->data['Company']['ch_business_type']='N';
					$this->data['Profile']['ch_business_type']='N';
					
					}
					
					
					if(isset($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"])&& $this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]!='') 					
					$this->data['Company']['ch_business_type']='Y';
					

                    $vc_user_no = $this->Session->read('Auth.Member.vc_user_no');

                    $vc_customer_no = $this->Session->read('Auth.Member.vc_username');

                    $this->data['Company']['vc_customer_no'] = $vc_customer_no;

                    $vc_username = $this->Session->read('Auth.Member.vc_username');

                    $vc_email_id = $this->Session->read('Auth.Member.vc_email_id');

                    $fileName = trim($vc_customer_no);

                    $dir = WWW_ROOT . "uploadfile" . DS . "$fileName" . DS . 'Bank';

                    $vc_customer_name = ucfirst($this->Session->read('Auth.Member.vc_user_firstname')) . ' ' . ucfirst($this->Session->read('Auth.Member.vc_user_lastname'));

                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }

                    $this->data['Company']['ch_status'] = 'STSTY03';

                    $this->data['Company']['vc_username'] = $vc_username;

                    $this->data['Company']['vc_comp_code'] = $vc_comp_code;

                    $this->data['Profile']['vc_customer_no'] = $vc_customer_no;

                    $this->data['Profile']['vc_comp_code'] = $vc_comp_code;

                    $this->data['Profile']['vc_user_no'] = $vc_user_no;

                    $this->data['Profile']['vc_customer_name'] = $vc_customer_name;
					
					if(isset($this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"])&& $this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"]!='') 					
					$this->data['Profile']['ch_municipal_type']='Y';
					
					if(isset($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"])&& $this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]!='') 					
					$this->data['Profile']['ch_business_type']='Y';

                    $this->data['Profile']['vc_email_id'] = $vc_email_id;

                    if (trim($this->Session->read('Auth.Profile.vc_user_no')) != '') :
                        $this->data['Profile']['dt_modified_date'] = date('Y-m-d H:i:s');
                    else :
                        $this->data['Profile']['dt_created_date'] = date('Y-m-d H:i:s');
                    endif;


                    $profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

                    if ($profile['Profile']['ch_active'] == 'STSTY05') {

                        $companydetail = $this->Company->find('first', array(
                            'conditions' => array('Company.nu_company_id' => $this->Session->read('Auth.Profile.nu_company_id'),
                        )));

                        $comp_name = $this->data['Company']['vc_company_name'];

                        $compid = $companydetail['Company']['nu_company_id'];

                        $this->data['Profile']['nu_company_id'] = $compid;

                        $this->data['DocumentUpload']['nu_company_id'] = $compid;

                        $this->Company->id = $compid;

                        $this->Company->set($this->data['Company']);

                        $this->Company->save($this->data['Company'], false);
                        
						$nu_company_id = $compid;
						
                    } else {

                        $nu_company_id = $this->data['Company']['nu_company_id'];
                        
						$this->data['DocumentUpload']['nu_company_id'] = $nu_company_id;
                        
						$this->Company->save($this->data['Company'], false);
						
                    }


                    $this->data['Profile']['ch_active'] = 'STSTY03';

                    $this->data['Profile']['nu_variance_amount'] = 0;

                    $uploaded_doc = $this->data['DocumentUpload']['vc_uploaded_doc_name'];

                    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Bank';

                    $renameUploadFile = $nu_company_id . '-1-' . $this->renameUploadFile($uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = $renameUploadFile;

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($uploaded_doc['type']);

                    $saveData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');

                    $saveData['Member']['vc_mdc_customer_no'] = $vc_customer_no;

                    $saveData['Member']['vc_user_no'] = $vc_user_no;
					
					//if(isset($this->data['Profile']['vc_bank_supportive_doc']) && empty($this->data['Profile']['vc_bank_supportive_doc']))
					//unset($this->data['Profile']['vc_bank_supportive_doc']);
					
                    if ($this->Profile->save($this->data['Profile'], false) && $this->Member->save($saveData, false)) {

                        if (move_uploaded_file($uploaded_doc["tmp_name"], $dir . '/' . $renameUploadFile) == true) {

                            $this->DocumentUpload->deleteAll(array('DocumentUpload.vc_uploaded_doc_for'=>'Bank',
                                'DocumentUpload.vc_customer_no' => $vc_customer_no,
                                'DocumentUpload.nu_company_id' => $this->data['Profile']['nu_company_id']), false);

                            $this->DocumentUpload->save($this->data['DocumentUpload'], false);
                        }
						
						/* Municipal doc upload starts  */
						
					 $municipal_uploaded_doc = $this->data['DocumentUpload']['vc_municipal_doc_name'];	
					 
					 $dir = WWW_ROOT . "uploadfile" . DS . "$fileName" . DS . 'Municipal';

                  
                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }	
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Municipal';
					
                    $renameUploadFile_m = $nu_company_id . '-2-' . $this->renameUploadFile($municipal_uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile_m);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($municipal_uploaded_doc['type']);
					
					if (move_uploaded_file($municipal_uploaded_doc["tmp_name"], $dir . '/' . $renameUploadFile_m) == true) {
						
						  $this->DocumentUpload->deleteAll(array('DocumentUpload.vc_uploaded_doc_for' => 'Municipal',
                                'DocumentUpload.vc_customer_no' => $vc_customer_no,
                                'DocumentUpload.nu_company_id' =>$this->data['Profile']['nu_company_id']), false);

						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
					}
					
                    /*--End of  Municipal doc upload starts--*/
					
					
					
					/* Business Registration doc upload starts  */
						
					 $business_uploaded_doc = $this->data['DocumentUpload']['vc_business_reg_doc'];	
					 
					 $dir = WWW_ROOT . "uploadfile" . DS . "$fileName" . DS . 'Business';

                  
                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }
					
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Business';
					
                    $renameUploadFile_b = $nu_company_id . '-3-' . $this->renameUploadFile($business_uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile_b);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($business_uploaded_doc['type']);
					
					if (move_uploaded_file($business_uploaded_doc["tmp_name"], $dir . '/' . $renameUploadFile_b) == true) {
						
						  $this->DocumentUpload->deleteAll(array('DocumentUpload.vc_uploaded_doc_for' => 'Business',
                                'DocumentUpload.vc_customer_no' => $vc_customer_no,
                                'DocumentUpload.nu_company_id' =>$this->data['Profile']['nu_company_id']), false);
								

						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
						
					}
					
                    /* End of  Business Registration upload starts  */

                        /*                         * **************************Email Shoot **************************** */

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        if ($this->Session->check('Auth.Profile')) :

                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                            $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                            $this->Email->bcc = array(trim($this->AdminMdcEmailID));

                            $this->Email->subject = strtoupper($selectedType) . " Account Edit ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                            $this->Email->delivery = 'smtp';

                            $mesage = " Request to  edit your account has been received, Please wait for approval.";

                            $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                            $this->Email->send($mesage);

                            $this->Email->to = array();

                            $this->Email->bcc = array();


                            /*                             * *****Email Send To Admin********** */


                            $this->data = null;

                            $this->Session->write('Auth.Member.vc_mdc_customer_no', $vc_customer_no);

                            $this->Session->setFlash('Your profile has been updated successfully , pending for approval from RFA.!!', 'success');

                            $this->redirect($this->referer());
                        else :

                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                            $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                            $this->Email->bcc = array(trim($this->AdminMdcEmailID));

                            $this->Email->subject = strtoupper($selectedType) . " Account Created ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                            $this->Email->delivery = 'smtp';

                            $mesage = "Your account has been created, pending for approval ";

                            $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                            $this->Email->send($mesage);

                            $this->Email->to = array();

                            $this->Email->bcc = array();


                            $this->data = null;

                            $this->Session->write('Auth.Member.vc_mdc_customer_no', $vc_customer_no);

                            $this->Session->setFlash('Your account has been created successfully, pending for approval from RFA.!!', 'success');

                            $this->redirect($this->referer());


                        endif;
                    } else {

                        $this->Profile->rollback();

                        $this->DocumentUpload->rollback();

                        $this->Member->rollback();

                        $this->data = null;

                        $this->Session->setFlash('Some Error has come please try again.', 'error');
                    }
                } else {
                    //$this->set('data',$this->data);
                }
            }

            $this->layout = 'userprofile';

            $this->set('DocsSupportive', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'BANKSUPPTYP%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('CustType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CUSTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('CompanyType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'COMPANY%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));

            $profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));
            //pr($profile);
            //die;

            $company = $this->Company->find('first', array(
                'conditions' => array('Company.nu_company_id' => $profile['Profile']['nu_company_id']),
            ));

            $this->set('company', $company);

           // pr($profile);
          //   pr($company);
		//die('hua');

            if ($profile) {

                if (trim($profile['Profile']['ch_active']) == 'STSTY05') :

                    $this->set('title_for_layout', 'Edit Customer Profile');

                    $this->render('index');

                else :

                    $this->set('title_for_layout', 'View Customer Profile');

                    $this->render('view');

                endif;
            }

            $this->set('title_for_layout', 'Add Customer Profile');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     * Change Password
     *
     */
    public function changepassword() {

        try {

            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Profile->set($this->data);

                /*                 * ****** Use this before any validation ******************************* */

                $setValidates = array(
                    'vc_old_password',
                    'vc_password',
                    'vc_comp_code',
                    'vc_confirm_password');

                /**                 * ************************************************************************************ */
                $username = $this->Session->read('Auth.Member.vc_username');

                $newpassword = $this->data['Profile']['vc_password'];

                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                if ($this->Profile->validates(array('fieldList' => $setValidates))) {

                    $this->Member->validate = null;

                    $updateData['Member']['vc_password'] = $this->Auth->password(trim($this->data['Profile']['vc_password']));

                    $updateData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');

                    $updateData['Member']['vc_user_no'] = $this->Session->read('Auth.Member.vc_user_no');

                    if ($this->Member->save($updateData)) {

                        $this->data = NUll;

                        $this->Session->setFlash('Your password has been changed successfully.!!', 'success');


                        /*                         * ****************************** Email Shoot ******************************** */

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                        $this->Email->subject = strtoupper($selectedType) . " Password Changed ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = " You have recently changed password on RFA portal ( " . strtoupper($selectedType) . " Section ). Please use the credentials mentioned below to login : ";

                        $mesage .= "<br><br>Username : " . trim($username);

                        $mesage .= "<br><br>Password : " . trim($newpassword);

                        $this->Email->send($mesage);


                        /*                         * ****************************** End ******************************** */

                        $this->redirect($this->referer());
                    } else {

                        $this->data = NUll;

                        $this->Session->setFlash(' Your password could not be changed, please try later', 'error');
                    }
                }
            }

            $this->layout = 'userprofile';

            $this->set('title_for_layout', "Change Password ");
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     * Download doc
     *
     */
    function download($urlvalue=null) {

        $this->layout = NULL;

        $usercompanySessionid = $this->Session->read('Auth.Profile.nu_company_id');

        $customer_no = trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));

        $comp_code = trim($this->Session->read('Auth.Member.vc_comp_code'));
		
		if($urlvalue=='M'){   // municipal
		
		$DownloadFile = $this->DocumentUpload->find('first', array(
            'conditions' => array(
                'DocumentUpload.vc_comp_code' => $comp_code,
                'DocumentUpload.vc_uploaded_doc_for' => 'Municipal',
                'DocumentUpload.nu_company_id' => $usercompanySessionid,
                'DocumentUpload.vc_customer_no' => $customer_no),
            'order' => array('DocumentUpload.dt_date_uploaded' => 'desc')));
		}
		elseif($urlvalue=='B'){ // Business
		
		$DownloadFile = $this->DocumentUpload->find('first', array(
            'conditions' => array(
                'DocumentUpload.vc_comp_code' => $comp_code,
                'DocumentUpload.vc_uploaded_doc_for' => 'Business',
                'DocumentUpload.nu_company_id' => $usercompanySessionid,
                'DocumentUpload.vc_customer_no' => $customer_no),
            'order' => array('DocumentUpload.dt_date_uploaded' => 'desc')));
		}else{
             
			 $DownloadFile = $this->DocumentUpload->find('first', array(
            'conditions' => array(
                'DocumentUpload.vc_comp_code' => $comp_code,
                'DocumentUpload.vc_uploaded_doc_for' => 'Bank',
                'DocumentUpload.nu_company_id' => $usercompanySessionid,
                'DocumentUpload.vc_customer_no' => $customer_no),
            'order' => array('DocumentUpload.dt_date_uploaded' => 'desc')));
		}

        if ($DownloadFile && file_exists($DownloadFile['DocumentUpload']['vc_uploaded_doc_path'] . DS . $DownloadFile['DocumentUpload']['vc_uploaded_doc_name'])) {

            $path = $DownloadFile['DocumentUpload']['vc_uploaded_doc_path'] . DS . $DownloadFile['DocumentUpload']['vc_uploaded_doc_name'];

            header('Expires: 0');

            header('Pragma: public');

            header('Content-type:' . $DownloadFile['DocumentUpload']['vc_uploaded_doc_type']);

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Content-Disposition: attachment; filename="' . basename($DownloadFile['DocumentUpload']['vc_uploaded_doc_name']) . '"');

            header('Content-Transfer-Encoding: binary');

            @readfile($path);

            exit(0);
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect('index');
        }
    }

    /**
     *
     * Check Customer User Id Exist or not Exist
     *
     */
	 	 

    function checkcustomerid() {

       // Configure::write('debug', 0);

        if ($this->params['isAjax'] && isset($this->params['data']['Profile']['vc_customer_id'])) :

            $str = strtolower(trim($this->params['data']['Profile']['vc_customer_id']));

            $conditions = array("lower(Profile.vc_customer_id)  = '$str' ");

            if (isset($this->params['form']['id'])) :

                $id = strtolower(trim(base64_decode($this->params['form']['id'])));

                $conditions += array('lower(Profile.vc_user_no) !=' => $id);



            endif;

            $count = $this->Profile->find('count', array('conditions' => $conditions));

            if ($count == 0) :

                echo "true";

            else :

                echo "false";

            endif;

        else :

            echo "false";

        endif;

        exit;
    }
	
	/*
	
	Check business reg id for each company
	
	*/
	function checkbusinessregIDCompany(){
	
		
        if ($this->params['isAjax'] && isset($this->params['data']['Company']['vc_business_reg'])) :

            $str = strtolower(trim($this->params['data']['Company']['vc_business_reg']));

            $conditions = array("lower(Company.vc_business_reg)  = '".$str."' ");
			
        	//$profile = $this->Company->find('first', array('conditions' => array('Company.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

            //if ($profile['Profile']['ch_active'] == 'STSTY05') {

            if (isset($this->params['form']['id']) && $this->params['form']['id']!='') :
				//$companyid= base64_decode($this->params['form']['id']);
				$companyid = $this->params['form']['id'];
                $companyid = strtolower(trim($companyid));

                $conditions += array('lower(Company.nu_company_id)!'=>$companyid);
				
            endif;
			
			//}
			$count = $this->Company->find('count', array('conditions' => $conditions));

            if ($count == 0) :

                echo "true";

            else :

                echo "false";

            endif;

        else :

            echo "false";

        endif;

        exit;
	}
	
	/*
	Check business reg id
	
	*/
	
	function checkbusinessregID(){
	
		Configure::write('debug', 2);
		//$this->layout=null;
		//pr($this->params);die;

        if ($this->params['isAjax'] && isset($this->params['data']['Profile']['vc_business_reg'])) :

            $str = strtolower(trim($this->params['data']['Profile']['vc_business_reg']));

            $conditions = array("lower(Company.vc_business_reg)  = '$str' ");
			
        	$profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

            if ($profile['Profile']['ch_active'] == 'STSTY05') {

            if (isset($this->params['form']['id'])) :

                $id = strtolower(trim(base64_decode($this->params['form']['id'])));

                $conditions += array('lower(Company.vc_username) !=' => $id);
				
            endif;
			
			}
            $count = $this->Company->find('count', array('conditions' => $conditions));
			//pr($conditions);
			//echo base64_decode($this->params['form']['id']);
			//die;
            if ($count == 0) :

                echo "true";

            else :

                echo "false";

            endif;

        else :

            echo "false";

        endif;

        exit;
	}

    /**
     *
     * Check Company uniqueness at time of profile add or edit profile
     *
     */

    function checkcompanyname() {

        //Configure::write('debug', 0);

        if ($this->params['isAjax'] && isset($this->params['data']['Company']['vc_company_name'])):

            $vc_username = $this->Session->read('Auth.Member.vc_username');

            $vc_company_name = strtolower(trim($this->params['data']['Company']['vc_company_name']));

            $conditions = array("lower(Company.vc_company_name)  = '$vc_company_name' ");

            $profile = $this->Profile->find('first', array('conditions' => array(
                    'Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

            if ($profile['Profile']['ch_active'] == 'STSTY05') {

                //$companydetail = $this->Company->find('first',array(
                //'conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
                //	)));
                //$compid = $companydetail['Company']['nu_company_id'];
                $compid = $profile['Profile']['nu_company_id'];

                $conditions += array('NOT' => array('Company.nu_company_id' => $compid));
            }

            $count = $this->Company->find('count', array('conditions' => $conditions));

            if ($count == 0) :

                echo "true";

            else :

                echo "false";

            endif;

        else :

            echo "false";

        endif;

        exit;
    }

    /**
     *
     * Check Company uniqueness at time of company edit
     *
     */

    function checkcompanynameTable() {

        // Configure::write('debug', 0);

        if ($this->params['isAjax'] && isset($this->params['data']['Company']['vc_company_name'])) :

            $vc_username = $this->Session->read('Auth.Member.vc_username');

            $vc_company_name = strtolower(trim($this->params['data']['Company']['vc_company_name']));

            $conditions = array("lower(Company.vc_company_name)  = '$vc_company_name' ");

            if (isset($this->params['form']['id']) && $this->params['form']['id'] != '')
                $company_id = $this->params['form']['id'];
            else
                $company_id = '';

            if ($company_id > 0) {


                $conditions += array('NOT' => array('Company.nu_company_id' => $company_id));
            }

            $count = $this->Company->find('count', array('conditions' => $conditions));

            if ($count == 0) :

                echo "true";

            else :

                echo "false";

            endif;

        else :

            echo "false";

        endif;

        exit;
    }

    /*
     *
     * Function to add more company
     *
     */
	 


    function add_more_company() {

        try {
			
			set_time_limit(0);            
			
			if (isset($this->data) && !empty($this->data)) {

                $this->Company->set($this->data['Company']);
				
				
				
                
				if (isset($this->data['Company']['vc_bank_supportive_doc']) && $this->data['Company']['vc_bank_supportive_doc'] == '') {                   
				   $this->data['DocumentUpload']['vc_uploaded_doc_name'] = '';                
				}


                $this->DocumentUpload->set($this->data['DocumentUpload']);

                $setcompany = array('vc_company_name', 'vc_business_reg', 'vc_cust_type', 'vc_tel_no', 'vc_fax_no', 'vc_mobile_no','vc_bank_struct_code', 'vc_account_no', 'vc_address1');

                $setValidatesDocUpd = array('vc_uploaded_doc_name','vc_municipal_doc_name','vc_business_reg_doc');

                if ($this->DocumentUpload->validates(array('fieldList' => $setValidatesDocUpd)) && $this->Company->validates(array('fieldList' => $setcompany))) {
					
					$this->Company->create(false);
					
					$this->DocumentUpload->create(false);

                    $vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');

                    $this->data['Company']['nu_company_id'] = $this->Company->getPrimaryKey();

                    $vc_user_no = $this->Session->read('Auth.Member.vc_user_no');

                    $vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');

                    $this->data['Company']['vc_customer_no'] = $vc_customer_no;

                    $vc_username = $this->Session->read('Auth.Member.vc_username');

                    $vc_email_id = $this->Session->read('Auth.Member.vc_email_id');

                    $fileName = trim($vc_username);

                    $dir = WWW_ROOT . "uploadfile" . DS . "$fileName" . DS . 'Bank';

                    $vc_customer_name = ucfirst($this->Session->read('Auth.Member.vc_user_firstname')).' '.ucfirst($this->Session->read('Auth.Member.vc_user_lastname'));

                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }

                    $this->data['Company']['ch_status'] = 'STSTY03';

                    $this->data['Company']['vc_username'] = $vc_username;

                    $this->data['Company']['vc_comp_code'] = $vc_comp_code;

                    $uploaded_doc = $this->data['DocumentUpload']['vc_uploaded_doc_name'];
                   

                    $nu_company_id = $this->data['Company']['nu_company_id'];

                    $this->data['DocumentUpload']['nu_company_id'] = $nu_company_id;

					/* Bank doc upload starts  */
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Bank';
                    $renameUploadFile = $nu_company_id . '-1-' . $this->renameUploadFile($uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($uploaded_doc['type']);
					
					if(isset($this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"])&& $this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"]!='') 					
					$this->data['Company']['ch_municipal_type']='Y';

					if(isset($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"])&& $this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]!='') 					
					$this->data['Company']['ch_business_type']='Y';
					
					if($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]=='' && $this->data['Company']['vc_cust_type']=='CUSTYPE02' ){
						$this->data['Company']['ch_business_type']='N';
					//$this->data['Profile']['ch_business_type']='N';
				
					}

					
					
					
					
					

                    if ($this->Company->save($this->data['Company'], false)) {

                        if (move_uploaded_file($uploaded_doc["tmp_name"],$dir.'/'.$renameUploadFile) == true) {
						
							$this->DocumentUpload->save($this->data['DocumentUpload'], false);
                        }
						
						/*-- Bank doc upload ends--*/
						/*-- Municipal doc upload starts--*/
					
					 $municipal_uploaded_doc = $this->data['DocumentUpload']['vc_municipal_doc_name'];	
					 $dir = WWW_ROOT . "uploadfile" . DS . "$fileName" . DS . 'Municipal';

                  
                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }	
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Municipal';
					
                    $renameUploadFile_m = $nu_company_id . '-2-' . $this->renameUploadFile($municipal_uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile_m);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($municipal_uploaded_doc['type']);
					
					if (move_uploaded_file($municipal_uploaded_doc["tmp_name"], $dir . '/' . $renameUploadFile_m) == true) {
										
						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
					
					}
					/*-- Municipal doc ends here-- */
						
					/* Business Registration doc upload starts  */
						
					$business_uploaded_doc = $this->data['DocumentUpload']['vc_business_reg_doc'];	
					 
					$dir = WWW_ROOT . "uploadfile" . DS . "$fileName" . DS . 'Business';

                  
                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }
					
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Business';
					
                    $renameUploadFile_b = $nu_company_id . '-3-' . $this->renameUploadFile($business_uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile_b);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($business_uploaded_doc['type']);
					
					if (move_uploaded_file($business_uploaded_doc["tmp_name"], $dir . '/' . $renameUploadFile_b) == true) {
												  
						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
						
					}
					
                    /* End of  Business Registration upload starts  */
						
                        /*  * ******************Email Shoot *********************** */

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                        $this->Email->bcc = array(trim($this->AdminMdcEmailID));

                        $this->Email->subject = strtoupper($selectedType) . " Add Company ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Request to add a new company has been received, Please wait for approval.";

                        $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                        $this->Email->send($mesage);

                        $this->Email->to = array();

                        $this->Email->bcc = array();

                        /*                         * *****Email Send To Admin************ */

                        $this->data = null;

                        $this->Session->write('Auth.Member.vc_mdc_customer_no', $vc_customer_no);

                        $this->Session->setFlash('Request to add company has been sent successfully, pending for approval from RFA !!', 'success');

                        $this->redirect($this->referer());
                    } else {

                        $this->Profile->rollback();

                        $this->DocumentUpload->rollback();

                        //$this->data = null;

                        $this->Session->setFlash('Some Error has come please try again.', 'error');
                    }
                }else{
				
				//pr($this->validationerrors());
				}
            }

            $this->layout = 'userprofile';

            $this->set('DocsSupportive', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'BANKSUPPTYP%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('CustType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CUSTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));

            $profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

            /*

              $company = $this->Company->find('all', array(
              'conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
              )));

              $this->set('company',$company);

             */

            $this->set('title_for_layout', 'Add Company');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     *
     * Function to view/edit company
     *
     */
	 	 	 

    function view_company() {

        $this->layout = 'userprofile';

        $this->set('DocsSupportive', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'BANKSUPPTYP%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->set('CustType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CUSTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));

        $limit = 10;

        $this->paginate = array(
            'conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username')),
            'limit' => $limit
        );

        $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;

        $this->set('pagecounter', $pagecounter);

        $this->set('limit', $limit);

        $this->set('company', $this->paginate('Company'));

        $this->set('title_for_layout', 'View/Edit Company');
    }

    /*
     *
     * Function to edit company
     *
     */
	
    function edit_company($id = null) {
		set_time_limit(0);
		
        //$nu_company_id = base64_decode($id);
		
		if(isset($this->data['Company']['nu_company_id']) && $this->data['Company']['nu_company_id']!='' )
		$nu_company_id = $this->data['Company']['nu_company_id'];
		else
		$nu_company_id = base64_decode($id);
		
		$this->set('nu_company_id', $nu_company_id);		
		
        $vc_username    = $this->Session->read('Auth.Member.vc_username');
        $vc_comp_code   = $this->Session->read('Auth.Member.vc_comp_code');
        $vc_user_no     = $this->Session->read('Auth.Member.vc_user_no');
        $vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');
        
		if($nu_company_id==''){
		$this->redirect('view_company');
		}

        if ($nu_company_id!= '') {

            $company = $this->Company->find('first', array(
                'conditions' => array('Company.vc_username' => $vc_username,
                    'Company.ch_status' => 'STSTY05',
                    'Company.nu_company_id' => $nu_company_id)));
					//die;
            $this->set('company', $company);
        }
        //pr($company);

        $usercompanySessionid = $this->Session->read('Auth.Profile.nu_company_id');

        if ($nu_company_id != '') {

            $count = $this->Company->find('count', array('conditions' => array(
                    'Company.vc_username' => $vc_username,
                    'Company.ch_status' => 'STSTY05',
                    'Company.vc_comp_code' => $this->Session->read('Auth.Member.vc_comp_code'),
                    'Company.nu_company_id' => $nu_company_id,
            )));

            if ($count == 0) {

                $this->redirect(array('controller' => 'profiles', 'action' => 'view_company'));
            }
        }

        try {
			
			$this->set('data',$this->data);

            if (isset($this->data) && !empty($this->data)) {
				
				

                $this->Company->create(false);
				$this->Company->set($this->data['Company']);


                if	(isset($this->data['Company']['vc_bank_supportive_doc']) &&
                        $this->data['Company']['vc_bank_supportive_doc']== '') {
						$this->data['DocumentUpload']['vc_uploaded_doc_name'] = '';
                }
				//pr($this->data);

                $this->DocumentUpload->create(false);

                $this->DocumentUpload->set($this->data['DocumentUpload']);

                $setcompany = array('vc_company_name','vc_business_reg','vc_cust_type','vc_tel_no','vc_fax_no', 'vc_mobile_no','vc_bank_struct_code', 'vc_account_no', 'vc_address1');

                $setValidatesDocUpd = array('vc_uploaded_doc_name','vc_municipal_doc_name','vc_business_reg_doc');
				//pr($this->DocumentUpload->validates(array('fieldList' => $setValidatesDocUpd)));
				
                if ($this->DocumentUpload->validates(array('fieldList' => $setValidatesDocUpd)) && $this->Company->validates(array('fieldList' => $setcompany))) {
	
					$this->data['Company']['vc_customer_no'] = $vc_customer_no;
                    $vc_email_id = $this->Session->read('Auth.Member.vc_email_id');

                    $fileName = trim($vc_customer_no);

                    $dir = WWW_ROOT."uploadfile".DS."$fileName".DS.'Bank';

                    $vc_customer_name = ucfirst($this->Session->read('Auth.Member.vc_user_firstname')) . ' ' . ucfirst($this->Session->read('Auth.Member.vc_user_lastname'));

                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }

                    $this->data['Company']['ch_status'] = 'STSTY03';

                    $this->data['Company']['vc_username'] = $vc_username;

                    $this->data['Company']['vc_comp_code'] = $vc_comp_code;

                    $uploaded_doc = $this->data['DocumentUpload']['vc_uploaded_doc_name'];

                    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Bank';

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['nu_company_id'] = $this->data['Company']['nu_company_id'];
					
					
                    
					$checkfirstcompany = $this->Profile->find('count', array('conditions' => array('Profile.nu_company_id' =>$this->data['Company']['nu_company_id'])));

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($uploaded_doc['type']);

                    $companydetail = $this->Company->find('first', array('conditions' => array('Company.vc_username' => $vc_username,)));
					
                    $renamefileto = $this->data['Company']['nu_company_id'] . '-1-' . $this->renameUploadFile($uploaded_doc["name"]);
					
                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = $renamefileto;
					
				    if(isset($this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"])&& $this->data['DocumentUpload']['vc_municipal_doc_name']["tmp_name"]!='')				
					$this->data['Company']['ch_municipal_type']='Y';
					
					if(isset($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"])&& $this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]!='')				
					$this->data['Company']['ch_business_type']='Y';
					
					if($this->data['DocumentUpload']['vc_business_reg_doc']["tmp_name"]=='' && $this->data['Company']['vc_cust_type']=='CUSTYPE02' ){
						$this->data['Company']['ch_business_type']='N';
					//$this->data['Profile']['ch_business_type']='N';
				
					}



                    $this->Company->id = $this->data['Company']['nu_company_id'];

                    $this->Company->set($this->data['Company']);

                    if ($this->Company->save($this->data['Company'], false)) {

                        if (move_uploaded_file($uploaded_doc["tmp_name"], $dir . '/' . $renamefileto) == true) {

                            $this->DocumentUpload->deleteAll(array('DocumentUpload.vc_uploaded_doc_for' => 'Bank',
                                'DocumentUpload.vc_customer_no' => $vc_customer_no,
                                'DocumentUpload.nu_company_id' => $this->data['Company']['nu_company_id']), false);

                            $this->DocumentUpload->save($this->data['DocumentUpload'], false);
                        }
						
					/* Municipal doc upload starts  */
						
					 $municipal_uploaded_doc = $this->data['DocumentUpload']['vc_municipal_doc_name'];	

					 $dir = WWW_ROOT."uploadfile".DS."$fileName".DS.'Municipal';

                  
                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }	
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Municipal';
					
                    $renameUploadFile_m = $nu_company_id . '-2-' . $this->renameUploadFile($municipal_uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile_m);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($municipal_uploaded_doc['type']);
					
					if (move_uploaded_file($municipal_uploaded_doc["tmp_name"],$dir.'/'.$renameUploadFile_m) == true) {
						
						  $this->DocumentUpload->deleteAll(array('DocumentUpload.vc_uploaded_doc_for' => 'Municipal',
                                'DocumentUpload.vc_customer_no' => $vc_customer_no,
                                'DocumentUpload.nu_company_id' => $this->data['Company']['nu_company_id']), false);

						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
					}
					
                    /******** End of  Municipal doc upload ends*********/
					
					/* Business Registration doc upload starts  */
						
					$business_uploaded_doc = $this->data['DocumentUpload']['vc_business_reg_doc'];	
					 
					$dir = WWW_ROOT."uploadfile".DS."$fileName".DS.'Business';

                  
                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }
					
				    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                    $this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;

                    $this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;

                    $this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');

                    $this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Business';
					
                    $renameUploadFile_b = $nu_company_id.'-3-'.$this->renameUploadFile($business_uploaded_doc['name']);

                    $this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($renameUploadFile_b);

                    $this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;

                    $this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($business_uploaded_doc['type']);
					
					if (move_uploaded_file($business_uploaded_doc["tmp_name"], $dir .'/'.$renameUploadFile_b) == true) {
												  
						 $this->DocumentUpload->deleteAll(array('DocumentUpload.vc_uploaded_doc_for' => 'Business',
                                'DocumentUpload.vc_customer_no' => $vc_customer_no,
                                'DocumentUpload.nu_company_id' => $this->data['Company']['nu_company_id']), false);

						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
						
					}
					
                    /* End of  Business Registration upload starts  */
					    
                        if ($checkfirstcompany > 0) {

                            $this->data['Profile']['vc_tel_no'] = $this->data['Company']['vc_tel_no'];
                            $this->data['Profile']['vc_fax_no'] = $this->data['Company']['vc_fax_no'];
                            $this->data['Profile']['vc_mobile_no'] = $this->data['Company']['vc_mobile_no'];
                            $this->data['Profile']['vc_business_reg'] = $this->data['Company']['vc_business_reg'];
                            $this->data['Profile']['vc_account_no'] = $this->data['Company']['vc_account_no'];
                            $this->data['Profile']['vc_bank_struct_code'] = $this->data['Company']['vc_bank_struct_code'];
                            $this->data['Profile']['vc_bank_supportive_doc'] = $this->data['Company']['vc_bank_supportive_doc'];
                            $this->data['Profile']['vc_cust_type'] = $this->data['Company']['vc_cust_type'];
                            $this->data['Profile']['vc_address1'] = $this->data['Company']['vc_address1'];
                            $this->data['Profile']['vc_address2'] = $this->data['Company']['vc_address2'];
                            $this->data['Profile']['vc_address3'] = $this->data['Company']['vc_address3'];
                            $this->data['Profile']['vc_customer_no'] = $vc_customer_no;
                            //pr($this->data['Profile']);
                            //die;
                            //$this->Profile->id = $vc_customer_no;							
                            $this->Profile->set($this->data['Profile']);
                            $this->Profile->save($this->data['Profile'], false);
                            
                        }

                        /***************************Email Shoot **************************** */

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                        $this->Email->bcc = array(trim($this->AdminMdcEmailID));

                        $this->Email->subject = strtoupper($selectedType) . " Add Company ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Request to edit company details has been received, Please wait for approval.";

                        $mesage .= "<br> <br> Username : " . trim($vc_username);

                        $this->Email->send($mesage);

                        $this->Email->to = array();

                        $this->Email->bcc = array();

                        /*                         * *****Email Send To Admin************ */

                        $this->data = null;

                        $this->Session->write('Auth.Member.vc_mdc_customer_no', $vc_customer_no);

                        $this->Session->setFlash('Request to edit company details has been sent successfully, pending for approval from RFA !!', 'success');

                        $this->redirect(array('controller' => 'profiles', 'action' => 'view_company'));
                    } else {

                        $this->DocumentUpload->rollback();

                        $this->data = null;

                        $this->Session->setFlash('Some Error has come please try again.', 'error');
                    }
                } else {
								//pr($this->DocumentUpload->invalidFields()); 
								//pr($this->Company->invalidFields()); 
                 //   $this->redirect($this->referer());
                    //$this->referer();
                }
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }

        $this->layout = 'userprofile';

        $vc_username = $this->Session->read('Auth.Member.vc_username');

        $this->set('DocsSupportive', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'BANKSUPPTYP%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->set('CustType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CUSTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));



        $this->set('title_for_layout', 'Edit Company');
    }

}