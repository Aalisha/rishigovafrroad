<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class PaymentsController extends AppController {

    /**
     *
     *
     */
    var $name = 'Payments';

    /**
     *
     *
     */
    var $uses = array('Payment','Member');

    /**
     *
     *
     */
    public function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();

        if (!$currentUser) {

            $this->Session->setFlash('You are not authorized to access that location');

            $this->redirect($this->Auth->logout());
        }

        if ($this->isInspector) {

            $this->redirect(array('controller' => 'inspectors', 'action' => 'index'));
        }
		
		if($this->Session->read('Auth.Profile.ch_active') != 'STSTY04') {
			
			$this->redirect(array('controller' => 'profiles', 'action' => 'index'));
		
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
	 
	 public function index($assessmentNo = null) {


        try {
		    set_time_limit(0);
			
			$nu_company_id = $this->Session->read('nu_company_id');			
			
			$this->Set('nu_company_id',$nu_company_id);
				//$this->data['Payment']['vc_uploaded_doc_name']
            $this->loadModel('AssessmentVehicleMaster');
			$this->loadModel('DocumentUploadVehicle');
			
			$vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');
			 $this->AssessmentVehicleMaster->unBindModel(array('hasMany' => array('AssessmentVehicleDetail'),'belongsTo' => array('PaymentStatus')));
        
			//pr($this->AssessmentVehicleMaster);
			$AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('first', array('conditions' => array('AssessmentVehicleMaster.vc_assessment_no' => base64_decode(trim($assessmentNo)),
			"AssessmentVehicleMaster.vc_payment_status='STSTY01' or AssessmentVehicleMaster.vc_payment_status = 'STSTY05'",
			'AssessmentVehicleMaster.vc_customer_no'=>$vc_customer_no,
			)));
			
			$countAssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('count', array('conditions' => array('AssessmentVehicleMaster.vc_assessment_no' => base64_decode(trim($assessmentNo)),			
			"AssessmentVehicleMaster.vc_payment_status='STSTY01' or AssessmentVehicleMaster.vc_payment_status = 'STSTY05'",
			'AssessmentVehicleMaster.vc_customer_no'=>$vc_customer_no,
			)));
			//pr($countAssessmentVehicleMaster);
			//die;
			if ($assessmentNo != null && $countAssessmentVehicleMaster>0) {
				//echo '---'.$assessmentNo;
				//pr($AssessmentVehicleMaster);
                if (!empty($this->data) && $this->RequestHandler->isPost()) {
					
					$this->Payment->create(false);
                    $this->Payment->set($this->data);
					//$this->data['Payment']['vc_uploaded_doc_name']
					if($this->Payment->validates()){
					
					
					$saveData = array();
					
					
						if(((float)trim($this->data['Payment']['vc_mdc_paid']))<((float)trim($this->data['Payment']['vc_mdc_payable_hidden']))){
						
						$this->Session->setFlash(' Payment should not be less than payable amount.!! ', 'error');

                            $this->redirect($this->referer());
						}
						//die;
					    $saveData['AssessmentVehicleMaster']['vc_bank_struct_code'] = $this->data['Payment']['vc_bank_struct_code'];

                        $saveData['AssessmentVehicleMaster']['vc_payment_status'] = 'STSTY03';
						
                        $saveData['AssessmentVehicleMaster']['nu_company_id'] = $nu_company_id;
						
						$saveData['AssessmentVehicleMaster']['vc_mdc_paid'] = (float)trim($this->data['Payment']['vc_mdc_paid']);

						$saveData['AssessmentVehicleMaster']['vc_payment_reference_no'] = $this->data['Payment']['vc_payment_reference_no'];
						
	if(isset($this->data['Payment']['vc_uploaded_doc_name']['tmp_name']) && $this->data['Payment']['vc_uploaded_doc_name']['tmp_name']!=''){
						                       
					   $saveData['AssessmentVehicleMaster']['ch_upload_doc'] ='Y';
                        
					}

                        $saveData['AssessmentVehicleMaster']['vc_assessment_no'] = base64_decode(trim($assessmentNo));

                        $this->AssessmentVehicleMaster->create();

						$this->AssessmentVehicleMaster->set($saveData);
						
						if ($this->AssessmentVehicleMaster->save($saveData)) {

							$vc_username = $this->Session->read('Auth.Member.vc_username');

                            $fileName = trim($vc_username);
							
							
							if(isset($this->data['Payment']['vc_uploaded_doc_name']['tmp_name']) && $this->data['Payment']['vc_uploaded_doc_name']['tmp_name']!=''){
							
							$dir = WWW_ROOT ."uploadfile" . DS . "$fileName" . DS .'Payment';
							$this->delTree($dir);
                            if (!file_exists($dir)) {
								//rmdir($dir);	
                                mkdir($dir, 0777, true);
								$this->DocumentUploadVehicle->deleteAll(array('DocumentUploadVehicle.vc_vehicle_assess_no'=>base64_decode(trim($assessmentNo))));
                            }

                            //==** ***** Upload Assessment related Payment related Docs  ************* *==//


                            $docUpload['vc_customer_no'] = $vc_customer_no;

                            $docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                            $docUpload['vc_vehicle_assess_no'] = base64_decode(trim($assessmentNo));
							
                            $docUpload['nu_company_id'] = $nu_company_id;

                            $docUpload['vc_upload_vehicle_id'] = $this->DocumentUploadVehicle->getPrimaryKey();

                            $docUpload['vc_uploaded_doc_path'] = $dir;

                            $filename     = $this->data['Payment']['vc_uploaded_doc_name']['name'];
							$newfilename  = $this->renameUploadFile($filename);

                            if (file_exists($dir . DS . $newfilename)) {

                                $newfilename =  time(). '-'.$newfilename;
                            }

                            $docUpload['vc_uploaded_doc_name'] = $newfilename;

                            $docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');
							
								//	unlink($path);
							
							

                            $this->DocumentUploadVehicle->validate = null;

                            $this->DocumentUploadVehicle->create();

                            $this->DocumentUploadVehicle->set($docUpload);

                            $this->DocumentUploadVehicle->save();
							
							if(isset($this->data['Payment']['vc_uploaded_doc_name']["tmp_name"])!='')	
								move_uploaded_file($this->data['Payment']['vc_uploaded_doc_name']["tmp_name"], $dir . DS . $newfilename);
							
							}							
                            	
 							$this->data = null;
							
							//===*********** Email Send To Customer ***************** *==///
							

							list($selectedType,$type,$selectList) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

							$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

							$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
							
							$this->Email->bcc = array(trim($this->AdminMdcEmailID));

							$this->Email->subject = strtoupper($selectedType)." ". " Customer Assessment Payement ";

							$this->Email->template = 'registration';

							$this->Email->sendAs = 'html';

							$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

							$this->Email->delivery = 'smtp';

							$mesage = " Your payment detail has been submitted successfully , please wait for approval.!!";
							
							$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
				
							$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
							
							$this->Email->send($mesage);
							
							$this->Email->to = array();
				
							$this->Email->bcc =  array();

							//==*****************End****************************************==//


                            $this->Session->setFlash(' Your payment details has been submitted successfully , please wait for approval.!! ', 'success');

                            $this->redirect(array('controller'=>'vehicles','action'=>'viewassessment'));                            
							
							}					
					
					  }				
				
				   
				}
			
			}else{
			
				$this->Session->setFlash(' Invalid Assessment Number ');
				
                $this->redirect(array('controller'=>'vehicles','action'=>'viewassessment'));                            
                           
			}
				
				$this->layout = 'userprofile';

                $this->set('title_for_layout', ' Assessment Payment');

                $this->set('assessmentNo', $assessmentNo);

                $this->set('AssessmentVehicleMaster', $AssessmentVehicleMaster);

                $this->loadModel('ParameterType');

                $this->loadModel('Bank');

                $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));

                $this->set('ASSUSRVRF', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'ASSUSRVRF%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));					
		
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
		
		
		
	}
	
	public  function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 
	 
	 /*
	 
    public function index($assessmentNo = null) {


        try {
		
			$nu_company_id = $this->Session->read('nu_company_id');
			
			$this->Set('nu_company_id',$nu_company_id);

            $this->loadModel('AssessmentVehicleMaster');
			$this->loadModel('DocumentUploadVehicle');
			

            // Let's remove the hasMany...
            $this->AssessmentVehicleMaster->unbindModel(
                    array('hasMany' => array('AssessmentVehicleDetail'))
            );

            $AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('first', array('conditions' => array('AssessmentVehicleMaster.vc_assessment_no' => base64_decode(trim($assessmentNo)),
			'AssessmentVehicleMaster.vc_payment_status'=>'STSTY01'
			)));


            if ($assessmentNo != null && $AssessmentVehicleMaster) {


                if (!empty($this->data) && $this->RequestHandler->isPost()) {

                    $this->Payment->create(false);
                    $this->Payment->set($this->data);
					
					//echo 'er---'.$erro= $this->DocumentUploadVehicle->validates(array('fieldList' => $setValidatesDocUpd));
					//die;
					$saveData=array();
					if ($this->Payment->validates()) {

                        $saveData['AssessmentVehicleMaster']['vc_bank_struct_code'] = $this->data['Payment']['vc_bank_struct_code'];

                        $saveData['AssessmentVehicleMaster']['vc_payment_status'] = 'STSTY03';
						
                        $saveData['AssessmentVehicleMaster']['nu_company_id'] = $nu_company_id;
						
						$saveData['AssessmentVehicleMaster']['vc_mdc_paid'] = (float) trim($this->data['Payment']['vc_mdc_paid']);

                        $saveData['AssessmentVehicleMaster']['vc_payment_reference_no'] = $this->data['Payment']['vc_payment_reference_no'];

                        $saveData['AssessmentVehicleMaster']['vc_assessment_no'] = base64_decode(trim($assessmentNo));

                        $this->AssessmentVehicleMaster->create();

                        $this->AssessmentVehicleMaster->set($this->data);

                        if ($this->AssessmentVehicleMaster->save($saveData)) {

                            $vc_customer_no = $this->Session->read('Auth.Member.vc_username');

                            $fileName = trim($vc_customer_no);

                            $dir = WWW_ROOT ."uploadfile" . DS . "$fileName" . DS .'Payment';

                            if (!file_exists($dir)) {

                                mkdir($dir, 0777, true);
                            }

                            //==** ***** Upload Assessment related Payment related Docs  ************* *==//


                            $docUpload['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

                            $docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                            $docUpload['vc_vehicle_assess_no'] = base64_decode(trim($assessmentNo));
							
                            $docUpload['nu_company_id'] = $nu_company_id;

                            $docUpload['vc_upload_vehicle_id'] = $this->DocumentUploadVehicle->getPrimaryKey();

                            $docUpload['vc_uploaded_doc_path'] = $dir;

                            $filename = $this->data['Payment']['vc_uploaded_doc_name']['name'];

                            if (file_exists($dir . DS . $filename)) {

                                $filename = date('YmdHis') . '-' . $filename;
                            }

                            $docUpload['vc_uploaded_doc_name'] = $filename;

                            $docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

                            $this->DocumentUploadVehicle->validate = null;

                            $this->DocumentUploadVehicle->create();

                            $this->DocumentUploadVehicle->set($docUpload);

                            $this->DocumentUploadVehicle->save();

                                move_uploaded_file($this->data['Payment']['vc_uploaded_doc_name']["tmp_name"], $dir . DS . $filename);


                                //===*********** Email Send To Customer ***************** *==///
								

                                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                                $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
								
								$this->Email->bcc = array(trim($this->AdminMdcEmailID));

                                $this->Email->subject = strtoupper($selectedType)." ". " Customer Assessment Payement ";

                                $this->Email->template = 'registration';

                                $this->Email->sendAs = 'html';

                                $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                                $this->Email->delivery = 'smtp';

                                $mesage = " Your payment detail has been submitted successfully , please wait for approval.!!";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
								
                                $this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();

                                //==*****************End****************************************==//
								
                                $this->data = null;

                                $this->Session->setFlash(' Your payment details has been submitted successfully , please wait for approval.!! ', 'success');

                                $this->redirect($this->referer());
                            
                       
						} else {

                            $this->data = null;
                            $this->Session->setFlash(' Your payment details has not submitted please try again ', 'error');
                            $this->redirect($this->referer());
                        }
                    }
                }

                $this->layout = 'userprofile';

                $this->set('title_for_layout', ' Assessment Payment');

                $this->set('assessmentNo', $assessmentNo);

                $this->set('AssessmentVehicleMaster', $AssessmentVehicleMaster);

                $this->loadModel('ParameterType');

                $this->loadModel('Bank');

                $this->set('banks', array('' => ' Select ') + $this->Bank->find('list', array('fields' => array('vc_struct_code', 'vc_description'))));

                $this->set('ASSUSRVRF', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'ASSUSRVRF%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
            } else {


                $this->Session->setFlash(' Invalid Assessment Number ');
				
                $this->redirect($this->referer());
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }
	*/

}