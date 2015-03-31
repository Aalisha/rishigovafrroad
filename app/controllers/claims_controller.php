<?php

App::import('Sanitize');

/**
 *
 *
 */
class ClaimsController extends AppController {

    /**
     *
     *
     */
    var $name = 'Claims';

    /**
     *
     *
     */
    var $components = array('Auth', 'Session', 'RequestHandler', 'Email');

    /**
     *
     *
     */
	 var $uses = array('Client', 'Member','BankBranch','FuelOutlet','ClientHeader','ClientUploadDocs','ClientFuelOutlet','Bank','ParameterType','ClientChangeHistory','ClaimprocessData','ClientBank','ClientBankHistory','ClaimDetail','ClaimHeader','InvoiceClaimDoc');
        

    /**
     *
     *
     */
	 
    public function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();
        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');

        $this->layout = $this->Auth->params['prefix'] . '_layout';

        $vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
        $ch_active = $this->Session->read('Auth.Client.ch_active_flag');
        //$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
        $vc_username = $this->Session->read('Auth.Member.vc_username');


        if ($vc_username != '' && $ch_active == 'STSTY04' && $FRL_USER_TYPE == 'USRLOGIN_CLT')
            $this->Auth->allow('*');

        $this->loginRightCheck();
    }

    function loginRightCheck() {

        if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {
            $this->redirect(array('controller' => 'members', 'action' => 'login', @$this->Auth->params['prefix'] => false));
        }
    }

    /*
     *
     * Refund Rate value
     *
     */
    function flr_deleteajaxuploadify(){
	    $this->layout = NULL;
		$this->autoRender = false;
		$client_no = trim($this->Session->read('Auth.Client.vc_client_no'));
		if($this->params['isAjax']){
				$filename=  $this->params['form']['filename'];
				unlink(WWW_ROOT.DS.'uploadify'.DS.$client_no.DS.$filename);
				echo 'deleted';
				
		}
		die;
	}
	
    function flr_uploadall() {

        $this->autoRender = false;
        $name = $type = $size = $status = false;
        $message = 'There was a problem uploading the file';
        //print_r($_FILES);die;
        $targetPath = WWW_ROOT . 'uploadfile';
        if (!empty($_FILES)) {
            if ($_FILES['Filedata']['error'] == 0) {

                $allowedTypes = array('jpg', 'gif', 'jpeg', 'pdf');
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                if (in_array($fileParts['extension'], $allowedTypes)) {
                    $tempFile = $_FILES['Filedata']['tmp_name'];

                    //$targetFile =  str_replace('\\','\\',$targetPath."\\") . $_FILES['Filedata']['name'];
                    //$targetFile =  "D:\wamp\www\rfa\app\webroot\video"; 
                    $targetFile = rtrim($targetPath, '/') . '/' . $_FILES['Filedata']['name'];
                    move_uploaded_file($tempFile, $targetFile);
                    $name = array_pop(explode('/', $targetFile));
                    $type = $_FILES['Filedata']['type'];
                    $size = $_FILES['Filedata']['size'];
                    $status = 1;
                    $message = 'File successfully uploaded';
                } else {
                    $status = 0;
                    $message = 'Invalid file type.';
                }
            } else {
                $status = 0;
                switch ($_FILES['Filedata']['error']) {
                    case 1:
                        $message = 'File exceeded max filesize';
                        break;
                    case 2:
                        $message = 'File exceeded max filesize';
                        break;
                    case 3:
                        $message = 'File only partially uploaded';
                        break;
                    case 4:
                        $message = 'No file was uploaded';
                        break;
                    case 7:
                        $message = 'There was a problem saving the file';
                        break;
                    default:
                        $message = 'There was a problem uploading the file';
                        break;
                }
            }
        } else {
            $status = 0;
            $message = 'No file data received.';
        }
        echo json_encode(
                array(
                    'status' => $status,
                    'name' => $name,
                    'type' => $type,
                    'size' => $size,
                    'message' => $message
                )
        );
    }

    function getRefundRateValue($client_no = null, $type = null, $category = null) {
	
        $this->loadModel('ClaimDetail');

        $query = "select FLR.CLAIM_RATE('01','$client_no','$type','$category') as refundValue from dual ";

        $refundRatevalue = $this->ClaimDetail->query($query);
        return $refundRatevalue[0][0]['dual'];
    }

    /*
     *
     * check Fuel Litres
     *
     */

    function checkInvoiceFuel($fuel_litres = null) {

        $fuelallow = $this->globalParameterarray['FUELALLOW'];
        if ((float)$fuel_litres < (float)$fuelallow) {
            return false;
        } else {
            return true;
        }
    }

    /*
     *
     * check Invoice Date
     *
     */

    function checkInvoiceDate($dt_invoice_date = null) {

        $currentdate = date('Y-m-d');
        $dt_invoice_date = date('Y-m-d', strtotime($dt_invoice_date));

        $diff = abs(strtotime($currentdate) - strtotime($dt_invoice_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        if ((int) $months >= 3) {
            return false;
        } else {
            return true;
        }
    }

    function flr_getAllInvoiceCheck() {
       
		if ($this->params['isAjax']) {

            $countValue = 0;
            $this->loadModel('ClaimDetail');
            $invoiceNo = $this->params['form']['ClaimDetailVcInvoiceNo'];
            $ClaimHeaderVcInvoicedate = date('Y-m-d', strtotime($this->params['form']['ClaimHeaderVcInvoicedate']));
            $ClaimHeaderVcOutletCode = trim($this->params['form']['ClaimHeaderVcOutletCode'], '');

            if (isset($invoiceNo) && !empty($invoiceNo) && isset($ClaimHeaderVcInvoicedate) && !empty($ClaimHeaderVcInvoicedate) && isset($ClaimHeaderVcOutletCode) && !empty($ClaimHeaderVcOutletCode)) {

                $invoiceNo = strtolower(trim($invoiceNo));

                $conditions = array();

                if (isset($this->params['form']['ClaimHeaderVcClaimNo']) && $this->params['form']['ClaimHeaderVcClaimNo'] != '') {

                    //$invoiceidNo =  base64_decode(trim($this->params['form']['ClaimHeaderVcInvoiceid']));
                    $vc_claim_no = base64_decode(trim($this->params['form']['ClaimHeaderVcClaimNo']));

                    $conditions = array('conditions' => array("LOWER(ClaimDetail.vc_invoice_no)='" . $invoiceNo . "'",
                            'ClaimDetail.vc_claim_no!'=> $vc_claim_no,
                            'ClaimDetail.vc_outlet_code' => $ClaimHeaderVcOutletCode,
                            'ClaimDetail.dt_invoice_date' => $ClaimHeaderVcInvoicedate
                    ));
                } else {

                    $conditions = array('conditions' => array("LOWER(ClaimDetail.vc_invoice_no)='" . $invoiceNo . "'",
                            "ClaimDetail.vc_outlet_code" => $ClaimHeaderVcOutletCode,
                            "ClaimDetail.dt_invoice_date" => $ClaimHeaderVcInvoicedate,
                    ));
                }
				//pr($conditions);die;
             $countValue = $this->ClaimDetail->find('count', $conditions);
            }
            if ($countValue == 0) {

                echo true;
            } else {

                echo false;
            }
        }
        exit;
    }

    function flr_getInvoiceCheck() {

        if ($this->params['isAjax']) {

            $countValue = 0;
            $this->loadModel('ClaimDetail');
			$invoiceNo = current(current($this->params['data']['ClaimDetail']));
            $ClaimHeaderVcInvoicedate = date('Y-m-d', strtotime($this->params['form']['ClaimHeaderVcInvoicedate']));
            $ClaimHeaderVcOutletCode = trim($this->params['form']['ClaimHeaderVcOutletCode'], '');

            if (isset($invoiceNo) && !empty($invoiceNo)) {

                $invoiceNo = strtolower(trim($invoiceNo));

                $conditions = array();
                if (isset($this->params['form']['ClaimHeaderVcClaimNo']) && $this->params['form']['ClaimHeaderVcClaimNo'] != '') {

                    //$invoiceidNo =  base64_decode(trim($this->params['form']['ClaimHeaderVcInvoiceid']));
                    $vc_claim_no = base64_decode(trim($this->params['form']['ClaimHeaderVcClaimNo']));


                    $conditions = array('conditions' =>
                        array("LOWER(ClaimDetail.vc_invoice_no)='" . $invoiceNo . "'",
                            "ClaimDetail.vc_outlet_code" => $ClaimHeaderVcOutletCode,
                            "ClaimDetail.dt_invoice_date" => $ClaimHeaderVcInvoicedate,
                            'ClaimDetail.vc_claim_no!' => $vc_claim_no));
                } else {

                    $conditions = array(
                        'conditions' => array("LOWER(ClaimDetail.vc_invoice_no)='" . $invoiceNo . "'",
                            "ClaimDetail.vc_outlet_code" => $ClaimHeaderVcOutletCode,
                            "ClaimDetail.dt_invoice_date" => $ClaimHeaderVcInvoicedate,
                    ));
                }
                //
                $countValue = $this->ClaimDetail->find('count', $conditions);
            }
            
			if ($countValue == 0) {

                echo "true";
            } else {

                echo "false";
            }
        
		} // if isset of invoice

        exit;
    }

    /***
     * **
     * * Claim Form no unique check
     * **
     */

    function flr_getFormCheck() {

        if ($this->params['isAjax']) {
            $countValue = 0;
            $this->loadModel('ClaimHeader');
         
			if (isset($this->params['data']['ClaimHeader']['vc_party_claim_no']) && $this->params['data']['ClaimHeader']['vc_party_claim_no'] != '') {
                $VcClaimFormNo = $this->params['data']['ClaimHeader']['vc_party_claim_no'];
                $conditions = array('ClaimHeader.vc_party_claim_no' => $VcClaimFormNo);
            }
            if (isset($this->params['form']['ClaimHeaderVcClaimNo']) && $this->params['form']['ClaimHeaderVcClaimNo'] != '') {

                $vc_claim_no = base64_decode($vc_claim_no = $this->params['form']['ClaimHeaderVcClaimNo']);
                $conditions +=array('ClaimHeader.vc_claim_no!' => $vc_claim_no);
            }
            $countValue = $this->ClaimHeader->find('count', array('conditions' => $conditions));

            if ($countValue == 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
        exit;
    }

    function flrgetFormCheck($claimformNO = null, $claimNo = null) {
        $conditions = array();
        $this->loadModel('ClaimHeader');

        if (isset($claimformNO) && $claimformNO != '') {
            $countValue = 0;
            $conditions = array('ClaimHeader.vc_party_claim_no' => $claimformNO);
        }

        if (isset($claimNo) && $claimNo != '') {

            $conditions += array('ClaimHeader.vc_claim_no!' => $claimNo);
        }
        $countValue = $this->ClaimHeader->find('count', array('conditions' => $conditions));
        //die;
        if ($countValue == 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Check unique invoice no.
     *
     */

    function checkUniqueInvoice($invoiceNo = null, $vc_claim_no = null, $VcInvoicedate = null, $ClaimHeaderVcOutletCode = null) {

        $this->loadModel('ClaimDetail');

        if (isset($invoiceNo) && !empty($invoiceNo) && isset($VcInvoicedate) && !empty($VcInvoicedate) && isset($ClaimHeaderVcOutletCode) && !empty($ClaimHeaderVcOutletCode)) {
            $invoiceNo = strtolower(trim($invoiceNo));

            $ClaimHeaderVcInvoicedate = date('Y-m-d', strtotime($VcInvoicedate));

            $conditions = array();

            if (isset($vc_claim_no) && $vc_claim_no != '')
                $conditions = array("LOWER(ClaimDetail.vc_invoice_no)='" . $invoiceNo . "'", 'ClaimDetail.vc_claim_no!' => $vc_claim_no);
            else
                $conditions = array("LOWER(ClaimDetail.vc_invoice_no)='" . $invoiceNo . "'");

            $conditions+=array("ClaimDetail.vc_outlet_code" => $ClaimHeaderVcOutletCode,
                "ClaimDetail.dt_invoice_date" => $ClaimHeaderVcInvoicedate);

            echo 'unique-inv-cnt--'.$countValue = $this->ClaimDetail->find('count', array('conditions' => $conditions));

            if ($countValue > 0)
                return false;
            else
                return true;
        }
    }

    function fileExtension($filename = null) {
        $arrayextension = array('jpg', 'jpeg', 'png',  'pdf');
        $ext = trim(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($ext, $arrayextension)) {
            return true;
        } else {
            return false;
        }
    }

    function flr_view() {

        $this->loadModel('ClaimHeader');
        $this->loadModel('Client');
        $vc_comp_code = $this->Session->read('Auth.Client.vc_comp_code');
        $vc_username = $this->Session->read('Auth.Member.vc_username');


        $vc_client_no = '';
        $conditions['fields'] = array('Client.vc_client_no');
        $conditions['joins'] = array(
            array('table' => 'pr_dt_users_details_all',
                'alias' => 'Member',
                'type' => 'INNER',
                'conditions' => array(
                    array('Member.vc_flr_customer_no=Client.vc_client_no'),
                    array('Member.vc_username' => $vc_username),
                )
        ));



        $client_details = $this->Client->find('first', $conditions);
        $vc_client_no = $client_details['Client']['vc_client_no'];

        $this->set('Clientdetails', $this->Session->read('Auth.Client'));

        $this->paginate = array(
            'conditions' => array('ClaimHeader.vc_client_no' => $vc_client_no,
                'ClaimHeader.vc_comp_code' => $vc_comp_code),
            'order' => array('ClaimHeader.dt_entry_date' => 'desc'),
            'limit' => 10
        );


        $this->set('claimslist', $this->paginate('ClaimHeader'));
        $this->set('title_for_layout', 'View Claims');

        $this->layout = "flr_layout";
    }

    /*

     */

    public function flr_getclaimdetails() {

        if ($this->params['isAjax']) {

            $this->loadModel('ClaimDetail');
            $claimno = $this->params['data'];
            $claimno = base64_decode($claimno);

            $allInvoicedata = array();

            $vc_comp_code = $this->Session->read('Auth.Client.vc_comp_code');
            $vc_username = $this->Session->read('Auth.Member.vc_username');
            $vc_cateogry = $this->Session->read('Auth.ClientHeader.vc_cateogry'); //vc_fuel_type

            $allInvoicedata = $this->ClaimDetail->find('all', array('conditions' =>
                array('ClaimDetail.vc_claim_no' => $claimno),
                'order' => array('ClaimDetail.dt_entry_date' => 'desc')));

            $this->set('allInvoicedata', $allInvoicedata);

            if (isset($claimno) && !empty($claimno))
                $this->set('claimno', $claimno);

            $this->render('flr_getclaimdetails');
        }

        //die;
    }

    /**
     * 
     * Add Claim Processing
     * 
     */
    public function flr_index() {
     //  echo  phpinfo();
	    set_time_limit(0);
        $this->loadModel('FuelOutlet');
        $this->loadModel('ClaimDetail');
        $this->loadModel('ClaimHeader');
        $this->loadModel('ClaimprocessData');
        $this->loadModel('ClientFuelOutlet');
        $this->loadModel('InvoiceClaimDoc');
        $this->loadModel('Client');

        $vc_comp_code = $this->Session->read('Auth.Client.vc_comp_code');
        $vc_username = $this->Session->read('Auth.Member.vc_username');
        $vc_client_no = '';


        $conditions['fields'] = array('Client.vc_client_no');
        $conditions['joins'] = array(
            array('table' => 'pr_dt_users_details_all',
                'alias' => 'Member',
                'type' => 'INNER',
                'conditions' => array(
                    array('Member.vc_flr_customer_no=Client.vc_client_no'),
                    array('Member.vc_username' => $vc_username),
                )
        ));

        $client_details = $this->Client->find('first', $conditions);
        $vc_client_no   = $client_details['Client']['vc_client_no'];
        $this->Session->write('Auth.Client.vc_client_no', $vc_client_no);

        $flrFuelOutLet = array();
        $flrFuelOutLet = $this->ClientFuelOutlet->find('all', array('conditions' => array(
                'vc_client_no' => $vc_client_no,
                'vc_status' => 'STSTY04')));
				
        $flrFuelOutLet = Set::combine($flrFuelOutLet, '{n}.ClientFuelOutlet.vc_fuel_outlet', '{n}.ClientFuelOutlet.vc_fuel_outlet');
        $this->set('flrFuelOutLet', $flrFuelOutLet);
		
        $vc_cateogry = $this->Session->read('Auth.ClientHeader.vc_cateogry');
        $this->layout = 'flr_layout';
        
		$ClaimprocessData = $this->ClaimprocessData->find('first', array('conditions' => array('ClaimprocessData.vc_fuel_type' => $vc_cateogry)));

        $this->set('refundData', $ClaimprocessData);

        $fuelallow            = $this->globalParameterarray['FUELALLOW'];
        $nu_admin_fee_percent = $ClaimprocessData['ClaimprocessData']['nu_admin_fee'];
        $nu_refund_prcnt      = $ClaimprocessData['ClaimprocessData']['nu_refund_prcnt'];
        $vc_fuel_type         = $ClaimprocessData['ClaimprocessData']['vc_fuel_type'];
        $fuel_type_category   = $ClaimprocessData['ClaimprocessData']['fuel_type'];
        $nu_fuel_leavy        = $ClaimprocessData['ClaimprocessData']['nu_fuel_leavy'];
        $dt_effective_date    = $ClaimprocessData['ClaimprocessData']['dt_effective_date'];
        $refundRateValue      = $this->getRefundRateValue($vc_client_no, $fuel_type_category, $vc_fuel_type);

        $this->set('refundRateValue', $refundRateValue);

        $error = false;
		
        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            $i = 0;
		    $filesizeLimit = '2048000';
            
			if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
                
				
				$noofinvoicescnt=0;
				foreach ($this->data['ClaimDetail'] as $index => $value) {
						$noofinvoicescnt++;
				}
                
				foreach ($this->data['InvoiceClaimDoc'] as $index => $value) {
                	
					$filemulticnt=1;					
					
					if($value['name']!='') {				
				
						if ($this->fileExtension($value['name']) == false) {
							$error = true;
							$this->Session->setFlash('The type of file should be jpg, png , jpeg or pdf.', 'error');
						}

						if ((int)$value['size'] > 2048000) {

							$error = true;
							$this->Session->setFlash('The file size should be less than 2MB', 'error');
						}
						$filemulticnt++;
					 }	
                }
				//echo $filemulticnt.'=='.$noofinvoicescnt;
				if($filemulticnt!=$noofinvoicescnt){				
					//$error = true;
					//$this->Session->setFlash('Please upload the file for all invoices.', 'error');
				}
				
            }else{
			 
			$fileSinglecnt=0;
			
			foreach ($this->data['ClaimHeader']['input_allfileupload_values'] as $index => $value) {				
				if($value!=''){				
					$fileSinglecnt++;
				}				
			}
			
			if($fileSinglecnt ==0){				
					// $error = true;
					$this->Session->setFlash('Please upload atleast one file for all invoices.', 'error');
			  }			
			
			}

            $vc_claim_form_no = $this->data['ClaimHeader']['vc_party_claim_no'];
            //echo 'seppp===',$this->flrgetFormCheck($vc_claim_form_no);
            if ($this->flrgetFormCheck($vc_claim_form_no) == false) {

                $error = true;
                $this->Session->setFlash('Please enter the unique claim form no.', 'error');
            }

            foreach ($this->data['ClaimDetail'] as $index => $value) {

                $rejectionStatus = false;
                $vc_invoice_no   = $value['vc_invoice_no'];
                $vc_outlet_code  = $value['vc_outlet_code'];
                $dt_invoice_date = date('d-M-Y', strtotime($value['dt_invoice_date']));
                
				$this->data['ClaimHeader']['dt_claim_to']   = date('d-M-Y', strtotime($this->data['ClaimHeader']['dt_claim_to']));
                $this->data['ClaimHeader']['dt_claim_from'] = date('d-M-Y', strtotime($this->data['ClaimHeader']['dt_claim_from']));
                
				$this->data['ClaimHeader']['singlefileuploadID'] = $this->data['ClaimHeader']['singlefileuploadID'];
                $this->data['ClaimDetail']['singlefileuploadID'] = $this->data['ClaimHeader']['singlefileuploadID'];
                
				$fuel_litres = $value['nu_litres'];
			
				/*               
				if ($this->checkUniqueInvoice($vc_invoice_no, '', $value['dt_invoice_date'], $vc_outlet_code) == false) {
                    $error = true;
                    $this->Session->setFlash('Please enter the unique invoice numbers.', 'error');
                }				
				*/
            }
            if ($error == false) {

                $vc_claim_no = '';

				$vc_claim_no = $this->ClaimHeader->getPrimaryKey();

                //$vc_claim_no = 'CLAIM-' . $vc_claim_no;

                if ($this->data['Claim']['posted_data'] == 'SAVE') {

                    $this->data['ClaimHeader']['vc_status'] = 'STSTY08';
                } else {

                    $this->data['ClaimHeader']['vc_status'] = 'STSTY03';
                }

                $this->data['ClaimHeader']['vc_claim_no']     = $vc_claim_no;
                $this->data['ClaimHeader']['vc_client_no']    = $vc_client_no;
                $this->data['ClaimHeader']['vc_comp_code']    = $vc_comp_code;
                $this->data['ClaimHeader']['nu_refund_prcnt'] = $nu_refund_prcnt;
                $this->data['ClaimHeader']['nu_admin_fee']    = $nu_admin_fee_percent;
                $this->data['ClaimHeader']['nu_refund_rate']  = $refundRateValue;
                $this->data['ClaimHeader']['nu_fuel_leavy']   = $nu_fuel_leavy;
                $this->data['ClaimHeader']['vc_fuel_type']    = $vc_fuel_type;
                $this->data['ClaimHeader']['dt_effective_date'] = $dt_effective_date;
                $this->data['ClaimHeader']['vc_party_claim_no'] = $vc_claim_form_no;
                $this->data['ClaimHeader']['vc_payment_status'] = 'STSTY03';

                if ($this->data['ClaimHeader']['singlefileuploadID'] == 1)
                    $this->data['ClaimHeader']['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
                else
                    $this->data['ClaimHeader']['singlefileuploadid'] = 0;

                $this->ClaimHeader->create();
                $this->ClaimHeader->set($this->data['ClaimHeader']);
                $this->ClaimHeader->save($this->data['ClaimHeader'], false);
                
				$totalLitres = 0;
                $totalAmount = 0;

                $dirpath = WWW_ROOT."uploadfile".DS.$vc_username. DS . 'Claim' . DS . $vc_claim_no;

                if ($this->data['ClaimHeader']['singlefileuploadID'] == 1) {
					
					$dirpath = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . 'Claim' . DS . $vc_claim_no.DS.'Claimfiles';
					
					if (file_exists($dirpath)) {

                            $this->rrmdir($dirpath);
                    }
					
					mkdir($dirpath, 0777, true);
                
                    foreach ($this->data['ClaimHeader']['input_allfileupload_values'] as $index => $value) {
					
					if($value!=''){
					
					$filename = $value;
                    $copypath = WWW_ROOT . 'uploadify'.DS.$vc_client_no;
					$renamefile = $index . '-' . $this->renameUploadFile($filename);
					
                       if (copy($copypath.DS.$filename, $dirpath .DS. $renamefile) == true) {
						
                            $filedata 				= array();
                            $filedata['vc_upload_id'] = $this->InvoiceClaimDoc->getPrimaryKey();
                            $filedata['vc_comp_code'] = $vc_comp_code;
                            $filedata['vc_claim_no'] = $vc_claim_no;
                            $filedata['vc_client_no'] = $vc_client_no;
                            $filedata['vc_uploaded_doc_for'] = 'Claim';
                            //$filedata['vc_claim_dt_id'] 	  =  $vc_claim_no;
                            $filedata['vc_uploaded_doc_path'] = $dirpath;
                            $filedata['vc_uploaded_doc_type'] = $filetype;
                            $filedata['vc_uploaded_doc_name'] = $renamefile;
                            $filedata['dt_date_uploaded'] = date('Y-m-d H:i:s');
                            $this->InvoiceClaimDoc->create();
                            $this->InvoiceClaimDoc->set($filedata);
                            $this->InvoiceClaimDoc->save($filedata, false);
                            $uploadSinglefileStatus = true;
                            unlink($copypath .DS. $filename);
                        }
                      }
					} // if of value chaeck
                }
                $filename = '';
                foreach ($this->data['ClaimDetail'] as $index => $value) {
                    $dir = '';
                    $rejectionStatus = false;
					$uploadStatus=false;

                    if ($this->checkInvoiceDate($value['dt_invoice_date']) == false) {
                        //$error=true;					
                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months';
                    }

                    if ($this->checkInvoiceFuel($value['nu_litres']) == false) {

                        //$error=true;					
                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs.';
                    }
					if ($this->checkUniqueInvoice($value['vc_invoice_no'], '', $value['dt_invoice_date'],$value['vc_outlet_code'] ) == false) {

						$rejectionStatus = true;
						$rejectionValue ='Invoice already exist.';
					}
					

                    if ($this->checkInvoiceDate($value['dt_invoice_date']) == false && $this->checkInvoiceFuel($value['nu_litres']) == false) {
                     
						$rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Fuel is less than 200 Ltrs. ';
                    }
					 
					 if ($this->checkInvoiceDate($value['dt_invoice_date']) == false && $this->checkUniqueInvoice($value['vc_invoice_no'], '', $value['dt_invoice_date'],$value['vc_outlet_code']) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Invoice already exist. ';
                    }
					if ($this->checkInvoiceFuel($value['nu_litres'])== false && $this->checkUniqueInvoice($value['vc_invoice_no'], '', $value['dt_invoice_date'],$value['vc_outlet_code']) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs. & Invoice already exist. ';
                    }
					
					if ($this->checkUniqueInvoice($value['vc_invoice_no'], '', $value['dt_invoice_date'],$value['vc_outlet_code']) == false && $this->checkInvoiceDate($value['dt_invoice_date']) == false && $this->checkInvoiceFuel($value['nu_litres']) == false) {

						$rejectionStatus = true;
						$rejectionValue ='Invoice is older than 3 months & Fuel is less than 200 Ltrs. & Invoice already exist.';
					}
					//$this->checkUniqueInvoice($value['vc_invoice_no'], '', $value['dt_invoice_date'],$value['vc_outlet_code']);

                    if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {

                       $filename = $this->data['InvoiceClaimDoc'][$index]['name'];
                        $filetmpname = $this->data['InvoiceClaimDoc'][$index]['tmp_name'];
                        $filetype = $this->data['InvoiceClaimDoc'][$index]['type'];
                    }

                    $vc_invoice_no = $value['vc_invoice_no'];
                    $dt_invoice_date = $value['dt_invoice_date'];
                    $fuel_litres = $value['nu_litres'];
                    $totalLitres = $totalLitres + $fuel_litres;
					$claimdetId = $this->ClaimDetail->getPrimaryKey();
					$vc_outlet_code = $value['vc_outlet_code'];
                    
					$removeCharacters = array("/", " ");
                    $vc_outlet_codereplace = str_replace($removeCharacters, "-", $vc_outlet_code);

					$dir = $dirpath.DS.$vc_invoice_no.'-'.strtotime($dt_invoice_date).'-'.$vc_outlet_codereplace;

                    if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
						
						if($filetmpname!=''){
						
							if(file_exists($dir)){
								$this->rrmdir($dir);
							}
							mkdir($dir, 0777, true);
							$renamefile = $vc_invoice_no . '-' . $this->renameUploadFile($filename);
							$uploadStatus = move_uploaded_file($filetmpname, $dir . DS . $renamefile);
						}
                    }


                    if ($uploadStatus == true || $uploadSinglefileStatus == true || $this->data['Claim']['posted_data'] == 'SAVE') {

                        
                        if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {

                            $filedata = array();
                            $filedata['vc_upload_id']    = $this->InvoiceClaimDoc->getPrimaryKey();
                            $filedata['vc_comp_code']    = $vc_comp_code;
                            $filedata['vc_invoice_no']   = $vc_invoice_no;
                            $filedata['dt_invoice_date'] = $dt_invoice_date;
                            $filedata['vc_invoice_datetimestamp'] = strtotime($dt_invoice_date);
							$filedata['vc_outlet_code']           = $vc_outlet_code;
                            $filedata['vc_claim_no']              = $vc_claim_no;
                            $filedata['vc_client_no']             = $vc_client_no;
                            $filedata['vc_uploaded_doc_for']      = 'Invoice';
                            $filedata['vc_claim_dt_id']           = $claimdetId;
                            $filedata['vc_uploaded_doc_path']     = $dir;
                            $filedata['vc_uploaded_doc_type']     = $filetype;
                            $filedata['vc_uploaded_doc_name']     = $renamefile;
                            $filedata['dt_date_uploaded']         = date('Y-m-d H:i:s');
                        }

                        $value['nu_admin_fee_prcnt'] = $nu_admin_fee_percent;
                        $value['dt_entry_date']  = date('Y-m-d');
                        $value['vc_claim_no']    = $vc_claim_no;
                        $value['vc_comp_code']   = $vc_comp_code;
                        $value['vc_claim_dt_id'] = $claimdetId;
                        $value['vc_fuel_type']   = $vc_fuel_type;
                        $value['nu_fuel_levy']   = $nu_fuel_leavy;



                        if ($rejectionStatus == true) {

                            //$this->data['Claim']['posted_data'] == 'SAVE'

                            $value['vc_status'] = 'STSTY05';
                            $value['ch_rejected'] = 'Y';
                            $value['nu_amount'] = 0;
                            $value['nu_admin_fee'] = 0;
                            echo '<br>'.$value['vc_reasons'] = $rejectionValue;
							
                        } else {

                            $value['vc_reasons']   = '';
                            $value['nu_amount']    = ($refundRateValue)*($fuel_litres);
                            $value['nu_admin_fee'] = ($nu_admin_fee_percent)*($fuel_litres);
                            if ($this->data['Claim']['posted_data'] == 'SAVE') {

                                //$value['vc_status'] = 'STSTY08';
                            } else {

                                //$value['vc_status'] = 'STSTY03';
                            }
							$value['vc_status'] = 'STSTY03';

                        }

                        $value['nu_refund_prcnt'] = $nu_refund_prcnt;
                        $value['nu_refund_rate']  = $refundRateValue;
                        $value['vc_client_no']    = $vc_client_no;
                       
                        $totalAmount = $totalAmount + $value['nu_amount'];
                        if ($this->data['ClaimHeader']['singlefileuploadID'] == 1)
                            $value['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
                        else
                            $value['singlefileuploadid'] = 0;

                        $this->ClaimDetail->create();
                        $this->ClaimDetail->set($value);
                        $this->ClaimDetail->save($value, false);

                        if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
							
							if($uploadStatus == true){
								
								$this->InvoiceClaimDoc->create();
								$this->InvoiceClaimDoc->set($filedata);
								$this->InvoiceClaimDoc->save($filedata, false);
							
							}
                        }
                    } else {

                        $this->Session->setFlash('File was not uploaded. ', 'error');
                    
					} // if check for upload	file
                
				} // end of foreach
                //pr($this->data);die;


                /* ********Email to client**************** */


                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                $this->Email->bcc = array(trim($this->AdminFlrEmailID));

                $this->Email->subject = strtoupper($selectedType) . " Claim Details Added";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                $this->Email->delivery = 'smtp';

                if ($this->data['Claim']['posted_data'] == 'SAVE') {

                    $mesage = " Claim details have been saved successfully !!";
                } else {

                    $mesage = " Claim details have been added successfully, pending for approval from RFA !!";
                }

                $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                $mesage .= "<br> <br>RFA Account No. : " . trim($this->Session->read('Auth.Member.vc_flr_customer_no'));
				
                $this->Email->send($mesage);
                $this->Email->to = array();
                $this->Email->bcc = array();
				
                /************* End *********************************** */
				
				if ($this->data['ClaimHeader']['singlefileuploadID'] == 1) {
				$totalLitres=$totalLitres-1;
				}
                $this->data['ClaimHeader']['nu_tot_amount'] = $totalAmount;
                $this->data['ClaimHeader']['nu_tot_litres'] = $totalLitres;
                $this->ClaimHeader->id = $vc_claim_no;
                $this->ClaimHeader->save($this->data['ClaimHeader'], false);
				
			//	pr($this->data);
			//	pr($this->data);
				//die;
                if ($this->data['Claim']['posted_data'] == 'SAVE') {
                    $this->Session->setFlash(' Claim details have been saved successfully !! ', 'success');
                } else {
                    $this->Session->setFlash(' Claim details have been added successfully, pending for approval from RFA !! ', 'success');
                }
                $this->redirect($this->referer());
                unset($this->data);
            }else{
			    $this->redirect($this->referer());
            
			} 
			
			// end of error false condition
        }// end of post 
    }

// end of function 

    /*
     *
     * Save Claim
     *
     */

	 function flr_save($claimno = null) {
	    set_time_limit(0);
	  $this->layout = "flr_layout";
      $claim_no = base64_decode($claimno);

      if(isset($claim_no) && $claim_no != '')
            $this->set('claim_no', $claim_no);
       else
            $this->set('claim_no', '');


        $this->loadModel('FuelOutlet');
        $this->loadModel('ClaimDetail');
        $this->loadModel('ClaimHeader');
        $this->loadModel('Client');
        $this->loadModel('ClaimprocessData');
        $this->loadModel('ClientFuelOutlet');
        $this->loadModel('InvoiceClaimDoc');

        $vc_comp_code = $this->Session->read('Auth.Client.vc_comp_code');
        $vc_username  = $this->Session->read('Auth.Member.vc_username');
        $vc_cateogry  = $this->Session->read('Auth.ClientHeader.vc_cateogry'); //vc_fuel_type

        $vc_client_no = '';
        $conditions['fields'] = array('Client.vc_client_no');
        $conditions['joins'] = array(
            array('table' => 'pr_dt_users_details_all',
                'alias' => 'Member',
                'type' => 'INNER',
                'conditions' => array(
                    array('Member.vc_flr_customer_no=Client.vc_client_no'),
                    array('Member.vc_username' => $vc_username),
                )
        ));



        $client_details = $this->Client->find('first', $conditions);
        $vc_client_no = $client_details['Client']['vc_client_no'];
		$this->set('vc_client_no',$vc_client_no);
        $flrFuelOutLet = array();

        $flrFuelOutLet = $this->ClientFuelOutlet->find('all', array('conditions' => array(
                'vc_client_no' => $vc_client_no,
                'vc_status' => 'STSTY04')));

        $flrFuelOutLet = Set::combine($flrFuelOutLet, '{n}.ClientFuelOutlet.vc_fuel_outlet', '{n}.ClientFuelOutlet.vc_fuel_outlet');
        $this->set('flrFuelOutLet', $flrFuelOutLet);

       
        $showclaimdetails = $this->ClaimHeader->find('all', array('conditions' => array(
                'ClaimHeader.vc_claim_no' => trim($claim_no),
                'ClaimHeader.vc_client_no' => $vc_client_no,
                'ClaimHeader.vc_comp_code' => $vc_comp_code
        )));
		//	pr($showclaimdetails);        
		
		$this->set('showclaimdetails', $showclaimdetails[0]);
        $ClaimprocessData = $this->ClaimprocessData->find('first', array('conditions' => array('ClaimprocessData.vc_fuel_type' => $this->Session->read('Auth.ClientHeader.vc_cateogry'))));

        $this->set('refundData', $ClaimprocessData);
        $fuelallow = $this->globalParameterarray['FUELALLOW'];
        $nu_admin_fee_percent = $ClaimprocessData['ClaimprocessData']['nu_admin_fee'];
        $nu_refund_prcnt = $ClaimprocessData['ClaimprocessData']['nu_refund_prcnt'];
        $vc_fuel_type = $ClaimprocessData['ClaimprocessData']['vc_fuel_type'];
        $fuel_type_category = $ClaimprocessData['ClaimprocessData']['fuel_type'];
        $nu_fuel_leavy = $ClaimprocessData['ClaimprocessData']['nu_fuel_leavy'];
        $dt_effective_date = $ClaimprocessData['ClaimprocessData']['dt_effective_date'];

        $refundRateValue = $this->getRefundRateValue($vc_client_no, $fuel_type_category, $vc_fuel_type);
        $this->set('refundRateValue', $refundRateValue);		
		
		$error = false;
		
        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            $vc_claim_no   = base64_decode($this->data['ClaimHeader']['vc_claim_no']);
		    $previousstate = base64_decode($this->data['ClaimHeader']['previousstate']);
			unset($this->data['ClaimHeader']['vc_claim_no']);
			
            $validclaimNo = $this->ClaimHeader->find('count', array('conditions' => array(
                    'ClaimHeader.vc_claim_no' => trim($vc_claim_no),
                    'ClaimHeader.vc_client_no' => $vc_client_no,
                    'ClaimHeader.vc_comp_code' => $vc_comp_code
            )));
			
            if ($validclaimNo == 0) {

                $this->Session->setFlash('Invalid Claim No.', 'error');
                $this->redirect('view');
            }

            $i = 0;
            $filesizeLimit = '2097152';
            $vc_claim_form_no = $this->data['ClaimHeader']['vc_party_claim_no'];

            if ($this->flrgetFormCheck($vc_claim_form_no, $vc_claim_no) == false) {
			
               $error = true;
               $this->Session->setFlash('Please enter the unique claim form no.', 'error');
            
			}
				
			$this->data['ClaimHeader']['dt_claim_to'] = date('d-M-Y', strtotime($this->data['ClaimHeader']['dt_claim_to']));
			$this->data['ClaimHeader']['dt_claim_from'] = date('d-M-Y', strtotime($this->data['ClaimHeader']['dt_claim_from']));
			$this->data['ClaimHeader']['singlefileuploadID'] = $this->data['ClaimHeader']['singlefileuploadID'];
            
            if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
				
				$filemulticnt=0;
				$noofinvoicescnt=0;
				
				foreach ($this->data['ClaimDetail'] as $index => $value) {
				
					$noofinvoicescnt++;
				
				}
				
                foreach ($this->data['InvoiceClaimDoc'] as $index => $value) {
					
					if($value['name']!='' ) {
                   
					   if ($this->fileExtension($value['name']) == false) {

							$error = true;
							$this->Session->setFlash('The type of file should be jpg , png , jpeg or pdf.', 'error');
						}
						if ((int) $value['size'] > 2048000) {

							$error = true;
							$this->Session->setFlash('The file size should be less than 2MB', 'error');
						
						}
						$filemulticnt++;
					}
					if($filemulticnt!=$noofinvoicescnt){				
						//$error = true;
						//$this->Session->setFlash('Please upload the file for all invoices.', 'error');
					}
                }
            }else{
			 
			 $fileSinglecnt=0;			 
			 
			 foreach ($this->data['ClaimHeader']['input_allfileupload_values'] as $index => $value) {				
				if($value!=''){				
					$fileSinglecnt++;
				}				
			 }
			 if($fileSinglecnt ==0){				
					//$error = true;
					//$this->Session->setFlash('Please upload atleast one file for all invoices.', 'error');
				}			
			
			}
			$invoicedetailsarray=$this->data['ClaimDetail'];
			//pr($invoicedetailsarray);
			//echo 'invoice';
			//pr($this->data['ClaimDetail']);
			
			foreach ($this->data['ClaimDetail'] as $index => $value) {

                $vc_invoice_no   = $value['vc_invoice_no'];
                $vc_outlet_code  = $value['vc_outlet_code'];
				//$y[]= $value['nu_amount'];
                $dt_invoice_date = date('d-M-Y', strtotime($value['dt_invoice_date']));                
                $fuel_litres     = $value['nu_litres'];

               /*
			   if ($this->checkUniqueInvoice($vc_invoice_no, $vc_claim_no, $value['dt_invoice_date'], $vc_outlet_code) == false) {

                    $error = true;
                    $this->Session->setFlash('Please enter the unique invoice numbers.', 'error');
                }
				*/
            }

//pr($y);echo 'yy';
			
			if ($error == false) {
				
				$this->ClaimDetail->deleteAll(array('ClaimDetail.vc_claim_no' => $vc_claim_no), false);				
				
				$totalLitres = 0;
                $totalAmount = 0;

                $dirpath = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . 'Claim' . DS . $vc_claim_no;

                if ($this->data['ClaimHeader']['singlefileuploadID'] == 1) {
				
				$dirpath = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . 'Claim' . DS . $vc_claim_no.DS.'Claimfiles';
   
				  
				   //echo 'previousstate==',$previousstate; //die;
				   // $previousstate =0 means previous state of claim before save
				   if($previousstate==0){
					
						if (file_exists($dirpath)) {
						
							  $this->rrmdir($dirpath);
							 // $this->recursiveRemove($dirpath);
						}
						 //$this->recursiveRemove($dirpath);
						mkdir($dirpath,0777,true);
					    $this->InvoiceClaimDoc->deleteAll(array('InvoiceClaimDoc.vc_claim_no' => $vc_claim_no,'InvoiceClaimDoc.vc_client_no'=>$vc_client_no), false);
       
					}                   
		
                    foreach ($this->data['ClaimHeader']['input_allfileupload_values'] as $index => $value) {

                        $filename = $value;
						$copypath = WWW_ROOT . 'uploadify'.DS.$vc_client_no;
                        $renamefile = $index . '-' . $this->renameUploadFile($filename);

                        if (copy($copypath.DS.$filename, $dirpath.DS.$renamefile) == true) {
						
                            $filedata = array();                            
							$filedata['vc_upload_id']         = $this->InvoiceClaimDoc->getPrimaryKey();
                            $filedata['vc_comp_code']         = $vc_comp_code;
                            $filedata['vc_claim_no']          = $vc_claim_no;
                            $filedata['vc_client_no']         = $vc_client_no;							
                            $filedata['vc_uploaded_doc_for']  = 'Claim';
                            // $filedata['vc_claim_dt_id'] 	  =  $vc_claim_no;
                            $filedata['vc_uploaded_doc_path'] = $dirpath;
                            $filedata['vc_uploaded_doc_type'] = $filetype;
                            $filedata['vc_uploaded_doc_name'] = $renamefile;
                            $filedata['dt_date_uploaded']     = date('Y-m-d H:i:s');
                            
							$this->InvoiceClaimDoc->create();
                            $this->InvoiceClaimDoc->set($filedata);
                            $this->InvoiceClaimDoc->save($filedata, false);
                            $uploadSinglefileStatus           = true;
							
                            unlink($copypath.DS.$filename);
                        } // end of copy
                    }  //end of foreach files 
             
                    
                	//unset($this->data['ClaimDetail']['singlefileuploadID']);
					
				  foreach ($this->data['ClaimDetail'] as $index => $value) {
					
     				$rejectionStatus = false;						
                    $vc_invoice_no   = $value['vc_invoice_no'];						
					$vc_outlet_code	 =	$value['vc_outlet_code'];
					
                    if($vc_invoice_no!=''){
					
					$dt_invoice_date = $value['dt_invoice_date'];
                    $fuel_litres     = $value['nu_litres'];
                    $totalLitres     = $totalLitres + $fuel_litres;

                    if ($this->checkInvoiceDate($dt_invoice_date) == false) {
					
                        $rejectionStatus = true;
                        $rejectionValue  = 'Invoice is older than 3 months.';
                    }

                    if ($this->checkInvoiceFuel($fuel_litres) == false) {

                        $rejectionStatus = true;
                        $rejectionValue  = 'Fuel is less than 200 Ltrs.';
                    }
					if ($this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {

						$rejectionStatus = true;
						$rejectionValue  = 'Invoice number already exist.';
					}

                    if ($this->checkInvoiceDate($dt_invoice_date) == false && $this->checkInvoiceFuel($fuel_litres) == false)
					{

                        $rejectionStatus = true;
                        $rejectionValue  = 'Invoice is older than 3 months & Fuel is less than 200 Ltrs.';
                    }

                    
					if ($this->checkInvoiceDate($dt_invoice_date) == false && $this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Invoice number already exist. ';
                    }
					
					if ($this->checkInvoiceFuel($fuel_litres)== false && $this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs. & Invoice number already exist. ';
                    }
					
					if ($this->checkUniqueInvoice($vc_invoice_no, $vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false && $this->checkInvoiceDate($dt_invoice_date) == false && $this->checkInvoiceFuel($fuel_litres) == false) {

						$rejectionStatus = true;
						$rejectionValue ='Invoice is older than 3 months & Fuel is less than 200 Ltrs. & Invoice number already exist.';
					}
					
					
					if ($this->data['Claim']['posted_data'] == 'SAVE' ||($uploadSinglefileStatus == true && $previousstate==0) ||($previousstate==1)) {

                        $claimdetId = $this->ClaimDetail->getPrimaryKey();						
						$value['vc_claim_no']        = $vc_claim_no;
                        $value['vc_comp_code']       = $vc_comp_code;
                        $value['vc_claim_dt_id']     = $claimdetId;
                        $value['nu_refund_prcnt']    = $nu_refund_prcnt;
                        $value['nu_refund_rate']     = $refundRateValue;
                        $value['vc_client_no']       = $vc_client_no;
                        $value['nu_admin_fee_prcnt'] = $nu_admin_fee_percent;
                        $value['vc_fuel_type']       = $vc_fuel_type;
                        $value['nu_fuel_levy']       = $nu_fuel_leavy;
						$x[]=$value['nu_amount'];
                        $totalAmount = $totalAmount + $value['nu_amount'];

                        if ($rejectionStatus == true) {

                            $value['vc_reasons'] = $rejectionValue;
                            $value['vc_status'] = 'STSTY05';
                            $value['ch_rejected'] = 'Y';
                            $value['nu_amount'] = 0;
                            $value['nu_admin_fee'] = 0;
                            $value['dt_entry_date'] = date('Y-m-d H:i:s');
                            //	$value['dt_mod_date']        = date('Y-m-d H:i:s');
                        } else {

                            if ($this->data['Claim']['posted_data'] == 'SAVE') {
                              //  $value['vc_status'] = 'STSTY08';
                            } else {
                                // $value['vc_status'] = 'STSTY03';
                            }
							$value['vc_status']     = 'STSTY03';
                            $value['nu_amount']     = ($refundRateValue) * ($fuel_litres);
                            $value['nu_admin_fee']  = ($nu_admin_fee_percent) * ($fuel_litres);
                            $value['vc_reasons']    = '';
                            $value['dt_entry_date'] = date('Y-m-d H:i:s');
                            //$value['dt_mod_date'] = date('Y-m-d H:i:s');
                        }
						
                        if ($this->data['ClaimHeader']['singlefileuploadID'] == 1)
                            $value['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
                        else
                            $value['singlefileuploadid'] = 0;

                        $this->ClaimDetail->create();
                        $this->ClaimDetail->set($value);
                        $this->ClaimDetail->save($value, false);
						unset($value);
						
					  } // end of uploadSinglefileStatus 

                    } 	// end of if of invoice no. not null
					
              } // end- of- foreach
				
				
				 if ($this->data['Claim']['posted_data'] == 'SAVE') {
                    $this->data['ClaimHeader']['vc_status'] = 'STSTY08';
                } else {
                    $this->data['ClaimHeader']['vc_status'] = 'STSTY03';
                }
                $this->data['ClaimHeader']['vc_payment_status'] = 'STSTY03';
                $this->data['ClaimHeader']['nu_tot_amount'] = $totalAmount;
                $this->data['ClaimHeader']['nu_tot_litres'] = $totalLitres;
                $this->data['ClaimHeader']['dt_mod_date'] = date('Y-m-d H:i:s');
                $this->data['ClaimHeader']['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];

                $this->ClaimHeader->id = $vc_claim_no;
                $this->ClaimHeader->save($this->data['ClaimHeader'], false);
				if ($this->data['Claim']['posted_data'] == 'SAVE') {
                    $this->Session->setFlash(' Claim details have been saved successfully !! ', 'success');
                } else {
                    $this->Session->setFlash(' Claim details have been added successfully, pending for approval from RFA !! ', 'success');
                }
                $this->redirect('view');
		   } // end of  if of current status is 1 or single file upload and start of else for multiple
		   else{
		   
			    // start of code
			    $dir = '';
				  
                $dirpath = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . 'Claim' . DS . $vc_claim_no;

                // unset($this->data['ClaimDetail']['singlefileuploadID']);
				if($previousstate==1){								
						    
 					$this->InvoiceClaimDoc->deleteAll(array('InvoiceClaimDoc.vc_claim_no'=>$vc_claim_no,'InvoiceClaimDoc.vc_client_no'=>$vc_client_no), false);

				}
				foreach ($this->data['ClaimDetail'] as $index => $value) {
					
     				$rejectionStatus = false;						
                    $vc_invoice_no = $value['vc_invoice_no'];		
					$vc_outlet_code	=	$value['vc_outlet_code'];
										
                    $claimdetId  = $this->ClaimDetail->getPrimaryKey();						
						
					if($vc_invoice_no!=''){
					
					//pr($this->data['InvoiceClaimDoc'][$index]);
					if($this->data['InvoiceClaimDoc'][$index]['tmp_name']!=''){
					
					$filename = $this->data['InvoiceClaimDoc'][$index]['name'];
					$filetmpname = $this->data['InvoiceClaimDoc'][$index]['tmp_name'];
					$filetype = $this->data['InvoiceClaimDoc'][$index]['type'];
					
					}else{
					
					$filename ='';
					$filetmpname ='';
					$filetype ='';					
					
					}
					
					$dt_invoice_date = $value['dt_invoice_date'];
                    $fuel_litres = $value['nu_litres'];
                    $totalLitres = $totalLitres + $fuel_litres;
					$vc_outlet_code = $value['vc_outlet_code'];
					

                    if ($this->checkInvoiceDate($dt_invoice_date) == false) {
					
                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months.';
                    }

                    if ($this->checkInvoiceFuel($fuel_litres) == false) {

                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs.';
                    }

                 
					if ($this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {

						$rejectionStatus = true;
						$rejectionValue ='Invoice number is not unique.';
					}
					   

                    if ($this->checkInvoiceDate($dt_invoice_date) == false && $this->checkInvoiceFuel($fuel_litres) == false)
					{

                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Fuel is less than 200 Ltrs.';
                    }

                    
					if ($this->checkInvoiceDate($dt_invoice_date) == false && $this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Invoice number is not unique. ';
                    }
					
					if ($this->checkInvoiceFuel($fuel_litres)== false && $this->checkUniqueInvoice($vc_invoice_no, $vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs. & Invoice number is not unique. ';
                    }
					
					if ($this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false && $this->checkInvoiceDate($dt_invoice_date) == false && $this->checkInvoiceFuel($fuel_litres) == false) {

						$rejectionStatus = true;
						$rejectionValue  = 'Invoice is older than 3 months & Fuel is less than 200 Ltrs. & Invoice number is not unique.';
					}
					
					////////////s
					$removeCharacters = array("/", " ");
                    $vc_outlet_codereplace = str_replace($removeCharacters, "-", $vc_outlet_code);

					//$vc_outlet_codereplace = str_replace($vc_outlet_code,'/'),
                    $dir = $dirpath . DS . $vc_invoice_no.'-'.strtotime($dt_invoice_date).'-'.$vc_outlet_codereplace;
						
				    if($previousstate==1){						
							
    						//$this->recursiveRemove($dirpath);
                        	if ($filetmpname != '') {
							
								if (file_exists($dir)) {
										$this->rrmdir($dir);
								}
								mkdir($dir, 0777, true);
							}
					} else {
							if ($filetmpname != '') {							
								if (file_exists($dir)) {
										$this->rrmdir($dir);
								}
								mkdir($dir, 0777, true);
                        
							}
					}
                        $uploadStatus=false;
						
                        if ($filetmpname != '') {													
							
						$countrows = $this->InvoiceClaimDoc->find('count',array('conditions'=>array(			'InvoiceClaimDoc.vc_claim_no' => $vc_claim_no,'InvoiceClaimDoc.vc_client_no'=>$vc_client_no,
							'InvoiceClaimDoc.vc_invoice_no' => $vc_invoice_no,'InvoiceClaimDoc.vc_invoice_datetimestamp' => strtotime($dt_invoice_date),'InvoiceClaimDoc.vc_outlet_code' => $vc_outlet_code)));
							
						if($countrows>0){
							$this->InvoiceClaimDoc->deleteAll(array('InvoiceClaimDoc.vc_claim_no' => $vc_claim_no,
							'InvoiceClaimDoc.vc_invoice_no' => $vc_invoice_no,
							'InvoiceClaimDoc.vc_client_no'=>$vc_client_no,
							'InvoiceClaimDoc.vc_invoice_datetimestamp' => strtotime($dt_invoice_date),'InvoiceClaimDoc.vc_outlet_code' => $vc_outlet_code), false);
						}
						//	die;
						//echo 'filetmpname===',$filetmpname;
						//echo '<br/>';
						//echo 'dir===',$dir.DS.$renamefile;
                        $renamefile   = $vc_invoice_no . '-' . $this->renameUploadFile($filename);
                        $uploadStatus = move_uploaded_file($filetmpname, $dir . DS . $renamefile);

                        //mkdir($dirpath);
                        
						/////////////
					    
					if ($uploadStatus==true) {
					    
						$filedata                         = array();
						
						$this->InvoiceClaimDoc->create();
                    	$filedata['vc_upload_id']         = $this->InvoiceClaimDoc->getPrimaryKey();
						$filedata['vc_comp_code']         = $vc_comp_code;						
						$filedata['vc_claim_no']          = $vc_claim_no;
						$filedata['vc_invoice_no']        = $vc_invoice_no;
						$filedata['dt_invoice_date']      = $dt_invoice_date;						
						$filedata['vc_invoice_datetimestamp']  = strtotime($dt_invoice_date);
						$filedata['vc_outlet_code']       = $vc_outlet_code;
						$filedata['vc_client_no']         = $vc_client_no;
						$filedata['vc_uploaded_doc_for']  = 'Invoice';
						$filedata['vc_claim_dt_id'] 	  = $claimdetId;
						$filedata['vc_uploaded_doc_path'] = $dir;
						$filedata['vc_uploaded_doc_type'] = $filetype;
						$filedata['vc_uploaded_doc_name'] = $renamefile;
						$filedata['dt_date_uploaded']     = date('Y-m-d H:i:s');
							
						$this->InvoiceClaimDoc->set($filedata);
						$this->InvoiceClaimDoc->save($filedata, false);
						//pr($filedata);
						
						}else{
						
						//pr($filedata);
						//pr($this->data);
						//die;						
						
						}
						
						} // end of file not empty check
						  // unset($uploadStatus);
						if($previousstate==1 || $previousstate==0){
						
						$value['vc_claim_no']        = $vc_claim_no;
                        $value['vc_comp_code']       = $vc_comp_code;
                        $value['vc_claim_dt_id']     = $claimdetId;
                        $value['nu_refund_prcnt']    = $nu_refund_prcnt;
                        $value['nu_refund_rate']     = $refundRateValue;
                        $value['vc_client_no']       = $vc_client_no;
                        $value['nu_admin_fee_prcnt'] = $nu_admin_fee_percent;
                        $value['vc_fuel_type']       = $vc_fuel_type;
                        $value['nu_fuel_levy']       = $nu_fuel_leavy;
                        $value['vc_invoice_no']      = $vc_invoice_no;
						
                        $totalAmount = $totalAmount + $value['nu_amount'];

                        if ($rejectionStatus == true) {

                            $value['vc_reasons'] = $rejectionValue;
                            $value['vc_status'] = 'STSTY05';
                            $value['ch_rejected'] = 'Y';
                            $value['nu_amount'] = 0;
                            $value['nu_admin_fee'] = 0;
                            $value['dt_entry_date'] = date('Y-m-d H:i:s');
                            //	$value['dt_mod_date']        = date('Y-m-d H:i:s');
                        } else {

                            if ($this->data['Claim']['posted_data'] == 'SAVE') {
                              //  $value['vc_status'] = 'STSTY08';
                            } else {
                                // $value['vc_status'] = 'STSTY03';
                            }
							$value['vc_status'] = 'STSTY03';
                            $value['nu_amount'] = ($refundRateValue) * ($fuel_litres);
                            $value['nu_admin_fee'] = ($nu_admin_fee_percent) * ($fuel_litres);
                            $value['vc_reasons'] = '';
                            $value['dt_entry_date'] = date('Y-m-d H:i:s');
                            //$value['dt_mod_date'] = date('Y-m-d H:i:s');
                        }
						
                        if ($this->data['ClaimHeader']['singlefileuploadID'] == 1)
                            $value['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
                        else
                            $value['singlefileuploadid'] = 0;

                        $this->ClaimDetail->create();
                        $this->ClaimDetail->set($value);
                        $this->ClaimDetail->save($value, false);
						unset($value);
						
					  } // end of  

                    } 	// end of if of invoice no not null
					
              } // end-of-foreach
				
				
				if ($this->data['Claim']['posted_data'] == 'SAVE') {
                    $this->data['ClaimHeader']['vc_status'] = 'STSTY08';
                } else {
                    $this->data['ClaimHeader']['vc_status'] = 'STSTY03';
                }
				
                $this->data['ClaimHeader']['vc_payment_status'] = 'STSTY03';
                $this->data['ClaimHeader']['nu_tot_amount'] = $totalAmount;
                $this->data['ClaimHeader']['nu_tot_litres'] = $totalLitres;
                $this->data['ClaimHeader']['dt_mod_date'] = date('Y-m-d H:i:s');
				
				if($this->data['ClaimHeader']['singlefileuploadID']==1)
                $this->data['ClaimHeader']['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
				else
				$this->data['ClaimHeader']['singlefileuploadid'] =0;

                $this->ClaimHeader->id = $vc_claim_no;
                $this->ClaimHeader->save($this->data['ClaimHeader'], false);
				if ($this->data['Claim']['posted_data'] == 'SAVE') {
                    $this->Session->setFlash(' Claim details have been saved successfully !! ', 'success');
                } else {
                    $this->Session->setFlash(' Claim details have been added successfully, pending for approval from RFA !! ', 'success');
                }
				//pr($this->data);
			//	pr($filedata);
			//	die;
                $this->redirect('view');
			// end of code 
		   
		   }
		
		}else{
			$this->redirect($this->referer());
		
		} // error is false
	 
	  } // end of post check
	 } // end of function 
	 
	 
	 

    /*
     *
     * Edit Claim
     *
     */

    function flr_edit($claimno = null) {
		set_time_limit(0);
        $this->layout = "flr_layout";
        $claim_no = base64_decode($claimno);

        if (isset($claim_no) && $claim_no != '')
            $this->set('claim_no', $claim_no);
        else
            $this->set('claim_no', '');


        $this->loadModel('FuelOutlet');
        $this->loadModel('ClaimDetail');
        $this->loadModel('ClaimHeader');
        $this->loadModel('Client');
        $this->loadModel('ClaimprocessData');
        $this->loadModel('ClientFuelOutlet');
        $this->loadModel('InvoiceClaimDoc');

        $vc_comp_code = $this->Session->read('Auth.Client.vc_comp_code');
        $vc_username = $this->Session->read('Auth.Member.vc_username');
        $vc_cateogry = $this->Session->read('Auth.ClientHeader.vc_cateogry'); //vc_fuel_type

        $vc_client_no = '';
        $conditions['fields'] = array('Client.vc_client_no');
        $conditions['joins'] = array(
            array('table' => 'pr_dt_users_details_all',
                'alias' => 'Member',
                'type' => 'INNER',
                'conditions' => array(
                    array('Member.vc_flr_customer_no=Client.vc_client_no'),
                    array('Member.vc_username' => $vc_username),
                )
        ));



        $client_details = $this->Client->find('first', $conditions);
        $vc_client_no = $client_details['Client']['vc_client_no'];
        $flrFuelOutLet = array();

        $flrFuelOutLet = $this->ClientFuelOutlet->find('all', array('conditions' => array(
                'vc_client_no' => $vc_client_no,
                'vc_status' => 'STSTY04')));
        $flrFuelOutLet = Set::combine($flrFuelOutLet, '{n}.ClientFuelOutlet.vc_fuel_outlet', '{n}.ClientFuelOutlet.vc_fuel_outlet');
        $this->set('flrFuelOutLet', $flrFuelOutLet);



        $showclaimdetails = $this->ClaimHeader->find('all', array('conditions' => array(
                'ClaimHeader.vc_claim_no' => trim($claim_no),
                'ClaimHeader.vc_client_no' => $vc_client_no,
                'ClaimHeader.vc_comp_code' => $vc_comp_code
        )));
        $this->set('showclaimdetails', $showclaimdetails[0]);
		
        $ClaimprocessData = $this->ClaimprocessData->find('first', array('conditions' => array('ClaimprocessData.vc_fuel_type' => $this->Session->read('Auth.ClientHeader.vc_cateogry'))));
        $this->set('refundData', $ClaimprocessData);
		
        $fuelallow = $this->globalParameterarray['FUELALLOW'];
        $nu_admin_fee_percent = $ClaimprocessData['ClaimprocessData']['nu_admin_fee'];
        $nu_refund_prcnt = $ClaimprocessData['ClaimprocessData']['nu_refund_prcnt'];
        $vc_fuel_type = $ClaimprocessData['ClaimprocessData']['vc_fuel_type'];
        $fuel_type_category = $ClaimprocessData['ClaimprocessData']['fuel_type'];
        $nu_fuel_leavy = $ClaimprocessData['ClaimprocessData']['nu_fuel_leavy'];
        $dt_effective_date = $ClaimprocessData['ClaimprocessData']['dt_effective_date'];
        $refundRateValue = $this->getRefundRateValue($vc_client_no, $fuel_type_category, $vc_fuel_type);
        $this->set('refundRateValue', $refundRateValue);

        $error = false;

        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            $vc_claim_no = base64_decode($this->data['ClaimHeader']['vc_claim_no']);

            $validclaimNo = $this->ClaimHeader->find('count', array('conditions' => array(
                    'ClaimHeader.vc_claim_no' => trim($vc_claim_no),
                    'ClaimHeader.vc_client_no' => $vc_client_no,
                    'ClaimHeader.vc_comp_code' => $vc_comp_code
            )));
            if ($validclaimNo == 0) {

                $this->Session->setFlash('Invalid Claim No.', 'error');
                $this->redirect('view');
            }

            $i = 0;
            $filesizeLimit = '2048000';
            $vc_claim_form_no = $this->data['ClaimHeader']['vc_party_claim_no'];

            if ($this->flrgetFormCheck($vc_claim_form_no, $vc_claim_no) == false) {

                $error = true;
                $this->Session->setFlash('Please enter the unique claim form no.', 'error');
            }

            foreach ($this->data['ClaimDetail'] as $index => $value) {

                $vc_invoice_no = $value['vc_invoice_no'];
                $vc_outlet_code = $value['vc_outlet_code'];
                $dt_invoice_date = date('d-M-Y', strtotime($value['dt_invoice_date']));
                $this->data['ClaimHeader']['dt_claim_to'] = date('d-M-Y', strtotime($this->data['ClaimHeader']['dt_claim_to']));
                $this->data['ClaimHeader']['dt_claim_from'] = date('d-M-Y', strtotime($this->data['ClaimHeader']['dt_claim_from']));

                $fuel_litres = $value['nu_litres'];

                /*
				if ($this->checkUniqueInvoice($vc_invoice_no, $vc_claim_no, $value['dt_invoice_date'], $vc_outlet_code) == false) {

                    $error = true;
                    $this->Session->setFlash('Please enter the unique invoice numbers.', 'error');
                }
				*/
            }
			
            if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
				$filemulticnt=0;
				$noofinvoicescnt=0;
				foreach ($this->data['ClaimDetail'] as $index => $value) {
					$noofinvoicescnt++;
				}
                foreach ($this->data['InvoiceClaimDoc'] as $index => $value) {
					
					if($value['name']!=''){					
					
                    if ($this->fileExtension($value['name']) == false) {

                        $error = true;
                        $this->Session->setFlash('The type of file should be jpg , png , jpeg or pdf.', 'error');
                    }
                    if ((int) $value['size'] > 2048000) {

                        $error = true;
                        $this->Session->setFlash('The file size should be less than 2MB', 'error');
                    }
						$filemulticnt++;
					}
                }
         
				if($filemulticnt!=$noofinvoicescnt){				
					//$error = true;
					//$this->Session->setFlash('Please upload the file for all invoices.', 'error');
				}
			
			}else{
			 
			 $fileSinglecnt=0;			 
			 
			 foreach ($this->data['ClaimHeader']['input_allfileupload_values'] as $index => $value) {				
				if($value!=''){				
					$fileSinglecnt++;
				}				
			 }
			 if($fileSinglecnt ==0){				
					//$error = true;
					//$this->Session->setFlash('Please upload at least one file for all invoices.', 'error');
				}			
			
			}
            if ($error == false) {
			

                $this->ClaimDetail->deleteAll(array('ClaimDetail.vc_claim_no' => $vc_claim_no), false);               

                $totalLitres = 0;
                $totalAmount = 0;

                $dirpath = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . 'Claim' . DS . $vc_claim_no;

                if ($this->data['ClaimHeader']['singlefileuploadID'] == 1) {
					
					$dirpath = $dirpath.DS.'Claimfiles';
					
					$this->InvoiceClaimDoc->deleteAll(array('InvoiceClaimDoc.vc_claim_no' => $vc_claim_no,'InvoiceClaimDoc.vc_client_no' => $vc_client_no), false);
					
                    if (file_exists($dirpath)) {
                        $this->rrmdir($dirpath);
                    }
                    mkdir($dirpath,0777,true);

                    foreach ($this->data['ClaimHeader']['input_allfileupload_values'] as $index => $value) {

                        $filename = $value;
						$copypath = WWW_ROOT . 'uploadify'.DS.$vc_client_no;
                        $renamefile = $index . '-' . $this->renameUploadFile($filename);

                        if (copy($copypath.DS.$filename, $dirpath.DS.$renamefile) == true) {
                            $filedata = array();
                            $filedata['vc_upload_id'] = $this->InvoiceClaimDoc->getPrimaryKey();
                            $filedata['vc_comp_code'] = $vc_comp_code;
                            $filedata['vc_claim_no']  = $vc_claim_no;
                            $filedata['vc_client_no'] = $vc_client_no;
                            $filedata['vc_uploaded_doc_for'] = 'Claim';
                            //$filedata['vc_claim_dt_id'] 	  =  $vc_claim_no;
                            $filedata['vc_uploaded_doc_path'] = $dirpath;
                            $filedata['vc_uploaded_doc_type'] = $filetype;
                            $filedata['vc_uploaded_doc_name'] = $renamefile;
                            $filedata['dt_date_uploaded']     = date('Y-m-d H:i:s');
                            $this->InvoiceClaimDoc->create();
                            $this->InvoiceClaimDoc->set($filedata);
                            $this->InvoiceClaimDoc->save($filedata, false);
                            $uploadSinglefileStatus = true;
                            unlink($copypath .DS. $filename);
                        }
                    }
                }
                $filename = '';

                foreach ($this->data['ClaimDetail'] as $index => $value) {

                    $dir = '';
                    $rejectionStatus = false;

                    $filename = $this->data['InvoiceClaimDoc'][$index]['name'];
                    $filetmpname = $this->data['InvoiceClaimDoc'][$index]['tmp_name'];
                    $filetype = $this->data['InvoiceClaimDoc'][$index]['type'];
                    $vc_invoice_no = $value['vc_invoice_no'];
                    $dt_invoice_date = $value['dt_invoice_date'];
                    $vc_outlet_code  = $value['vc_outlet_code'];
                    $fuel_litres = $value['nu_litres'];
                    $totalLitres = $totalLitres + $fuel_litres;
					
					$uploadStatus =false;

                    if ($this->checkInvoiceDate($dt_invoice_date) == false) {

                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months.';
                    }

                    if ($this->checkInvoiceFuel($fuel_litres) == false) {

                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs.';
                    }
					if ($this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {

						$rejectionStatus = true;
						$rejectionValue ='Invoice number already exist.';
					}
					   

                    if ($this->checkInvoiceDate($dt_invoice_date) == false && $this->checkInvoiceFuel($fuel_litres) == false)
					{

                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Fuel is less than 200 Ltrs.';
                    }

                    
					if ($this->checkInvoiceDate($dt_invoice_date) == false && $this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Invoice is older than 3 months & Invoice number already exist. ';
                    }
					
					if ($this->checkInvoiceFuel($fuel_litres)== false && $this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false) {
                        //$error=true;
                        $rejectionStatus = true;
                        $rejectionValue = 'Fuel is less than 200 Ltrs. & Invoice number already exist. ';
                    }
					
					if ($this->checkUniqueInvoice($vc_invoice_no,$vc_claim_no, $dt_invoice_date, $vc_outlet_code) == false && $this->checkInvoiceDate($dt_invoice_date) == false && $this->checkInvoiceFuel($fuel_litres) == false) {

						$rejectionStatus = true;
						$rejectionValue ='Invoice is older than 3 months & Fuel is less than 200 Ltrs. & Invoice number already exist.';
					}

                    


                    if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
					
						$vc_outlet_code = $value['vc_outlet_code'];                    
						$removeCharacters = array("/", " ");
						$vc_outlet_codereplace = str_replace($removeCharacters, "-", $vc_outlet_code);
						$dir = $dirpath . DS . $vc_invoice_no.'-'.strtotime($dt_invoice_date).'-'.$vc_outlet_codereplace;

                        if (file_exists($dir)) {
						     $this->rrmdir($dir);                        
						}						
						
                        mkdir($dir, 0777, true);
                        $renamefile = $vc_invoice_no . '-' . $this->renameUploadFile($filename);
                        $uploadStatus = move_uploaded_file($filetmpname, $dir . DS . $renamefile);
						
						if($filename!='' && $uploadStatus==true){
							
							$this->InvoiceClaimDoc->deleteAll(array('InvoiceClaimDoc.vc_claim_no' => $vc_claim_no,'InvoiceClaimDoc.vc_client_no' => $vc_client_no,
							'InvoiceClaimDoc.dt_invoice_date'=>strtotime($dt_invoice_date),
							'InvoiceClaimDoc.vc_invoice_no'=>$vc_invoice_no,
							'InvoiceClaimDoc.vc_outlet_code'=>$vc_outlet_code), false);
						
						}
                    }

                    if ($uploadStatus == true || $uploadSinglefileStatus == true) {

                        $claimdetId = $this->ClaimDetail->getPrimaryKey();

                        if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {

                            $filedata = array();
                            $filedata['vc_upload_id'] = $this->InvoiceClaimDoc->getPrimaryKey();
                            $filedata['vc_comp_code'] = $vc_comp_code;
                            $filedata['vc_client_no'] = $vc_client_no;
                            $filedata['vc_invoice_no'] = $vc_invoice_no;
                            $filedata['dt_invoice_date'] = $dt_invoice_date;
                            $filedata['vc_outlet_code'] = $vc_outlet_code;
                            $filedata['vc_invoice_datetimestamp'] = strtotime($dt_invoice_date);
                            $filedata['vc_claim_no'] = $vc_claim_no;
                            $filedata['vc_uploaded_doc_for'] = 'Invoice';
                            $filedata['vc_claim_dt_id'] = $claimdetId;
                            $filedata['vc_uploaded_doc_path'] = $dir;
                            $filedata['vc_uploaded_doc_type'] = $filetype;
                            $filedata['vc_uploaded_doc_name'] = $renamefile;
                            $filedata['dt_date_uploaded'] = date('Y-m-d H:i:s');
                        }

                        $value['vc_claim_no'] = $vc_claim_no;
                        $value['vc_comp_code'] = $vc_comp_code;
                        $value['vc_claim_dt_id'] = $claimdetId;
                        $value['nu_refund_prcnt'] = $nu_refund_prcnt;
                        $value['nu_refund_rate'] = $refundRateValue;
                        $value['vc_client_no'] = $vc_client_no;
                        $value['nu_admin_fee_prcnt'] = $nu_admin_fee_percent;
                        $value['vc_fuel_type'] = $vc_fuel_type;
                        $value['nu_fuel_levy'] = $nu_fuel_leavy;

                        $totalAmount = $totalAmount + $value['nu_amount'];
                        if ($this->data['ClaimHeader']['singlefileuploadID'] == 1)
                            $value['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
                        else
                            $value['singlefileuploadid'] = 0;



                        if ($rejectionStatus == true) {

                            $value['vc_reasons'] = $rejectionValue;
                            $value['vc_status'] = 'STSTY05';
                            $value['ch_rejected'] = 'Y';
                            $value['nu_amount'] = 0;
                            $value['nu_admin_fee'] = 0;
                            $value['dt_entry_date'] = date('Y-m-d H:i:s');
                        } else {

                            $value['vc_status'] = 'STSTY03';
                            $value['nu_amount'] = ($refundRateValue) * ($fuel_litres);
                            $value['nu_admin_fee'] = ($nu_admin_fee_percent) * ($fuel_litres);
                            $value['vc_reasons'] = '';
                            $value['dt_entry_date'] = date('Y-m-d H:i:s');
                        }

                        $this->ClaimDetail->create();
                        $this->ClaimDetail->set($value);
                        $this->ClaimDetail->save($value, false);

                        if ($this->data['ClaimHeader']['singlefileuploadID'] != 1) {
							
							if ($uploadStatus == true){	
                            
							$this->InvoiceClaimDoc->create();
                            $this->InvoiceClaimDoc->set($filedata);
                            $this->InvoiceClaimDoc->save($filedata, false);							
							
							}
                        }
                    } else {

                        $this->Session->setFlash('File was not uploaded. ', 'error');
                    } // if check for upload	file
                } // end of foreach


                /** ********Email to client****************** */


                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($this->Session->read('Auth.Member.vc_email_id'));

                $this->Email->bcc = array(trim($this->AdminFlrEmailID));

                $this->Email->subject = strtoupper($selectedType) . "  Edit Claim Details";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($this->Session->read('Auth.Member.vc_user_firstname'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Member.vc_user_lastname'))));

                $this->Email->delivery = 'smtp';

                $mesage = " Claim details have been updated successfully, pending for approval from RFA !!";

                $mesage .= "<br> <br> Username : " . trim($this->Session->read('Auth.Member.vc_username'));

                $mesage .= "<br> <br>RFA Account No. : " . trim($this->Session->read('Auth.Member.vc_flr_customer_no'));

                $this->Email->send($mesage);

                $this->Email->to = array();

                $this->Email->bcc = array();

                /******************************* End *********************************** */

                unset($this->data['ClaimDetail']);
                unset($this->data['InvoiceClaimDoc']);
                unset($this->data['ClaimHeader']['vc_claim_no']);
				
                $this->data['ClaimHeader']['vc_status'] = 'STSTY03';
                $this->data['ClaimHeader']['vc_payment_status'] = 'STSTY03';
                $this->data['ClaimHeader']['nu_tot_amount'] = $totalAmount;
                $this->data['ClaimHeader']['nu_tot_litres'] = $totalLitres;
                $this->data['ClaimHeader']['vc_party_claim_no'] = $vc_claim_form_no;
                $this->data['ClaimHeader']['dt_mod_date'] = date('Y-m-d H:i:s');

                if ($this->data['ClaimHeader']['singlefileuploadID'] == 1)
                    $this->data['ClaimHeader']['singlefileuploadid'] = $this->data['ClaimHeader']['singlefileuploadID'];
                else
                    $this->data['ClaimHeader']['singlefileuploadid'] = 0;



                $this->ClaimHeader->id = $vc_claim_no;
                $this->ClaimHeader->save($this->data['ClaimHeader'], false);
                $this->Session->setFlash(' Claim details have been updated successfully, pending for approval from RFA !! ', 'success');
                $this->redirect('view');
            } // end of error false condition
			else{
			
			$this->redirect($this->referer());
			}
            //else
        }  // end of post value
    }

    // end of function

    /**
     * 
     * Add Claim
     * 
     */
    public function flr_deletefile($id = null) {

        Configure::write('debug', 0);

        $this->layout = NULL;
        //$this->autorender=false;

        $this->loadModel('InvoiceClaimDoc');
        if ($this->params['isAjax']) {				
			
            $client_no = trim($this->Session->read('Auth.Client.vc_client_no'));
            $comp_code = trim($this->Session->read('Auth.Client.vc_comp_code'));
            $id = base64_decode($this->params['form']['ClaimDocDetailId']);
            $vc_username = $this->Session->read('Auth.Member.vc_username');
            $DownloadFile = $this->InvoiceClaimDoc->find('first', array(
                'conditions' => array(
                    'InvoiceClaimDoc.vc_comp_code' => $comp_code,
                    'InvoiceClaimDoc.vc_upload_id' => $id),
            ));

            $dirpath = $DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_path'] . DS . $DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_name'];
            //$dirpath = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . 'Claim' . DS . $vc_claim_no;
            unlink($dirpath);
            $deleteFile = $this->InvoiceClaimDoc->deleteAll(array(
                'InvoiceClaimDoc.vc_upload_id' => $id), false);
			if(isset($this->params['pass'][0]) && $this->params['pass'][0]!=''){
			//pr($this->params);
			}else{
			exit;
			}
        }
    }

    public function flr_viewfile($id = null) {

        Configure::write('debug', 0);

        $this->layout = NULL;

        $this->loadModel('InvoiceClaimDoc');

        $client_no = trim($this->Session->read('Auth.Client.vc_client_no'));

        $comp_code = trim($this->Session->read('Auth.Client.vc_comp_code'));

        $DownloadFile = $this->InvoiceClaimDoc->find('first', array(
            'conditions' => array(
                'InvoiceClaimDoc.vc_comp_code' => $comp_code,
                'InvoiceClaimDoc.vc_upload_id' => $id),
        ));

        if ($DownloadFile && file_exists($DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_path'] . DS . $DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_name'])) {

            $path = $DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_path'] . DS . $DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_name'];

            header('Expires: 0');

            header('Pragma: public');

            header('Content-type:' . $DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_type']);

            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            header('Content-Disposition: attachment; filename="' . basename($DownloadFile['InvoiceClaimDoc']['vc_uploaded_doc_name']) . '"');

            header('Content-Transfer-Encoding: binary');

            @readfile($path);

            exit(0);
        } else {

            $this->Session->setFlash('Sorry No file', 'info');

            $this->redirect($this->referer());
        }
    }

    public function flr_addclaim() {


        $this->loadModel('ClaimprocessData');
        $this->loadModel('Member');
        $this->loadModel('Client');
        $this->loadModel('ClientFuelOutlet');

        $this->layout = null;

        if ($this->params['isAjax']) {


            if (isset($this->params['form']['rowCount'])) {

                $this->set('rowCount', (int) $this->params['form']['rowCount']);
            }
        }

        $ClaimprocessData = $this->ClaimprocessData->find('first', array(
            'conditions' => array(
                'lower(ClaimprocessData.vc_fuel_type)' =>
                strtolower(trim($this->Session->read('Auth.ClientHeader.vc_cateogry'))))));
        $this->set('refundData', $ClaimprocessData);

        $vc_fuel_type = $ClaimprocessData['ClaimprocessData']['vc_fuel_type'];
        $fuel_type_category = $ClaimprocessData['ClaimprocessData']['fuel_type'];
        $vc_username = $this->Session->read('Auth.Member.vc_username');
        $vc_cateogry = $this->Session->read('Auth.ClientHeader.vc_cateogry'); //vc_fuel_type

        $vc_client_no = '';
        $conditions['fields'] = array('Client.vc_client_no');
        $conditions['joins'] = array(
            array('table' => 'pr_dt_users_details_all',
                'alias' => 'Member',
                'type' => 'INNER',
                'conditions' => array(
                    array('Member.vc_flr_customer_no=Client.vc_client_no'),
                    array('Member.vc_username' => $vc_username),
                )
        ));



        $client_details = $this->Client->find('first', $conditions);
        $vc_client_no = $client_details['Client']['vc_client_no'];

        $refundRateValue = $this->getRefundRateValue($vc_client_no, $fuel_type_category, $vc_fuel_type);
        $this->set('refundRateValue', $refundRateValue);

        $flrFuelOutLet = array();
        $flrFuelOutLet = $this->ClientFuelOutlet->find('all', array('conditions' => array(
                'vc_client_no' => $vc_client_no,
                'vc_status' => 'STSTY04')));

        $flrFuelOutLet = Set::combine($flrFuelOutLet, '{n}.ClientFuelOutlet.vc_fuel_outlet', '{n}.ClientFuelOutlet.vc_fuel_outlet');
        $this->set('flrFuelOutLet', $flrFuelOutLet);
    }

    function rrmdir($dir) {
//echo $dir;
        foreach (glob($dir . DS . '*') as $file) {
//echo $file;
            if (is_dir($file))
                rrmdir($file);
            else
                unlink($file);
        }

        rmdir($dir);
    }

}

?>
