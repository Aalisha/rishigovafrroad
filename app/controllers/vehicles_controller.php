<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class VehiclesController extends AppController {

    /**
     *
     *
     */
	 
    var $name = 'Vehicles';

    /**
     *
     *
     */
    var $components = array('Session','Auth','RequestHandler','Email','Cbccardvehiclepdfcreator','Assessmentreportpdfcreator');

    /**
     *
     *
     */
    var $helpers = array('Session', 'Html','Form','Number','Deletelastlog');

    /**
     *
     *
     */
    var $uses = array('Profile',
        'ParameterType',
        'Vehicle',
        'VehicleHeader',
        'VehicleDetail',
        'VehicleAmendment',
        'DocumentUpload',
        'CustomerAmendment',
        'Vehicle',
		'VehicleHeader',		
		'VehicleAmendment',
		'DocumentUploadCbc',
		'ActivationDeactivationVehicle', 
		'Customer',
		'Member',
		'AddVehicle', 
		'VehicleLogCbc', 
		'Company', 
		'VehicleLogDetail', 		
		'DocumentUploadVehicle');

    /**
     *
     * Default Running Function Controller
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
		    if ($this->Session->read('Auth.Profile.ch_active') != 'STSTY04') {
			$this->redirect(array('controller' => 'inspectors', 'action' => 'index'));
        }}
		
		$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');		
		$ch_active = $this->Session->read('Auth.Profile.ch_active');
		$vc_mdc_customer_no = $this->Session->read('Auth.Member.vc_mdc_customer_no');
		$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
		$vc_username = $this->Session->read('Auth.Member.vc_username');
		//pr($this->Session->read('Auth.Customer'));
		$cbc_ch_active = $this->Session->read('Auth.Customer.ch_active');

		
		if($vc_username!='' && $ch_active=='STSTY04' && $this->mdc==$vc_comp_code && $vc_mdc_customer_no!='')	
		$this->Auth->allow('companysubmit','ownershipchangedetail','index','edit','cronpdfattachment','viewlogdetail',
		'editlogdetail','ownershipchange','addlogdetail','addvehicle','getTransferCustomerDetail','getselectvehicledetails',
		'gettabledata','gettableassessment','view','transfer','getCustomerTransferDetail','getvehiclelogdetails',
		'viewassessment','loginRightCheck','getVehicleTransferDetail','gettransferaddress','getVehicleDetail',
		'addassessment','addfileupload','rrmdir','getVehicleStartOM','getVehicleCheck','getVehicleMainCheck','showassessmentdetail','getMdcNotice','getMdcRfrLetter','downloadPrintReceipt','downloadPayProof','getvehicleremarksbyid','getassessmentremarksbyid','changedetail','getdistanceselectedlocationto','calculatedistancelocation','calculatedistancelocationother','getoriginlocation','getdestinationlocation','vehicletransferlist','deletelogs','getcustomerdetailbysearch','download','deleteajaxfile','downloadammned','deletedoc');

		elseif($this->cbc!=$vc_comp_code)
		$this->Auth->allow('cronpdfattachment');	
		elseif($vc_username!='' && $cbc_ch_active == 'STSTY04' && $this->cbc==$vc_comp_code && $vc_cbc_customer_no!='')	
		$this->Auth->allow('cbc_vehiclesreg','cbc_vehiclesview','cbc_editvehicle','cbc_add_rowintbl','cbc_addfileupload','cbc_getVehicleCheck','cbc_activationdeactivation','cbc_vehicle_list_pdf','addfileupload');
		else
		$this->Auth->allow('cronpdfattachment');
			
			
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
			//pr($this->Auth->allowedActions);die;
        if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {

             $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        }
    }
	
	function companysubmit(){
	
		if(isset($this->data['VehicleDetail']['nu_company_id']) && $this->data['VehicleDetail']['nu_company_id']!=''){
		
		$nu_company_id = $this->data['VehicleDetail']['nu_company_id'];
		$this->Session->write('nu_company_id',$nu_company_id );	
		
		}else{	
		
		$nu_company_id = $this->Session->read('nu_company_id');// session
		
		}
		
		$this->redirect($this->referer());
	}
	


	function cronpdfattachment($assessmentno){
		
		//$this->downloadPrintReceipt('CM1-ASS-1','1');
			$this->layout = 'pdf';
			    
			$this->loadModel('AssessmentVehicleMaster');
			$cron=1;
			if($cron==1){			
				$this->set('cron',$cron);
			}	
			//$assessmentno=	'CM1-ASS-1';
			$AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('first', array('conditions' => array('AssessmentVehicleMaster.vc_assessment_no' => trim($assessmentno))));
			$this->set('AssessmentVehicleMaster' , $AssessmentVehicleMaster);	
				
			$this->render('download_print_receipt');
				

			
		}
		
		
	 function cbc_vehiclesreg() {
	 
		set_time_limit(0);
		$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
		
		$this->layout = 'cbc_layout';
		
		$this->loadModel('AddVehicle');
		
		$this->loadModel('VehicleDocumentUploadCbc');
		
		$this->set('CustType', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'V00%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));
		
		$this->set('vehtype', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => '0400000000%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
		
		$this->set('vehtype1', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'A000%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));
		
		$this->set('vehtype3', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'M00%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));

		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$vc_username = $this->Session->read('Auth.Customer.vc_username');

		$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');
        

		if (isset($this->data) && !empty($this->data) && $this->RequestHandler->isPost()) {
		
			
			$filepath = trim($this->Session->read('Auth.Customer.vc_username'));
            
            foreach ($this->data['AddVehicle'] as $key => &$value) {

                    $value['DocumentUploadVehicle'] = $this->data['DocumentUploadVehicle'][$key];

                    unset($this->data['DocumentUploadVehicle'][$key]);
			}

			unset($value);

			unset($this->data['DocumentUploadVehicle']);
			
			$isDone = false;

            foreach ($this->data['AddVehicle'] as $value) {
				
				$count = $this->AddVehicle->find('count',array(
														'conditions'=>array(
															'LOWER(AddVehicle.vc_reg_no)'=>trim(strtolower($value['vc_reg_no']))
														)));
				if( $count ==  0  ) :				
					
					$isDone = true;
					
					$vehId = $this->AddVehicle->getPrimaryKey();

					$value['dt_created'] = date('Y-m-d H:i:s');

					$value['vc_status'] = 'STSTY03';

					$value['vc_cust_no'] = $this->Session->read('Auth.Customer.vc_cust_no');
					
					$value['vc_user_no'] = $this->Session->read('Auth.Customer.vc_user_no');

					$value['vc_comp_code'] = $this->Session->read('Auth.Customer.vc_comp_code');

					$value['vc_reg_no'] = trim($value['vc_reg_no']);

					$value['nu_vehicle_id'] = $vehId;

					$dir = WWW_ROOT."uploadfile" . DS . "$filepath" . DS. 'Vehicle'. DS . trim($value['vc_reg_no']);

					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
					}

					$this->AddVehicle->create();

					$this->AddVehicle->set($value);       
					
					$this->AddVehicle->save($value, false);
					

					foreach ($value['DocumentUploadVehicle'] as $docUpload) {
						
						$docUpload['vc_cust_no'] = $this->Session->read('Auth.Customer.vc_first_name');

						$docUpload['vc_comp_code'] = $this->Session->read('Auth.Customer.vc_comp_code');

						$docUpload['nu_upload_vehicle_id'] = $this->VehicleDocumentUploadCbc->getPrimaryKey();

						$docUpload['vc_cust_no'] = $this->Session->read('Auth.Customer.vc_cust_no');
						
						$docUpload['vc_user_no'] = $this->Session->read('Auth.Customer.vc_user_no');

						$docUpload['nu_vehicle_id'] = $vehId;
						
						$docUpload['vc_status']     = 'STSTY01';
						
						$docUpload['vc_uploaded_doc_path'] = $dir;
						
						$filename = trim(base64_decode($docUpload['newfile']));
											
						$docUpload['vc_upload_doc_name'] = $filename;

						$docUpload['vc_upload_doc_for'] = $this->globalParameterarray['DOCUPLOAD02'];

						$docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

						$this->VehicleDocumentUploadCbc->validate = null;

						$this->VehicleDocumentUploadCbc->create();

						$this->VehicleDocumentUploadCbc->set($docUpload);

						if(rename(trim(base64_decode($docUpload['fpath'])).DS.$filename ,$dir.DS.$filename)) {
							
							$this->VehicleDocumentUploadCbc->save($docUpload, false);

						}else{
						
							$this->Session->setFlash("File not uploaded successfully !!",'error');
							
							$this->redirect($this->referer());	

						}							
					
						unset($docUpload);
						
					}
					
					unset($value);
			
				else :

					$this->data = null;
					
					$this->Session->setFlash('You have already registered this vehicle !!','error');
				
				endif;
				
            }
			
			if($isDone):
					
				
					/**********Email Shoot ***************** */

			
					list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

					$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
					
					$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
					
					$this->Email->bcc = array(trim($this->AdminCbcEmailID));

					$this->Email->subject = strtoupper($selectedType)." "." Vehicle registration ";

					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

					$this->Email->delivery = 'smtp';

					$mesage = "Your Vehicle has been added successfully, pending for approval from RFA !!";
					
					$mesage .= "<br> <br> Username : ".trim($vc_username);
					
					$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
					
					$this->Email->send($mesage);
					
					$this->Email->to = array();
					
					$this->Email->bcc =  array();
					
					
					/**********Email Shoot at alternative email id***************** */
					
					if(isset($vc_alter_email) && !empty($vc_alter_email)) {
					
					list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

					$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';
					
					$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

					$this->Email->subject = strtoupper($selectedType)." "." Vehicle registration ";

					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

					$this->Email->delivery = 'smtp';

					$mesage = "Your Vehicle has been added successfully, pending for approval from RFA !!";
					
					$mesage .= "<br> <br> Username : ".trim($vc_username);
					
					$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
					
					$this->Email->send($mesage);

					}

					/******************Email Send To Admin************************** */
	
					/* 
					$this->Email->from = ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))) . '<' . trim($this->Session->read('Auth.Customer.vc_email')) . '>';

					$this->Email->to = $this->AdminEmailID;

					$this->Email->subject = strtoupper($selectedType)." "."Vehicle registration";

					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', $this->AdminName);

					$this->Email->delivery = 'smtp';

					$mesage =  "A new request for Vehicle Approval  from a CBC customer(" . ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))).")."; 

					$this->Email->send($mesage); */


					/*********************************************/
					$this->data = null;

					$this->Session->setFlash('Your Vehicle has been added successfully, pending for approval from RFA !!', 'success');
			
					$this->redirect($this->referer());
				
			endif;
	     
		}
	}
	
	/*
	*
    *
    *
    */
	 
    function cbc_vehiclesview() {
		$this->layout = 'cbc_layout';
		
		$no_of_rows = 10;

		
		if (isset($this->params['named']['page'])) :

			$pageno = trim($this->params['named']['page']);

		else :

			$pageno = 1;
			
		endif;

		$start = ((($pageno-1) * $no_of_rows) + 1);

		$this->set('start',$start);

		$this->paginate = array(
                'conditions' => array('AddVehicle.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no')),
                'order' => array('AddVehicle.dt_created'=>'desc'),
                'limit' => $no_of_rows
            );
			
		$list= $this->paginate('AddVehicle');

		$this->set('list', $list);
        
    }
	
	
	/**
	*
	*
	*
	*
	*/
	
	function cbc_editvehicle($id = null){
		    set_time_limit(0);
		$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$this->loadModel('VehicleDocumentUploadCbc');
		
		$id=(int)base64_decode($id);
		
		if(isset($id) && $id!='' )
		
		$this->set('id',$id);
		
	    try {
		    if(isset($this->data['AddVehicle']['id']) && !empty($this->data['AddVehicle']['id']))
			$id= $this->data['AddVehicle']['id'];	
			
            $sqlResult = $this->AddVehicle->find('first', array('conditions' => array('AddVehicle.nu_vehicle_id' => $id,
			'AddVehicle.vc_cust_no'=>$vc_cust_no
			)));
			
		
			if ($sqlResult) {

                if (!empty($this->data) && $this->RequestHandler->isPost()) {
				//pr($this->data);
		            $filepath = trim($this->Session->read('Auth.Customer.vc_username'));
					
		
					$vc_username = $this->Session->read('Auth.Customer.vc_username');
					
					/********* Firstly Delete old File and Entry From Database ************ */

                    $this->VehicleDocumentUploadCbc->deleteAll(array('VehicleDocumentUploadCbc.nu_vehicle_id' => $sqlResult['AddVehicle']['nu_vehicle_id']));

                    $dir = WWW_ROOT."uploadfile" . DS . "$filepath" . DS .'Vehicle'. DS . trim($sqlResult['AddVehicle']['vc_reg_no']);
					  
                    if (file_exists($dir)) {

                        $this->rrmdir($dir);
                    }

                    /****************** End ************************************* */
	
					
                    /** * *******Set File Upload Data According with Vehicle********** */
					
                    foreach ($this->data['AddVehicle'] as $key => &$value) {

                        $value['DocumentUploadVehicle'] = $this->data['DocumentUploadVehicle'][$key];

                        unset($this->data['DocumentUploadVehicle'][$key]);
                    }
					
					
                    unset($this->data['DocumentUploadVehicle']);
					
					
					/*******************End****************************** */

                    /*** Save data in detail Table******************** */
						
                    foreach ($this->data['AddVehicle'] as $value) {

                        $this->AddVehicle->validate = null;

                        $this->AddVehicle->id = $id;

                        $value['dt_mod_date'] = date('Y-m-d H:i:s');

                        $value['vc_status'] = 'STSTY03';
						
                        $this->AddVehicle->set($value);
						
						$this->AddVehicle->save($value, false);
						
                        /******* Upload Docs ******* */
						 $dir = WWW_ROOT."uploadfile" . DS . "$filepath" . DS .'Vehicle'. DS . trim($value['vc_reg_no']);
						 
                        if (!file_exists($dir)) {

                            mkdir($dir, 0777, true);
                        }
						$i=0;
						
						foreach ($value['DocumentUploadVehicle'] as $docUpload) {
							$i++;
							$docUpload['vc_cust_no'] = $this->Session->read('Auth.Customer.vc_first_name');

							$docUpload['vc_comp_code'] = $this->Session->read('Auth.Customer.vc_comp_code');

							$docUpload['nu_upload_vehicle_id'] = $this->VehicleDocumentUploadCbc->getPrimaryKey();

							$docUpload['vc_cust_no'] = $this->Session->read('Auth.Customer.vc_cust_no');

							$docUpload['nu_vehicle_id'] = $id;

							$docUpload['vc_uploaded_doc_path'] = $dir;
							$serverfile = base64_decode($docUpload['newfile']);

							$filename = trim(base64_decode($docUpload['newfile']));
							
							if($filename!='')
							$filename = $i.'-'.$this->renameUploadFile($filename);

							
							$docUpload['vc_upload_doc_name'] = $filename;
							
							$docUpload['vc_status'] = 'STSTY01';

							//$docUpload['vc_upload_doc_for'] = $this->globalParameterarray['DOCUPLOAD02'];

							$docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

							$this->VehicleDocumentUploadCbc->validate = null;

							$this->VehicleDocumentUploadCbc->create();

							$this->VehicleDocumentUploadCbc->set($docUpload);
						
							$this->VehicleDocumentUploadCbc->save($docUpload, false);
							
		
							rename(trim(base64_decode($docUpload['fpath'])) . DS .$serverfile , $dir . DS . $filename);
							
							
							unset($docUpload);
							
						}
						
						/*********************End*****************/
						
						unset($value);
                    
					}	
						/*********** Email Send To Customer ***************** */
					
						list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

						$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

						$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
						
						$this->Email->bcc = array(trim($this->AdminCbcEmailID));

						$this->Email->subject = strtoupper($selectedType)." "."Updated Vehicle Registration ";

						$this->Email->template = 'registration';

						$this->Email->sendAs = 'html';

						$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

						$this->Email->delivery = 'smtp';

						$mesage = "Your Vehicle has been updated successfully, pending for approval from RFA !!";
						
						$mesage .= "<br> <br> Username : ".trim($vc_username);
					
						$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
						
						$this->Email->send($mesage);
						
						$this->Email->to = array();
					
						$this->Email->bcc =  array();
						
						
						/*********** Email Send at alternative email id ***************** */
						
						
						if(isset($vc_alter_email) && !empty($vc_alter_email)) {
					
						list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

						$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

						$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

						$this->Email->subject = strtoupper($selectedType)." "."Updated Vehicle Registration ";

						$this->Email->template = 'registration';

						$this->Email->sendAs = 'html';

						$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

						$this->Email->delivery = 'smtp';

						$mesage = "Your Vehicle has been updated successfully, pending for approval from RFA !!";
						
						$mesage .= "<br> <br> Username : ".trim($vc_username);
					
						$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
						
						$this->Email->send($mesage);

						}
						/****************** Email Send To Admin************************** */

						/*  */


						$this->data = null;

						/**************** End **************************** */

						$this->Session->setFlash('Your Vehicle has been updated successfully and pending for approval from RFA !!', 'success');
									
						$this->data = null;
						
						$this->redirect(array('controller' => 'vehicles', 'action' => 'vehiclesview', 'cbc' => true));
                
				}

                $this->layout = 'cbc_layout';

                $this->set('title_for_layout', 'Vehicle Registration');

				$this->set('CustType', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'V00%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));

				$this->set('vehtype', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => '0400000000%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

				$this->set('vehtype1', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'A000%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));

				$this->set('vehtype3', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'M00%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));

				
				$this->set('edit',  $sqlResult);
				
		    } else {

                $this->Session->setFlash(' Invalid Vehicle Registration Id', 'info');

                $this->redirect($this->referer());
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
	
     function cbc_add_rowintbl() {
	
			if($this->params['isAjax']) :
				
				$this->set('rowCount', (int)$this->params['data']);
				
			else :
			
				$this->set( 'rowCount', 0 );
			
			endif;
  
            $this->layout = null;

			$this->loadModel('AddVehicle');

			$this->loadModel('DocumentUploadVehicle');


		$this->set('CustType', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'V00%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));

		$this->set('vehtype', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => '0400000000%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

		$this->set('vehtype1', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'A000%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));

		$this->set('vehtype3', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'M00%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'), 'order' => array('ParameterType.vc_prtype_name' => 'asc'))));
    
    }
	
	/**
	*
	*
	*
	*/
	
    function cbc_addfileupload() {

            if ($this->params['isAjax']) {

            $this->layout = null;


            if (isset($this->params['form']['countRow'])) {

                $this->set('rowCount', (int) $this->params['form']['countRow']);

                $this->set('row', (int) $this->params['form']['row']);
            
			} else {

                $this->set('rowCount', 0);

                $this->set('row', 0);
            }
        }
    }
	
	
	/*
	**
	** To check unique vehicle registration number
	**
	**
	*/
	
	
	function cbc_getVehicleCheck($vehicle = null, $id = null) {
		
        if ($this->params['isAjax']) {

            $vehicle = strtolower(trim($this->params['data']));
			
			if(isset($this->params['form']['id']) && $this->params['form']['id']>0)
			$id = $this->params['form']['id'];		
		
			$conditions = array('LOWER(AddVehicle.vc_reg_no)' => $vehicle);
			
			if($id != '' ){
				
				$conditions += array('AddVehicle.nu_vehicle_id !='=>$id);
			
			}
		
		$count = $this->AddVehicle->find('count', array('conditions' =>$conditions ));
      
		if ($count == 0) {

            echo true;
			
        } else {

            echo false;
        }
        exit;
		
    }

    }

    /**
     *
     *Function for activation/deactivation of vehicles
     *
     */
	 
    function cbc_activationdeactivation() {

		$this->loadModel('ActivationDeactivationVehicle');
		
		$this->layout = 'cbc_layout';

		$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
		
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$vc_username = $this->Session->read('Auth.Customer.vc_username');

        if (!empty($this->data) && $this->RequestHandler->isPost()) {

			$isDone = false;
		  
			foreach ( $this->data['Vehicle'] as  $values   ) :
				
				if(  isset($values['vc_status']) && !empty($values['vc_status'])  ):
					
					$result = $this->ActivationDeactivationVehicle->find('first', array(
												'conditions' => array(
															'ActivationDeactivationVehicle.nu_vehicle_id' => $values['nu_vehicle_id'])));
					if( $result ) :
					
									
						$this->data['ActivationDeactivationVehicle']['nu_vehicle_id'] = $this->ActivationDeactivationVehicle->getPrimaryKey();

						$this->data['VehicleLogCbc']['nu_vehicle_log_id'] = $this->VehicleLogCbc->getPrimaryKey();

                        $this->VehicleLogCbc->create();
						
                        @$resultReturn = array(
                            'VehicleLogCbc' => array(
                                'nu_vehicle_log_id' =>$this->VehicleLogCbc->getPrimaryKey(),
                                'vc_comp_code' => $result['ActivationDeactivationVehicle']['vc_comp_code'],
                                'vc_default_comp' => $result['ActivationDeactivationVehicle']['vc_default_comp'],
                                'vc_veh_type' => $result['ActivationDeactivationVehicle']['vc_veh_type'],
                                'vc_cust_no' => $result['ActivationDeactivationVehicle']['vc_cust_no'],
                                'vc_user_no' => $result['ActivationDeactivationVehicle']['vc_user_no'],
                                'vc_vehicle_sr_no' => $result['ActivationDeactivationVehicle']['vc_vehicle_sr_no'],
                                'vc_type_no' => $result['ActivationDeactivationVehicle']['vc_type_no'],
                                'vc_reg_no' => $result['ActivationDeactivationVehicle']['vc_reg_no'],
                                'vc_make' => $result['ActivationDeactivationVehicle']['vc_make'],
                                'vc_axle_type' => $result['ActivationDeactivationVehicle']['vc_axle_type'],
                                'vc_series_name' => $result['ActivationDeactivationVehicle']['vc_series_name'],
                                'vc_engine_no' => $result['ActivationDeactivationVehicle']['vc_engine_no'],
                                'vc_chasis_no' => $result['ActivationDeactivationVehicle']['vc_chasis_no'],
                                'vc_vin_vehcile_no' => $result['ActivationDeactivationVehicle']['vc_vin_vehcile_no'],
                                'nu_d_rating' => $result['ActivationDeactivationVehicle']['nu_d_rating'],
                                'nu_v_rating' => $result['ActivationDeactivationVehicle']['nu_v_rating'],
                                'vc_entry_user' => $result['ActivationDeactivationVehicle']['vc_entry_user'],
                                'dt_mod_date' => $result['ActivationDeactivationVehicle']['dt_mod_date'],
                                'dt_created' => $result['ActivationDeactivationVehicle']['dt_created'],
                                'vc_status' => 'STSTY02',
                                'vc_del_by' => $result['ActivationDeactivationVehicle']['vc_del_by'],
                                'dt_del_date' => date('d-M-Y'),
								'dt_deactivated' => date('d-M-Y')
                            )
                        );
						
						$this->VehicleLogCbc->set($resultReturn);
						$isDone = true;
						
                        if ($this->VehicleLogCbc->save($resultReturn)) {
							                          
							$this->ActivationDeactivationVehicle->delete($values['nu_vehicle_id']);
							
                        }
					
					
					endif;
					
				endif;
			
			endforeach;
		 
			
			if($isDone):
			
				/************************* Sending Email To User *************************/
				
				list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
				
				$this->Email->from =$this->AdminName . '<' . $this->AdminEmailID . '>';

				$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
				
				$this->Email->bcc = array(trim($this->AdminCbcEmailID));

				$this->Email->subject = strtoupper($selectedType)." "." Deactivation of Vehicle";

				$this->Email->template = 'registration';

				$this->Email->sendAs = 'html';

				$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

				$this->Email->delivery = 'smtp';

				$message = ' Your vehicle has been deactivated successfully !!';
				
				$message .= "<br> <br> Username : ".trim($vc_username);
					
				$message .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
				
				$this->Email->send($message);
				
				$this->Email->to = array();
					
				$this->Email->bcc =  array();
				
				/************************* Sending Email at alternative email id *************************/
				
				if(isset($vc_alter_email) && !empty($vc_alter_email)) {
				
				list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
				
				$this->Email->from =$this->AdminName . '<' . $this->AdminEmailID . '>';

				$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

				$this->Email->subject = strtoupper($selectedType)." "."Deactivation of Vehicle";

				$this->Email->template = 'registration';

				$this->Email->sendAs = 'html';

				$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

				$this->Email->delivery = 'smtp';

				$message = ' Your vehicle has been deactivated successfully !!';
				
				$message .= "<br> <br> Username : ".trim($vc_username);
					
				$message .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);

				$this->Email->send($message);
				}
				
				/************************** Send Email To Admin ******************************/

				/* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))) . '<' . trim($this->Session->read('Auth.Customer.vc_email')) . '>';

				$this->Email->to = trim($this->AdminEmailID);

				$this->Email->subject =  strtoupper($selectedType)." ".'Deactivation of Vehicle';

				$this->Email->template = 'registration';

				$this->Email->sendAs = 'html';

				$this->set('name',$this->AdminName);

				$this->Email->delivery = 'smtp';

				$message = " A new request for vehicle deactivation from a CBC customer(" . ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))).").";

				$this->Email->send($message); */
				
				/************************** End Email *******************************/

				$this->Session->setFlash('Your Vehicle has been deactivated successfully !!','success');

				$this->redirect($this->referer());
		
			
			endif;
							
				
        }  // for isset data

		$this->set('total_vehicles', $this->ActivationDeactivationVehicle->find('count', array(
				'conditions' => array('ActivationDeactivationVehicle.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
				'ActivationDeactivationVehicle.vc_status' => 'STSTY04'))));

		$this->paginate = array(
			'conditions' => array('ActivationDeactivationVehicle.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
			'ActivationDeactivationVehicle.vc_status' => 'STSTY04'),
			'limit' => 10
		);

		$this->set('vehicle', $this->paginate('ActivationDeactivationVehicle'));
	
    }
    /**
     *
     *Function to generate pdf for vehicles list
     *
     */
	
	function cbc_vehicle_list_pdf() {

        $this->loadModel('ActivationDeactivationVehicle');
		
		$records = $this->ActivationDeactivationVehicle->find('all', array(
            'conditions' => array('ActivationDeactivationVehicle.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
                'ActivationDeactivationVehicle.vc_status' => 'STSTY04')));

        $total_vehicles = count($records);

        $this->set('total_vehicles', $total_vehicles);

        $this->set('records', $records);
		
		$columnsValues= array('SI.No.','Vehicle Reg. No.',
			'Vehicle Chassis No.',
			'Vehicle Type',
			'Current Status'
		);
		$this->Cbccardvehiclepdfcreator->headerData('Vehicle List', $period = NULL,$this->Session->read('Auth')) ;
		$this->Cbccardvehiclepdfcreator->generate_vehicle_list_pdf($columnsValues,$total_vehicles,$records,$this->globalParameterarray,$this->Session->read('Auth.Customer'));
			$vc_customer_no = $this->Session->read('Auth.Customer.vc_cust_no');

		
		$this->Cbccardvehiclepdfcreator->output($vc_customer_no.'-Vehicle-List'.'.pdf', 'D');
		
		//$this->layout = 'pdf';
    }
	
	
	 

    /**
     *
     *
     */
    function index() {

        try {
		
			$nu_company_id = $this->Session->read('nu_company_id');
			$this->Set('nu_company_id',$nu_company_id);
            if (!empty($this->data) && $this->RequestHandler->isPost()) {
					
				/**********Set File Upload Data According with Vehicle ********** */

                foreach ($this->data['VehicleDetail'] as $key => &$value) {

                    $value['DocumentUploadVehicle'] = $this->data['DocumentUploadVehicle'][$key];

                    unset($this->data['DocumentUploadVehicle'][$key]);
                }

                unset($value);

                unset($this->data['DocumentUploadVehicle']);
				
										
				/********************End****************************** */

                $hdregId = $this->VehicleHeader->getPrimaryKey();

                $this->data['VehicleHeader'] = $this->Session->read('Auth.Profile');

                $this->data['VehicleHeader']['vc_registration_no'] = $hdregId;

                $this->data['VehicleHeader']['dt_account_opened_date'] = date('Y-m-d H:i:s', strtotime($this->Session->read('Auth.Profile.dt_account_create_date')));

                $this->data['VehicleHeader']['dt_created_date'] = date('Y-m-d H:i:s');

                $duplicateVehiclieList = array();

                if ($this->VehicleHeader->save($this->data['VehicleHeader'], false)) {

                    /******** Save data in detail Table ************/
					
					ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
					
                    foreach ($this->data['VehicleDetail'] as $value) {


                        $dtregId = $this->VehicleDetail->getPrimaryKey();

                        $value['dt_created_date'] = date('Y-m-d H:i:s');

                        $value['vc_vehicle_status'] = 'STSTY03';

                        $value['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

                        $value['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                        $value['vc_registration_no'] = $hdregId;

                        $value['vc_vehicle_lic_no'] = trim($value['vc_vehicle_lic_no']);

                        $value['vc_vehicle_reg_no'] = trim($value['vc_vehicle_reg_no']);

                        $value['vc_registration_detail_id'] = $dtregId;
                        $value['nu_company_id'] = $nu_company_id;


                        $countCheck = $this->VehicleDetail->find('count', array('conditions' => array('OR' => array(
                                    'VehicleDetail.vc_vehicle_lic_no' => trim($value['vc_vehicle_lic_no']),
                                    'VehicleDetail.vc_vehicle_reg_no' => trim($value['vc_vehicle_lic_no']),
                                    'VehicleDetail.vc_vehicle_lic_no' => trim($value['vc_vehicle_reg_no']),
                                    'VehicleDetail.vc_vehicle_reg_no' => trim($value['vc_vehicle_reg_no'])
                            ))));
							
                        if ($countCheck == 0) {

                            $this->VehicleDetail->create();

                            $this->VehicleDetail->set($value);

                            $this->VehicleDetail->save($value, false);

                            /*  * ***** Upload Docs ******* */

                            $filepath = trim($this->Session->read('Auth.Member.vc_username'));

                            $dir = WWW_ROOT . "uploadfile" . DS . "$filepath" . DS . 'Vehicle' . DS . trim($value['vc_vehicle_lic_no']);
                           
							
                            if (!file_exists($dir) && count($value['DocumentUploadVehicle'])>0 ) {

                                mkdir($dir, 0777, true);
                            }
							$cntuploadfiles=1;
                            foreach ($value['DocumentUploadVehicle']  as $key => $docUpload) {

                                $docUpload['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

                                $docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                                $docUpload['vc_registration_detail_id'] = $dtregId;
                                $docUpload['nu_company_id'] = $nu_company_id;

                                $docUpload['vc_upload_vehicle_id'] = $this->DocumentUploadVehicle->getPrimaryKey();

                                $docUpload['vc_uploaded_doc_path'] = $dir;

                                $filename = base64_decode(trim($docUpload['newfile']));
								
								$newfile = $cntuploadfiles.'-'.$this->renameUploadFile($filename);

								$docUpload['vc_uploaded_doc_name'] = $newfile;

                                //$docUpload['vc_uploaded_doc_type'] = base64_decode(trim($docUpload['type']));
								//echo filetype(trim($docUpload['fpath']). DS . $filename);
							//	pr($docUpload);
								//die;
								
                                $docUpload['vc_uploaded_doc_type'] = filetype(trim($docUpload['fpath']). DS . $filename);

                                $docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

                                $this->DocumentUploadVehicle->validate = null;

                                $this->DocumentUploadVehicle->create();

                                $this->DocumentUploadVehicle->set($docUpload);

                                $this->DocumentUploadVehicle->save($docUpload, false);
								
								/***Cut and Paste file from source to destination *********/
								
								rename( base64_decode(trim($docUpload['fpath'])). DS . $filename , $dir.DS.$newfile);
								
                               
                                unset($docUpload);
								$cntuploadfiles++;
                            }
							
                  /************ End *********************/
							
				 /*********** Email Send To Customer ***************** */

							list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

							$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

							$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

							$this->Email->bcc = array(trim($this->AdminMdcEmailID));

							$this->Email->subject = strtoupper($selectedType)." "."Vehicle Registration  ";

							$this->Email->template = 'registration';

							$this->Email->sendAs = 'html';

							$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

							$this->Email->delivery = 'smtp';

							$mesage = " Your Vehicle has been added successfully, pending for approval from RFA !! ";

							$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));

							$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));

							$this->Email->send($mesage);
						
						} 
						
						else {


                            $duplicateVehiclieList[$value['vc_vehicle_lic_no']] = $value['vc_vehicle_reg_no'];

                            continue;
                        }

                        unset($value);
                    }
                                 
                   /* * ************** End **************************** */

                    $this->data = null;

                    if (count($duplicateVehiclieList) > 0) {

                        $this->Session->setFlash('Duplicated Vehicle has been removed and unique added successfully, pending for approval from RFA !!', 'success');
                    } else {

                        $this->Session->setFlash('Your Vehicle has been added successfully, pending for approval from RFA !!', 'success');
                    }

                    $this->redirect($this->referer());
                } else {


                    $this->data = null;

                    $this->Session->setFlash('Vehicle could not be added please try again later !!', 'error');

                    $this->redirect(array('controller' => 'vehicles', 'action' => 'index'));
                }
            }

            $this->layout = 'userprofile';

            $this->set('title_for_layout', 'Vehicle Registration');

            $this->Set('payfrequency', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PAYFREQ%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->Set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $this->Set('status', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'STSTY02%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

            $customerdetails = $this->Session->read('Auth');  
			$this->set('customerdetails', $customerdetails);

			
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
    function ownershipchange() {
	
        try {
		    
			set_time_limit(0);
			
			$vc_cust_type = $this->Session->read('Auth.Profile.vc_cust_type');
			// CUSTYPE01
			$nu_company_id = $this->Session->read('nu_company_id');
			$this->set('nu_company_id',$nu_company_id);
			$vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');

            if (isset($this->data) && !(empty($this->data))) {
			
				//if($vc_cust_type=='CUSTYPE01')
                $setValidates = array('vc_amend_type','vc_new_customer_name','vc_new_cust_no');
				//else
                //$setValidates = array('vc_amend_type','vc_new_customer_name');
				
				$this->CustomerAmendment->set($this->data['CustomerAmendment']);
				$this->DocumentUpload->set($this->data['DocumentUpload']);
				
                $this->unsetValidateVariable($setValidates, array_keys($this->CustomerAmendment->validate), &$this->CustomerAmendment);

                $setValidatesDocUpd = array('vc_uploaded_doc_name');
		
                if ($this->CustomerAmendment->validates(array('fieldList' => $setValidates)) && $this->DocumentUpload->validates(array('fieldList' => $setValidatesDocUpd))) {

                    $this->DocumentUpload->validate = NUll;

                    $this->CustomerAmendment->validate = NUll;

                   $TotalCustAmd = $this->CustomerAmendment->find('count', array(
                        'conditions' => array(
                            'CustomerAmendment.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                            'CustomerAmendment.vc_customer_no' => $vc_customer_no,
                            //'CustomerAmendment.nu_company_id' => $nu_company_id,							
                            )));

                   $CompletedCustAmd = $this->CustomerAmendment->find('count', 
							array('conditions' => array(
							'CustomerAmendment.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                            'CustomerAmendment.vc_customer_no' => $vc_customer_no,                            
							//  'CustomerAmendment.nu_company_id' => $nu_company_id,
							//"(CustomerAmendment.ch_approve='STSTY04' or CustomerAmendment.ch_approve='STSTY05' )",
							 array('OR'=>array(array('CustomerAmendment.ch_approve'=>'STSTY04'),
							 array('CustomerAmendment.ch_approve'=>'STSTY05'))				
							))                          
                            ));
							//die;

                    if (( $TotalCustAmd == 0 ) || ($TotalCustAmd > 0 && ($CompletedCustAmd == $TotalCustAmd))) {

                        $NameChange = False;

                        $OwnerChnage = False;

                        if ($this->data['CustomerAmendment']['vc_amend_type'] == 'CUSTAMDTYP01') :

                            $NameChange = True;

                        elseif ($this->data['CustomerAmendment']['vc_amend_type'] == 'CUSTAMDTYP02') :

                            $OwnerChnage = True;

                        else :

                            $this->data = null;

                            $this->Session->setFlash(' Invalid Customer Amendment Type ', 'info');

                            $this->redirect('ownershipchange');

                        endif;

                        $cust_amnd_no = $this->CustomerAmendment->getPrimaryKey();

                        $this->data['CustomerAmendment']['vc_cust_amend_no'] = $cust_amnd_no;

                        $this->data['CustomerAmendment']['vc_customer_no'] = $vc_customer_no;

                        $this->data['CustomerAmendment']['dt_amend_date'] = date('d-M-y');

                        $this->data['CustomerAmendment']['ch_approve'] = 'STSTY03';

                        $this->data['CustomerAmendment']['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                        $this->data['CustomerAmendment']['vc_amend_type'] = $this->data['CustomerAmendment']['vc_amend_type'];
                        
						$this->data['CustomerAmendment']['nu_company_id'] = $nu_company_id;

						if($this->data['DocumentUpload']['vc_uploaded_doc_name']['name']!='')
                        $this->data['CustomerAmendment']['ch_doc_upload'] = 'Y';
						               

                        if ($NameChange) :

                            $this->data['CustomerAmendment']['vc_customer_id'] = $this->data['CustomerAmendment']['vc_new_cust_no'];

                            $this->data['CustomerAmendment']['vc_customer_name'] = $this->data['CustomerAmendment']['vc_new_customer_name'];

                            $this->data['CustomerAmendment']['vc_customer_no'] = $vc_customer_no;

                            $this->data['CustomerAmendment']['vc_address1'] = $this->Session->read('Auth.Profile.vc_address1');

                            $this->data['CustomerAmendment']['vc_address2'] = $this->Session->read('Auth.Profile.vc_address2');

                            $this->data['CustomerAmendment']['vc_po_box'] = $this->Session->read('Auth.Profile.vc_po_box');
                            
							$this->data['CustomerAmendment']['vc_town'] = $this->Session->read('Auth.Profile.vc_town');

                            $this->data['CustomerAmendment']['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                            $this->data['CustomerAmendment']['vc_tel_no'] = $this->Session->read('Auth.Profile.vc_tel_no');

                            $this->data['CustomerAmendment']['vc_fax_no'] = $this->Session->read('Auth.Profile.vc_fax_no');

                            $this->data['CustomerAmendment']['vc_mobile_no'] = $this->Session->read('Auth.Profile.vc_mobile_no');

                            $this->data['CustomerAmendment']['vc_email_id'] = $this->Session->read('Auth.Profile.vc_email_id');

                        elseif ($OwnerChnage):

                            $this->data['CustomerAmendment']['vc_customer_id'] = $this->data['CustomerAmendment']['vc_new_cust_no'];

                            $this->data['CustomerAmendment']['vc_customer_name'] = $this->data['CustomerAmendment']['vc_new_customer_name'];

                            $this->data['CustomerAmendment']['vc_customer_no'] = $vc_customer_no;
							
							$this->data['CustomerAmendment']['vc_address1'] = $this->Session->read('Auth.Profile.vc_address1');

                            $this->data['CustomerAmendment']['vc_address2'] = $this->Session->read('Auth.Profile.vc_address2');

                            $this->data['CustomerAmendment']['vc_po_box'] = $this->Session->read('Auth.Profile.vc_po_box');
                            
							$this->data['CustomerAmendment']['vc_town'] = $this->Session->read('Auth.Profile.vc_town');

                            $this->data['CustomerAmendment']['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                            $this->data['CustomerAmendment']['vc_tel_no'] = $this->Session->read('Auth.Profile.vc_tel_no');

                            $this->data['CustomerAmendment']['vc_fax_no'] = $this->Session->read('Auth.Profile.vc_fax_no');

                            $this->data['CustomerAmendment']['vc_mobile_no'] = $this->Session->read('Auth.Profile.vc_mobile_no');

                            $this->data['CustomerAmendment']['vc_email_id'] = $this->Session->read('Auth.Profile.vc_email_id');
							

							/*
							$ToProfileDetail = $this->Profile->find('first', array(
                                'conditions' => array(
                                    'Profile.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                                    'Profile.vc_customer_no' => trim($this->data['CustomerAmendment']['vc_new_cust_no']),
                                    )));
							
                            
                            $this->data['CustomerAmendment']['vc_address1'] = $ToProfileDetail['Profile']['vc_address1'];

                            $this->data['CustomerAmendment']['vc_address2'] = $ToProfileDetail['Profile']['vc_address2'];

                            $this->data['CustomerAmendment']['vc_po_box'] = $ToProfileDetail['Profile']['vc_po_box'];

                            $this->data['CustomerAmendment']['vc_tel_no'] = $ToProfileDetail['Profile']['vc_tel_no'];

                            $this->data['CustomerAmendment']['vc_fax_no'] = $ToProfileDetail['Profile']['vc_fax_no'];

                            $this->data['CustomerAmendment']['vc_mobile_no'] = $ToProfileDetail['Profile']['vc_mobile_no'];

                            $this->data['CustomerAmendment']['vc_email_id1'] = $ToProfileDetail['Profile']['vc_email_id'];

                            $this->data['CustomerAmendment']['vc_to_customer_no'] = $this->data['CustomerAmendment']['vc_new_cust_no'];
							*/

                        endif;

                        $AmendmentType = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code' => $this->data['CustomerAmendment']['vc_amend_type']), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                        $this->CustomerAmendment->create();

                        $this->CustomerAmendment->set($this->data['CustomerAmendment']);

						//pr($this->data['CustomerAmendment']);$this->CustomerAmendment->save($this->data['CustomerAmendment']);
						//die;	
                        if ($this->CustomerAmendment->save($this->data['CustomerAmendment'])) {

                            $filepath = trim($this->Session->read('Auth.Profile.vc_customer_no'));

                            $dir = WWW_ROOT."uploadfile".DS."$filepath".DS.'Amendment';

                            if (!file_exists($dir)) {

                                mkdir($dir, 0777, true);
                            }

                            $docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                            $docUpload['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

                            $docUpload['vc_cust_amend_no'] = $cust_amnd_no;

                            $docUpload['vc_upload_id'] = $this->DocumentUpload->getPrimaryKey();

                            $docUpload['vc_uploaded_doc_for'] = current($AmendmentType);
							
                            $docUpload['vc_uploaded_doc_type'] = $this->data['DocumentUpload']['vc_uploaded_doc_name']['type'];

                            $docUpload['vc_uploaded_doc_path'] = $dir;

                            $filename = $this->data['DocumentUpload']['vc_uploaded_doc_name']['name'];
							$newfile = $this->renameUploadFile($filename);

                            if (file_exists($dir . '/' . $newfile)) {

                                $filename = time(). '-' . $newfile;
                            }

                            $docUpload['vc_uploaded_doc_name'] = $newfile;
							
                            $docUpload['nu_company_id']        = $nu_company_id;

                            $docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

                            $this->DocumentUpload->validate = null;

                            $this->DocumentUpload->create();

                            $this->DocumentUpload->set($docUpload);

                            $this->DocumentUpload->save();

                            move_uploaded_file($this->data['DocumentUpload']['vc_uploaded_doc_name']['tmp_name'], $dir . '/' . $newfile);

                            unset($docUpload);
							
							/*******************Email Shoot***************************/

                            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                            $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
							
							$this->Email->bcc = array(trim($this->AdminMdcEmailID));

                           // $this->Email->subject = strtoupper($selectedType)." "."Vehicle Registration  ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                            $this->Email->delivery = 'smtp';

                            
							/**************Email Send To Admin***************** */
                            
                            
                            if ($NameChange) :

                                $this->Email->subject = strtoupper($selectedType)." "."Name Change ";

                                $mesage = strtoupper($selectedType) . " Request for name change has been received , please wait for approval ";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
								
                                $this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();

                                $this->Session->setFlash('Your request for the name change has been sent successfully,please wait for approval !!', 'success');

                            else :

                                $this->Email->subject = strtoupper($selectedType)." "."Ownership change Change ";

                                $mesage = strtoupper($selectedType) . " Request for Ownership change has been received , please wait fot the approval !!";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
								
                                $this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();

                                $this->Session->setFlash('Your request for the ownership change has been sent successfully, please wait for approval !!', 'success');


                            endif;

                            $this->data = null;

                            $this->redirect('ownershipchange');
                        }else {

                            $this->data = null;

                            if ($NameChange) :

                                $this->Session->setFlash('Name could not be changed this time, Please try later !!', 'error');


                            else :

                                $this->Session->setFlash('Ownership could not be changed this time, Please try later !!', 'error');

                            endif;

                            $this->redirect('ownershipchange');
                        }
                    }else {

                        $this->data = null;

                        $this->Session->setFlash('You have already sent the request for the amendment, please wait for response from RFA !!', 'error');

                            $this->redirect('ownershipchange');
                        
                    }
                }
            }

            $this->layout = 'userprofile';

            $this->set('CUSTAMDTYP', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CUSTAMDTYP%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
			
			$this->Profile->bindModel(array('hasOne' => array('Member'=>array('className'=>'Member','foreignKey' => false)))); 
			
            $sqlProfile = $this->Profile->find('all', array(
                'conditions' => array(
                    'Profile.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'Profile.ch_active' => 'STSTY04',
					'Profile.vc_user_no = Member.vc_user_no',
                    'Profile.vc_customer_no !=' => $this->Session->read('Auth.Profile.vc_customer_no')
                    )));
			
            $this->set('profileData', $sqlProfile);

            $this->set('title_for_layout', 'Vehicle Ownership Change');
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     */
	 
    function addvehicle() {

        if ($this->params['isAjax']) {

            $this->layout = null;

            if (isset($this->params['form']['rowCount'])) {

                $this->set('rowCount', (int) $this->params['form']['rowCount']);
            }
        }

        $this->Set('payfrequency', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PAYFREQ%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->Set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->Set('status', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'STSTY02%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
		
			
    }

	
	/**
     *
     *
     *Delete log details which are not bind to assessment
     *
     */
	
	function deletelogs($id=null){
		
		if(isset($id) && $id!=''){
		  $id = base64_decode($id);
		  $this->VehicleLogDetail->deleteAll(array('VehicleLogDetail.vc_log_detail_id'=>$id));
		  $this->Session->setFlash('Log deleted successfully !!', 'success');			
		  $this->redirect('viewlogdetail');
		}		
		//pr($this->params);
		//pr($id);
		//die;
	}
    /**
     *
     *
     */
    function addlogdetail() {

        try {
		
			set_time_limit(0);

            $this->loadModel('VehicleLogMaster');

            $this->loadModel('VehicleLogDetail');
			
			$this->loadModel('CustomerLocationDistance');
			
			$nu_company_id = $this->Session->read('nu_company_id');// session
			
			$this->set('nu_company_id',$nu_company_id);

            if (!empty($this->data) && $this->RequestHandler->isPost()) {
				
			    $checktransfervehicles = $this->VehicleAmendment->find('count',array('conditions'=>array('CH_APPROVE'=>'STSTY03','vc_vehicle_lic_no'=>$this->data['VehicleLogMaster']['vc_vehicle_lic_no'])));
				
				
                $payFrequency = $this->ParameterType->find('first', array('conditions' => array('ParameterType.vc_prtype_name' => $this->data['VehicleLogMaster']['vc_pay_frequency']), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

                $hdvehlogID = $this->VehicleLogMaster->getPrimaryKey();

                $logdetails = $this->Session->read('Auth.Profile');

                $logdetails['vc_vehicle_log_no'] = $hdvehlogID;

                $logdetails['vc_pay_frequency'] = $payFrequency['ParameterType']['vc_prtype_code'];

                $logdetails['vc_vehicle_lic_no'] = $this->data['VehicleLogMaster']['vc_vehicle_lic_no'];

                $logdetails['dt_created_date'] = date('d-M-Y H:i:s');

                if ($this->VehicleLogMaster->save($logdetails, false)) {
					
					//ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
                    
					$errcounter = 0;
					//pr($this->data);die;
					$cntroadidindex=0;
					
					foreach ($this->data['VehicleLogDetail'] as $vehicleLogData) {
						
						if($this->data['RoadID'][$cntroadidindex]==1){ 
						
							$vehicleLogData['nu_km_traveled']=0;
							$vehicleLogData['nu_other_road_km_traveled']=($vehicleLogData['nu_end_ometer']-$vehicleLogData['nu_start_ometer']);
							$vehicleLogData['vc_orign']='';
							$vehicleLogData['vc_destination']='';
							$vehicleLogData['ch_road_type']=1;    // other road type 
						
						}else{
							
							$vehicleLogData['vc_other_road_destination']='';
							$vehicleLogData['vc_other_road_orign']='';
							$vehicleLogData['nu_other_road_km_traveled']=0;
							$vehicleLogData['nu_km_traveled']=($vehicleLogData['nu_end_ometer']-$vehicleLogData['nu_start_ometer']);
							$vehicleLogData['ch_road_type']=0;  // namibian road type
						}
						
						
						
						if($this->VehicleLogDetail->find('count',array(
										'conditions'=>array(
												'VehicleLogDetail.vc_comp_code' =>trim($this->Session->read('Auth.Profile.vc_comp_code')),
												'VehicleLogDetail.vc_customer_no' =>trim($this->Session->read('Auth.Profile.vc_customer_no')),
												'lower(VehicleLogDetail.vc_vehicle_lic_no)'=>strtolower(trim($this->data['VehicleLogMaster']['vc_vehicle_lic_no'])),
												array('OR'=>array(
													array('VehicleLogDetail.nu_start_ometer'=>trim($vehicleLogData['nu_start_ometer'])),
													array('VehicleLogDetail.nu_end_ometer'=>trim($vehicleLogData['nu_end_ometer'])),											
												))))) == 0  &&  trim($vehicleLogData['nu_start_ometer']) != '' &&  
												trim($vehicleLogData['nu_end_ometer']) != '' ) {
												
												
								$vehicleLogData['vc_log_detail_id'] = $this->VehicleLogDetail->getPrimaryKey();
								
								$tmp = null;
								
								$tmp = $this->CustomerLocationDistance->find('first', array(
													'conditions'=>array(
													'lower(CustomerLocationDistance.vc_loc_from_code)'=>strtolower(trim($vehicleLogData['vc_orign']))
													),
													'fields'=>array('CustomerLocationDistance.loc_from')));
								
								$vehicleLogData['vc_orign_name']=  $tmp == true ? $tmp['CustomerLocationDistance']['loc_from'] :  null;
								
								$tmp = $this->CustomerLocationDistance->find('first', array(
														'conditions'=>array(
														'lower(CustomerLocationDistance.vc_loc_to_code)'=>strtolower(trim($vehicleLogData['vc_destination']))),
														'fields'=>array('CustomerLocationDistance.loc_to')));
								
								$vehicleLogData['vc_destination_name'] = $tmp == true ? $tmp['CustomerLocationDistance']['loc_to'] :  null;
								
								/*
								$tmp =  $this->CustomerLocationDistance->find('first', array(
														'conditions'=>array(
														'lower(CustomerLocationDistance.vc_loc_from_code)'=>strtolower(trim($vehicleLogData['vc_other_road_orign']))),
														'fields'=>array('CustomerLocationDistance.loc_from')));
								
								$vehicleLogData['vc_other_road_orign_name']= $tmp == true ? $tmp['CustomerLocationDistance']['loc_from'] :  null;
								
								$tmp = $this->CustomerLocationDistance->find('first', array(
															'conditions'=>array(											'lower(CustomerLocationDistance.vc_loc_to_code)'=>strtolower(trim($vehicleLogData['vc_other_road_destination']))),
															'fields'=>array('CustomerLocationDistance.loc_to')));
								
								$vehicleLogData['vc_other_road_destination_name']=$tmp == true ? $tmp['CustomerLocationDistance']['loc_to'] :  null;
								
								*/
								$vehicleLogData['vc_other_road_orign_name']=$vehicleLogData['vc_other_road_orign'];
								$vehicleLogData['vc_other_road_destination_name']=$vehicleLogData['vc_other_road_destination'];
								unset($tmp);
								
								$vehicleLogData['dt_log_date'] = date('d-M-Y H:i:s', strtotime($vehicleLogData['dt_log_date']));

								$vehicleLogData['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

								$vehicleLogData['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

								$vehicleLogData['dt_created_date'] = date('d-M-Y H:i:s');

								$vehicleLogData['vc_pay_frequency'] = $payFrequency['ParameterType']['vc_prtype_code'];

								$vehicleLogData['vc_vehicle_lic_no'] = $this->data['VehicleLogMaster']['vc_vehicle_lic_no'];

								$vehicleLogData['vc_status'] = 'STSTY01'; /* Active Now and  will be use any assessment  */

								$vehicleLogData['vc_vehicle_reg_no'] = $this->data['VehicleLogMaster']['vc_vehicle_reg_no'];
							   
								$vehicleLogData['nu_other_road_km_traveled'] = trim($vehicleLogData['nu_other_road_km_traveled']) == '' ? 0 : $vehicleLogData['nu_other_road_km_traveled'];

								$vehicleLogData['vc_vehicle_log_no'] = $hdvehlogID;
													
								$vehicleLogData['vc_remark_by'] = 'USRTYPE03';
								
								$vehicleLogData['nu_company_id'] = $nu_company_id;
								
								$this->VehicleLogDetail->create();

								$this->VehicleLogDetail->set($vehicleLogData);

								$this->VehicleLogDetail->save($vehicleLogData, false);

								unset($vehicleLogData);	


								/** ********* Email Send To Customer ***************** */
								

								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
								
								$this->Email->bcc = array(trim($this->AdminMdcEmailID));

								$this->Email->subject = strtoupper($selectedType) ." ". " Vehicle Log Details ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " Your Vehicle Log Detail has been added successfully. ";
								
								$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
								
								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();

								/**************End*************** */

				

								/************ End *************** */	
											
						} else {
							
							$errcounter++;
						
						}
						$cntroadidindex++;	
                    }
					
					$this->data = null;
					
					if( $errcounter == 0  ) {
					
						$this->Session->setFlash('Log Details have been added successfully !!', 'success');
					
					} else if( $errcounter == 1  ) {
					
							$this->Session->setFlash(' Log Details have not been added successfully , Some duplicate data exist !!', 'info');	
						
					} else {
						
						$this->Session->setFlash('Log Details have been added successfully ,Some duplicate data exist but not saved  !!', 'info');	
							
					}
					
                    $this->redirect($this->referer());
               
			   } else {

                    $this->data = null;

                    $this->Session->setFlash('Log Detail could not be added please try again later', 'error');

                    $this->redirect($this->referer());
                }
            }

            $this->layout = 'userprofile';

            $this->set('title_for_layout', ' Add Vehicle Log Detail ');

            $vehiclelist = $this->VehicleDetail->find('list', array('conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleDetail.vc_vehicle_status' => 'STSTY04',
					'VehicleDetail.nu_company_id'=>$nu_company_id
                ), 'fields' => array('vc_vehicle_lic_no', 'vc_vehicle_lic_no')));
				
				//pr($vehiclelist);
            
			$vehicleReg = $this->VehicleDetail->find('list', array('conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleDetail.vc_vehicle_status' => 'STSTY04',
					'VehicleDetail.nu_company_id'=>$nu_company_id					
                ),'fields' => array('vc_vehicle_reg_no', 'vc_vehicle_reg_no')));

			//addlogdetail
            $alltransfervehicles = $this->VehicleAmendment->find('all',array('conditions'=>array('ch_approve'=>'STSTY03')));
			
			/////// start
			
			foreach($alltransfervehicles as $VehicleDetail){
			
			   $arraytransfervehicleslicenseno[]=$VehicleDetail['VehicleAmendment']['vc_vehicle_lic_no'];
			   $arraytransfervehiclesregno[]=$VehicleDetail['VehicleAmendment']['vc_vehicle_reg_no'];
			}
			//$sqlResult  
           
		   $arrayVehicleLogsLicense=array();
		   foreach($vehiclelist as $VehicleDetail){
		   
			    $licenso_no=$VehicleDetail;
				
				if(in_array($licenso_no,$arraytransfervehicleslicenseno)==false){
					$arrayVehicleLogsLicense[$VehicleDetail]=$VehicleDetail;
				}
			}
			
			
		   $arrayVehicleLogsRegno=array();
		   foreach($vehicleReg as $VehicleDetailreg){
			   $vereg_no=$VehicleDetailreg;
		
				if(in_array($VehicleDetailreg,$arraytransfervehiclesregno)==false){
					$arrayVehicleLogsRegno[$VehicleDetailreg]=$VehicleDetailreg;
				}
			}
			//////////////end
			$this->set('vehiclelist', array('' => 'Select Licence No.') + $arrayVehicleLogsLicense);

            $this->set('vehicleReg', array('' => 'Select Register. No.') + $arrayVehicleLogsRegno);
						
			
			$this->set('OriginCustomerLocationDistance', array(''=>'Select')+$this->CustomerLocationDistance->find('list',array('fields'=>array('CustomerLocationDistance.vc_loc_from_code','CustomerLocationDistance.loc_from'))));
			
			/*
			$this->set('DestinationCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
																		'fields'=>array(
																			'CustomerLocationDistance.vc_loc_to_code',
																			'CustomerLocationDistance.loc_to'))));
			*/
																

        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * View Log Detail
     *
     */
	 
    function viewlogdetail() {

        $this->loadModel('VehicleLogDetail');
		
		$nu_company_id = $this->Session->read('nu_company_id');
		$this->set('nu_company_id',$nu_company_id);
			
        $this->paginate = array(
            'conditions' => array(
                'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
				'VehicleLogDetail.nu_company_id' => $nu_company_id
            ),
            'order' => array('VehicleLogDetail.dt_log_date' => 'desc'),
            'limit' => 20
        );
		
        $this->set('logdetaildata', $this->paginate('VehicleLogDetail'));
        $this->layout = 'userprofile';			

        $this->set('title_for_layout', ' View Log Detail Vehicle ');//die('hua');
    }
	
	 

    /**
     *
     * @param type $id 
     * 
     */
    function editlogdetail($id = null) {
   set_time_limit(0);
        $this->loadModel('VehicleLogDetail');

        try {

            $Queryresult = $this->VehicleLogDetail->find('first', array('conditions' => array('VehicleLogDetail.vc_log_detail_id' => $id)));

            if ($Queryresult) {

                if (!empty($this->data) && $this->RequestHandler->isPost()) {

                    foreach ($this->data['VehicleLogDetail'] as $data) {

                        $this->VehicleLogDetail->validate = null;

                        $this->VehicleLogDetail->id = $id;

                        $data['dt_modified_date'] = date('d-M-Y H:i:s');

                        $data['nu_start_ometer'] = $Queryresult['VehicleLogDetail']['nu_start_ometer'];

                        $data['nu_end_ometer'] = $Queryresult['VehicleLogDetail']['nu_end_ometer'];

                        $data['nu_km_traveled'] = $Queryresult['VehicleLogDetail']['nu_km_traveled'];

                        $data['dt_log_date'] = date('d-M-Y H:i:s', strtotime($Queryresult['VehicleLogDetail']['dt_log_date']));

                        $data['vc_status'] = 'STSTY01';

                        $data['vc_log_detail_id'] = $id;

                        $this->VehicleLogDetail->set($data);

                        $this->VehicleLogDetail->save();
                    }

                    /* **** Email Send To Customer ********** */

                    list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                    $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                    $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
					
					$this->Email->bcc = array(trim($this->AdminMdcEmailID));

                    $this->Email->subject = strtoupper($selectedType)." "."Vehicle Log Detail Updated ";

                    $this->Email->template = 'registration';

                    $this->Email->sendAs = 'html';

                    $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                    $this->Email->delivery = 'smtp';

                    $mesage = " Your Vehicle Log Detail has been Updated, please wait for the approval ";
					
					$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
					$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
					
                    $this->Email->send($mesage);
					
					$this->Email->to = array();
					
					$this->Email->bcc =  array();

                    /** ***************End************************ */

                    /************ Email Send To Admin***************** */                   

                    /********** End ********************** */

                    $this->data = null;

                    $this->Session->setFlash('Your Log Details has been updated successfully', 'success');

                    $this->redirect($this->referer());
                }


                $this->layout = 'userprofile';
				
				$this->loadModel('CustomerLocationDistance');

				$this->set('OriginCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
																			'fields'=>array(
																				'CustomerLocationDistance.vc_loc_from_code',
																				'CustomerLocationDistance.loc_from'))));

				$this->set('DestinationCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
																			'fields'=>array(
																				'CustomerLocationDistance.vc_loc_to_code',
																				'CustomerLocationDistance.loc_to'))));
				
                $this->set('data', $Queryresult);
            } else {

                $this->Session->setFlash(' Invalid log Id', 'info');

                $this->redirect(array('controller' => 'vehicles', 'action' => 'viewlogdetail'));
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
	 
    function gettabledata() {

        if ($this->params['isAjax']) {

            $this->layout = null;

            if (isset($this->params['form']['rowCount'])) {

                $this->set('rowCount', (int) $this->params['form']['rowCount']);
				
				$this->loadModel('CustomerLocationDistance');
			
				$this->set('OriginCustomerLocationDistance',  array(''=>'Select') + $this->CustomerLocationDistance->find('list',array(	'fields'=>array('CustomerLocationDistance.vc_loc_from_code',
																				'CustomerLocationDistance.loc_from'))));
				
				/*$this->set('DestinationCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
																			'fields'=>array(
																				'CustomerLocationDistance.vc_loc_to_code',
																				'CustomerLocationDistance.loc_to'))));*/
            }
        }
    }

    /**
     *
     *
     *
     */
    function gettableassessment() {
	
		$nu_company_id = $this->Session->read('nu_company_id');

        if ($this->params['isAjax']) {

            $this->layout = null;

            $this->loadModel('VehicleLogDetail');

            if (isset($this->params['form']['rowCount'])) {

                $getvehiclelist = $this->params['form']['vehiclelist'];

                $conditions = array(
                    'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleLogDetail.vc_status' => 'STSTY01',
					'VehicleDetail.nu_company_id' => $nu_company_id
                );


                $list = $this->VehicleLogDetail->find('all', array('conditions' => $conditions,
                    'fields' => array(' Distinct VehicleLogDetail.vc_vehicle_lic_no')
                        ));

                $vehiclelist = array();

                $vehicleReg = array();

                $newConditionsMain = array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleDetail.vc_vehicle_status' => 'STSTY04');

                if (count($getvehiclelist) == 1) {

                    $newConditionsMain += array('VehicleDetail.vc_registration_detail_id !=' => current($getvehiclelist));
                } else {

                    $newConditionsMain += array('NOT' => array('VehicleDetail.vc_registration_detail_id' => $getvehiclelist));
                }
                unset($value);

                foreach ($list as $key => $value) {


                    $newConditions = $newConditionsMain + array('VehicleDetail.vc_vehicle_lic_no' => $value['VehicleLogDetail']['vc_vehicle_lic_no']);


                    $getvalue = $this->VehicleDetail->find('first', array('conditions' => $newConditions,
                        'fields' => array('vc_registration_detail_id', 'vc_vehicle_lic_no', 'vc_vehicle_reg_no')));

                    unset($newConditions);

                    if (!$getvalue) {

                        continue;
                    }

                    $vehiclelist += array($getvalue['VehicleDetail']['vc_registration_detail_id'] => $getvalue['VehicleDetail']['vc_vehicle_lic_no']);

                    $vehicleReg +=array($getvalue['VehicleDetail']['vc_registration_detail_id'] => $getvalue['VehicleDetail']['vc_vehicle_reg_no']);
                    unset($value);
                }

                if (empty($vehiclelist)) {
                    exit;
                }
                $this->set('vehiclelist', array('' => ' Select Lic. No') + $vehiclelist);

                $this->set('vehicleReg', array('' => ' Select Reg. No') + $vehicleReg);

                $this->set('rowCount', (int) $this->params['form']['rowCount']);
            }
        }
    }

    /**
     *
     *
     *
     */
	 
    function addassessment() {

        try {
			set_time_limit(0);
			$nu_company_id = $this->Session->read('nu_company_id');

			$this->Set('nu_company_id',$nu_company_id);

            $this->loadModel('AssessmentVehicleMaster');

            $this->loadModel('AssessmentVehicleDetail');

            $this->loadModel('VehicleLogDetail');
			
			$assemntnegativestatus= false;
			if(isset($this->data['AssessmentVehicleDetail']) && !empty($this->data['AssessmentVehicleDetail'])){
			
			foreach($this->data['AssessmentVehicleDetail'] as $key => $value) {
			 
			if(($value['vc_km_travelled'] < (int)0 ))
			    {
					$assemntnegativestatus = true;	
				}
 
			}
			//echo 'assm--',$assemntnegativestatus;
			
			}
			
			if($assemntnegativestatus == true){
		    	$this->Session->setFlash('Assessment of negative km travelled is not possible ','error');
			    $this->redirect($this->referer());
			}
			//die;
            if (!empty($this->data) && $this->RequestHandler->isPost()) {
			    
				$fromSearchyear = date('01-M-y', strtotime($this->data['AssessmentVehicleMaster']['vc_pay_month_from']));
                
				$toSeachyear =  date('t-M-y', strtotime($this->data['AssessmentVehicleMaster']['vc_pay_month_to']));
			
				$fromyear = date('Y', strtotime($this->data['AssessmentVehicleMaster']['vc_pay_month_from']));
                
				$toyear =  date('Y', strtotime($this->data['AssessmentVehicleMaster']['vc_pay_month_to']));
				
				$Total_Payable_Amount = 0;

                $this->data['AssessmentVehicleMaster'] = $this->data['AssessmentVehicleMaster'] + $this->Session->read('Auth.Profile');
				unset($this->data['AssessmentVehicleMaster']['nu_variance_amount']);
                $vc_comp_code = $this->data['AssessmentVehicleMaster']['vc_comp_code'];

                $assessmentNo = $this->AssessmentVehicleMaster->getPrimaryKey($vc_comp_code);

                $this->data['AssessmentVehicleMaster']['vc_assessment_no'] = $assessmentNo;
				
                $this->data['AssessmentVehicleMaster']['nu_company_id'] = $nu_company_id;

                $this->data['AssessmentVehicleMaster']['dt_assessment_date'] = date('d-M-Y');

                $this->data['AssessmentVehicleMaster']['dt_received_date'] = date('d-M-Y');

                $this->data['AssessmentVehicleMaster']['dt_process_date'] = date('d-M-Y');

                $this->data['AssessmentVehicleMaster']['vc_pay_month_from'] = date('M', strtotime($this->data['AssessmentVehicleMaster']['vc_pay_month_from']));

                $this->data['AssessmentVehicleMaster']['vc_pay_month_to'] = date('M', strtotime($this->data['AssessmentVehicleMaster']['vc_pay_month_to']));

                $this->data['AssessmentVehicleMaster']['vc_pay_year_from'] = $fromyear;

                $this->data['AssessmentVehicleMaster']['vc_pay_year_to'] = $toyear;

                $this->data['AssessmentVehicleMaster']['vc_mdc_paid'] = 0;

                $this->data['AssessmentVehicleMaster']['vc_status'] = 'STSTY03';

                $this->data['AssessmentVehicleMaster']['vc_payment_status'] = 'STSTY02';
				
				$this->data['AssessmentVehicleMaster']['vc_remarks'] = '';

                $this->AssessmentVehicleMaster->create();

                $this->AssessmentVehicleMaster->set($this->data['AssessmentVehicleMaster']);

                $vehicleListLog = array();

                $checkError = false;
												
                if ( $this->AssessmentVehicleMaster->save()  ) {

					// ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
					
                    foreach ($this->data['AssessmentVehicleDetail'] as $key => $value) :

                        $value = $this->data['AssessmentVehicleDetail'][$key];

                        $VehicleDetail = $this->VehicleDetail->find('first', array(
																'conditions' => array(
																	'vc_registration_detail_id' => trim($value['vc_vehicle_lic_no'])
																),
																'fields' => array(
																	'vc_vehicle_lic_no',
																	'vc_vehicle_reg_no'
																	)));

                        $vehicleListLog[$VehicleDetail['VehicleDetail']['vc_vehicle_lic_no']] = $VehicleDetail['VehicleDetail']['vc_vehicle_reg_no'];

                        $getData = $this->getselectvehicledetails(
								$VehicleDetail['VehicleDetail']['vc_vehicle_lic_no'],
								$VehicleDetail['VehicleDetail']['vc_vehicle_reg_no'],
								$toSeachyear,
								$fromSearchyear
                        );
                       
                        $Total_Payable_Amount += $getData['payable'];

                        $value['vc_assessment_detail_id'] = $this->AssessmentVehicleDetail->getPrimaryKey();

                        $value['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                        $value['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

                        $value['vc_assessment_no'] = $assessmentNo;

                        $value['dt_created_date'] = date('d-M-Y H:i:s');
						
						$value['nu_company_id'] = $nu_company_id;

                        $value['vc_vehicle_lic_no'] = $VehicleDetail['VehicleDetail']['vc_vehicle_lic_no'];

                        $value['vc_vehicle_reg_no'] = $VehicleDetail['VehicleDetail']['vc_vehicle_reg_no'];
						
						$this->AssessmentVehicleDetail->create();

                        $this->AssessmentVehicleDetail->set($value);
						
						if (!$this->AssessmentVehicleDetail->save($value)) {

                            $checkError = true;

                            break;
                        }

                        unset($value);

                        unset($VehicleDetail);

                    endforeach;
									
                    if (!$checkError) :

                        /*** Update Vehicle Log Details with Flag status Active mean Log under Assessment process ***/
						
                      					
                        foreach ($vehicleListLog as $key => $value) {
											
							$key = trim($key);
							
							$value = trim($value);
													
                            $detail = $this->VehicleLogDetail->find('list', array(
                                'conditions' => array(
                                    'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                                    'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                                    'VehicleLogDetail.vc_status' => 'STSTY01',
                                    'VehicleLogDetail.dt_log_date >= ' => $fromSearchyear,
                                    'VehicleLogDetail.dt_log_date <= ' => $toSeachyear,
									array(
									'OR'=>array (
                                    array('VehicleLogDetail.vc_vehicle_lic_no' => $key),
                                    array('VehicleLogDetail.vc_vehicle_reg_no' => $value)
									)
									)),
                                'fields' => array('vc_log_detail_id', 'vc_log_detail_id')
                                    ));
							
							//pr($detail);
							//pr($this->data);
							//die;
                            foreach ($detail as $key => $value) {

                                $this->VehicleLogDetail->id = $key;
                                $this->VehicleLogDetail->save(array(
                                    'vc_log_detail_id' => $key,
                                    'vc_assessment_no' =>$assessmentNo,
									'dt_modified_date' => date('d-M-Y H:i:s'),
                                    'vc_status' => 'STSTY03'));
                            }
							

                            unset($detail);
                        }

                        $this->AssessmentVehicleMaster->id = $assessmentNo;

                        $this->AssessmentVehicleMaster->save(array(
                            'vc_assessment_no' => $assessmentNo,
                            'nu_total_payable_amount' => (float) $Total_Payable_Amount));
                        unset($saveData);

                        /********End************************ */

                        /*********** Email Send To Customer ***************** */

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
						
						$this->Email->bcc = array(trim($this->AdminMdcEmailID));

                        $this->Email->subject = strtoupper($selectedType)." "."Customer Add Assessment Detail ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = " Your Assessment Detail has been submitted,please wait till we verify the details ";
						
						$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
						$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
						
                        $this->Email->send($mesage);
						
						$this->Email->to = array();
					
						$this->Email->bcc =  array();

                        /* ***************End******************************************** */

                        /************** Email Send To Admin******************** */

                        

                        /*********** End ************* */

                        $this->data = NULL;

                        $this->Session->setFlash('Your assessment details has been saved successfully, please wait for approval !! ', 'success');

                        $this->redirect($this->referer());

                    else :

                        $this->data = NULL;

                        $this->AssessmentVehicleMaster->id = $assessmentNo;

                        $this->AssessmentVehicleMaster->delete();
                        
						$this->AssessmentVehicleDetail->deleteAll(array('AssessmentVehicleDetail.vc_assessment_no' => $assessmentNo));

                        $this->Session->setFlash('Your assessment details has not been saved successfully', 'success');


                    endif;
					
                } else {

                    $this->data = NULL;

                    $this->Session->setFlash('Sorry your data has not saved please try again. ', 'error');
                }
            }


            $this->layout = 'userprofile';

            $this->set('title_for_layout', ' Add Vehicle Assessment  ');

            $vehiclelist = array('' => ' Select Licence');

            $vehicleReg = array('' => 'Select Reg No. ');

            $list = $this->VehicleLogDetail->find('all', array('conditions' => array(
                    'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleLogDetail.vc_status' => 'STSTY01',
					'VehicleDetail.nu_company_id' => $nu_company_id
                ),
                'fields' => array(' Distinct VehicleLogDetail.vc_vehicle_lic_no')
                    ));

            foreach ($list as $key => $value) {

                $getvalue = $this->VehicleDetail->find('first', array('conditions' => array(
                        'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                        'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                        'VehicleDetail.vc_vehicle_status' => 'STSTY04',
                        'VehicleDetail.nu_company_id' => $nu_company_id,
                        'VehicleDetail.vc_vehicle_lic_no' => $value['VehicleLogDetail']['vc_vehicle_lic_no']
                    ),
                    'fields' => array('vc_registration_detail_id', 'vc_vehicle_lic_no', 'vc_vehicle_reg_no')));


                $vehiclelist += array($getvalue['VehicleDetail']['vc_registration_detail_id'] => $getvalue['VehicleDetail']['vc_vehicle_lic_no']);

                $vehicleReg +=array($getvalue['VehicleDetail']['vc_registration_detail_id'] => $getvalue['VehicleDetail']['vc_vehicle_reg_no']);
            }

            $this->set('vehiclelist', array('' => ' Select Lic. No') + $vehiclelist);

            $this->set('vehicleReg', array('' => ' Select Reg. No') + $vehicleReg);
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
    function addfileupload() {

        if ($this->params['isAjax']) {

            $this->layout = null;

            if (isset($this->params['form']['countRow'])) {

                $this->set('rowCount', (int) $this->params['form']['countRow']);

                $this->set('row', (int) $this->params['form']['row']);
            }
        }
    }

    /**
     *
     *
     *
     */
    function view() {

        $this->layout = 'userprofile';
		$nu_company_id = $this->Session->read('nu_company_id');
		$this->Set('nu_company_id',$nu_company_id);
        $this->set('title_for_layout', 'View Vehicles');

        $this->Set('payfrequency', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PAYFREQ%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->Set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $this->Set('status', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'STSTY02%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

        $customerdetails = $this->Session->read('Auth');

        $this->paginate = array(
            'conditions' => array(
                'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'VehicleDetail.nu_company_id' => $nu_company_id
            ),
            'order' => array('VehicleDetail.dt_created_date' => 'desc'),
            'limit' => 10
        );

        $this->set('data', $this->paginate('VehicleDetail'));

        $this->set('customerdetails', $customerdetails);
    }

    /**
     *
     *
     *
     */
    function edit($id = null) {

        try {
		    
			set_time_limit(0);	
			$id = base64_decode(trim($id));
			
			$nu_company_id = $this->Session->read('nu_company_id');
			$this->Set('nu_company_id',$nu_company_id);
			
			$vc_comp_code   = $this->Session->read('Auth.Member.vc_comp_code');		
			$ch_active      = $this->Session->read('Auth.Profile.ch_active');
			//$vc_customer_no = $this->Session->read('Auth.Member.vc_mdc_customer_no');
			$vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');
			$vc_username    = $this->Session->read('Auth.Member.vc_username');
			/*$sqlResult      = $this->VehicleDetail->find('first', array('conditions' => array('VehicleDetail.vc_registration_detail_id' => $id)));*/
			
			$sqlResult = $this->VehicleDetail->find('first', array('conditions' => array('VehicleDetail.vc_registration_detail_id' => $id,'VehicleDetail.vc_customer_no' => $vc_customer_no,'VehicleDetail.vc_vehicle_status'=>'STSTY05')));
			
			$vehicledocs = $this->DocumentUploadVehicle->find('all', array('conditions' => array('DocumentUploadVehicle.vc_registration_detail_id' => $id,)));
			
			//pr($vehicledocs);
			$this->Set('vehicledocs',$vehicledocs);
           
			
			//pr($sqlResult);die;
            if ($sqlResult) {

                if (!empty($this->data) && $this->RequestHandler->isPost()) {
						
										
					$filepath = trim($this->Session->read('Auth.Member.vc_username'));


                    /** ******Firstly Delete old File and Entry From Database *********** */

                    //$this->DocumentUploadVehicle->deleteAll(array('DocumentUploadVehicle.vc_registration_detail_id' => $sqlResult['VehicleDetail']['vc_registration_detail_id']));

                   // $dir = WWW_ROOT. "uploadfile" . DS. "$filepath" . DS. 'Vehicle'. DS . trim($sqlResult['VehicleDetail']['vc_vehicle_lic_no']);

                  

                    /* ************ End ******************** */


                    /**** Set File Upload Data According with Vehicle *******/
					
                    foreach ($this->data['VehicleDetail'] as $key => &$value) {

                        $value['DocumentUploadVehicle'] = $this->data['DocumentUploadVehicle'][$key];

                        unset($this->data['DocumentUploadVehicle'][$key]);
                    }
					
					if(isset($this->data['DocumentUploadVehicle']) && count($value['DocumentUploadVehicle'])>0){
					
						/*
						$this->DocumentUploadVehicle->deleteAll(array('DocumentUploadVehicle.vc_registration_detail_id' => $sqlResult['VehicleDetail']['vc_registration_detail_id']));
						$dir = WWW_ROOT. "uploadfile" . DS. "$filepath" . DS. 'Vehicle'. DS . trim($sqlResult['VehicleDetail']['vc_vehicle_lic_no']);
						if (file_exists($dir)) {

							$this->rrmdir($dir);
						}
						*/
					
					}

                    unset($value);
                    unset($this->data['DocumentUploadVehicle']);


                    /*******************End*******************************/

                    /****** Save data in detail Table ************ */
					
					$erro = false;
					
                    foreach ($this->data['VehicleDetail'] as $value) {
						
						/*
							if($this->VehicleDetail->find('count', array(
										'conditions'=>array(
												'lower(VehicleDetail.vc_registration_detail_id) !='=>strtolower(trim($value['vc_registration_detail_id'])),
												'OR'=>array(
													'VehicleDetail.vc_vehicle_lic_no '=>array($value['vc_vehicle_lic_no'], $value['vc_vehicle_reg_no']),
													'VehicleDetail.vc_vehicle_reg_no '=>array($value['vc_vehicle_lic_no'], $value['vc_vehicle_reg_no']),
												))
									)) == 0 )
							*/									
						if($this->VehicleDetail->find('count', array(
										'conditions'=>array(
												'lower(VehicleDetail.vc_registration_detail_id) !='=>strtolower(trim($value['vc_registration_detail_id'])),
												'OR'=>array(
													array(
													'VehicleDetail.vc_vehicle_lic_no'=>$value['vc_vehicle_lic_no']),
													array(
													'VehicleDetail.vc_vehicle_lic_no'=>$value['vc_vehicle_reg_no'],
													),
													array(
													'VehicleDetail.vc_vehicle_reg_no'=>$value['vc_vehicle_lic_no']),
													array(
													'VehicleDetail.vc_vehicle_reg_no'=>$value['vc_vehicle_reg_no'],
													))))) == 0) {
													

								$this->VehicleDetail->validate       = null;
								$this->VehicleDetail->id             = $value['vc_registration_detail_id'];
								$value['dt_modified_date']           = date('Y-m-d H:i:s');
								$value['vc_vehicle_status']          = 'STSTY03';
								$value['vc_registration_detail_id']  = $value['vc_registration_detail_id'];
								$nu_company_id                       = $value['nu_company_id'];
								
								$this->VehicleDetail->set($value);
								$this->VehicleDetail->save();
								
								/** ***** Upload Docs ******* */

								$dir = WWW_ROOT."uploadfile" . DS . "$filepath" . DS .'Vehicle'. DS . trim($value['vc_vehicle_lic_no']);

								if (!file_exists($dir) && count($value['DocumentUploadVehicle'])>0 ) {

									mkdir($dir, 0777, true);
								}
								$cntuploadfiles=1;
								foreach ($value['DocumentUploadVehicle'] as  $key => $docUpload) {

									$docUpload['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

									$docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

									$docUpload['vc_registration_detail_id'] = $value['vc_registration_detail_id'];

									$docUpload['vc_upload_vehicle_id'] = $this->DocumentUploadVehicle->getPrimaryKey();

									$docUpload['vc_uploaded_doc_path'] = $dir;
									
									$docUpload['nu_company_id']        = $nu_company_id;

									$filename = base64_decode(trim($docUpload['newfile']));
									$newfile = $cntuploadfiles.'-'.$this->renameUploadFile($filename);

								   
									$docUpload['vc_uploaded_doc_name'] = $newfile;

									$docUpload['vc_uploaded_doc_type'] = base64_decode(trim($docUpload['type']));

									$docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

									$this->DocumentUploadVehicle->validate = null;

									$this->DocumentUploadVehicle->create();

									$this->DocumentUploadVehicle->set($docUpload);

									$this->DocumentUploadVehicle->save();

									rename( base64_decode(trim($docUpload['fpath'])). DS . $filename , $dir . DS . $newfile);

									unset($docUpload);
									$cntuploadfiles++;
								}

							/*******	End	****************/

								unset($value);
						
						} else {
							
								$erro = true;
						
						}
						
                    }
					
					if( $erro ) {
					
						 $this->Session->setFlash('Sorry , you have already registered vehicle reg. no. or vehicle lic. no. ', 'info');

					
					} else {
					
					
					/*********** Email Send To Customer ***************** */
					
						list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
						
							$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

							$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
							
							$this->Email->bcc = array(trim($this->AdminMdcEmailID));

							$this->Email->subject = strtoupper($selectedType) . " Vehicle Details Changed ";

							$this->Email->template = 'registration';

							$this->Email->sendAs = 'html';

							$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

							$this->Email->delivery = 'smtp';

							$mesage = " Your vehicle details have been changed successfully, pending for approval from RFA !!";
							
							$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
				
							$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
							
							$this->Email->send($mesage);
								
								
						/************* Email Send To Admin**************/				
								
								
						/*************** End ****************************/


						$this->data = null;
						
						$this->Session->setFlash('Your vehicle details have been changed successfully, pending for approval from RFA !! ', 'success');

					}
                   
                    $this->redirect(array('controller' => 'vehicles', 'action' => 'view'));
                }


                $this->layout = 'userprofile';

                $this->set('title_for_layout', 'Change Vehicle Registration Detail');

                $this->Set('payfrequency', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PAYFREQ%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

                $this->Set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

                $this->Set('status', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => $sqlResult['VehicleDetail']['vc_vehicle_status']), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
				
				

                $this->set('data', $sqlResult);
				
				
				            
			} else {

                $this->Session->setFlash(' Invalid Vehicle Registration Id', 'info');

                $this->redirect(array('controller' => 'vehicles', 'action' => 'view'));
            }
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
		
    }

    /**
     *
     * Remove Folder and its files 
     *
     */
    function rrmdir($dir) {

        foreach (glob($dir . DS .'*') as $file) {

            if (is_dir($file))
                rrmdir($file); else
                unlink($file);
        }

        rmdir($dir);
    }
	
	
	/*
	*
	*
	*/
	function vehicletransferlist(){
	
	$nu_company_id = $this->Session->read('nu_company_id');
			$this->Set('nu_company_id',$nu_company_id);          
			$this->set('customerdetails', $this->Session->read('Auth'));
            
            $this->loadModel('VehicleAmendment');
            //$this->loadModel('NameChangeHistory');
           
            $conditions     =   array('vc_customer_no'=>trim($this->Session->read('Auth.Profile.vc_customer_no')),
                                      'vc_comp_code'=>trim($this->Session->read('Auth.Profile.vc_comp_code')),
									  'nu_company_id'=>$nu_company_id
                                  );    
           
            $limit = 10;
            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('VehicleAmendment.dt_amend_date' => 'desc'),
                'limit' => $limit
            );
			
			//pr($this->paginate('VehicleAmendment'));
            $this->set('ownershipchangedetails', $this->paginate('VehicleAmendment'));

            $this->layout = 'userprofile';

	
	}
    /**
     *
     *
     *
     */
	 
    function transfer() {

        try {
		
			 set_time_limit(0);	
			 
			 $nu_company_id = $this->Session->read('nu_company_id');
			 
			 $this->Set('nu_company_id',$nu_company_id);

             if (!empty($this->data) && $this->RequestHandler->isPost()) {
			
			 $countsqlResultlogvehicles = $this->VehicleLogDetail->find('count', array(                
				'conditions' => array(
                    'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleLogDetail.vc_status!' => 'STSTY04',
                    'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
					'VehicleLogDetail.vc_vehicle_lic_no' => trim($this->data['VehicleAmendment']['vc_vehicle_lic_no'])
                    //'VehicleLogDetail.nu_company_id' => $nu_company_id
                    )));
					
			if($countsqlResultlogvehicles>0){
			
				$this->Session->setFlash('Request for vehicle transfer not possible, vehicle logs are pending!!', 'error');
				$this->redirect('transfer');
			}					


                $setValidates = array('vc_vehicle_lic_no','vc_vehicle_reg_no','to_vc_customer_name');

                $this->VehicleAmendment->create(false);
                $this->VehicleAmendment->set($this->data['VehicleAmendment']);				
				
				$this->DocumentUploadVehicle->set($this->data['DocumentUploadVehicle']);
				
                $this->unsetValidateVariable($setValidates, array_keys($this->VehicleAmendment->validate), &$this->VehicleAmendment);

                $setValidatesDocUpd = array('vc_uploaded_doc_name');

                $this->unsetValidateVariable($setValidatesDocUpd, array_keys($this->DocumentUploadVehicle->validate), &$this->DocumentUploadVehicle);

                if ($this->VehicleAmendment->validates(array('fieldList' => $setValidates)) && $this->DocumentUploadVehicle->validates(array('fieldList' => $setValidatesDocUpd))) {

                if ($this->VehicleAmendment->find('count', array(
                                'conditions' => array(
                                    'VehicleAmendment.vc_vehicle_lic_no' => trim($this->data['VehicleAmendment']['vc_vehicle_lic_no']),
                                    'VehicleAmendment.ch_approve' => 'STSTY03'))) == 0) {


                        $this->VehicleAmendment->validate = NUll;

                        $this->DocumentUploadVehicle->validate = NUll;

                        $amndPrmy = $this->VehicleAmendment->getPrimaryKey();

                        $savedata['VehicleAmendment']['vc_vehicle_amend_no'] = $amndPrmy;
                        $savedata['VehicleAmendment']['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');
                        $savedata['VehicleAmendment']['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');
                        $savedata['VehicleAmendment']['vc_vehicle_reg_no'] = $this->data['VehicleAmendment']['vc_vehicle_reg_no'];
                        $savedata['VehicleAmendment']['vc_vehicle_lic_no'] = $this->data['VehicleAmendment']['vc_vehicle_lic_no'];						
						$nu_company_id_to = $this->data['VehicleAmendment']['nu_company_id_to'];
                        $savedata['VehicleAmendment']['vc_to_customer_no'] = $this->data['VehicleAmendment']['vc_to_customer_no'];
                        $savedata['VehicleAmendment']['dt_account_opened_date'] = $this->Session->read('Auth.Profile.dt_account_create_date');
						
                        $ToProfileDetail = $this->Company->find('first', array(
                         'conditions' => array('Company.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                                'Company.vc_customer_no' => trim($this->data['VehicleAmendment']['vc_to_customer_no']),
                                'Company.nu_company_id' => $nu_company_id_to,
                                )));

								
                        $savedata['VehicleAmendment']['vc_customer_id'] = $ToProfileDetail['Company']['vc_customer_id'];
                        $savedata['VehicleAmendment']['vc_customer_name'] = $ToProfileDetail['Company']['vc_customer_name'];
                        $savedata['VehicleAmendment']['vc_address1'] = $ToProfileDetail['Company']['vc_address1'];
                        $savedata['VehicleAmendment']['vc_address2'] = $ToProfileDetail['Company']['vc_address2'];
                        $savedata['VehicleAmendment']['nu_company_id'] = $nu_company_id;
                        $savedata['VehicleAmendment']['nu_company_id_to'] = $nu_company_id_to;
                        $savedata['VehicleAmendment']['vc_po_box'] = $ToProfileDetail['Company']['vc_po_box'];
                        $savedata['VehicleAmendment']['vc_town'] = $ToProfileDetail['Company']['vc_town'];
                        $savedata['VehicleAmendment']['vc_telephone_no'] = $ToProfileDetail['Company']['vc_tel_no'];        $savedata['VehicleAmendment']['vc_fax_no'] = $ToProfileDetail['Company']['vc_fax_no'];
                        $savedata['VehicleAmendment']['vc_mobile_no'] = $ToProfileDetail['Company']['vc_mobile_no'];
                        $savedata['VehicleAmendment']['vc_email_id'] = $ToProfileDetail['Company']['vc_email_id'];
                        $savedata['VehicleAmendment']['vc_cust_type'] = $ToProfileDetail['Company']['vc_cust_type'];
                        $savedata['VehicleAmendment']['dt_transfer_date'] = date('Y-m-d H:i:s');
                        $savedata['VehicleAmendment']['dt_amend_date'] = date('Y-m-d H:i:s');
                        $savedata['VehicleAmendment']['ch_approve'] = 'STSTY03';
						
						if($this->data['DocumentUploadVehicle']['vc_uploaded_doc_name']['name']!='')
                        $savedata['VehicleAmendment']['ch_doc_upload'] = 'Y';

                        $this->VehicleAmendment->create();

                        $this->VehicleAmendment->set($savedata);
						
						//pr( $savedata);
                        
			if ($this->VehicleAmendment->save($savedata, false)) {

                            $filepath = trim($this->Session->read('Auth.Profile.vc_customer_no'));
							if(isset($this->data['DocumentUploadVehicle']['vc_uploaded_doc_name']['tmp_name']) && $this->data['DocumentUploadVehicle']['vc_uploaded_doc_name']['tmp_name']!=''){
                            $dir = WWW_ROOT."uploadfile".DS."$filepath".DS.'Vehicle'.DS.'Amendment';

                            if (!file_exists($dir)) {

                                mkdir($dir, 0777, true);
                            }

                            $docUpload['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

                            $docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

                            $docUpload['vc_vehicle_amend_no'] = $amndPrmy;

                            $docUpload['vc_upload_vehicle_id'] = $this->DocumentUploadVehicle->getPrimaryKey();

                            $docUpload['vc_uploaded_doc_path'] = $dir;

                            $filename = $this->data['DocumentUploadVehicle']['vc_uploaded_doc_name']['name'];
							$newfilename = $this->renameUploadFile($filename);

							$docUpload['vc_uploaded_doc_type'] = $this->data['DocumentUploadVehicle']['vc_uploaded_doc_name']['type'];

                            if (file_exists($dir.DS.$newfilename)) {

                                $newfilename = date('YmdHis').'-'.$newfilename;
                            }

                            $docUpload['vc_uploaded_doc_name'] = $newfilename;

                            $docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

                            $this->DocumentUploadVehicle->validate = null;

                            $this->DocumentUploadVehicle->create();

                            $this->DocumentUploadVehicle->set($docUpload);
							
							
//pr( $docUpload);
                            $this->DocumentUploadVehicle->save($docUpload, false);

                            move_uploaded_file($this->data['DocumentUploadVehicle']['vc_uploaded_doc_name']['tmp_name'],$dir.DS.$newfilename);
							}
//pr($this->data);die;
                            unset($docUpload);

                            unset($savedata);


                            /************** Email Send To Customer ************ */
							

                            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                            $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
							
                            $this->Email->bcc = array(trim($this->AdminMdcEmailID));

                            $this->Email->subject = strtoupper($selectedType)." "." Vehicle Transfer ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                            $this->Email->delivery = 'smtp';

                            $mesage = " Your request for vehilce transfer has been received, pending for approval from RFA !! ";
							
							$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
					
							$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
							
                            $this->Email->send($mesage);
							
							$this->Email->to = array();
					
							$this->Email->bcc =  array();
								

                            /* ***************End***************************** */

                            /* ******* Email Send To Admin******************* */

                            /*** End **/

                            $this->data = null;

                            $this->Session->setFlash('Your request for vehicle transfer has been received, please wait for approval from RFA!!', 'success');

                            $this->redirect($this->referer());
                        
						} else {

                            unset($savedata);

                            $this->data = null;

                            $this->Session->setFlash('Some Error has occurred please try again.', 'error');

                            $this->redirect($this->referer());
                        }
                    } else {

                        $this->data = null;

                        $this->Session->setFlash('You have already sent the request for the amendment of vehicle, please wait for the response from RFA !!', 'error');

                        $this->redirect($this->referer());
                    }
                }
            }

            $this->layout = 'userprofile';
			
			$this->VehicleDetail->bindModel(array('hasMany'=>array('VehicleLogDetail' =>array(
                      'className' => 'VehicleLogDetail' ,'foreignKey' => 'vc_vehicle_lic_no',
				//	  'conditions' => array('VehicleLogDetail.vc_vehicle_lic_no' => 'VehicleDetail.vc_vehicle_lic_no'),
					  ))));
					
            
			$sqlResult = $this->VehicleDetail->find('all', array(                
				//array('contain' => 'VehicleLogDetail'),
				'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_vehicle_status' => 'STSTY04',
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleDetail.nu_company_id' => $nu_company_id
                    )));					
			//   pr($sqlResult);	die;		
            $this->set('data', $sqlResult);
			
			$sqlResultlogvehicles = $this->VehicleLogDetail->find('all', array(                
				'conditions' => array(
                    'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleLogDetail.vc_status!' => 'STSTY04',
                    'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    //'VehicleLogDetail.nu_company_id' => $nu_company_id
                    )));			
           $arrayvehicleslicenseno = array();

			foreach($sqlResultlogvehicles as $VehicleLogDetail){
			
			   $arrayvehicleslicenseno[]=$VehicleLogDetail['VehicleLogDetail']['vc_vehicle_lic_no'];
			}
			//$sqlResult  
           $arrayVehicleLogs=array();
		   foreach($sqlResult as $VehicleDetail){
			
			   $licenso_no=$VehicleDetail['VehicleDetail']['vc_vehicle_lic_no'];
				if(count($arrayvehicleslicenseno)>0){
				if(in_array($licenso_no,$arrayvehicleslicenseno)==false){
					$arrayVehicleLogs[]=$VehicleDetail;
				}}else{
				$arrayVehicleLogs[]=$VehicleDetail;
				}
			}
			//pr($arrayVehicleLogs);die;
    		$this->set('data', $arrayVehicleLogs);
			
		
		//$this->Profile->contain();	
		/*
			$this->Profile->bindModel(
               array(
                 'hasMany'=>array(
                     'Company' =>array(
                      'className' => 'Company',
                      'foreignKey' => 'nu_company_id',
                      'conditions' => array('Company.nu_company_id' => 'Profile.vc_customer_no'),
                  )         
               )
            )
			); 
		*/
			//$this->Voucher->unbindModel(array('hasMany' => array('Bill')), true);
			/*
			$this->Profile->bindModel(array('hasMany' => array('Company' =>
                array('foreignKey' =>false,
				'conditions' => array('Company.vc_customer_no' => 'Profile.vc_customer_no')))));
					
			//$this->Voucher->order = array('Voucher.nu_id' => 'asc');
			//$this->Profile->recursive = 3;
			*/

		    //$join=array('LEFT'=>array(''));
			
/*			$fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',
			'Profile.vc_user_no',
			'Profile.ch_active',
			'Profile.vc_customer_name', 'Profile.vc_address1', 'Profile.vc_address2', 'Profile.vc_address3'
			, 'Profile.vc_customer_id', 'Profile.vc_tel_no', 'Profile.vc_fax_no', 'Profile.vc_mobile_no', 
			'Profile.vc_email_id', 'Profile.vc_cust_type', 'Profile.vc_business_reg', 'Profile.vc_account_no', 'Profile.vc_bank_struct_code', 'Profile.vc_bank_supportive_doc', 
			'Profile.dt_created_date', 'Profile.dt_modified_date', 'Profile.dt_account_create_date', 'Profile.nu_variance_amount', 'Profile.vc_remarks', 'Profile.ch_email_flag', 'Profile.vc_erp_customer_no', 'Profile.vc_po_box', 'Profile.nu_company_id', 
			'Company.nu_company_id','Company.vc_company_name'
            
        );


        $paramsjoins['joins'] = array(
					array(
						 'table'=>'mst_company_mdc',
						 'alias'=>'Company',
						 'type'=>'INNER',
						 'conditions'=>array('Company.vc_customer_no !='=>
						 $this->Session->read('Auth.Profile.vc_customer_no'),
						 'Profile.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
						'Profile.ch_active' => 'STSTY04',
						'Company.ch_status' => 'STSTY04',
						)
					 )
				 );

			$paramsjoins['fields'] = $fields;
			*/
			
           $sqlProfile = $this->Company->find('all', array('conditions'=>array('Company.vc_customer_no !='=>$this->Session->read('Auth.Profile.vc_customer_no'),'Company.ch_status' => 'STSTY04')));

            $this->set('profileData', $sqlProfile);

            $this->set('title_for_layout', 'Vehicle Transfer');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Get Vehicle Transfer Detail
     *  
     *
     */
    function getVehicleTransferDetail() {

        $sqlQuery = '';

        if ($this->params['isAjax']) {

            $sqlQuery .= strtolower(trim($this->params['data']));
        }
		$nu_company_id = $this->Session->read('nu_company_id');

        if ($sqlQuery != '') {

            $sqlResult = $this->VehicleDetail->find('all', array(
                'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_vehicle_status' => 'STSTY04',
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    'VehicleDetail.nu_company_id' => $nu_company_id,
                    'OR' => array(
                        'lower(VehicleDetail.vc_vehicle_lic_no) like' =>'%'.$sqlQuery . '%',
                        'lower(VehicleDetail.vc_vehicle_reg_no) like' =>'%'. $sqlQuery . '%'))));
						
        } else {

            $sqlResult = $this->VehicleDetail->find('all', array(
                'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_vehicle_status' => 'STSTY04',
                    'VehicleDetail.nu_company_id' => $nu_company_id,
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'))));
        }


        $this->layout = null;

		
		$sqlResultlogvehicles = $this->VehicleLogDetail->find('all', array(                
				'conditions' => array(
                    'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleLogDetail.vc_status!' => 'STSTY04',
                    'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                    //'VehicleLogDetail.nu_company_id' => $nu_company_id
                    )));			

			foreach($sqlResultlogvehicles as $VehicleLogDetail){
			
			   $arrayvehicleslicenseno[]=$VehicleLogDetail['VehicleLogDetail']['vc_vehicle_lic_no'];
			}
			//$sqlResult  
           $arrayVehicleLogs=array();
		   foreach($sqlResult as $VehicleDetail){
			
			   $licenso_no=$VehicleDetail['VehicleDetail']['vc_vehicle_lic_no'];
		
				if(in_array($licenso_no,$arrayvehicleslicenseno)==false){
					$arrayVehicleLogs[]=$VehicleDetail;
				}
			}
			//pr($arrayVehicleLogs);die;
    		$this->set('data', $arrayVehicleLogs);
    }

    /**
     *
     * Get Vehicle Tranfer Detail
     *  
     *
     */
    function getCustomerTransferDetail() {

        $sqlQuery = '';

        if ($this->params['isAjax']) {

            $sqlQuery .= strtolower(trim($this->params['data']));
        }

		/*$this->Profile->bindModel(
               array(
                 'hasMany'=>array(
                     'Company' =>array(
                      'className' => 'Company',
                      'foreignKey' => 'nu_company_id',
                     // 'conditions' => array('NpoMember.status' => 'Active'),
                  )         
               )
            )
        ); */
        $sqlProfile = $this->Company->find('all', array(
            'conditions' => array(
                'Company.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'Company.ch_status' => 'STSTY04',
                'Company.vc_customer_no !=' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'OR' => array(
                    'lower(Company.vc_customer_name) like' =>'%'.$sqlQuery . '%',
                    'lower(Company.vc_customer_no) like' => '%'.$sqlQuery . '%',
					'lower(Company.vc_company_name) like' => '%'.$sqlQuery . '%',
					))));

        $this->layout = null;

        $this->set('data', $sqlProfile);
    }

    /*
     *
     *
     *
     */

    function getTransferCustomerDetail() {

        $sqlQuery = '';

        if ($this->params['isAjax']) {

            $sqlQuery .= $this->params['data'];
        }
		//pr($this->params['data']);
		//die;

        $sqlProfile = $this->Company->find('first', array(
            'conditions' => array(
                'Company.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'Company.ch_status' => 'STSTY04',
                'Company.nu_company_id' => trim($sqlQuery),
                )));

        $this->layout = null;

        $this->set('data', $sqlProfile);
    }

    /*
     *
     *
     *
     */

    function gettransferaddress() {

        $sqlQuery = '';

        if ($this->params['isAjax']) {


            $sqlQuery .= $this->params['data'];
        }


        $sqlProfile = $this->Profile->find('first', array(
            'conditions' => array(
                'Profile.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'Profile.vc_customer_no' => trim($sqlQuery),
                )));
        $this->layout = null;

        $this->set('data', $sqlProfile);

        $this->layout = null;
    }

    /**
     *
     * View Assessment Functionality
     *
     */
    function viewassessment() {

        try {
		
			$nu_company_id = $this->Session->read('nu_company_id');
			
			$this->Set('nu_company_id',$nu_company_id);

            $this->loadModel('AssessmentVehicleMaster');

            $this->loadModel('AssessmentVehicleDetail');

            $this->layout = 'userprofile';

            $this->set('title_for_layout', ' View Vehicle Assessment  ');
			
            $limit = 10;

            $this->paginate = array(
                'conditions' => array(
                    'AssessmentVehicleMaster.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'AssessmentVehicleMaster.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
					'AssessmentVehicleMaster.nu_company_id' => $nu_company_id
                ),
                'order' => array('AssessmentVehicleMaster.dt_assessment_date' => 'desc'),
                'limit' => $limit
            );
            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;
            $this->set('pagecounter', $pagecounter);
            $this->set('limit', $limit);
            $this->set('data', $this->paginate('AssessmentVehicleMaster'));
        
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * get Vehicle Log Details
     *
     */
	 
    function getvehiclelogdetails($licenseno = null, $regisatrationno = null, $toDate = null, $fromate = null, $assessmentno=null) {

		$nu_company_id = $this->Session->read('nu_company_id');
		
        $this->loadModel('VehicleLogDetail');
		
		$this->loadModel('AssessmentVehicleMaster');
		
		$this->loadModel('VehicleLogDetailRejected');
		
		$company_name = $this->Company->find('first', array('conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
			'Company.nu_company_id' => $nu_company_id)
			));
		$this->Set('company_name',$company_name);

        if ($this->params['isAjax']) {

            $licenseno = $this->params['form']['licenseno'];

            $regisatrationno = $this->params['form']['regisatrationno'];

            $toDate = date('t-M-Y', strtotime($this->params['form']['toDate']));

            $fromDate = date('01-M-Y', strtotime($this->params['form']['fromDate']));

            $assessmentShow = isset($this->params['form']['assessment']) ? true : false;
			
			$assessmentno = isset($this->params['form']['assessmentno']) ? trim($this->params['form']['assessmentno']) : '';			
			
			$status = '';
			
			if(!empty($assessmentno)) {
				
				$result = 	$this->AssessmentVehicleMaster->find('first', array(
												'conditions'=>array(
														'lower(AssessmentVehicleMaster.vc_assessment_no)'=>strtolower(trim($assessmentno))
												
												)));
				if( !empty($result) ) {
					
					$status =  isset($result['AssessmentVehicleMaster']['vc_status']) ? trim($result['AssessmentVehicleMaster']['vc_status']) : '';
				}	
			
			}
			
        } else {

            if ($licenseno == null || $regisatrationno == null || $toDate == null || $fromDate == null || $assessmentno == null) :

                $this->cakeError('error404');

            endif;
        }       
		
		if( !empty($status) && $status == 'STSTY05' ) :
		
			$conditions = array(
						'VehicleLogDetailRejected.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
						'VehicleLogDetailRejected.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
						'VehicleLogDetailRejected.dt_log_date >= ' => $fromDate,
						'VehicleLogDetailRejected.dt_log_date <= ' => $toDate);
			
			if( $assessmentno != ''){
				$conditions += array('VehicleLogDetailRejected.vc_assessment_no' => $assessmentno);
			}	

			$conditions += array(	
								'OR' => array(
									'VehicleLogDetailRejected.vc_vehicle_lic_no' => trim($licenseno),
									'VehicleLogDetailRejected.vc_vehicle_reg_no' => trim($regisatrationno),
									));

			if ($assessmentShow) :
				$conditions += array('VehicleLogDetailRejected.vc_status !=' => 'STSTY01');
			else :
				$conditions += array('VehicleLogDetailRejected.vc_status ' => 'STSTY01');
			endif;	
			
			
			$detail = $this->VehicleLogDetailRejected->find('all', array(
				'conditions' => $conditions,
				'order'=>array('VehicleLogDetailRejected.dt_log_date'=> 'desc')));
		
		else :
		
			$conditions = array(
			'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
			'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
			'VehicleLogDetail.dt_log_date >= ' => $fromDate,
			'VehicleLogDetail.dt_log_date <= ' => $toDate);
			
			if( $assessmentno != ''){
				$conditions += array('VehicleLogDetail.vc_assessment_no' => $assessmentno);
			}	

			$conditions += array(	
			'OR' => array(
				'VehicleLogDetail.vc_vehicle_lic_no' => trim($licenseno),
				'VehicleLogDetail.vc_vehicle_reg_no' => trim($regisatrationno),
				));

			if ($assessmentShow) :
				$conditions += array('VehicleLogDetail.vc_status !=' => 'STSTY01');
			else :
				$conditions += array('VehicleLogDetail.vc_status ' => 'STSTY01');
			endif;
		
			$detail = $this->VehicleLogDetail->find('all', array(
				'conditions' => $conditions,
				'order'=>array('VehicleLogDetail.dt_log_date'=> 'desc')));
        endif;
      
        $this->set('detail', $detail);

        $this->set('toDate', $toDate);

        $this->set('fromDate', $fromDate);
		
		if(  !empty($status) && $status == 'STSTY05'  ) {
			
			$this->render('getvehiclelogdetailsreject');
			
		} 
		
    }

    /**
     *
     * get Select Vehicle Details with log
     *
     */
    function getselectvehicledetails($licenseno = null, $regisatrationno = null, $toDate= null, $fromDate= null) {

        $this->loadModel('VehicleLogDetail');

        if ($this->params['isAjax']) {

            $licenseno = $this->params['form']['licenseno'];

            $regisatrationno = $this->params['form']['regisatrationno'];

            $toDate = date('t-M-y', strtotime($this->params['form']['toDate']));

            $fromDate = date('01-M-y', strtotime($this->params['form']['fromDate']));
        
		} else {

            if ($licenseno == null || $regisatrationno == null || $toDate == null || $fromDate == null) :

                throw new NotFoundException(' Could not find that url ');

            endif;

            $toDate = date('t-M-y', strtotime($toDate));

            $fromDate = date('01-M-y', strtotime($fromDate));
        }

        $payFrequency = null;
        $prevEndOm = array();
        $EndOm = array();
        $kmtraveled = 0;
        $rate = null;
        $payable = null;
        $checkExist = false;


        $sqlResult = $this->VehicleDetail->find('first', array(
            'conditions' => array(
                'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'OR' => array(
                    'VehicleDetail.vc_vehicle_lic_no' => $licenseno,
                    'VehicleDetail.vc_vehicle_reg_no' => $regisatrationno)),
            'fields' => array('vc_rate')
                ));



        $rate = isset($sqlResult['VehicleDetail']['vc_rate']) && !empty($sqlResult['VehicleDetail']['vc_rate']) ? $sqlResult['VehicleDetail']['vc_rate'] : 0;
		
        $detail = $this->VehicleLogDetail->find('all', array(
            'conditions' => array(
                'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'VehicleLogDetail.vc_status' => 'STSTY01',
                'VehicleLogDetail.dt_log_date >= ' => $fromDate,
                'VehicleLogDetail.dt_log_date <= ' => $toDate,
                'OR' => array(
                    'VehicleLogDetail.vc_vehicle_lic_no' => trim($licenseno),
                    'VehicleLogDetail.vc_vehicle_reg_no' => trim($regisatrationno),
            ))));
		
        foreach ($detail as $value) {

            $payFrequency = $value ['PAYFREQUENCY']['vc_prtype_name'];

            array_push($prevEndOm, $value ['VehicleLogDetail']['nu_start_ometer']);

            array_push($EndOm, $value ['VehicleLogDetail']['nu_end_ometer']);

            $kmtraveled += $value ['VehicleLogDetail']['nu_km_traveled'];
			
            //$kmtraveled -= $value ['VehicleLogDetail']['nu_other_road_km_traveled'];
			
            unset($value);
        }
		
        if (count($detail) > 0) {

            $checkExist = true;
        }

        $sendout = array(
            'payFrequency' => @$payFrequency,
            'prevEndOm' => @min($prevEndOm),
            'EndOm' => @max($EndOm),
            'kmtraveled' => @$kmtraveled,
            'rate' => @$rate,
            'payable' => @($kmtraveled )* ((float)($rate/100)),
            'checkExist' => $checkExist
        );

        if ($this->params['isAjax']) {

            echo json_encode($sendout);
            exit;
        }

        return $sendout;
    }

    /**
     *
     *
     *
     */
    function getVehicleDetail() {

        $param = null;

        if ($this->params['isAjax']) {

            $param .= $this->params['data'];
        }

        $conditions = array(
            'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
            'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
        );

        $conditions += array(
            'OR' => array(
                'VehicleDetail.vc_vehicle_lic_no' => trim($param),
                'VehicleDetail.vc_vehicle_reg_no' => trim($param)
                ));

        $detail = $this->VehicleDetail->find('first', array('conditions' => $conditions));
		
        $sendOutput = array();

        if ($detail):

            $sendOutput += array(
                'vc_vehicle_lic_no' => $detail['VehicleDetail']['vc_vehicle_lic_no'],
                'vc_vehicle_reg_no' => $detail['VehicleDetail']['vc_vehicle_reg_no'],
                'vc_pay_frequency' => $detail['PAYFREQUENCY']['vc_prtype_name']
            );
			
			$getDateconditions = array();
			
			$getDateconditions += array(
									'OR' => array(
										'VehicleLogDetail.vc_vehicle_lic_no' => trim($param),
										'VehicleLogDetail.vc_vehicle_reg_no' => trim($param)
										));
			
			$this->loadModel('VehicleLogDetail');
			
			$getDate  = $this->VehicleLogDetail->find('first', array(
																'conditions' => $getDateconditions,
																'order' => array('VehicleLogDetail.nu_end_ometer' => 'DESC')
																		));
																		
			//pr($getDate);
			if($getDate):
			
				$sendOutput +=array('dt_created_date' =>  date('d M Y',strtotime($getDate['VehicleLogDetail']['dt_log_date'])));
			
				$sendOutput +=array('vc_start_ometer' => (int) $getDate['VehicleLogDetail']['nu_end_ometer']);
			
			
			else :
			
				$sendOutput +=array('dt_created_date' =>'');
			
				$sendOutput +=array('vc_start_ometer' => (int) $detail['VehicleDetail']['vc_start_ometer']);
			
			endif;
        endif;
		
        echo json_encode($sendOutput);

        exit;
    }

    /**
     *
     * Get Vehicle Start OdometerMeter Reading
     *
     */
    function getVehicleStartOM() {

        $this->loadModel('VehicleLogDetail');

        $licno = null;

        $regno = null;

        $sendOutput = array();

        if ($this->params['isAjax']) {

            $licno .= trim($this->params['form']['licno']);

            $regno .= trim($this->params['form']['regno']);
        }

        $conditions = array(
            'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
            'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
        );
				
		$conditions += array(
				'VehicleLogDetail.vc_vehicle_lic_no' => trim($licno),
				'VehicleLogDetail.vc_vehicle_reg_no' => trim($regno)
			   );

		$detail = $this->VehicleLogDetail->find('first', array(
								'conditions' => $conditions,
								'order' => array('VehicleLogDetail.nu_end_ometer' => 'DESC')
																	));

		if ($detail) :

            $sendOutput +=array('vc_start_ometer' => (int) $detail['VehicleLogDetail']['nu_end_ometer']);

        else :

            $oldData = $this->VehicleDetail->find('first', array(
                'conditions' => array(
                    'VehicleDetail.vc_vehicle_lic_no' => trim($licno),
                    )));

            $sendOutput +=array('vc_start_ometer' => (int) $oldData['VehicleDetail']['vc_start_ometer']);



        endif;

        echo json_encode($sendOutput);

        exit;
    }

    /**
     * 
     *  Check Vehicle License No or Registration No is 	 or not
     *  
     */
    function getVehicleCheck($vehicle = null, $id = null) {


        if ($this->params['isAjax']) {
			
			$vehicle = strtolower(trim($this->params['data']));
             
			$id = isset($this->params['form']['id'])? $this->params['form']['id'] :'';
        }
		
		
	$conditions = array(
			'OR' => array(
			"lower(VehicleDetail.vc_vehicle_lic_no) = '{$vehicle}'",
			"lower(VehicleDetail.vc_vehicle_reg_no) = '{$vehicle}'"
			)
			);
        if( $id != '' ){
			
			$conditions +=array('VehicleDetail.vc_registration_detail_id !='=>$id);
		
		}
               
	$count = $this->VehicleDetail->find('count', array('conditions' => $conditions));
			
		
        if ($count == 0) {

            echo true;
			
        } else {

            echo false;
        }
		
		
        exit;
    }
	
	
	/**
     * 
     *  New Function Checking  Vehicle License No or Registration No is	 or not
     *  
     */
    function getVehicleMainCheck() {

		//Configure::write('debug', 2);
		
		$conditions = array();
		
        if ($this->params['isAjax']) {
			
			if( isset($this->params['form']['id']) ) {
				
				$vehicle =  strtolower(trim(current(current($this->params['data']['VehicleDetail']))));
				$id  	 =	strtolower(trim($this->params['form']['id']));
				$conditions += array('lower(VehicleDetail.vc_registration_detail_id) !='=>$id);

			}	
			
			if( isset($this->params['data']['VehicleDetail']) ) {
				
				$vehicle =  strtolower(trim(current(current($this->params['data']['VehicleDetail']))));
				
				$conditions += array( 'OR' => array(
										"lower(VehicleDetail.vc_vehicle_lic_no) = '{$vehicle}'",
										"lower(VehicleDetail.vc_vehicle_reg_no) = '{$vehicle}'"
											));

			}
			
			
			
		}
		            
		$count = $this->VehicleDetail->find('count', array('conditions' => $conditions));			
		
        if ($count == 0) {

            echo "true";
			
        } else {

            echo "false";
        }		
        exit;
    }

    /**
     *
     *
     *
     *
     */
    function showassessmentdetail($assessmentno = null) {

        try {
		
			$nu_company_id = $this->Session->read('nu_company_id');
			//$assessmentno
			$assessmentno=base64_decode($assessmentno);
			$this->Set('nu_company_id',$nu_company_id);

            $this->loadModel('AssessmentVehicleMaster');
            // Let's remove the hasMany...
            $this->AssessmentVehicleMaster->unbindModel(
                    array('hasMany' => array('AssessmentVehicleDetail'))
            );
            $AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('first', array('conditions' => array('AssessmentVehicleMaster.vc_assessment_no' => trim($assessmentno))));
			//pr($AssessmentVehicleMaster);
			//die;
            if ($assessmentno != null && $AssessmentVehicleMaster) {

                $this->loadModel('AssessmentVehicleDetail');

                $this->layout = 'userprofile';
               /*$this->AssessmentVehicleDetail->unbindModel(
                    array(array('belongsTo' => array('AssessmentVehicleMaster'))
                    ),array('hasOne' => array('VehicleDetail'))
                    );*/
                $this->paginate = array(
                    'conditions' => array(
                        'AssessmentVehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                        'AssessmentVehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                        'AssessmentVehicleDetail.vc_assessment_no' => $assessmentno,
                    ),
                    'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc'),
                    'limit' => 5
                );
				// pr($this->paginate('AssessmentVehicleDetail'));

                $this->set('data', $this->paginate('AssessmentVehicleDetail'));

                $this->set('AssessmentVehicleMaster', $AssessmentVehicleMaster);
				
				$this->set('assessmentno', $assessmentno);

                $this->set('ASSUSRVRF', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'ASSUSRVRF%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

                $this->layout = 'userprofile';
				
            } else {

                $this->Session->setFlash('Invalid assessment no.', 'error');
				
                $this->redirect(array('controller' => 'vehicles', 'action' => 'viewassessment'));
				
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }
	
	
	function deleteajaxfile(){
	    $this->layout = NULL;
		$this->autoRender = false;
		$client_no = trim($this->Session->read('Auth.Client.vc_client_no'));
		//pr($this->params);die;
		if($this->params['isAjax']){
				$doc_id       =  base64_decode($this->params['form']['VehicleDocId']);
				$DownloadFile = $this->DocumentUploadVehicle->find('first', array(
				'conditions' => array(
					'DocumentUploadVehicle.vc_upload_vehicle_id' => $doc_id),
				));

				$path = $DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'];
				unlink($path);

				$deleted = $this->DocumentUploadVehicle->deleteAll(array('DocumentUploadVehicle.vc_upload_vehicle_id' => $doc_id),false);
				//unlink(WWW_ROOT.DS.'uploadify'.DS.$client_no.DS.$filename);
				
				
			//	echo 'deleted';
				
		}
		die;
	}
	
	function deletedoc($urlvalue=null,$amend_id=null){
		
		$this->layout = NULL;
				$this->loadModel('AssessmentVehicleMaster');
	
		if($amend_id!='')
		$doc_id = base64_decode($amend_id);		
		
		if($urlvalue=='V'){
		
			$DownloadFile = $this->DocumentUploadVehicle->find('first', array(
            'conditions' => array(
                'DocumentUploadVehicle.vc_vehicle_amend_no' => $doc_id),
            ));
		   $path = $DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'];     
		
		}
		
		if($urlvalue=='N'){
		
			$DownloadFile = $this->DocumentUpload->find('first', array(
            'conditions' => array(
                'DocumentUpload.vc_cust_amend_no' => $doc_id),
            ));
			
			$path = $DownloadFile['DocumentUpload']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUpload']['vc_uploaded_doc_name']; 
		}
		
		
		if($urlvalue=='A'){
		
			$DownloadFile = $this->DocumentUploadVehicle->find('first', array(
            'conditions' => array(
                'DocumentUploadVehicle.vc_vehicle_assess_no' => $doc_id),
            ));
			$path = $DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'];
			$this->DocumentUploadVehicle->deleteAll(array('DocumentUploadVehicle.vc_vehicle_assess_no'=>$doc_id));
			//			die;
			//$arrayvalue=array('AssessmentVehicleMaster.ch_upload_doc'=>'N');
			$this->AssessmentVehicleMaster->create();
            $data['ch_upload_doc'] = 'N';
			$this->AssessmentVehicleMaster->id=$doc_id;		
            $this->AssessmentVehicleMaster->set($data);
            $this->AssessmentVehicleMaster->save($data,false);
     		//			die;
					

			//$this->AssessmentVehicleMaster->set($arrayvalue);       
			//$this->AssessmentVehicleMaster->save($arrayvalue, false);

		}

        if ($DownloadFile && file_exists($path)) {                  
				unlink($path);
		}
		
		    $this->Session->setFlash('File deleted successfully !!', 'success');			
		    $this->redirect($this->referer());

		
	}
	function downloadammned($urlvalue=null,$amend_id=null){
	
		if($amend_id!='')
		$doc_id = base64_decode($amend_id);
		
		$this->layout = NULL;
		if($urlvalue=='V'){
		
			$DownloadFile = $this->DocumentUploadVehicle->find('first', array(
            'conditions' => array(
                'DocumentUploadVehicle.vc_vehicle_amend_no' => $doc_id),
            ));
		$path = $DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'];     
		}
		if($urlvalue=='N'){
		
			$DownloadFile = $this->DocumentUpload->find('first', array(
            'conditions' => array(
                'DocumentUpload.vc_cust_amend_no' => $doc_id),
            ));
			$path = $DownloadFile['DocumentUpload']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUpload']['vc_uploaded_doc_name']; 
		}
		
		
		if($urlvalue=='A'){
		
			$DownloadFile = $this->DocumentUploadVehicle->find('first', array(
            'conditions' => array(
                'DocumentUploadVehicle.vc_vehicle_assess_no' => $doc_id),
            ));
			$path = $DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'];
//			die;
		}

        if ($DownloadFile && file_exists($path)) {                  
			
			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($path));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            ob_clean();
            flush();
            readfile($path);
            exit(0);
			
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect('index');
        }
	}

	function download($id=null){
		
		//Configure::write('debug',0);
		
		if($id!='')
		$doc_id = base64_decode($id);
		
		$this->layout = NULL;

       /*
	   
	    $usercompanySessionid = $this->Session->read('Auth.Profile.nu_company_id');
        $customer_no = trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
        $comp_code = trim($this->Session->read('Auth.Member.vc_comp_code'));
		
		*/
		
		
		$DownloadFile = $this->DocumentUploadVehicle->find('first', array(
            'conditions' => array(
                'DocumentUploadVehicle.vc_upload_vehicle_id' => $doc_id),
            ));

        if ($DownloadFile && file_exists($DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'])) {

            $path = $DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_path'].DS.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_name'];
			
            /*
			header('Expires: 0');
            header('Pragma: public');
			header('Content-type:'.$DownloadFile['DocumentUploadVehicle']['vc_uploaded_doc_type']);
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Content-Transfer-Encoding: binary');
            @readfile($path);	
			*/	
			
			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($path));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            ob_clean();
            flush();
            readfile($path);
            exit(0);
			
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect('index');
        }
    }
    /**
     *
     * Download Mdc Notice 
     *
     */
    function getMdcNotice() {

        $filename = 'MDC-Notice.pdf';

        $baseFile = 'document/MDC-Notice.pdf';

        if (file_exists($baseFile)) {

            header('Expires: 0');

            header('Pragma: public');

            header('Content-type: application/pdf');

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Content-Type: application/octet-stream');

            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

            header('Content-Transfer-Encoding: binary');

            @readfile($baseFile);

            exit(0);
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect($this->referer());
        }
    }

    /**
     *
     * Download Mdc Reference Letter 
     *
     */
    function getMdcRfrLetter() {


        $filename = 'MDC-Ref-Letter.pdf';

        $baseFile = 'document/MDC-Ref-Letter.pdf';

        if (file_exists($baseFile)) {

            header('Expires: 0');

            header('Pragma: public');

            header('Content-type: application/pdf');

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Content-Type: application/octet-stream');

            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

            header('Content-Transfer-Encoding: binary');

            @readfile($baseFile);

            exit(0);
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect($this->referer());
        }
    }
	
	/**
     *
     * Download Mdc Print Receipt 
     *
     */
	

	function downloadPrintReceipt ($assessmentno = null ,$cron=null) {

		 try {
			//Configure::write('debug',0);
			$this->loadModel('AssessmentVehicleMaster');
			$majorcnt=0;
			if($cron==1){			
				$this->set('cron',$cron);
			}else{
				$this->set('cron',0);			
			}	

			$vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');

			$AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('all', array('conditions' => array('AssessmentVehicleMaster.vc_customer_no' => trim($vc_customer_no),'AssessmentVehicleMaster.vc_status'=>'STSTY04')));
			
			//pr($AssessmentVehicleMaster);die;
			
			$totaloutstanding=0;
					foreach($AssessmentVehicleMaster as $index=>$value){
							$cnt=0;
							$outstand=((float)$value['AssessmentVehicleMaster']['nu_total_payable_amount']-(float)$value['AssessmentVehicleMaster']['vc_mdc_paid']);
					//		echo '<br>';
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
			//die;
			if ($AssessmentVehicleMaster) {

				$this->layout = 'pdf';
				$this->set('nettotaloutstanding',$totaloutstanding);		
					
				$this->set('AssessmentVehicleMaster' , $AssessmentVehicleMaster);	
			
			} else {
				
				$this->Session->setFlash('No approved assessment yet.', 'error');
				
				$this->redirect($this->referer());
			}
			
			$columnsValues=array('Assessment
					Number','Assessment Date',
			'Vehicle License No.','Vehicle Registration No.',
			'Total KM','KM/100','Rate (N$)',
			'Amount Due(N$)','Amount Paid(N$)',
			'Outstanding Amount (N$)'
			);
			
		$this->Assessmentreportpdfcreator->headerData('',$this->Session->read('Auth'),$AssessmentVehicleMaster) ;	
		//$totaloutstanding=222;
		$this->Assessmentreportpdfcreator->genrate_mdc_assessmentreport($columnsValues,$AssessmentVehicleMaster,$this->globalParameterarray,$totaloutstanding);
	    $this->Assessmentreportpdfcreator->output($vc_customer_no.'-MDC_Assessment_Statement'.'.pdf', 'D');
	   
		die;

		
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }	 
		
	}

	/**
     *
     * Download Mdc Pay Proof 
     *
     */
	
	function downloadPayProof ($assessmentno = null) {

		try { 
				
			$this->loadModel('AssessmentVehicleMaster');
			
			$vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');
			
			$AssessmentVehicleMaster = $this->AssessmentVehicleMaster->find('first', array('conditions' => array('AssessmentVehicleMaster.vc_assessment_no' => trim($assessmentno),
			'AssessmentVehicleMaster.vc_customer_no' =>$vc_customer_no
			)));
			
			if ($assessmentno!= null && $AssessmentVehicleMaster) {

				/*
				header('Expires: 0');

                header('Pragma: public');

				header('Content-type: application/pdf');

				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

				header('Content-Type: application/octet-stream');
				$filename='MDC_Assessment_Invoice'.date('YmdHis'). '.pdf';
				header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

				header('Content-Transfer-Encoding: binary');
				*/	
			//	@readfile($baseFile);
					
				$this->set('AssessmentVehicleMaster' , $AssessmentVehicleMaster);	
								$this->layout = 'pdf';

			
			} else {

				$this->Session->setFlash('Invalid assessment no.', 'error');

				$this->redirect($this->referer());
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
	*
	*/

	function getvehicleremarksbyid(){

		//Configure::write('debug', 0);
		
		$this->layout = null;
		
		if( $this->params['isAjax'] && isset($this->params['data']) ):
			
			$data = $this->VehicleDetail->find('first', array('conditions'=>array(
													'VehicleDetail.vc_registration_detail_id'=>base64_decode(trim($this->params['data']))
											)));
				
		else :
		
			$data  = array();	
				
		endif;

		$this->set('data', $data);	
	}
	
	/**
	*
	*
	*
	*
	*/

	function getassessmentremarksbyid(){

		//Configure::write('debug', 0);
		
		$this->layout = null;
		
		if( $this->params['isAjax'] && isset($this->params['data']) ):
			
			$this->loadModel('AssessmentVehicleMaster');
			
			$data = $this->AssessmentVehicleMaster->find('first', array('conditions'=>array(
													'AssessmentVehicleMaster.vc_assessment_no'=>base64_decode(trim($this->params['data']))
											)));
				
		else :
		
			$data  = array();	
				
		endif;

		$this->set('data', $data);	
	}
	
	
	/**
     *
     *
     *
     */
    function changedetail($id = null) {

        try {
		
			set_time_limit(0);		
			$id = base64_decode(trim($id));
			
			$nu_company_id   = $this->Session->read('nu_company_id');
			$vc_comp_code    = $this->Session->read('Auth.Member.vc_comp_code');		
			$ch_active       = $this->Session->read('Auth.Profile.ch_active');
			// $vc_customer_no = $this->Session->read('Auth.Member.vc_mdc_customer_no');
			$vc_customer_no  = $this->Session->read('Auth.Profile.vc_customer_no');
			$vc_username     = $this->Session->read('Auth.Member.vc_username');
			
			$this->set('nu_company_id',$nu_company_id);
			/*	$sqlResult = $this->VehicleDetail->find('first', array('conditions' => 		array('VehicleDetail.vc_registration_detail_id' => $id)));

			*/
		
			
			$sqlResultforvalidvehicle = $this->VehicleDetail->find('count', array('conditions' => array('VehicleDetail.vc_registration_detail_id' => $id)));
			
			if($sqlResultforvalidvehicle==0){
			    $this->Session->setFlash(' Invalid Vehicle details', 'error');


				$this->redirect($this->referer());
			
			}
			
			$sqlResult = $this->VehicleDetail->find('first', array('conditions' => array('VehicleDetail.vc_registration_detail_id' => $id,'VehicleDetail.vc_customer_no' => $vc_customer_no,'VehicleDetail.vc_vehicle_status'=>'STSTY03')));
			
			
			$vehicledocs = $this->DocumentUploadVehicle->find('all', array('conditions' => array('DocumentUploadVehicle.vc_registration_detail_id' => $id,)));
			
			//pr($vehicledocs);
			$this->set('vehicledocs',$vehicledocs);
			
            if ($sqlResult) {

                if (!empty($this->data) && $this->RequestHandler->isPost()) {
						
					$filepath = trim($this->Session->read('Auth.Member.vc_username'));


                    /** *******Firstly Delete old File and Entry From Database ************ */

                    

                    $dir = WWW_ROOT."uploadfile".DS."$filepath".DS.'Vehicle'.DS.trim($sqlResult['VehicleDetail']['vc_vehicle_lic_no']);

                    

                    /* *********** End *********** */
                    /** **Set File Upload Data According with Vehicle******** */
					
				
				/*
				
				$unapprovedsqlResult = $this->VehicleDetail->find('count', array('conditions' => array('VehicleDetail.vc_registration_detail_id' => $id,'VehicleDetail.vc_customer_no' => $vc_customer_no,'VehicleDetail.vc_vehicle_status'=>'STSTY03')));				
				//die;
				if($unapprovedsqlResult==0){
					//$sqlResult['VehicleDetail']['vc_vehicle_lic_no'];
					$this->Session->setFlash('You cannot change the vehicle details.');

					$this->redirect($this->referer());
				}
				
				*/
	
                    foreach ($this->data['VehicleDetail'] as $key => &$value) {

                        $value['DocumentUploadVehicle'] = $this->data['DocumentUploadVehicle'][$key];

                        unset($this->data['DocumentUploadVehicle'][$key]);
                    }
					if(isset($this->data['DocumentUploadVehicle']) && count($value['DocumentUploadVehicle'])>0){
					
						/*
						$this->DocumentUploadVehicle->deleteAll(array('DocumentUploadVehicle.vc_registration_detail_id' => $sqlResult['VehicleDetail']['vc_registration_detail_id']));
						if (file_exists($dir)) {

							$this->rrmdir($dir);
						}*/
					
					}

                    unset($value);
                    unset($this->data['DocumentUploadVehicle']);


                    /* * ******************End****************************** */

                    /** *********Save data in detail Table ************************ */
					
					$erro = false;
					
                    foreach ($this->data['VehicleDetail'] as $value) {
						
						
							/*
							if ($this->VehicleDetail->find('count', array(
										'conditions'=>array(
												'lower(VehicleDetail.vc_registration_detail_id) !='=>strtolower(trim($value['vc_registration_detail_id'])),
												'OR'=>array(
													'VehicleDetail.vc_vehicle_lic_no '=>array( $value['vc_vehicle_lic_no'], $value['vc_vehicle_reg_no'] ),
													'VehicleDetail.vc_vehicle_reg_no '=>array( $value['vc_vehicle_lic_no'], $value['vc_vehicle_reg_no'] ),
												))
									)) == 0 ) {
							*/
							
							if($this->VehicleDetail->find('count', array(
										'conditions'=>array(
												'lower(VehicleDetail.vc_registration_detail_id) !='=>strtolower(trim($value['vc_registration_detail_id'])),
												'OR'=>array(
													array(
													'lower(VehicleDetail.vc_vehicle_lic_no)'=>strtolower(trim($value['vc_vehicle_lic_no']))),
													array(
													'lower(VehicleDetail.vc_vehicle_lic_no)'=>strtolower(trim($value['vc_vehicle_reg_no']))),
													array(
													'lower(VehicleDetail.vc_vehicle_reg_no)'=>strtolower(trim($value['vc_vehicle_lic_no']))),
													array(
													'lower(VehicleDetail.vc_vehicle_reg_no)'=>strtolower(trim($value['vc_vehicle_reg_no'])))
													)
									))) == 0 )	
									{
//die;
								$this->VehicleDetail->validate = null;

								$this->VehicleDetail->id = $value['vc_registration_detail_id'];

								$value['dt_modified_date'] = date('Y-m-d H:i:s');

								$value['vc_vehicle_status'] = 'STSTY03';
								$value['vc_registration_detail_id']=$value['vc_registration_detail_id'];

								$nu_company_id = $value['nu_company_id'];
								//$value['nu_company_id'] = $nu_company_id;

								$this->VehicleDetail->set($value);

								$this->VehicleDetail->save();

								/******* Upload Docs ********/

								$dir = WWW_ROOT."uploadfile" . DS . "$filepath" . DS .'Vehicle'. DS . trim($value['vc_vehicle_lic_no']);

								if (!file_exists($dir)) {

									mkdir($dir, 0777, true);
								}
								$cntrvalue=1;
								foreach ($value['DocumentUploadVehicle'] as  $key => $docUpload) {

									$docUpload['vc_customer_no'] = $this->Session->read('Auth.Profile.vc_customer_no');

									$docUpload['vc_comp_code'] = $this->Session->read('Auth.Profile.vc_comp_code');

									$docUpload['vc_registration_detail_id'] = $value['vc_registration_detail_id'];

									$docUpload['vc_upload_vehicle_id'] = $this->DocumentUploadVehicle->getPrimaryKey();

									$docUpload['vc_uploaded_doc_path'] = $dir;

									$filename = base64_decode(trim($docUpload['newfile']));
									$newfile= $cntrvalue."-".$this->renameUploadFile($filename);
								   
									$docUpload['vc_uploaded_doc_name'] = $newfile;
									$gtmimetype = getimagesize(base64_decode(trim($docUpload['fpath'])). DS . $filename);
									// echo exif_imagetype(base64_decode(trim($docUpload['fpath'])). DS . $filename);
									// pr($docUpload);
									// die;									
									$docUpload['nu_company_id'] = $nu_company_id;

									$docUpload['vc_uploaded_doc_type'] = $gtmimetype['mime'];

									$docUpload['dt_date_uploaded'] = date('Y-m-d H:i:s');

									$this->DocumentUploadVehicle->validate = null;

									$this->DocumentUploadVehicle->create();

									$this->DocumentUploadVehicle->set($docUpload);

									$this->DocumentUploadVehicle->save();

									rename( base64_decode(trim($docUpload['fpath'])). DS . $filename , $dir.DS.$newfile);

									unset($docUpload);
									$cntrvalue++;
								}

								/******	End	****************/

								unset($value);
						
						} else {
							
								$erro = true;
						
						}
						
                    }
					
					if( $erro ) {
					
						 $this->Session->setFlash('Sorry , you have already registered vehicle register no. or vehicle lic. no. ', 'info');

					
					} else {
					
					
					/*********** Email Send To Customer **************/
					
						list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
						
							$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

							$this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));
							
							$this->Email->bcc = array(trim($this->AdminMdcEmailID));

							$this->Email->subject = strtoupper($selectedType) . " Vehicle Details Changed ";

							$this->Email->template = 'registration';

							$this->Email->sendAs = 'html';

							$this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

							$this->Email->delivery = 'smtp';

							$mesage = " Your vehicle details have been changed successfully, pending for approval from RFA !!";
							
							$mesage .= "<br> <br> Username : ".trim($this->Session->read('Auth.Member.vc_username'));
				
							$mesage .= "<br> <br>RFA Account No. : ".trim($this->Session->read('Auth.Member.vc_mdc_customer_no'));
							
							$this->Email->send($mesage);
								
								
						/****** Email Send To Admin***********/
						/****** End ***********/


						$this->data = null;
						
						$this->Session->setFlash('Your vehicle details have been changed successfully, pending for approval from RFA !! ', 'success');

					}
					
				 
                   
                    $this->redirect(array('controller' => 'vehicles', 'action' => 'view'));
                }


                $this->layout = 'userprofile';

                $this->set('title_for_layout', 'Change Vehicle Registration Detail');

                $this->Set('payfrequency', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PAYFREQ%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

                $this->Set('vehiclelist', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'VEHTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));

                $this->Set('status', $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => $sqlResult['VehicleDetail']['vc_vehicle_status']), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
				
				
                
				$this->set('data', $sqlResult);
				
				            
			} else {

                $this->Session->setFlash('Vehicle details are not allowed to update anymore', 'error');

                $this->redirect(array('controller' => 'vehicles', 'action' => 'view'));
            }
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }
	
	/*
	*
	*
	* Get List of To Destination Location List 
	*
	*/			 
	
	function getdistanceselectedlocationto() {
		
		//Configure::write('debug', 0);
		
		$this->layout = null;
		
		$string = '';
		
		if( $this->params['isAjax'] && isset($this->params['data']) ) :
			
			$data  =  isset($this->params['data']) && trim($this->params['data']) == '' ? NULL : $this->params['data'];  
			
			$string = strtolower(trim($data));
		
		endif;	
			
			$this->loadModel('CustomerLocationDistance');
			
			$conditions = array( 'lower(CustomerLocationDistance.vc_loc_from_code)'=>"{$string}");
			
			$DestinationCustomerLocationDistance = $this->CustomerLocationDistance->find('list', array(
																	'conditions'=>$conditions,
																	'fields'=>array(
																			'CustomerLocationDistance.vc_loc_to_code',
																			'CustomerLocationDistance.loc_to')));
																			
			$additionalvalue = $this->CustomerLocationDistance->find('first', array(
																	'conditions'=>$conditions,
																	'fields'=>array(
																			'CustomerLocationDistance.vc_loc_from_code',
																			'CustomerLocationDistance.loc_from')));
			$newarray = array();
			$newarray = array($additionalvalue['CustomerLocationDistance']['vc_loc_from_code'] => $additionalvalue['CustomerLocationDistance']['loc_from']);
			
			
			$newarray = array_merge($DestinationCustomerLocationDistance,$newarray);
			$this->set('DestinationCustomerLocationDistance',$newarray);																
			
	}
	
	/**
	*
	*
	*
	*
	*/
	
	function calculatedistancelocation() {
	
		//Configure::write('debug', 0);
		
		$this->layout = null;
				
		$vc_orign = '';
		
		$string = '';
		
		$k = 0;
		if( $this->params['isAjax'] 
						&& isset($this->params['form']['vc_orign']) 
						&& isset($this->params['data']) ) :
			
			$string = strtolower(trim($this->params['data']));
			
			$vc_orign = strtolower(trim($this->params['form']['vc_orign'])); 
			
			$k =  trim($this->params['form']['k']);
		
		endif;	
						
			$this->loadModel('CustomerLocationDistance');
			
			$conditions= array(
					'lower(CustomerLocationDistance.vc_loc_from_code)'=>"{$vc_orign}",
					'lower(CustomerLocationDistance.vc_loc_to_code)'=>"{$string}",
					
				);
			
			$distance = $this->CustomerLocationDistance->find('first', array(
																	'conditions'=>$conditions,
																	'fields'=>array(
																			'CustomerLocationDistance.nu_distance')));
			
			
			$result = '';
			if($distance):
				$result =  current($distance['CustomerLocationDistance']);
			else:
				$result = 0;
			endif;
			
			$this->set('result', $result );
			
			$this->set('k', $k );
			
			$this->layout = false;			
	
	}
	
	
	/**
	*
	*
	*
	*
	*/
	
	function calculatedistancelocationother() {
	
		//Configure::write('debug', 0);
		
		$this->layout = null;
				
		$vc_orign = '';
		
		$string = '';
		
		$k = 0;
		
		if( $this->params['isAjax'] 
						&& isset($this->params['form']['vc_orign']) 
						&& isset($this->params['data']) ) :
			
			$string = strtolower(trim($this->params['data']));
			
			$vc_orign = strtolower(trim($this->params['form']['vc_orign'])); 
			
			$k =  trim($this->params['form']['k']);
		
		endif;	
		
			$this->loadModel('CustomerLocationDistance');
			
			$conditions= array();		
				
			$conditions= array(
				'lower(CustomerLocationDistance.vc_loc_from_code)'=>"{$vc_orign}",
				'lower(CustomerLocationDistance.vc_loc_to_code)'=>"{$string}",
				
			);		
			
			$distance = $this->CustomerLocationDistance->find('first', array(
																	'conditions'=>$conditions,
																	'fields'=>array(
																			'CustomerLocationDistance.nu_distance')));
			$result = '';
			if($distance):
				$result =  current($distance['CustomerLocationDistance']);
			else:
				$result = 0;
			endif;
			
			$this->set('result', $result );
			$this->set('k', $k );
			
			$this->layout = false;
			
			
	
	}
	
	/**
	* 
	* Below function is use to get list of origin location
	*
	*/

	function  getoriginlocation() {
		
		$this->loadModel('CustomerLocationDistance');
		
		$this->set('OriginCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(
																		'fields'=>array(
																			'CustomerLocationDistance.vc_loc_from_code',
																			'CustomerLocationDistance.loc_from'))));
			
		
	}
	
	/**
	* 
	* Below function is use to get list of destination location
	*
	*/

	function  getdestinationlocation() {
		
		$this->loadModel('CustomerLocationDistance');
		$this->set('DestinationCustomerLocationDistance', array());
		/*$this->set('DestinationCustomerLocationDistance', $this->CustomerLocationDistance->find('list',array(	'fields'=>array(	'CustomerLocationDistance.loc_to'))));*/
	
	}
        
     function ownershipchangedetail() {
			set_time_limit(0);
			$nu_company_id = $this->Session->read('nu_company_id');
			$this->Set('nu_company_id',$nu_company_id);          
			$this->set('customerdetails', $this->Session->read('Auth'));
            
            $this->loadModel('OwnershipChangeHistory');
            $this->loadModel('NameChangeHistory');
           
            $conditions     =   array('vc_customer_no'=>trim($this->Session->read('Auth.Profile.vc_customer_no')),
                                      'vc_comp_code'=>trim($this->Session->read('Auth.Profile.vc_comp_code'))
                                  );    
           
            $limit = 10;
            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('NameChangeHistory.dt_amend_date' => 'desc'),
                'limit' => $limit
            );
            $this->set('ownershipchangedetails', $this->paginate('NameChangeHistory'));

            $this->layout = 'userprofile';
            
            
        }
}