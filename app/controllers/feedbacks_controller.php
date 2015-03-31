<?php

App::import('Sanitize');

/**
 *
 *
 *
 */
class FeedbacksController extends AppController {

    /**
     *
     *
     *
     */
    var $name = 'Feedbacks';

    /**
     *
     *
     *
     */
    var $components = array('Session', 'RequestHandler', 'Email');

    /**
     *
     *
     *
     */
    var $uses = array('Customer', 'FeedbackData', 'ClientFeedback', 'DocumentUploadCbc', 'AllFeedback', 'FeedbackUpload','Member');

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
    var $layout = 'cbc_layout';

    function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow(array('userfeedback'));
        $currentUser = $this->checkUser();

        if ($this->isInspector) {

            $this->redirect(array('controller' => 'inspectors', 'action' => 'index'));
        }
		
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
		$cbc_ch_active = $this->Session->read('Auth.Customer.ch_active');
		$flr_ch_active = $this->Session->read('Auth.Client.ch_active_flag');
		$vc_username = $this->Session->read('Auth.Member.vc_username');
		
		if($vc_username!='' && $cbc_ch_active=='STSTY04')	
		$this->Auth->allow('cbc_addcomplaint');
		
		if($vc_username!='' && $flr_ch_active=='STSTY04')	
		$this->Auth->allow('flr_addcomplaint');
		
