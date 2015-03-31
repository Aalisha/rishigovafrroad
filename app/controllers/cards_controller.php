<?php

App::import('Sanitize');

/**
 *
 *
 *
 */
 
class CardsController extends AppController {

    /**
     *
     *
     *
     */
	 
    var $name = 'Cards';

    /**
     *
     *
     *
     */
	 
    var $components = array('Session', 'RequestHandler', 'Email','Cbccardvehiclepdfcreator');

    /**
     *
     *
     *
     */

    var $uses = array('Card','CustomerCard', 'AccountRecharge', 'Customer', 'DocumentUploadCbc', 'ActivationDeactivationCard', 'RequestCard', 'CardLogCbc','Member');

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
	 
    function beforeFilter() {
		
		parent::beforeFilter();

        $currentUser = $this->checkUser();
		
        if( $this->isInspector ) {

			$this->redirect(array('controller'=>'inspectors','action'=>'index'));

        }
	
		$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
		$ch_active = $this->Session->read('Auth.Customer.ch_active');
		$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
		$vc_username = $this->Session->read('Auth.Member.vc_username');
		
		if($vc_username!='' && $ch_active=='STSTY04' )	
		$this->Auth->allow('*');
		
		/*$this->Auth->allow('cbc_activationdeactivation','cbc_card_list_pdf','cbc_card_request','cbc_submit_card','cbc_account_recharge','cbc_refund_request');*/
		
		
		$this->layout = $this->Auth->params['prefix'].'_layout';
		
		$this->loginRightCheck();
    }

    /**
     *
     *
     *
     */
	 function loginRightCheck() {
	
        if ($this->loggedIn && !in_array(strtolower($this->action), $this->Auth->allowedActions)) {

             $this->redirect(array('controller' => 'members', 'action' => 'login',@$this->Auth->params['prefix'] => false));
        }
    }

	 
    public function cbc_index() {
        
    }

    /**
     *
     * Function for Activation/Deactivation Card
     *
     */
	 
