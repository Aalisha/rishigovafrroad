<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class SuppliersController extends AppController {

    /**
     *
     *
     */
    var $name = 'Suppliers';

    /**
     *
     *
     */
	 
    var $uses = array('FuelOutlet','ParameterType','Bank','BankBranch','ClientHeader','ClientBank','ClientUploadDocs','Clientsupplier', 'Member','Client');
	
	var $helpers = array('Session', 'Html', 'Form','Suppliername');

    /**
     *
     *
     */
    public function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();
        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');

        if ($FRL_USER_TYPE == 'USRLOGIN_SUPL') {

            $this->layout = 'flr_supplier';
        } else {

            $this->redirect(array('controller' => 'clients', 'action' => 'index', 'flr' => true));
        }
		$ch_active = $this->Session->read('Auth.Client.ch_active_flag');
		$vc_username = $this->Session->read('Auth.Member.vc_username');


		if($vc_username!='' && ($ch_active=='STSTY05' || $ch_active=='' || $ch_active=='STSTY03' ) && $FRL_USER_TYPE=='USRLOGIN_SUPL')
		$this->Auth->allow('flr_index','flr_view','flr_changepassword','flr_downloadrefunddoc','rrmdir');		
		
		if($vc_username!='' && $ch_active=='STSTY04' && $FRL_USER_TYPE=='USRLOGIN_SUPL')
		$this->Auth->allow('*');		
		
		$this->loginRightCheck();
		
    }
	
	function loginRightCheck() {

       if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {
            $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        
        }
      
    }
	
	function flr_viewsupplierinvoice(){
		$this->loadModel('Supplier');
		 $client_no = trim($this->Session->read('Auth.Clientsupplier.vc_client_no'));
	 /* $invoiceuploaded = $this->Supplier->find('all', array(
	  'conditions'=>,
	  'fields' => array('vc_invoice_no','nu_liters','nu_amount','vc_sold_to','dt_invoice_date','vc_supplier_no','dt_created_date')));
	  */
	   $conditions     =   array('Supplier.vc_supplier_no'=>$client_no);    
           
            $limit = 10;
            $this->paginate = array(
                'conditions' => $conditions,
                'limit' => $limit
            );
            $this->set('invoiceuploaded', $this->paginate('Supplier'));
	//  pr($invoiceuploaded);
	  //$this->set('invoiceuploaded',$invoiceuploaded);

	}
	
	
	function flr_downloadrefunddoc() {


        $this->layout = NULL;

        $this->loadModel('ClientUploadDocs');

        $client_no = trim($this->Session->read('Auth.Client.vc_client_no'));

        $comp_code = trim($this->Session->read('Auth.Client.vc_comp_code'));

        $DownloadFile = $this->ClientUploadDocs->find('first', array(
            'conditions' => array(
			'ClientUploadDocs.vc_comp_code' => $comp_code,
                'ClientUploadDocs.vc_client_no' => $client_no),                
            'order' => array('ClientUploadDocs.dt_date_uploaded' => 'desc')));

        if ($DownloadFile && file_exists($DownloadFile['ClientUploadDocs']['vc_uploaded_doc_path'] . DS . $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name'])) {

            $path = $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_path'].DS. $DownloadFile['ClientUploadDocs']['vc_uploaded_doc_name'];

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
     * Function to add the client details
     *
     */
    public function flr_index($id = null) {

        try {
			set_time_limit(0);
		        //     ini_set('set_time_limit',0);
            $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');
			
			$errormsg=true;
			if(isset($this->data['ClientUploadDocs']['fuelusagedoc']['name']) && $this->data['ClientUploadDocs']['fuelusagedoc']['name']!=''){
			
				if((int)$this->data['ClientUploadDocs']['fuelusagedoc']['size']>2048000){
				  $this->Session->setFlash('Please upload less than 2MB ', 'error');
                        //$this->redirect(array('action' => 'index'));
						$errormsg=false;
				}
			}
			if($errormsg==true){
			
            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Clientsupplier->set($this->data);
                $this->ClientUploadDocs->set($this->data);
				
				//unset($this->ClientUploadDocs->validate['bankdoc']);
				//unset($this->ClientUploadDocs->validate['ownershipchange']);
				//pr($this->ClientUploadDocs->validate);
				/*pr($this->Clientsupplier->validates(array('fieldList' => array(                                'vc_client_name','vc_fuel_outlet','vc_address1',
                'vc_address2','vc_address3','vc_fuel_outlet',
                 'vc_postal_code1','vc_tel_no','vc_cell_no','vc_fax_no'))));
				 pr($this->ClientUploadDocs->validates(array('fieldList' =>array('fuelusagedoc'))));
				 die;
				 */
				if ($this->Clientsupplier->validates(array('fieldList' => array(                                'vc_client_name','vc_fuel_outlet','vc_address1',
                'vc_address2','vc_address3','vc_fuel_outlet',
                 'vc_postal_code1','vc_tel_no','vc_cell_no','vc_fax_no')))) {
						
                    //ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
                    
					$client = $this->Clientsupplier->getDataSource();
                    
					$client->begin();
					
                    $id = $id == null ? null : base64_decode($id);

                    if ($id == null) {
                        
						$primaryKey = 'SUP-'.$this->Clientsupplier->getPrimaryKey();
						$this->data['Clientsupplier']['vc_user_no'] = trim($this->Session->read('Auth.Member.vc_user_no'));
                        $this->data['Clientsupplier']['dt_date1'] = date('d-M-Y H:i:s');

					}else {
					
                        if ($this->Clientsupplier->find('count', array('conditions' => array('Clientsupplier.vc_client_no' => trim($id)))) > 0) {
						
                            $primaryKey = $id;
                            $this->data['Clientsupplier']['dt_mod_date'] = date('d-M-Y H:i:s');
                        
						} else {
						
                            $this->Session->setFlash('Invalid parameter, please try again!!!', 'info');
                            $this->redirect($this->referer());
                        
						}
                    }


                    /**********Master Table MST_Client****************** */

                    $this->data['Clientsupplier']['vc_comp_code']   = trim($this->Session->read('Auth.Member.vc_comp_code'));
                    $this->data['Clientsupplier']['ch_active_flag'] = 'STSTY03';
                    $this->data['Clientsupplier']['vc_username']    = trim($this->Session->read('Auth.Member.vc_username'));
                    $this->data['Clientsupplier']['vc_client_no']   = $primaryKey;
                    $this->data['Clientsupplier']['vc_user_no']     = trim($this->Session->read('Auth.Member.vc_user_no'));
                    $this->data['Clientsupplier']['vc_email']       = trim($this->Session->read('Auth.Member.vc_email_id'));

                    if ($this->Clientsupplier->save($this->data, false)) {

                        $client->commit();
                        $this->loadModel('Member');
                        $saveData                                 = array();
                        $saveData['Member']['dt_user_modified']   = date('Y-m-d H:i:s');
                        $saveData['Member']['vc_flr_customer_no'] = $primaryKey;
                        $saveData['Member']['vc_user_no'] = trim($this->Session->read('Auth.Member.vc_user_no'));
                        $this->Member->save($saveData, false);
                        unset($saveData);

                        /*********Email Functionality *************** */


                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<'.$this->AdminEmailID. '>';

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
                        $this->Session->write('Auth.Member.vc_flr_customer_no', $primaryKey);
						
                        if ($id != null && trim($id) != '') {
								
								$this->ClientUploadDocs->deleteAll(array('ClientUploadDocs.vc_client_no' => $primaryKey), false);

                                $this->rrmdir(WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Profile');
								
                               $this->Session->setFlash('Your account has been updated successfully, pending for approval from RFA !!', 'success');
                        
						} else {
						
                               $this->Session->setFlash('Your account has been created successfully, pending for approval from RFA !!', 'success');
                        
						}
							$uploadDocs=array();
							
							$uploadDocs['ClientUploadDocs']['vc_comp_code'] = $this->Session->read('Auth.Member.vc_comp_code');

							$uploadDocs['ClientUploadDocs']['dt_date_uploaded'] = 
							date('d-M-Y H:i:s');

                            $uploadDocs['ClientUploadDocs']['vc_client_no'] = 
							$primaryKey;
							
							$filename= time().'-'.$this->data['ClientUploadDocs']['fuelusagedoc']['name'];
                            $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_name'] 
							= $filename;

                            $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_type'] = $this->data['ClientUploadDocs']['fuelusagedoc']['type'];
                               
                            $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_for'] = 'SupplierProfile';
							
                            $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'] = WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Profile';

                            $uploadDocs['ClientUploadDocs']['vc_upload_id'] = $this->ClientUploadDocs->getPrimaryKey();
							$dir = $uploadDocs['ClientUploadDocs']['vc_uploaded_doc_path'];
							 
							mkdir($dir, 0777, true);
							$uploadedfile= move_uploaded_file($this->data['ClientUploadDocs']['fuelusagedoc']["tmp_name"], $dir . DS . $filename);
							
							if($uploadedfile==true){
							
							$this->ClientUploadDocs->save($uploadDocs, false);
							
							}
							$this->data = null;
                             
							$this->redirect(array('action' => 'view'));
						
                    } else {
					
                        $this->data = null;
                        $client->rollback();
                        $this->Session->setFlash(' Your profile has not been created due to some error has occurred ', 'error');
                        $this->redirect(array('action' => 'index'));
                    }
                }
            }
			}
			//pr($this->Session->read('Auth'));
			//echo 'hus---',$this->Session->read('Auth.Client.ch_active_flag');
			//die;
            if (trim($this->Session->read('Auth.Member.vc_flr_customer_no')) == '') :

                $this->set('title_for_layout', " Add Supplier Profile ");

                $this->render('flr_index');

            elseif (trim($this->Session->read('Auth.Client.ch_active_flag')) == 'STSTY05'):			

                $this->set('title_for_layout', " Edit Supplier Profile ");

                $this->render('flr_edit');

            else :
                $this->set('title_for_layout', " View Supplier Profile ");
                $this->redirect('view');

            endif;
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
		
			$profile=$this->Clientsupplier->find('first',array('conditions'=>array('Clientsupplier.vc_client_no'=>$this->Session->read('Auth.Member.vc_flr_customer_no'))));
           
            $this->Session->write('Auth.Client', $profile['Clientsupplier']);
			//echo $this->Session->read('Auth.Client.ch_active_flag');
			//die;
			if ($this->Session->read('Auth.Member.vc_flr_customer_no') == '' || $this->Session->read('Auth.Client.ch_active_flag') == 'STSTY05') :
			$this->redirect(array('action' => 'index'));
             
            endif;

            
            $this->set('title_for_layout', " View Client Profile ");


        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     * 
     * Flr Change Client Password 
     *
     */

    public function flr_changepassword() {

        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');

        try {

           
            $this->set('title_for_layout', " Change Password ");
			
            if (!empty($this->data) && $this->RequestHandler->isPost()) {

                $this->Clientsupplier->set($this->data);
                
				/* **** Use this before any validation********** */
                
				$setValidates = array('vc_old_password','vc_password','vc_confirm_password');

                /******************************************************* */

                $username = $this->Session->read('Auth.Member.vc_username');
                $newpassword = $this->data['Clientsupplier']['vc_password'];

                if ($this->Clientsupplier->validates(array('fieldList' => $setValidates))) {
                    $this->loadModel('Member');
                    $this->Member->validate = null;
                    $updateData['Member']['vc_password'] = $this->Auth->password(trim($this->data['Clientsupplier']['vc_password']));
                    $updateData['Member']['dt_user_modified'] = date('Y-m-d H:i:s');
                    $updateData['Member']['vc_user_no'] = $this->Session->read('Auth.Member.vc_user_no');

                    if ($this->Member->save($updateData)) {
                        $this->data = NUll;
                        /****************Email send to********************** */
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
                }else { 
				
					$this->data = NUll;
					$this->Session->setFlash('Invalid details', 'error');

					$this->redirect($this->referer());
				}
            }

            $this->set('title_for_layout', " Change Password ");
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
    function flr_supplier() {

        App::import('Vendor', 'Excel/reader');
        $this->loadModel('Supplier');
		
        if (!empty($this->data)) {

            if (isset($this->data['Supplier']['saledetails']['name']) && 
			$this->data['Supplier']['saledetails']['name']!= '') {
                $filenameexp = explode(".", $this->data['Supplier']['saledetails']['name']);
                $filenameexplength = count($filenameexp);
                $extension = $filenameexp[$filenameexplength - 1];
            }
			
			if(isset($this->data['Supplier']['saledetails']['size']) && $this->data['Supplier']['saledetails']['size']!=''){
			$filenamesize =	$this->data['Supplier']['saledetails']['size'];
			$restrictsize = 10240000;
			if((int)$filenamesize>(int)$restrictsize){
				$this->Session->setFlash('Error.  File size is more than 10 MB.', 'error');
				$this->redirect('supplier');
			}		
			}
			
            if ($extension == 'xls' || $extension == 'xlt' || $this->data['Supplier']['saledetails']['type'] == 'application/vnd.ms-excel') {

                $data = new Spreadsheet_Excel_Reader();


                $data->read($this->data['Supplier']['saledetails']['tmp_name']);
                //Excel manupulation

                $headings = array();
                $xls_data = array();

                /* code for duplicacy check */


                $datahascode = $this->Supplier->find('all', array('fields' => array('vc_invoice_no')));

                foreach ($datahascode as $vc_invoice_no) {
                    $vc_invoice_num[] = $vc_invoice_no['Supplier']['vc_invoice_no'];
                }
                if (!empty($vc_invoice_num)) {
                    $vc_invoice_num = $vc_invoice_num;
                } else {
                    $vc_invoice_num = array();
                }
                $messag = '';


                if (!empty($data->sheets[0]['cells'][1][1]) && $data->sheets[0]['cells'][1][1] == 'VC_INVOICE_NO' && $data->sheets[0]['cells'][1][2] == 'NU_LITERS' && $data->sheets[0]['cells'][1][3] == 'NU_AMOUNT' && $data->sheets[0]['cells'][1][4] == 'VC_SOLD_TO' && $data->sheets[0]['cells'][1][5] == 'DT_INVOICE_DATE'
                ) {

                    for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                        $row_data = array();

                        if (!in_array($data->sheets[0]['cells'][$i][1], $vc_invoice_num)) {

                            $row_data['vc_invoice_no'] = isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : 0;
                            $row_data['nu_liters'] = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : 0;
                            $row_data['nu_amount'] = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : 0;
                            $row_data['vc_sold_to'] = isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : 0;
							
                            $row_data['dt_invoice_date'] = isset($data->sheets[0]['cells'][$i][5]) ?
                                    date('d-M-Y', strtotime($data->sheets[0]['cells'][$i][5])) : '';


                            $row_data['vc_supplier_id'] = $this->Session->read('Auth.Member.vc_username');
							$row_data['dt_created_date'] = date('Y-m-d H:i:s');
							$row_data['vc_supplier_no'] = $this->Session->read('Auth.Clientsupplier.vc_client_no');
                            $row_data['vc_supplier_name'] = trim(ucfirst($this->Session->read('Auth.Member.vc_user_firstname'))) . " " . trim(ucfirst($this->Session->read('Auth.Member.vc_user_lastname')));
                            $row_data['vc_supplier_email'] = $this->Session->read('Auth.Member.vc_email_id');

                            if ($i > 1) {
                                $xls_data[] = $row_data;
                            }
                        } else {
                            $ifmatched[] = $data->sheets[0]['cells'][$i][1];
                        }
                    }
                } else {
                    $messag .= 'Wrong excel file has been tried to upload';
					$this->redirect('supplier');
                }


                $duplicateNumrows = '';

                if (!empty($ifmatched)) {
                    $duplicateNumrows = count($ifmatched);
                    $valuesOf = '';
                    foreach ($ifmatched as $key => $val) {
                        $valuesOf.= $val . ',';
                    }
                    $messag .= 'Invoice Number ' . trim($valuesOf, ',') . ' in excel file is duplicate entry. This Invoice  number already exist in the database<br />';
					
                }

                if (!empty($xls_data)) {
                    if ($this->Supplier->saveAll($xls_data, array('validate' => false))) {

                        $this->Session->setFlash('Imported ' . count($xls_data) . ' records.<br />' . $messag, 'default', 'success');
						$this->redirect('supplier');
                    } else {
                        
						$this->Session->setFlash('Error.  Unable to import records. Please try again.', 'error');
						
						$this->redirect('supplier');
                    }
                } else {
                    $this->Session->setFlash($messag);
                }
            } else {
                $this->Session->setFlash("No file has been selected or invalid file has been tried to upload. Upload excel file only.", 'error');
				$this->redirect('supplier');
            }
        }


        $this->set('title_for_layout', " Wholesaler / Supplier ");
    }

}