		$this->loginRightCheck();
		
    }
	
	function loginRightCheck() {
		
        if ($this->loggedIn && !in_array($this->action, $this->Auth->allowedActions)) {

             $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        }
    }

    /*
     *
     *
     *
     * CBC add Complaint From
     *
     *
     */

    public function cbc_addcomplaint() {


        $this->layout = 'cbc_layout';

        $this->loadModel('FeedbackData');

        $vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');

        $vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');

        $vc_username = $this->Session->read('Auth.Customer.vc_username');

        $vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');

        $vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');

        $vc_email_id = $this->Session->read('Auth.Customer.vc_email');

        $vc_customer_no = $this->Session->read('Auth.Customer.vc_cust_no');


        $fileName = trim($vc_customer_no);


        $customer = $this->Customer->find('first', array('conditions' => array('Customer.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'))));


        $this->set('customer', $customer);


        $vehtype = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PRIORTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

        $this->set('vehtype', $vehtype);
        $vehtype1 = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'COMPTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));
        $this->set('vehtype1', $vehtype1);

        //$prtype= $this->ParameterType->find('p');
        //$this->globalParameterarray = Set::combine($prtype, '{n}.ParameterType.vc_prtype_code', '{n}.ParameterType.vc_prtype_name');


        if (isset($this->data) && !empty($this->data) && $this->RequestHandler->isPost()) {

            $this->FeedbackData->create(false);
            //pr($this->data);
            //die;
            $this->data['FeedbackData']['feedback_request_id'] = $this->FeedbackData->getPrimaryKey();
            $this->data['FeedbackData']['vc_status'] = 'STSTY01';

            $this->data['DocumentUploadCbc']['nu_upload_id'] = $this->DocumentUploadCbc->getPrimaryKey();
            $this->data['DocumentUploadCbc']['feedback_request_id'] = $this->data['FeedbackData']['feedback_request_id'];

            $setValidates = array('complaint_description', 'logged_by', 'dt_created', 'contact_no');

            $this->FeedbackData->set($this->data);

            $this->unsetValidateVariable($setValidates, array_keys($this->FeedbackData->validate), &$this->FeedbackData);

            $this->FeedbackData->set($this->data['FeedbackData']);

            $this->DocumentUploadCbc->create(false);

            $this->DocumentUploadCbc->set($this->data);


            $insertion = array();
            $insertion['FeedbackData'] = array(
                'vc_user_no' => $vc_user_no,
                'vc_comp_code' => $vc_comp_code,
                'vc_cust_no' => $vc_cust_no,
                'dt_created' => date('d-M-Y', strtotime($this->data['FeedbackData']['dt_created'])),
            );
            $completeMessageForEmail = "<br><br>Username : " . $vc_username;
            $completeMessageForEmail.= "<br><br>RFA Account No. : " . $vc_cust_no;
            $completeMessageForEmail.= "<br><br>Complaint date : " . $this->data['FeedbackData']['dt_created'];
            $completeMessageForEmail.= "<br><br>Logged By : " . $this->data['FeedbackData']['logged_by'];
            $completeMessageForEmail.= "<br><br>Contact No. : " . $this->data['FeedbackData']['contact_no'];
            $completeMessageForEmail.= "<br><br>Complaint Type : " . $vehtype1[$this->data['FeedbackData']['complaint_type']];
            $completeMessageForEmail.= "<br><br>Priority : " . $vehtype[$this->data['FeedbackData']['priority_type']];
            $completeMessageForEmail.= "<br><br>Description  : " . nl2br($this->data['FeedbackData']['complaint_description']);

            if ($this->FeedbackData->validates($setValidates)) {

                if ($this->FeedbackData->save($insertion)) {

                    $file = $this->data['FeedbackData']['upload_doc'];

                    $filename = $file['name'];
                    if ($filename != '')
                        $filename = $this->renameUploadFile($filename);

                    $dir = WWW_ROOT . "uploadfile" . DS . $vc_username . DS . "Feedback-Complaint";

                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }



                    $uploadfile = array();

                    $uploadfile['DocumentUploadCbc'] = array(
                        'vc_user_no' => $vc_user_no,
                        'vc_comp_code' => $vc_comp_code,
                        'vc_cust_no' => $vc_cust_no,
                        'vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD04'],
                        'vc_upload_doc_name' => trim($filename),
                        'dt_date_uploaded' => date('d-M-y'),
                        'vc_upload_doc_path' => $dir
                    );

                    move_uploaded_file($file["tmp_name"], $dir . '/' . $filename);


                    /* ***********************Email Shoot ******************* */

                    list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                    $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                    $this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
					
					$this->Email->bcc = array(trim($this->AdminCbcEmailID));

                    $this->Email->subject = strtoupper($selectedType) . " Feedback/Complaint  ";

                    $this->Email->template = 'registration';

                    $this->Email->sendAs = 'html';

                    $this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

                    $this->Email->delivery = 'smtp';

                    $mesage = "Your Feedback/Complaint has been sent successfully !!";
					
                    $mesage = $mesage . '<br>' . $completeMessageForEmail;

                    $this->Email->send($mesage);
					
					$this->Email->to = array();
					
					$this->Email->bcc =  array();


                    /* *************Email Shoot at alternative email id************** */
					

                    if (isset($vc_alter_email) && !empty($vc_alter_email)) {

                        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                        $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                        $this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

                        $this->Email->subject = strtoupper($selectedType) . " Feedback/Complaint  ";

                        $this->Email->template = 'registration';

                        $this->Email->sendAs = 'html';

                        $this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

                        $this->Email->delivery = 'smtp';

                        $mesage = "Your Feedback/Complaint has been sent successfully !!";

                        $mesage = $mesage . '<br>' . $completeMessageForEmail;

                        $this->Email->send($mesage);
                    }


                    /*                     * ******************Email Send To Admin************************** */

                    /* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))) . '<' . trim($this->Session->read('Auth.Customer.vc_email')) . '>';

                    $this->Email->to = $this->AdminEmailID;

                    $this->Email->subject = strtoupper($selectedType) . " Feedback/Complaint ";

                    $this->Email->template = 'registration';

                    $this->Email->sendAs = 'html';

                    $this->set('name', $this->AdminName);

                    $this->Email->delivery = 'smtp';


                    $mesage = "A new Feedback/Complaint from a CBC customer(" . ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))) . ").";

                    $mesage = strtoupper($selectedType) . '<br>' . " Feedback/complaint recieved";
                    $mesage = $mesage . '<br>' . $completeMessageForEmail;


                    $this->Email->send($mesage); */




                    /*                     * ****************************************** */
                    $this->data = null;

                    $this->Session->write('Auth.Customer.vc_cust_no', $vc_cust_no);

                    $this->Session->setFlash('Your Feedback has been sent successfully !!', 'success');

                    $this->DocumentUploadCbc->save($uploadfile);

                    $this->Session->setFlash('Your Feedback has been sent successfully !!', 'success');

                    $this->redirect($this->referer());
                }
            }
        }
    }

    /*
     *
     *
     *
     *  Feedback/Complaint Form
     *
     *
     */

    public function userfeedback($type = null) {


        $this->layout = 'feedback';

        list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($type);

        $this->set('FLA_TYPE', $selectList);

        $vehtype = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PRIORTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

        $this->set('vehtype', array('' => 'Select Priorty') + $vehtype);

        $vehtype1 = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'COMPTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));

        $this->set('vehtype1', array('' => 'Select Complaint Type') + $vehtype1);


        if (isset($this->data) && !empty($this->data) && $this->RequestHandler->isPost()) {


            $this->AllFeedback->create(false);

            $this->data['AllFeedback']['feedback_id'] = $this->AllFeedback->getPrimaryKey();

            $this->data['FeedbackUpload']['nu_upload_id'] = $this->FeedbackUpload->getPrimaryKey();
            $this->data['FeedbackUpload']['feedback_id'] = $this->data['AllFeedback']['feedback_id'];

            $this->data['AllFeedback']['vc_comp_code'] = $this->data['AllFeedback']['customer_type'];



            $setValidates = array('complaint_description', 'logged_by', 'dt_created', 'contact_no');

            $this->AllFeedback->set($this->data);

            $this->unsetValidateVariable($setValidates, array_keys($this->AllFeedback->validate), &$this->AllFeedback);

            $this->AllFeedback->set($this->data['AllFeedback']);

            $this->FeedbackUpload->create(false);

            $this->FeedbackUpload->set($this->data);


            $insertion = array();

            $insertion['AllFeedback'] = array(
                'dt_created' => date('d-M-Y'),
            );

            $completeMessageForEmail = "<br><br>Customer Name : " . trim($this->data['AllFeedback']['vc_customer_name']);
            $completeMessageForEmail.= "<br><br>Complaint date : " . trim($this->data['AllFeedback']['dt_created']);
            $completeMessageForEmail.= "<br><br>Logged By :" . trim($this->data['AllFeedback']['logged_by']);
            $completeMessageForEmail.= "<br><br>Contact No. : " . trim($this->data['AllFeedback']['contact_no']);
            $completeMessageForEmail.= "<br><br>Complaint Type : " . trim($vehtype1[$this->data['AllFeedback']['complaint_type']]);
            $completeMessageForEmail.= "<br><br>Priority : " . trim($vehtype[$this->data['AllFeedback']['priority_type']]);
            $completeMessageForEmail.= "<br><br>Description  : " . nl2br($this->data['AllFeedback']['complaint_description']);

            
            
            ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes
            
            
            if ($this->AllFeedback->validates($setValidates)) {

                if ($this->AllFeedback->save($insertion)) {

                    $file = $this->data['AllFeedback']['upload_doc'];

                    $filename = $file['name'];

                    $dir = WWW_ROOT . "uploadfile" . DS . "Feedback-Complaint";

                    if (!file_exists($dir)) {

                        mkdir($dir, 0777, true);
                    }

                    if (file_exists($dir . '/' . $filename)) {

                        $filename = date('YmdHis') . '-' . $filename;
                    }

                    $uploadfile = array();

                    $uploadfile['FeedbackUpload'] = array(
                        'vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD04'],
                        'vc_upload_doc_name' => trim($filename),
                        'dt_date_uploaded' => date('d-M-Y'),
                        'vc_upload_doc_path' => $dir
                    );


                    move_uploaded_file($file["tmp_name"], $dir . '/' . $filename);


                    $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                    $this->Email->to = trim($this->data['AllFeedback']['vc_email_id']);

                    $this->Email->subject = " Feedback/Complaint  ";

                    $this->Email->template = 'registration';

                    $this->Email->sendAs = 'html';

                    $this->set('name', trim($this->data['AllFeedback']['vc_customer_name']));

                    $this->Email->delivery = 'smtp';

                    $mesage = "Your Feedback/Complaint has been sent successfully !!";

                    $mesage = "Your Feedback/Complaint has been sent successfully !!";
					
                    $mesage = $mesage . '<br>' . $completeMessageForEmail;

                    $this->Email->send($mesage);



                    /********************Email Send To Admin************************** */
                    $this->Email->from = $this->data['AllFeedback']['vc_customer_name'];

                    $this->Email->to = $this->AdminEmailID;

                    $this->Email->subject = strtoupper($selectedType) . " Feedback/Complaint ";

                    $this->Email->template = 'registration';

                    $this->Email->sendAs = 'html';

                    $this->set('name', $this->AdminName);

                    $this->Email->delivery = 'smtp';


                    $mesage = "A new Feedback/Complaint recived (" . $this->data['AllFeedback']['vc_customer_name'] . ").";

                    $mesage = strtoupper($selectedType) . '<br>' . " Feedback/complaint recieved";
                    $mesage = $mesage . '<br>' . $completeMessageForEmail;


                    $this->Email->send($mesage);



                    /*                     * ****************************************** */



                    $this->data = null;

                    $this->Session->setFlash('Your Feedback has been sent successfully !!', 'success');

                    if ($this->FeedbackUpload->save($uploadfile)) {

                        $this->Session->setFlash('Your Feedback has been sent successfully !!', 'success');

                        $this->redirect($this->referer());
                    }
                }
            }
        }
    }

    /*
     *
     *
     *
     * FLR add Complaint From
     *
     *
     */

    public function flr_addcomplaint() {

        $this->layout = 'flr_layout';
        
        $this->loadModel('ParameterType');
		
        $this->loadModel('ClientFeedback');
        
        
		$this->loadModel('ClientUploadDocs');

        $complaintType = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'COMPTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));
        
		$this->set('complaintType', array('' => 'Select') + $complaintType);

        $priorityType = $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'PRIORTYPE%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name')));
        
		$this->set('priorityType', array('' => 'Select') + $priorityType);

        $this->layout = 'flr_layout';


        if (isset($this->data) && !empty($this->data) && $this->RequestHandler->isPost()) {
			//pr($this->data);

            $setValidates = array('complaint_type', 'logged_by', 'priority_type', 'contact_no', 'complaint_description', 'dt_created');

            $this->ClientFeedback->set($this->data);

            if ($this->ClientFeedback->validates(array('fieldList' => $setValidates))) {


                $this->ClientUploadDocs->set($this->data);

                if ($this->ClientUploadDocs->validates(array('fieldList' => array('complaint_doc')))) {

                    $this->data['ClientFeedback']['feedback_request_id'] = $this->ClientFeedback->getPrimaryKey();
                    $this->data['ClientFeedback']['vc_comp_code'] = $this->Session->read('Auth.Client.vc_comp_code');
                    $this->data['ClientFeedback']['vc_user_no'] = $this->Session->read('Auth.Client.vc_user_no');
                    $this->data['ClientFeedback']['vc_client_no'] = $this->Session->read('Auth.Client.vc_client_no');
                    $this->data['ClientFeedback']['vc_status'] = 'STSTY01';

                    if ($this->ClientFeedback->save($this->data)) {

                        $this->data['ClientUploadDocs']['vc_upload_id'] = $this->ClientUploadDocs->getPrimaryKey();

                        $this->data['ClientUploadDocs']['vc_uploaded_doc_for'] = 'Feedback-Complaint';

                        $this->data['ClientUploadDocs']['vc_uploaded_doc_path'] = WWW_ROOT . 'uploadfile' . DS . $this->Session->read('Auth.Member.vc_username') . DS . 'Feedback-Complaint';

                        $this->data['ClientUploadDocs']['vc_comp_code'] = $this->Session->read('Auth.Client.vc_comp_code');

                        $this->data['ClientUploadDocs']['vc_client_no'] = $this->Session->read('Auth.Client.vc_client_no');

                        $this->data['ClientUploadDocs']['dt_date_uploaded'] = $this->data['ClientFeedback']['dt_created'];

					
                        $this->data['ClientUploadDocs']['vc_uploaded_doc_name'] = $this->data['ClientUploadDocs']['complaint_doc']['name'];
                        $this->data['ClientUploadDocs']['vc_uploaded_doc_tmp_name'] = $this->data['ClientUploadDocs']['complaint_doc']['tmp_name'];

                        $this->data['ClientUploadDocs']['vc_uploaded_doc_type'] = $this->data['ClientUploadDocs']['complaint_doc']['type'];

                        if ($this->ClientUploadDocs->save($this->data['ClientUploadDocs'], false)) {

                            $dir = $this->data['ClientUploadDocs']['vc_uploaded_doc_path'];

                            if (!file_exists($dir)) {
							
                                mkdir($dir, 0777, true);
                            }

                            $filename = $this->data['ClientUploadDocs']['vc_uploaded_doc_name'];

                            if (file_exists($dir . DS . $filename)) {

                                $filename = time(). '-' . $filename;
                            }
							
							

                           move_uploaded_file($this->data['ClientUploadDocs']['vc_uploaded_doc_tmp_name'], $dir . DS . $filename);

                            $completeMessageForEmail = "<br/><br/>Client Name : " .trim($this->Session->read('Auth.Client.vc_client_name'));
							
							$completeMessageForEmail.= "<br><br>Username : " .trim($this->Session->read('Auth.Member.vc_username'));
							
							$completeMessageForEmail.= "<br><br>RFA Account No. : " .trim($this->Session->read('Auth.Member.vc_flr_customer_no'));
							
							$completeMessageForEmail.= "<br/><br/>Complaint date : " . trim($this->data['ClientFeedback']['dt_created']);
                            
							$completeMessageForEmail.= "<br/><br/>Logged By :" . trim($this->data['ClientFeedback']['logged_by']);
                            
							$completeMessageForEmail.= "<br/><br/>Contact No. : " . trim($this->data['ClientFeedback']['contact_no']);
                            
							$completeMessageForEmail.= "<br/><br/>Complaint Type : " . trim($complaintType[$this->data['ClientFeedback']['complaint_type']]);
                            
							$completeMessageForEmail.= "<br/><br/>Priority : " . trim($priorityType[$this->data['ClientFeedback']['priority_type']]);
                            
							$completeMessageForEmail.= "<br/><br/>Description  : " . nl2br($this->data['ClientFeedback']['complaint_description']);

                            ini_set('max_execution_time', 1200); //1200 seconds = 20 minutes

                            /* ***************************Email Send To Client************************* */
							

                            list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

                            $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';;

                            $this->Email->to = trim($this->Session->read('Auth.Client.vc_email'));
							
							$this->Email->bcc = array(trim($this->AdminFlrEmailID));

                            $this->Email->subject = strtoupper($selectedType) . " Feedback/Complaint ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', ucfirst(trim($this->Session->read('Auth.Client.vc_client_name'))));

                            $this->Email->delivery = 'smtp';

                            $mesage = "Your Feedback/Complaint has been been received !!";

                            $mesage .= '<br/>' . $completeMessageForEmail;

                            $this->Email->send($mesage);
							
							$this->Email->to = array();
					
							$this->Email->bcc =  array();

                            /********************Email Send To Admin************************** */

                            /* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Client.vc_client_name'))) . ' ' . '<' . trim($this->Session->read('Auth.Client.vc_email')) . '>';

                            $this->Email->to = $this->AdminEmailID;

                            $this->Email->subject = strtoupper($selectedType) . " Feedback/Complaint ";

                            $this->Email->template = 'registration';

                            $this->Email->sendAs = 'html';

                            $this->set('name', $this->AdminName);

                            $this->Email->delivery = 'smtp';


                            $mesage = strtoupper($selectedType) . " - Feedback/complaint recieved ";

                            $mesage .= "A new Feedback/Complaint from a FLR Client <br/><br/> ";

                            $mesage .= $completeMessageForEmail;

                            $this->Email->send($mesage); */
                        }


                        $this->Session->setFlash('Your feedback has been sent successfully !!', 'success');
						
                        $this->redirect($this->referer());
						
                    } else {
                        $this->Session->setFlash('Your feedback could not be sent, please try later !!', 'error');
                    }
                }
            }
        }
    }

}