    function cbc_activationdeactivation() {
		   set_time_limit(0);
		$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
		
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$username =$this->Session->read('Auth.Customer.vc_username');
	 	
        if (!empty($this->data) && $this->RequestHandler->isPost()) {

            
				$isDone = false;

				$active=false;

				$deactive = false;
									
				foreach ( $this->data['Card'] as  $values ) {
				
					unset($data);
					
					if(  isset($values['vc_card_flag']) && !empty($values['vc_card_flag'])  ) {
										
						$result = $this->ActivationDeactivationCard->find('first', array(
												'conditions' => array(
												'ActivationDeactivationCard.vc_cust_no'=>$vc_cust_no,
												'ActivationDeactivationCard.vc_card_no' => $values['vc_card_no'])));
												
						$data['ActivationDeactivationCard']['vc_reason']= $values['vc_reason'];
						
						if( $result ) {
						
							$isDone = true; 
							
							$this->CardLogCbc->create(false);

							$dataLog['CardLogCbc'] = $result['ActivationDeactivationCard'];							
														
							$data['ActivationDeactivationCard']['vc_card_no'] = trim($values['vc_card_no']);
							
							if(trim($values['vc_card_flag']) == 'STSTY02'){
							
								$deactive=true;
							
							}else{
							
								$active = true;
							
							} 
							$data['ActivationDeactivationCard']['vc_card_flag'] =  trim($values['vc_card_flag']) == 'STSTY02' ? trim($values['vc_card_flag']) : 'STSTY03';

							$this->ActivationDeactivationCard->id = trim($values['vc_card_no']);
							
							$this->ActivationDeactivationCard->set($data['ActivationDeactivationCard']);

							$this->ActivationDeactivationCard->save($data['ActivationDeactivationCard']);
							
							$dataLog['CardLogCbc']['vc_reason']= $values['vc_reason'];
							
							$this->CardLogCbc->create();
							
							$this->CardLogCbc->set($dataLog['CardLogCbc']);
							
							$this->CardLogCbc->save($dataLog['CardLogCbc']);
						
						}
				
					}
				
				}
								
				if( $isDone ) :


				/***************Email Shoot to Customer******************/

					
					
					list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
					
					$this->Email->from =  $this->AdminName . '<' . $this->AdminEmailID . '>';

					$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
					
					$this->Email->bcc = array(trim($this->AdminCbcEmailID));

					$this->Email->subject = strtoupper($selectedType) . "  Card activation/deactivation ";

					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

					$this->Email->delivery = 'smtp';
					
					$mesage = " Cards have been deactivated successfully and  request for activation of cards is pending for approval from RFA !!";
					
					$mesage .= "<br> <br> Username : ".trim($username);
					
					$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);

					$this->Email->send($mesage);
					
					$this->Email->to = array();
					
					$this->Email->bcc =  array();
					

					/***************Email Shoot at alternative email id******************/
					
					if(isset($vc_alter_email) && !empty($vc_alter_email)) {
					
					list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

					$this->Email->from =   $this->AdminName . '<' . $this->AdminEmailID . '>';

					$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

					$this->Email->subject = strtoupper($selectedType) . "  Card activation/deactivation ";

					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

					$this->Email->delivery = 'smtp';

					$mesage = " Cards have been deactivated successfully and request for activation of cards is pending for approval from RFA !!";
					
					$mesage .= "<br> <br> Username : ".trim($username);
					
					$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
					
					$this->Email->send($mesage);

					}

					/******************Email Send To Admin***************************/



					/* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))) . '<' . trim($this->Session->read('Auth.Customer.vc_email')) . '>';

					$this->Email->to = trim($this->AdminEmailID);

					$this->Email->subject = strtoupper($selectedType) . "  Card activation/deactivation Request ";

					$this->Email->template = 'registration';

					$this->Email->sendAs = 'html';

					$this->set('name', $this->AdminName);

					$this->Email->delivery = 'smtp';

					$mesage = "A new request for card activation/deactivation from a CBC customer(" . ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))).")."; 

					$this->Email->send($mesage); */
					

					/********************** End Email***********************/
					
                    if($deactive== true && $active== false)
					$this->Session->setFlash('Cards have been deactivated successfully !!','success');

                    if($deactive== false && $active== true)
					$this->Session->setFlash('Request for activation of cards has been sent, pending for approval from RFA !!','success');

                    if($deactive== true && $active== true)
					$this->Session->setFlash('Cards have been deactivated successfully and  request for activation of cards is pending for approval from RFA !!','success');

					$this->redirect($this->referer());

				endif;	
				
				
				
           
			
			
        }
			
		
		$active_cards = $this->ActivationDeactivationCard->find('count', array(
		'conditions' => array('ActivationDeactivationCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
		'ActivationDeactivationCard.vc_card_flag' => 'STSTY01')));

		$inactive_cards = $this->ActivationDeactivationCard->find('count', array(
		'conditions' => array('ActivationDeactivationCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
		'ActivationDeactivationCard.vc_card_flag' => 'STSTY02')));

			
		$total_cards = ($active_cards + $inactive_cards);

		$this->set('total_cards', $total_cards);

		$this->set('active_cards', $active_cards);

		$this->set('inactive_cards', $inactive_cards);

