<?php

App::import('Sanitize');

/**
 * 
 *
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
    var $uses = array('Member', 'Profile', 'Bank', 'DocumentUpload','Company');

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
		
		
    }
	
	
	/*
	*
	* beforeRender
	*
	* Called after controller action logic, but before the view is rendered.
	* This callback is not used often, but may be needed if you are calling render() manually
	* before the end of a given action.
	*
	**/
	
	function beforeRender () {
	
	
		 parent::beforeRender();
	
	
	}


    /**
     *
     *
     */
    public function index() {

        try {
pr($this->Session);
 //
            if (!empty($this->data) && $this->RequestHandler->isPost()) {
				

			    $this->Profile->create(false);
				
			    $this->Company->create(false);

                $this->Profile->set($this->data['Profile']);
				
                $this->Company->set($this->data['Company']);

                $this->DocumentUpload->create(false);

                $this->DocumentUpload->set($this->data['DocumentUpload']);
                /**************** Use this before any validation *********************************** */

                $setValidates = array(
                    'vc_customer_id',
                    'vc_business_reg',
                    'vc_cust_type',
                    'vc_bank_struct_code',
                    'vc_account_no',
                    'vc_address1',
                    'vc_mobile_no');
					
				$setcompany = array('vc_company_name');

                $setValidatesDocUpd = array('vc_uploaded_doc_name');
				pr($this->data);die;
				if ($this->Profile->validates(array('fieldList' => $setValidates)) && $this->DocumentUpload->validates(array('fieldList' => $setValidatesDocUpd)) ) {

					$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
					
					$this->data['Company']['nu_company_id'] = $this->Company->getPrimaryKey();
					
					$vc_company_name = $this->data['Company']['vc_company_name'];

                    $vc_user_no = $this->Session->read('Auth.Member.vc_user_no');

                    $vc_customer_no = $this->Session->read('Auth.Member.vc_username');

                    $vc_email_id = $this->Session->read('Auth.Member.vc_email_id');

                    $fileName = trim($vc_customer_no);
					
                    $dir = WWW_ROOT."uploadfile" . DS . "$fileName" . DS .'Bank';

                    $vc_customer_name = ucfirst($this->Session->read('Auth.Member.vc_user_firstname')) . ' ' . ucfirst($this->Session->read('Auth.Member.vc_user_lastname'));

                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }
					

					$this->data['Company']['ch_status'] = 'STSTY03';
					$this->data['Company']['vc_username'] = $this->Session->read('Auth.Member.vc_username');
					$this->data['Company']['vc_comp_code'] = $vc_comp_code;

                    $this->data['Profile']['vc_customer_no'] = $vc_customer_no;
                    $this->data['Profile']['vc_comp_code'] = $vc_comp_code;
                    $this->data['Profile']['vc_user_no'] = $vc_user_no;
                    $this->data['Profile']['vc_customer_name'] = $vc_customer_name;
                    $this->data['Profile']['vc_email_id'] = $vc_email_id;
					
					if( trim($this->Session->read('Auth.Profile.vc_user_no')) != '' ) :
					
						$this->data['Profile']['dt_modified_date'] = date('Y-m-d H:i:s');
                    
					
					else :
	
						$this->data['Profile']['dt_created_date'] = date('Y-m-d H:i:s');
					
					endif;
					
					$this->data['Profile']['ch_active'] = 'STSTY03';
					
                    $this->data['Profile']['nu_variance_amount'] = 0;

                    $uploaded_doc = $this->data['DocumentUpload']['vc_uploaded_doc_name'];

                    $this->data['DocumentUpload']['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();
                    
					$this->data['DocumentUpload']['vc_customer_no'] = $vc_customer_no;
                    
					$this->data['DocumentUpload']['vc_comp_code'] = $vc_comp_code;
                    
					$this->data['DocumentUpload']['dt_date_uploaded'] = date('Y-m-d H:i:s');
                    
					$this->data['DocumentUpload']['vc_uploaded_doc_for'] = 'Bank';
                    
					$this->data['DocumentUpload']['vc_uploaded_doc_name'] = trim($uploaded_doc['name']);
                    
					$this->data['DocumentUpload']['vc_uploaded_doc_path'] = $dir;
					
					$this->data['DocumentUpload']['vc_uploaded_doc_type'] = trim($uploaded_doc['type']);
					
                    $saveData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');
                   
					$saveData['Member']['vc_mdc_customer_no'] = $vc_customer_no;

					$saveData['Member']['vc_user_no'] = $vc_user_no;
pr($this->data['Company']);
die;
                    if ($this->Profile->save($this->data['Profile'], false)&& $this->Member->save($saveData, false)
					&& $this->Company->save($this->data['Company'],false)) {

                        if(move_uploaded_file($uploaded_doc["tmp_name"], $dir . '/' . $uploaded_doc["name"])==true){
						
						
						$this->DocumentUpload->save($this->data['DocumentUpload'], false);
						
						
						}

                        /* ***************************Email Shoot **************************** */

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

						if($this->Session->check('Auth.Profile')) :
						
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
								
								$this->Email->bcc = array(trim($this->AdminMdcEmailID));

								$this->Email->subject = strtoupper($selectedType) . " Account Edit ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " Request to  edit your account has been received, Please wait for approval.";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
								
								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();
								
								
								/*******Email Send To Admin************ */

								
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
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
											
								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();

							
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
                } 
            }

            $this->layout = 'userprofile';

            $this->set('DocsSupportive', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'BANKSUPPTYP%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('CustType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CUSTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
			
            $this->set('CompanyType', array('' => ' Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'COMPANY%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));
			
            $profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));
			
			if ($profile) {
				
				if(trim($profile['Profile']['ch_active']) == 'STSTY05' ) :
				
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
     *Change Password
     *
     */
	 
    public function changepassword() {

        try {
			
			if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Profile->set($this->data);

                /* ******* Use this before any validation ******************************* */

                $setValidates = array(
                    'vc_old_password',
                    'vc_password',
                    'vc_comp_code',
                    'vc_confirm_password');

                /** ************************************************************************************* */

				$username =$this->Session->read('Auth.Member.vc_username');
				
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
						
						
						/******************************** Email Shoot *********************************/
						
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

								$this->Email->subject = strtoupper($selectedType) . " Password Changed ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " You have recently changed password on RFA portal ( ".strtoupper($selectedType)." Section ). Please use the credentials mentioned below to login : ";
								
								$mesage .= "<br><br>Username : ".trim($username);
								
								$mesage .= "<br><br>Password : ".trim($newpassword);

								$this->Email->send($mesage);
								
								
								/******************************** End *********************************/

                        $this->redirect($this->referer());
                    } else {

                        $this->data = NUll;

                        $this->Session->setFlash(' Your password could not be changed, please try later', 'error');
                    }
                }
            }

            $this->layout = 'userprofile';

            $this->set('title_for_layout',"Change Password ");
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *Download doc
     *
     */
	 
    function download() {

        $this->layout = NULL;

        $customer_no = trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));

        $comp_code = trim($this->Session->read('Auth.Member.vc_comp_code'));

        $DownloadFile = $this->DocumentUpload->find('first', array(
															'conditions' => array(
																	'DocumentUpload.vc_comp_code' => $comp_code,
																	'DocumentUpload.vc_uploaded_doc_for' => 'Bank',
																	'DocumentUpload.vc_customer_no' => $customer_no),
															'order'=>array('DocumentUpload.dt_date_uploaded'=>'desc')));
		
        if ($DownloadFile && file_exists($DownloadFile['DocumentUpload']['vc_uploaded_doc_path'] . DS . $DownloadFile['DocumentUpload']['vc_uploaded_doc_name']) ) {
			         
			$path = $DownloadFile['DocumentUpload']['vc_uploaded_doc_path'] . DS . $DownloadFile['DocumentUpload']['vc_uploaded_doc_name'];
           
			header('Expires: 0');
           
			header('Pragma: public');
			
			header('Content-type:'.$DownloadFile['DocumentUpload']['vc_uploaded_doc_type']);
			
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
	 
		Configure::write('debug', 0);
		
		if( $this->params['isAjax'] && isset( $this->params['data']['Profile']['vc_customer_id']) ) :
			
			$str = strtolower(trim($this->params['data']['Profile']['vc_customer_id']));
			
			$conditions = array("lower(Profile.vc_customer_id)  = '$str' ");
			
			if( isset($this->params['form']['id']) ) :
			 
				$id = strtolower(trim(base64_decode($this->params['form']['id'])));
				
				$conditions += array('lower(Profile.vc_user_no) !='=>$id);
				
				
			
			endif;
			
			$count = $this->Profile->find('count', array('conditions'=>$conditions));
			
			if( $count == 0 ) :
			
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
	 * Check Company name in MST_COMPANY_MDC table 
	 *
	 */
	 
	 function checkcompanyname() {
	 
		Configure::write('debug', 0);
		
		if( $this->params['isAjax'] && isset($this->params['data']['Company']['vc_company_name']) ) :
			
			$vc_company_name = strtolower(trim($this->params['data']['Company']['vc_company_name']));
			
			$conditions = array("lower(Company.vc_company_name)  = '$vc_company_name' ");
			
			$conditions += array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'));

        
			/*
			
			if( isset($this->params['form']['id']) ) :
			 
				$id = strtolower(trim(base64_decode($this->params['form']['id'])));
				
				$conditions += array('lower(Profile.vc_user_no) !='=>$id);
						
			endif;
			
			*/
			
			$count = $this->Company->find('count', array('conditions'=>$conditions));
			//pr($conditions);die;
			$count=0;
			if($count == 0) :
			
				echo "true";
			
			else :
			
				echo "false";
			
			endif;
			
		else :
			
			echo "false";
		
		endif;
				
		exit;
		
	 }
	
}