<?php

App::import('Sanitize');

class CustomersController extends AppController {

    /**
     *
     *
     */
    var $name = 'Customers';

    /**
     *
     *
     *
     */
    var $components = array('Session', 'Auth', 'RequestHandler', 'Email');

    /**
     *
     *
     *
     */
    var $helpers = array('Session', 'Html', 'Form');

    /**
     *
     *
     *
     */
    var $uses = array('Member', 'Customer','DocumentUploadCbc');

    /**
     *
     *
     *
     */
    function beforeFilter() {

        parent::beforeFilter();
		
		$checkUser = $this->checkUser();
		
		if( $this->isInspector ) {

			$this->redirect(array('controller'=>'inspectors','action'=>'index'));

        }
		$this->Session->read('Auth.Member.vc_user_firstname');
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$customerdetails = $this->Customer->find('first',array('conditions'=>
			array('Customer.vc_cust_no'=>$vc_cust_no,'Customer.ch_active'=>'STSTY04')
		,),array('fields'=>array('*')));
		
		if($customerdetails['Customer']['vc_cust_no']!='' && !empty($customerdetails['Customer']['vc_cust_no'])){
			$this->Session->write($this->Session->read('Auth.Customer'),$customerdetails);
			
			$this->Session->write(('Auth.Member.vc_user_firstname'),$customerdetails['Customer']['vc_first_name']);
			$this->Session->write(('Auth.Member.vc_user_lastname'),$customerdetails['Customer']['vc_surname']);
			
		}
		$this->layout = $this->Auth->params['prefix'].'_layout';
		
		
		$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
		$ch_active = $this->Session->read('Auth.Customer.ch_active');
		$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
		$vc_username = $this->Session->read('Auth.Member.vc_username');
		
		if($vc_username!='' && ($ch_active=='STSTY04' || $ch_active=='STSTY03'))	
		$this->Auth->allow('cbc_view','cbc_getAlterEmailCheck','cbc_download','cbc_changepassword');
		
		if($vc_username!='' && $ch_active=='STSTY05')		
		$this->Auth->allow('cbc_editprofile','cbc_getAlterEmailCheck','cbc_download','cbc_changepassword');
		
		if($vc_username!='' && $ch_active=='' && $this->cbc==$vc_comp_code)		
		$this->Auth->allow('cbc_customer_profile','cbc_changepassword','cbc_getAlterEmailCheck');
		
		
		$this->loginRightCheck();
    }
	
	
	function loginRightCheck() {
        if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {

             $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        }
    }

	
		/*Alter Email check*/
	  function cbc_getAlterEmailCheck() {

		//Configure::write('debug', 0);
		$countsame='';
		$conditions = array();
			
        if ($this->params['isAjax']) {
			
		
			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
			if(trim($this->params['form']['CustomerVcAlterEmail']) ==trim($this->params['form']['CustomerVcEmail']) ) {
				$countsame =1;
			}
			$vc_comp_code   = $this->Session->read('Auth.Member.vc_comp_code');
			
			if(isset($this->params['form']['CustomerEditvalue']) && $this->params['form']['CustomerEditvalue']=='edit'){
			
			$conditions += array(
										'OR'=>array(
											array('Customer.vc_alter_email'=>trim($this->params['form']['CustomerVcAlterEmail']),
											'Customer.vc_cust_no!'=>$vc_cust_no,
											),
											array('Customer.vc_email'=>trim($this->params['form']['CustomerVcAlterEmail']),
											)),
											'Customer.vc_comp_code'=>$vc_comp_code
											);
			
											
			$this->loadModel('Member');
			
			$countmemberResult = $this->Member->find('count',array(
										'conditions'=>array(											
										'Member.vc_email_id'=>trim($this->params['form']['CustomerVcAlterEmail']),										
										'Member.vc_comp_code'=>$vc_comp_code,
											'Member.vc_cbc_customer_no!'=>$vc_cust_no)));
				
			
			} else {
			
			$this->loadModel('Member');
			
			$countmemberResult = $this->Member->find('count',array(
										'conditions'=>array(											
										'Member.vc_email_id'=>trim($this->params['form']['CustomerVcAlterEmail']),										
										'Member.vc_comp_code'=>$vc_comp_code)));
		
			
			if( isset($this->params['form']['CustomerVcAlterEmail']) ) {
				
				$CustomerVcAlterEmail =  trim($this->params['form']['CustomerVcAlterEmail']);
				
				$conditions += array( 'Customer.vc_alter_email'=>$CustomerVcAlterEmail);

		    	}
			
			}
		}
		            
		$count = $this->Customer->find('count', array('conditions' => $conditions));			
		
        if ($count == 0 && $countsame!=1 && $countmemberResult==0) {

            echo "true";
			
        } else {

            echo "false";
        }		
        exit;
    }
	