		$this->paginate = array(
			'conditions' => array('ActivationDeactivationCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no')),
			'limit' => 10
		);

		$this->set('card', $this->paginate('ActivationDeactivationCard'));
								
		
    }

	/**
     *
     * Function to generate pdf for Activation/Deactivation Cards List
     *
     */

								
    function cbc_card_list_pdf() {

        $records = $this->ActivationDeactivationCard->find('all', array(
            'conditions' => array('ActivationDeactivationCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
        )));

        $active_cards = $this->ActivationDeactivationCard->find('count', array(
            'conditions' => array('ActivationDeactivationCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
                'ActivationDeactivationCard.vc_card_flag' => 'STSTY01')));

        $inactive_cards = $this->ActivationDeactivationCard->find('count', array(
            'conditions' => array('ActivationDeactivationCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
                'ActivationDeactivationCard.vc_card_flag' => 'STSTY02')));

      
		$total_cards = ($active_cards + $inactive_cards);
		
		$this->set('records', $records);

        $this->set('total_cards', $total_cards);

        $this->set('active_cards', $active_cards);

        $this->set('inactive_cards', $inactive_cards);
		
		
			$columnsValues = array('SI.No.','Card No.',
			'Issue Date','Current Status');
			
			$this->Cbccardvehiclepdfcreator->headerData('Activation Deactivation Card List', $period = NULL,$this->Session->read('Auth'));
			
			$this->Cbccardvehiclepdfcreator->generate_card_list_pdf($columnsValues,$active_cards, $inactive_cards, $total_cards, $records,
			$this->globalParameterarray,$this->Session->read('Auth'));
			
			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
			
			$this->Cbccardvehiclepdfcreator->output($vc_cust_no.'-Activation-Deactivation-Card-List'.'.pdf', 'D');
			
			die;

        $this->layout = 'pdf';
    }

    /**
     *
     * Function for prepaid card request
     *
     */
	 
    function cbc_card_request() {
   set_time_limit(0);
		$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
		
		$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');
		
		$vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');
		
		$username =$this->Session->read('Auth.Customer.vc_username');
		
		$vc_email_id = $this->Session->read('Auth.Customer.vc_email');
		
		$customer = $this->Customer->find('first', array(
            'conditions' => array(
                'Customer.vc_cust_no' => $vc_cust_no)));

        $this->set('customer', $customer);
		
		$conditions= array('conditions'=>array('RequestCard.vc_cust_no'=>$vc_cust_no,'RequestCard.vc_status'=>'STSTY03'),
		'fields'=>array('SUM(RequestCard.vc_no_of_cards) as pendingCards'));
		
		$countReuqest= $this->RequestCard->find('all',$conditions);
		$pendingCards = $countReuqest[0][0]['pendingCards'];
		
		if(isset($pendingCards) && (int)$pendingCards>0)
		$this->set('pendingCards', $pendingCards);
		else
		$this->set('pendingCards', 0);

		$nu_account_balance = $customer['Customer']['nu_account_balance'];
		
		$error=false;
        //echo 'crad==',$this->data['RequestCard']['vc_no_of_cards'];
		if (!empty($this->data) && $this->RequestHandler->isPost()) {
		if(isset($this->data['RequestCard']['vc_no_of_cards']) && ((int)$this->data['RequestCard']['vc_no_of_cards']==0 || $this->data['RequestCard']['vc_no_of_cards']=='') ){
				
				$this->Session->setFlash('No of cards should be greater than 0.', 'error');
				$error=true;
				
				$this->redirect('card_request');
		   
		   
		   }	
				
		if(isset($this->data['RequestCard']['vc_no_of_cards'])){
		
				$vc_no_of_cards = (int)$this->data['RequestCard']['vc_no_of_cards'];
				$CBCADMINFEE = $this->globalParameterarray['CBCADMINFEE'];
				$totalcardsRequested = (int)$pendingCards+(int)$vc_no_of_cards;
				$totalcardsRequestedCost = ($totalcardsRequested)*($CBCADMINFEE);
				if($totalcardsRequestedCost > $nu_account_balance ){
					if((int)$pendingCards>0){
						$this->Session->setFlash('Your Account balance is low for this request you have already '.$pendingCards.' cards pending .', 'error');
					}
					else{
						$this->Session->setFlash('Your Account balance is low for this request.', 'error');
					}
					$error=true;
					$this->redirect('card_request');
		   
				}		

		}

		
		   if($error==false){
            
			$this->RequestCard->create(false);

            $this->RequestCard->set($this->data['RequestCard']);

            if ($this->RequestCard->validates()) {


                $insertData['RequestCard'] = array(
                    'vc_cust_no' => $vc_cust_no,
                    'card_request_id' => $this->RequestCard->getPrimaryKey(),
                    'vc_user_no' => $vc_user_no,
                    'vc_comp_code' => $vc_comp_code,
                    'vc_status' => 'STSTY03',
                    'vc_no_of_cards' => $this->data['RequestCard']['vc_no_of_cards'],
                    'dt_created' => date('d-M-Y'),
                    'nu_total_charges' => $this->data['RequestCard']['nu_total_charges']
                );

                if ($this->RequestCard->save($insertData, false)) {



                     /*************** Email Shoot *******************/
					 
							
						list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

						$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

						$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
						
						$this->Email->bcc = array(trim($this->AdminCbcEmailID));

						$this->Email->subject = strtoupper($selectedType) . " Pre-Paid Card request ";

						$this->Email->template = 'registration';

						$this->Email->sendAs = 'html';

						$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

						$this->Email->delivery = 'smtp';

						$mesage = " We have recieved the Card issue Request , Please wait for approval.";
						
						$mesage .= "<br> <br> Username : ".trim($username);
			
						$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
						
						$this->Email->send($mesage);
						
						$this->Email->to = array();
					
						$this->Email->bcc =  array();
						
						
								/*************** Email Shoot at alternative email id*******************/
								
								if(isset($vc_alter_email) && !empty($vc_alter_email)) {
							
								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

								$this->Email->subject = strtoupper($selectedType) . "  Pre-Paid Card request ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " We have recieved the Card issue Request , Please wait for approval.";
								
								$mesage .= "<br> <br> Username : ".trim($username);
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
								
								$this->Email->send($mesage);
								
								}
								
								
								/******************Email Send To Admin************************** */

								/* $this->Email->from = ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))) . '<' . trim($this->Session->read('Auth.Customer.vc_email')) . '>';

								$this->Email->to = trim($this->globalParameterarray['ADMINDETEMAIL']);

								$this->Email->subject = strtoupper() . " Pre-Paid Card Request ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', $this->globalParameterarray['ADMINDETNAME']);

								$this->Email->delivery = 'smtp';

								$mesage =   "A new Pre-Paid Card  Request from a CBC customer (" . ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))).").";  

								$this->Email->send($mesage); */

							
						
                      
							/*********************************************/

                            $this->data = null;

                            $this->Session->write('Auth.Customer.vc_cust_no', $vc_cust_no);

                            $this->Session->setFlash('Your request for prepaid cards has been sent successfully, pending for approval from RFA !!', 'success');

							$this->redirect($this->referer());
				 }
			  } 
			}// for error	
		}

        
		$records = $this->RequestCard->find('all', array(
						'conditions' => array('RequestCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
						)));

						$active_records = $this->CustomerCard->find('all', array(
						'conditions' => array('CustomerCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
						'CustomerCard.vc_card_flag' => 'STSTY01')));

						$inactive_records = $this->CustomerCard->find('all', array(
						'conditions' => array('CustomerCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'),
						'CustomerCard.vc_card_flag' => 'STSTY02')));

						$active_cards = count($active_records);

						$inactive_cards = count($inactive_records);
						
						$total_cards = ($active_cards + $inactive_cards);

						$this->set('total_cards', $total_cards);

						$this->set('active_cards', $active_cards);

						$this->set('inactive_cards', $inactive_cards);

     
	}




    /**
     *
     * Function to view cards requested
     *
     */
	 
    public function cbc_submit_card() {
	
	   set_time_limit(0);
		$no_of_rows = 10;
		
		if (isset($this->params['named']['page'])) :

			$pageno = trim($this->params['named']['page']);

			else :

			$pageno = 1;
			
			endif;
		
		$start = ((($pageno - 1) * $no_of_rows) + 1);

			$this->set('start', $start);


       $this->paginate = array(
            'conditions' => array('RequestCard.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no')),
            'order' => array('RequestCard.dt_created' => 'desc'),
            'limit' =>$no_of_rows 
        );
		
       $this->set('list', $this->paginate('RequestCard'));
    }

    /**
     *
     * Function for Online Account Recharge
     *
     */
	 
    function cbc_account_recharge() {
			   set_time_limit(0);
			$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
			
			$vc_username = $this->Session->read('Auth.Customer.vc_username');
			
			$customer = $this->Customer->find('first', array(
            'conditions' => array('Customer.vc_cust_no' => $vc_cust_no)));

			$this->set('customer', $customer);
			
        
		if (isset($this->data)&& !empty($this->data)) {
			
			$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');
       
			$vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');
			
			$vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');
			 
            $this->AccountRecharge->create(false);

            $this->data['AccountRecharge']['nu_acct_rec_id'] = $this->AccountRecharge->getPrimaryKey();
			
            $this->data['DocumentUploadCbc']['nu_acct_rec_id'] = $this->data['AccountRecharge']['nu_acct_rec_id'];
			
            $this->data['DocumentUploadCbc']['nu_upload_id'] = $this->DocumentUploadCbc->getPrimaryKey();

            $setValidates = array('nu_amount_un', 'dt_payment_date', 'ch_tran_type', 'nu_hand_charge', 'vc_ref_no');
			
            $setValidatesDocUpd = array('vc_upload_doc_name');

            $this->AccountRecharge->set($this->data['AccountRecharge']);
			//pr($this->data);

            $this->DocumentUploadCbc->create(false);
			//$this->data['DocumentUploadCbc']['vc_upload_doc_name']=$this->data['AccountRecharge']['upload_doc'];
            $this->DocumentUploadCbc->set($this->data['DocumentUploadCbc']);

            //$this->unsetValidateVariable($setValidates, array_keys($this->AccountRecharge->validate), &$this->AccountRecharge);
            //$this->unsetValidateVariable($setValidatesDocUpd, array_keys($this->DocumentUploadCbc->validate), &$this->DocumentUploadCbc);
			//pr($this->AccountRecharge->validates(array('fieldList' =>$setValidates)));
			//pr($this->DocumentUploadCbc->validates(array('fieldList' =>$setValidatesDocUpd)));
			if ($this->AccountRecharge->validates(array('fieldList' =>$setValidates)) && $this->DocumentUploadCbc->validates(array('fieldList' => $setValidatesDocUpd))) {
			
                $insertData = array();
				$this->AccountRecharge->validate = NUll;
				$this->DocumentUploadCbc->validate = NUll;

                $file = $this->data['DocumentUploadCbc']['vc_upload_doc_name'];

                $insert['AccountRecharge'] = array(
                    'vc_user_no' => $vc_user_no,
                    'vc_comp_code' => $vc_comp_code,
                    'vc_cust_no' => $vc_cust_no,
                    'nu_hand_charge' => $this->globalParameterarray['CBCADMINFEE'],
                    'vc_ref_no' => $this->data['AccountRecharge']['vc_ref_no'],
                    'ch_tran_type' => $this->data['AccountRecharge']['ch_tran_type'],
                    'dt_payment_date' => date('d-M-Y',strtotime($this->data['AccountRecharge']['dt_payment_date'])),
                    'vc_recharge_status' => 'STSTY03',
					'dt_entry_date' => date('d-M-Y')
                );

                $filename = $file['name'];
				if($filename!='')
				$filename = $this->renameUploadFile($filename);

				
                $dir = WWW_ROOT. "uploadfile" . DS .$vc_username. DS. "Recharge";
				
				if (!file_exists($dir)) {

					mkdir($dir, 0777, true);
				}



                $insertData['DocumentUploadCbc'] = array(
						'vc_user_no' => $vc_user_no,
                        'vc_comp_code' => $vc_comp_code,
                        'vc_cust_no' => $vc_cust_no,
                        'vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD03'],
                        'vc_upload_doc_name' => trim($filename),
						'dt_date_uploaded' => date('d-M-Y'),
                        'vc_upload_doc_path' => $dir
					);
					
					if($this->AccountRecharge->save($insert) && $this->DocumentUploadCbc->save($insertData)){
					
					move_uploaded_file($file["tmp_name"], $dir . DS . $filename);
					
					

				/************** Email to Customer ********************/			
													
													
							list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
							
							$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

							$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
							
							$this->Email->bcc = array(trim($this->AdminCbcEmailID));
							
							$this->Email->subject = strtoupper($selectedType) . "  Online Account Recharge ";
							
							$this->Email->template = 'registration';
			
							$this->Email->sendAs = 'html';

							$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

							$this->Email->delivery = 'smtp';

							$mesage = " Your request for account recharge has been sent successfully, pending for approval from RFA !!";
							
							$mesage .= "<br> <br> Username : ".trim($vc_username);
				
							$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
							
							$this->Email->send($mesage);
							
							$this->Email->to = array();
				
							$this->Email->bcc =  array();
							
							
							/************** Send Email at alternative email id ********************/
							
												
							if(isset($vc_alter_email) && !empty($vc_alter_email)) {			
							
							list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));
							
							$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

							$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));
							
							$this->Email->subject = strtoupper($selectedType) . "  Online Account Recharge ";
							
							$this->Email->template = 'registration';
			
							$this->Email->sendAs = 'html';

							$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

							$this->Email->delivery = 'smtp';

							$mesage = " Your request for account recharge has been sent successfully, pending for approval from RFA !!";
							
							$mesage .= "<br> <br> Username : ".trim($vc_username);
				
							$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
							
							$this->Email->send($mesage);
							
							}
								
								
								

							$this->Session->setFlash('Your request for account recharge has been sent successfully, pending for approval from RFA !!','success');
							
							$this->data = null;
							//die('hua');
							
							$this->redirect('account_recharge');	

					}			
					
						
				}else{
				//echo 'hua';
				}
                
            
        }
		
		$this->loadModel('ParameterType');
		
		$this->set('CustType', array('' => 'Select') + $this->ParameterType->find('list', array('conditions' => array('ParameterType.vc_prtype_code like' => 'CARDPAY%'), 'fields' => array('vc_prtype_code', 'vc_prtype_name'))));
    
	}

    /**
     *
     *
	 *	 Function for Refund Request
     *
	 *
     **/
	 
    public function cbc_refund_request() {
		set_time_limit(0);
    	$vc_cust_no = $this->Session->read('Auth.Customer.vc_cust_no');
		
		$vc_username = $this->Session->read('Auth.Customer.vc_username');
			
		$vc_email_id = $this->Session->read('Auth.Customer.vc_email');
		
		$vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');

        $vc_user_no = $this->Session->read('Auth.Customer.vc_user_no');

        $vc_alter_email = $this->Session->read('Auth.Customer.vc_alter_email');

        $vc_comp_code = $this->Session->read('Auth.Customer.vc_comp_code');
		
        $res = $this->Customer->find('first', array(
            'conditions' => array('Customer.vc_cust_no' => $this->Session->read('Auth.Customer.vc_cust_no'))));

        $this->set('res', $res);
		
		
		$accountbalance=$res['Customer']['nu_account_balance'];
		
		$this->set('accountbalance',$accountbalance);

		if (isset($this->data) && !empty($this->data)) {

        
            if (isset($this->data['MdcRefund'])) :
				$mdc_vc_permit_no = $this->data['MdcRefund']['vc_permit_no'];
		
                $this->loadModel('MdcRefund');
                $model = 'MdcRefund';

            elseif (isset($this->data['CbcRefund'])) :

                $this->loadModel('CbcRefund');
                $model = 'CbcRefund';
				
			 elseif(isset($this->data['CardRefund'])) :
				
				$this->loadModel('CardRefund');
				$model = 'CardRefund'; 

            endif;

            $this->{$model}->create(false);

            $this->{$model}->set($this->data[$model]);
			
			$this->DocumentUploadCbc->create(false);
			
            $setValidatesDocUpd = array('vc_upload_doc_name');


            $this->DocumentUploadCbc->set($this->data);
			//pr($this->data);
			
		if ($this->{$model}->validates()) {
				
				$this->data[$model][$this->{$model}->primaryKey] =  $this->{$model}->getPrimaryKey();
				
				$this->data['DocumentUploadCbc']['nu_mdc_refund_id'] = $this->data[$model]['nu_refund_id'];
			
				$this->data['DocumentUploadCbc']['nu_upload_id'] = $this->DocumentUploadCbc->getPrimaryKey();
				
				$this->data[$model]['vc_comp_code'] =  $this->Session->read('Auth.Customer.vc_comp_code');

				$this->data[$model]['vc_cust_no'] =  $vc_cust_no;

				$this->data[$model]['vc_user_no'] =  $vc_user_no;
				

				$this->data[$model]['dt_entry_date'] =  date('d-M-y');
				
				//$this->data[$model]['dt_refund_date'] =  date('d-M-y');

				$this->data[$model]['vc_status'] =  'STSTY03';
				
				//$this->data[$model]['nu_permit_amt'] = $this->data[$model]['nu_permit_amt'];
	
			if(isset($this->data[$model]['ch_type'])  && ($this->data[$model]['ch_type']=='cbc' || $this->data[$model]['ch_type']=='mdc') )
				{ 
					$this->data[$model]['nu_amount'] = '' ;
					
					if($this->data[$model]['ch_type']=='cbc')
				      $this->data[$model]['ch_tran_type'] = $this->globalParameterarray['CBCREFNDTYPE01'];
					else
					  $this->data[$model]['ch_tran_type'] = $this->globalParameterarray['CBCREFNDTYPE02'];

					} else {
					$this->data[$model]['nu_amount']    = ($accountbalance - $this->globalParameterarray['CBCADMINFEE']) ;
					$this->data[$model]['ch_tran_type'] = $this->globalParameterarray['CBCREFNDTYPE03'];
					$this->data[$model]['nu_admin_fee'] = $this->globalParameterarray['CBCADMINFEE'];


				}
				
				if(isset($this->data[$model]['ch_type']))
				$ch_type                       	 =  trim($this->data[$model]['ch_type']);
				else
				$ch_type                       	 =  '';
			
				if(isset($this->data[$model]['vc_permit_no']) && $this->data[$model]['vc_permit_no']!='')
				$vc_permit_no                       	 =  trim($this->data[$model]['vc_permit_no']);
				else
				$vc_permit_no                       	 =  '';
				
				if($ch_type=='refund'){
				
				$refundexistence=$this->$model->find('count',array('conditions'=>array($model.'.vc_cust_no'=>$vc_cust_no,
				$model.'.ch_type'=>$ch_type,
				$model.'.vc_status!'=>'STSTY05'
				)));
				
				if($refundexistence>0){
				
					$this->Session->setFlash('You have already sent a request for the Refund ,please wait for approval from RFA !!', 'error');
					$this->redirect($this->referer());
					}
				}else{
					$refundexistence=$this->$model->find('count',array('conditions'=>array($model.'.vc_cust_no'=>$vc_cust_no,
					$model.'.ch_type'=>$ch_type,
					$model.'.vc_permit_no'=>$vc_permit_no,
					$model.'.vc_status!'=>'STSTY05'
					)));
					if($refundexistence>0){
						$this->Session->setFlash('You have already sent a request for '.ucfirst($ch_type).' Refund ,please wait for approval from RFA !!', 'error');
						$this->redirect($this->referer());
					}				
				}
				if(isset($vehtype) && $vehtype!='')
					$this->set('vehtype',$vehtype); 
				else
				$this->set('vehtype',''); 
                
				$saveFlag=false;
				
				if($model=='MdcRefund'){
					
				if($this->DocumentUploadCbc->validates(array('fieldList' => $setValidatesDocUpd))){
				
					if($this->{$model}->save($this->data)){
					$saveFlag =true;
					$insertData = array();
				
					$file = $this->data['DocumentUploadCbc']['vc_upload_doc_name'];

					
					$filename = $file['name'];
					if($filename!='')
					$filename = $this->renameUploadFile($filename);

				
					$dir = WWW_ROOT. "uploadfile" . DS .$vc_username. DS. "MDC Refund".DS.$mdc_vc_permit_no;
				
					if (!file_exists($dir)) {

							mkdir($dir, 0777, true);
						}
						
						$insertData['DocumentUploadCbc'] = array(
											'nu_mdc_refund_id' =>$this->data['DocumentUploadCbc']['nu_mdc_refund_id'],			 						
											'nu_upload_id' => $this->DocumentUploadCbc->getPrimaryKey(),
											'vc_user_no' => $vc_user_no,
											'vc_comp_code' => $vc_comp_code,
											'vc_cust_no' => $vc_cust_no,
											'vc_upload_doc_for' => $this->globalParameterarray['DOCUPLOAD05'],
											'vc_upload_doc_name' => trim($filename),
											'dt_date_uploaded' => date('d-M-Y'),
											'vc_upload_doc_path' => $dir
										);
				
						$this->DocumentUploadCbc->save($insertData);
					    move_uploaded_file($file["tmp_name"], $dir . DS . $filename);
					
					}
				
				 }
				
				}else{
				
					if($this->{$model}->save($this->data)){					
						$saveFlag = true;
					}
				}
				
				if ($saveFlag==true) {
				
					
				 /******************** Email Shoot **********************/
								
							list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

								$this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Customer.vc_email'));
								
								$this->Email->bcc = array(trim($this->AdminCbcEmailID));

								$this->Email->subject = strtoupper($selectedType) . " Refund Request  ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

								$this->Email->delivery = 'smtp';

								$mesage = "Your request for the Refund  has been sent successfully, pending for approval from RFA !!";
								
								$mesage .= "<br> <br> Username : ".trim($vc_username);
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
								
								$this->Email->send($mesage);
								
								$this->Email->to = array();
					
								$this->Email->bcc =  array();
					
								
								/******************** Email Shoot at alternative email id**********************/
								
								if(isset($vc_alter_email) && !empty($vc_alter_email)) { 
							
								list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($this->Session->read('Auth.Member.vc_comp_code'));

								$this->Email->from =$this->AdminName . '<' . $this->AdminEmailID . '>';

								$this->Email->to = trim($this->Session->read('Auth.Customer.vc_alter_email'));

								$this->Email->subject = strtoupper($selectedType) . "  Refund Request  ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($this->Session->read('Auth.Customer.vc_first_name'))) . ' ' . ucfirst(trim($this->Session->read('Auth.Customer.vc_surname'))));

								$this->Email->delivery = 'smtp';

								$mesage = " Your request for the refund has been sent successfully, pending for approval from RFA !!";
								
								$mesage .= "<br> <br> Username : ".trim($vc_username);
					
								$mesage .= "<br> <br>RFA Account No. : ".trim($vc_cust_no);
								
								$this->Email->send($mesage);

								}
								/***** Email Send To Admin ***************************/

								
							/*********************************************/

                            $this->data = null;
        

                            $this->Session->write('Auth.Customer.vc_cust_no', $vc_cust_no);
							
                            if( $ch_type=='refund')
                            
							$this->Session->setFlash('Your request for the Refund has been sent successfully ,pending for approval from RFA !!', 'success');
							else
                            
							$this->Session->setFlash('Your request for the '.ucfirst($ch_type).' Refund  has been sent successfully ,pending for approval from RFA !!', 'success');
							
							$this->redirect($this->referer());
		}else{
							$this->set('data',$this->data);	
							//$this->Session->setFlash('Data not saved','error');
            }
        }
    }

	}
	
}



?>