    /**
     *
     *Function to add Customer Profile
     * 
     */
	 
    public function cbc_customer_profile() {
                   
			try {
			   set_time_limit(0);
				$ch_active = $this->Session->read('Auth.Customer.ch_active');
				if($ch_active =='' || $ch_active =='null'){
				
				} elseif ($ch_active =='STSTY05') {
					
					$this->redirect('editprofile');
				
				} else {
				
					$this->redirect('view');
			
				}
				

				if (isset($this->data) && !empty($this->data)) {
				
					$setValidates = array('vc_company', 'vc_first_name', 'vc_surname', 'vc_cont_per', 'vc_address1', 'vc_address2', 
					'vc_address3', 'vc_tel_no', 'vc_fax_no', 'vc_mobile_no','vc_alter_email',
					'vc_alter_phone_no','vc_alter_cont_person');
					$setValidatesDocUpd = array('vc_upload_doc_name');

					$vc_comp_code   = $this->Session->read('Auth.Member.vc_comp_code');
                   
					$vc_user_no     = $this->Session->read('Auth.Member.vc_user_no');
                   
				    $vc_customer_no = $this->Session->read('Auth.Member.vc_username');

                    $vc_email_id    = $this->Session->read('Auth.Member.vc_email_id');
                    
					$this->data['Customer']['nu_cust_vehicle_card_id'] = $this->Customer->getPrimaryKey();
					
					$this->data['DocumentUploadCbc']['nu_cust_vehicle_card_id'] = $this->data['Customer']['nu_cust_vehicle_card_id'];
			
					$this->data['DocumentUploadCbc']['nu_upload_id'] = $this->DocumentUploadCbc->getPrimaryKey();
                    
					$this->data['Customer']['vc_cust_no'] = $vc_customer_no;
                    
					$this->data['Customer']['vc_comp_code'] = $vc_comp_code;
					
					$this->data['Customer']['vc_username'] = $vc_customer_no;
					
					//	$this->data['Customer']['nu_account_balance'] = 0;
					
					$this->data['Customer']['vc_email'] = $vc_email_id;
                    
					$this->data['Customer']['vc_user_no'] = $vc_user_no;
                    
					$this->data['Customer']['dt_created'] = date('Y-m-d H:i:s');
                    
					$this->data['Customer']['ch_active'] = 'STSTY03';
					
					$this->DocumentUploadCbc->create(false);

					$this->DocumentUploadCbc->set($this->data['DocumentUploadCbc']);

                    $this->Customer->create(false);
					
                    $this->Customer->set($this->data['Customer']);                  

                    $this->unsetValidateVariable($setValidates, array_keys($this->Customer->validate), &$this->Customer);

					$saveData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');
					
                    $saveData['Member']['vc_cbc_customer_no'] = $vc_customer_no;
					
                    $saveData['Member']['vc_user_no'] = $vc_user_no;
					
                    if ($this->Customer->validates(array('fieldList' => $setValidates)) &&
					$this->DocumentUploadCbc->validates(array('fieldList' => $setValidatesDocUpd))) {
					
						$vc_alter_email = $this->data['Customer']['vc_alter_email'];
						
                        $this->Member->validate = null;
						
						$file = $this->data['DocumentUploadCbc']['vc_upload_doc_name'];

						$filename = $file['name'];
						
						if($filename!='')
						$filename = $this->renameUploadFile($filename);

						$dir = WWW_ROOT. "uploadfile" . DS .$vc_customer_no. DS. "Application Form";

						if (!file_exists($dir)) {

							mkdir($dir, 0777, true);
						}
		
						@$insertData['DocumentUploadCbc'] = array(
									'vc_user_no' => $vc_user_no,
									'vc_comp_code' => $vc_comp_code,
									'vc_cust_no' => $vc_customer_no,
									'vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD01'],
									'vc_upload_doc_name' => trim($filename),
									'dt_date_uploaded' => date('d-M-Y'),
									'vc_upload_doc_path' => $dir
						);
						
						if(move_uploaded_file($file["tmp_name"], $dir . DS . $filename) == true){
						
							if ($this->Customer->save($this->data['Customer']) && $this->Member->save($saveData) && $this->DocumentUploadCbc->save($insertData)) {

							
								/***************** Email Shoot to customer ******************/
							
								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
								
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
								
								$this->Email->bcc = array(trim($this->AdminCbcEmailID));

								$this->Email->subject = strtoupper($selectedType) . "  Account Add ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " Request to activate your account has been received, please wait for approval !!";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
								//$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_cbc_customer_no'));
								
								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();
								
								
								/***************** Email Shoot at alternative email id *****************/
								
								if(isset($vc_alter_email) && !empty($vc_alter_email)) {
							
								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
								
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($vc_alter_email);

								$this->Email->subject = strtoupper($selectedType) . "  Account Add ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " Request to activate your account has been received, please wait for approval !!";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
				
								$this->Email->send($mesage);
								
								}
								
								/****************** Email Send To Admin *********************/
								
								
								
								/* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))) . '<' . trim($this->Session->read('Auth.Member.vc_email_id')) . '>';

								$this->Email->to = trim($this->AdminEmailID);

								$this->Email->subject = strtoupper($selectedType) . " Account Add ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', $this->AdminName);

								$this->Email->delivery = 'smtp';

								$mesage = strtoupper($selectedType) . " Customer Profile Activation Request";; 

								$this->Email->send($mesage); */

                      
								/*********************************************/

								$this->data = null;

								$this->Session->write('Auth.Member.vc_cbc_customer_no', $vc_customer_no);

								$this->Session->setFlash('Your account has been created successfully, pending for approval from RFA !!', 'success');
							   
								$this->redirect('view');
							
							}
							
						}else {
						
							$this->setFlash("File not uploaded successfully !!",'error');
							
							$this->set('data',$this->data);

							$this->redirect('view');
							
						}
						
						
						
                    }
					
					

					
                } // end of post
				
            } catch (Exception $e) {

				echo 'Caught exception: ', $e->getMessage(), "\n";

				exit;
			}
    }


    /**
     *
     *Function to view customer profile
     *
     */
		
		
	public function cbc_view(){	

		     $ch_active = $this->Session->read('Auth.Customer.ch_active');

			if($ch_active =='STSTY04' || $ch_active =='STSTY03'){
										
				if (!empty($this->data) && $this->RequestHandler->isPost()) {
			
					$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
                    
					$vc_user_no = $this->Session->read('Auth.Member.vc_user_no');
                    
					$vc_username = $this->Session->read('Auth.Customer.vc_username');
					
					$vc_cust_no = trim($this->Session->read('Auth.Customer.vc_cust_no'));
					
					$vc_customer_no = $this->Session->read('Auth.Member.vc_username');
					$this->data['Customer']['vc_cust_no'] =$vc_customer_no;
						$this->data['Customer']['vc_comp_code'] = $vc_comp_code;
						
					$setValidates= array('vc_alter_cont_person', 'vc_alter_email', 'vc_alter_phone_no');
					
					$this->Customer->set($this->data);
					
					$this->unsetValidateVariable($setValidates, array_keys($this->Customer->validate), &$this->Customer);
						
					if ($this->Customer->validates(array('fieldList' => $setValidates))) {
						$this->data['Customer']['nu_cust_vehicle_card_id'] = $this->Session->read('Auth.Customer.nu_cust_vehicle_card_id');	
						
						if( $this->Customer->save($this->data, false) ) {
							
								/***************** Email Shoot to customer ******************/
							
								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
								
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
								
								$this->Email->bcc = array(trim($this->AdminCbcEmailID));

								$this->Email->subject = strtoupper($selectedType) . "  Alternate information updated ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " Alternate information updated !!";
								
								$mesage .= "<br> <br> Username : ".trim($vc_username);
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);

								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();
								
								
								/****************** Email Send To Admin *********************/
								
								
								
								/* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))) . '<' . trim($this->Session->read('Auth.Member.vc_email_id')) . '>';

								$this->Email->to = trim($this->AdminEmailID);

								$this->Email->subject = strtoupper($selectedType) . " Alternate information update ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', $this->AdminName);

								$this->Email->delivery = 'smtp';

								$mesage = strtoupper($selectedType) . " Alternate information update ";; 

								$this->Email->send($mesage); */

                      
								/*********************************************/
							
							$this->Session->setFlash('Alternative contact person information updated successfully !!','success');	
													
						
						}else {
						
							$this->Session->setFlash('Alternative contact person information could not be updated !!','error');	
						
						}
						
						$this->data = array();
						
						$this->redirect($this->referer());	
					}	
				
				}
						
			
			
			
			
			}else if($ch_active =='STSTY05') {
				
				$this->redirect('editprofile');
			
			}else if($ch_active =='STSTY02' || $ch_active =='STSTY01'){
			
			
			} else{
			 
				$this->redirect('customer_profile');
			
			}
	}
	
	/**
     *
     *Function to edit customer profile
     *
     */
	
	public function cbc_editprofile(){
	
		try {
		       set_time_limit(0);
			$ch_active = $this->Session->read('Auth.Customer.ch_active');	
			
			if($ch_active == 'STSTY05'){
			
			}
			else{
			 $this->redirect('view');
			}
			
			$vc_customer_no = $this->Session->read('Auth.Member.vc_username');
			

			if (!empty($this->data) && $this->RequestHandler->isPost()) {
                    
					$setValidatesDocUpd = array('vc_upload_doc_name');
					$setValidates = array('vc_company', 'vc_first_name', 'vc_surname', 'vc_cont_per', 'vc_address1', 'vc_address2',
										'vc_address3', 'vc_tel_no', 'vc_fax_no', 'vc_mobile_no', 'vc_alter_email',
										'vc_alter_phone_no','vc_alter_cont_person');
										
					$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
                    
					$vc_user_no = $this->Session->read('Auth.Member.vc_user_no');
                    
					$vc_customer_no = $this->Session->read('Auth.Member.vc_username');
			
					$vc_username = $this->Session->read('Auth.Customer.vc_username');
					
                    $vc_email_id = $this->Session->read('Auth.Member.vc_email_id');
					
					$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
					
					$vc_remarks = $this->Session->read('Auth.Customer.vc_remarks');
					
					$this->Customer->nu_cust_vehicle_card_id = $this->data['Customer']['nu_cust_vehicle_card_id'];
					
					$this->data['DocumentUploadCbc']['nu_cust_vehicle_card_id'] = $this->data['Customer']['nu_cust_vehicle_card_id'];
			
					$this->data['DocumentUploadCbc']['nu_upload_id'] = $this->DocumentUploadCbc->getPrimaryKey();
				
   					$this->data['Customer']['vc_cust_no']=$vc_customer_no;
					
   					$this->data['Customer']['vc_username']=$vc_customer_no;

					$this->data['Customer']['vc_comp_code'] = $vc_comp_code;
                    
					$this->data['Customer']['vc_user_no'] = $vc_user_no;
                    
					$this->data['Customer']['dt_created'] = date('Y-m-d H:i:s');
                    
					$this->data['Customer']['ch_active'] = 'STSTY03';
					
					$this->DocumentUploadCbc->create(false);
					$this->DocumentUploadCbc->set($this->data['DocumentUploadCbc']);
					//$this->DocumentUploadCbc->set($this->data);

                    $this->Customer->create(false);
                    
					$this->Customer->set($this->data['Customer']);
					

                    $setValidates = array('vc_company','vc_first_name', 'vc_surname','vc_cont_per','vc_address1','vc_address2',
										'vc_address3','vc_tel_no','vc_fax_no','vc_mobile_no','vc_alter_email','vc_alter_phone_no',
										'vc_alter_cont_person');

                    $this->unsetValidateVariable($setValidates, array_keys($this->Customer->validate), &$this->Customer);

					$saveData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');
                    
					$saveData['Member']['vc_cbc_customer_no'] = $vc_customer_no;
                    
					$saveData['Member']['vc_user_no'] = $vc_user_no;
					
                    if ($this->Customer->validates(array('fieldList' => $setValidates))&&
					$this->DocumentUploadCbc->validates(array('fieldList' => $setValidatesDocUpd))) {
						
						$vc_cust_no = trim($this->Session->read('Auth.Customer.vc_cust_no'));

						/************* Firstly Delete old File and Entry From Database *************/

						$this->DocumentUploadCbc->deleteAll(array('DocumentUploadCbc.vc_cust_no' => $vc_cust_no,'DocumentUploadCbc.vc_upload_doc_for' =>$this->globalParameterarray['DOCUPLOAD01']));

                        $this->Member->validate = null;
						
						$file = $this->data['DocumentUploadCbc']['vc_upload_doc_name'];

						$filename = $file['name'];

						if($filename!='')
						$filename = $this->renameUploadFile($filename);


						$dir = WWW_ROOT. "uploadfile" . DS .$vc_customer_no. DS. "Application Form";

						if (!file_exists($dir)) {

							mkdir($dir, 0777, true);
						}

						
						@$insertData['DocumentUploadCbc'] = array(
									'vc_user_no' => $vc_user_no,
									'vc_comp_code' => $vc_comp_code,
									'vc_cust_no' => $vc_customer_no,
									'vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD01'],
									'vc_upload_doc_name' => trim($filename),
									'dt_date_uploaded' => date('d-M-Y'),
									'vc_upload_doc_path' => $dir
						);

						if(move_uploaded_file($file["tmp_name"], $dir . DS . $filename) == true){
						
							if ($this->Customer->save($this->data['Customer']) && $this->Member->save($saveData) && $this->DocumentUploadCbc->save($insertData)) {	
							
							
								/**********Email Shoot to customer***************** */
								
								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
                       
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
								
								$this->Email->bcc = array(trim($this->AdminCbcEmailID));

								$this->Email->subject = strtoupper($selectedType) . "  Account Edit ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " We have received your request to update your account, please wait for approval !!"; 
								
								$mesage .= "<br> <br> Username : ".trim($vc_username);
							
								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();
								
								
								/********** Email Shoot at alternative email id *********** */
								
								if(isset($vc_alter_email) && !empty($vc_alter_email)) {
								
									list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
						   
									$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

									$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

									$this->Email->subject = strtoupper($selectedType) . " Account Edit ";

									$this->Email->template = 'registration';

									$this->Email->sendAs = 'html';

									$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

									$this->Email->delivery = 'smtp';

									$mesage = " We have received your request to update your account, please wait for approval !!"; 
									
									$mesage .= "<br> <br> Username : ".trim($vc_username);
					
									$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
									
									$this->Email->send($mesage);
								
								}
								
							
                      
					  
								/*********************End Email************************/
								

								$this->data = null;

								$this->Session->write('Auth.Member.vc_cbc_customer_no', $vc_customer_no);

								$this->Session->setFlash('Your account has been updated successfully , pending for approval from RFA !!', 'success');

								$this->Session->read('Auth.Member.vc_cbc_customer_no');
								
								$this->redirect('view');
							}
						
						}else {
						
							$this->setFlash("File not uploaded successfully !!",'error');
							
							$this->set('data',$this->data);

							$this->redirect('view');
						
						}
                    }
			}
				
		}catch (Exception $e) {
				
			echo 'Caught exception: ', $e->getMessage(), "\n";

			exit;
		}
		
	}
	
	/**
     *
     *Function to change password
     *
     */
	
	public function cbc_changepassword() {

        try {
		
				 $username =$this->Session->read('Auth.Member.vc_username');
				$newpassword = $this->data['Customer']['vc_password'];
				list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Customer->set($this->data);

                /**************** Use this before any validation *********************************** */

                $setValidates = array(
                    'vc_old_password',
                    'vc_password',
                    'vc_comp_code',
                    'vc_confirm_password');

                /** ************************************************************************************* */
                if ( $this->Customer->validates(array('fieldList' => $setValidates)) ) {


                    $this->Member->validate = null;
					
                    $updateData['Member']['vc_password'] = $this->Auth->password(trim($this->data['Customer']['vc_password']));

                    $updateData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');

                    $updateData['Member']['vc_user_no'] = $this->Session->read('Auth.Member.vc_user_no');

                    if ($this->Member->save($updateData)) {

                        $this->data = NUll;

                         $this->Session->setFlash('Your password has been changed successfully !!', 'success');
						 
						 /********************************** Email shoot **********************************/
						 
						 
								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

								$this->Email->subject = strtoupper($selectedType) . " Password Changed ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " You have recently changed password on RFA portal ( ".strtoupper($selectedType)." Section ). Please use the credentials mentioned below to login : ";
								
								$mesage .= "<br> Username : ".trim($username);
								
								$mesage .= "<br> Password : ".trim($newpassword);

								$this->Email->send($mesage);
								
								
								/******************************** End *********************************/


                        $this->redirect($this->referer());
						
                    } else {

                        $this->data = NUll;

                        $this->Session->setFlash('Your password could not be changed, please try later', 'error');
                    }
					
                }
				
            }
			
            $this->set('title_for_layout',"Change Password ");
			
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }   
	
	/*
	*
	*Function to download the uploaded application form
	*
	*/
	
	function cbc_download() {

        $this->layout = NULL;
		
        $vc_cust_no = trim($this->Session->read('Auth.Customer.vc_cust_no'));

        $vc_comp_code = trim($this->Session->read('Auth.Customer.vc_comp_code'));
		
        $DownloadFile = $this->DocumentUploadCbc->find('first', array(
		                                                    'fields'=>array('DocumentUploadCbc.vc_upload_doc_path',
		                                                    'DocumentUploadCbc.vc_upload_doc_type',
															'DocumentUploadCbc.vc_upload_doc_name'),
															'conditions' => array(
																'DocumentUploadCbc.vc_comp_code' => $vc_comp_code,
																'DocumentUploadCbc.vc_cust_no' => $vc_cust_no,
																'DocumentUploadCbc.vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD01']),
																'order'=>array('DocumentUploadCbc.dt_date_uploaded'=>'desc')));
																
	
	 if ( isset($DownloadFile['DocumentUploadCbc']['vc_upload_doc_name']) && file_exists($DownloadFile['DocumentUploadCbc']['vc_upload_doc_path'] . DS . $DownloadFile['DocumentUploadCbc']['vc_upload_doc_name']) ) {
			         
			$path = $DownloadFile['DocumentUploadCbc']['vc_upload_doc_path'] . DS . $DownloadFile['DocumentUploadCbc']['vc_upload_doc_name'];
           
			header('Expires: 0');
           
			header('Pragma: public');
			
			header('Content-type:'.$DownloadFile['DocumentUploadCbc']['vc_upload_doc_type']);
			
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            
			header('Content-Disposition: attachment; filename="' . basename($DownloadFile['DocumentUploadCbc']['vc_upload_doc_name']) . '"');
            
			header('Content-Transfer-Encoding: binary');
			
			@readfile($path);
			
			exit(0);
        
		} else {

            $this->Session->setFlash('Sorry No file', 'info');

            // $this->redirect($this->referer());
		    $this->redirect('view');
        }
    }

}