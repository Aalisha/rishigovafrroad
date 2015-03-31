<?php 

App::import('Sanitize');

/**
 *
 * ERP Data Import Controller
 * @Description : Use import data from ERP to Portal RFA (Road Fund Administration)
 *
 */
 
Class ErpimportsController extends AppController {
 
	/**
	 *
	 */
	var $name = 'Erpimports';

	/**
	 *
	 */        
	var $components = array('Auth', 'Session', 'RequestHandler', 'Email');
	
	/**
	 *
	 */
	var $uses = array();
	
	/**
	 *
	 */
	var $__limit = 100;
	
	
	/**
	 *
	 */
	 
	 var $__pattern = array(
		'hostname' => '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)'
	);
	
	/**
     *
     */
    var $__userCode = null;
		
	/**
	 *
	 */
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->layout = false;
		
		$this->Auth->allow('*');	
		
		
	}
	
	/**
	 *
	 */ 
	public function index() {
		
		if( $this->Session->check('admin') ){
			
			$this->redirect('dashboard');
			
		}
		
		if( !empty($this->data) &&  $this->RequestHandler->isPost() ) {
			
			$this->loadModel('AccessLogin');

			$this->AccessLogin->create(false);
			
			$this->AccessLogin->set($this->data);
			
			if( $this->AccessLogin->validates() ) {
					
				$result = $this->AccessLogin->find('first',array(
								'conditions'=>array(
											'trim(AccessLogin.vc_username)'=>trim($this->data['AccessLogin']['username']),
											'trim(AccessLogin.vc_password)'=>trim($this->data['AccessLogin']['password']),
											'lower(trim(AccessLogin.ch_status))'=>strtolower(trim('y')))));	
				if($result){
											
						$this->__loginAccess = true;
						
						$this->AccessLogin->id = trim($result['AccessLogin']['nu_id']) ;
						
						$saveData['AccessLogin']['dt_login_date'] =  date('Y-m-d H:i:s');
						
						$saveData['AccessLogin']['nu_id'] =  trim($result['AccessLogin']['nu_id']) ;
						
						$this->AccessLogin->set($saveData);
						
						$this->AccessLogin->save($saveData);
						
						$this->Session->write('admin',true);	
							
						$this->Session->setFlash('Successful Login!!', 'success');
						
						$this->redirect('dashboard');
			
					
				} else {
				
					$this->Session->delete('admin');
					
					unset($this->data);
					
					$this->data  = null;
					
					$this->Session->setFlash('Sorry, Your username/password is invalid please try again!!!', 'error');
					
				}
				
			}
			
		}
		
		$this->layout = 'registration';
		
		$this->set('title_for_layout', 'Admin Login');
		
		
    }
	
	
	/*
	 *
	 */
  
	public function getMdcDataImport() {
		
		try {
			
			$this->checkLogin();
			
			ini_set('max_execution_time', 0);
			
			ini_set('memory_limit','2048M');
			
			$this->layout = false;
		
			$this->loadModel('MstCustomerDetailsErp');
				
			$this->loadModel('Member');
							
			$conditionArray = array();
			
			$existCustomer = $this->Member->find('list',array(
													'conditions'=>array(
																'Member.vc_mdc_customer_no != '=> NULL,
																'Member.vc_comp_code'=>trim($this->mdc)
																),
													'fields'=>array('SUBSTR(TRIM(Member.vc_mdc_customer_no),5)', 'SUBSTR(TRIM(Member.vc_mdc_customer_no),5)')
													));
			if( count($existCustomer) > 0 ) {
			
					$conditionArray  += array("MstCustomerDetailsErp.vc_customer_no NOT" =>$existCustomer); 
				
			}else {
				
				$conditionArray 	+= array(' 1 = 1');
			
			}
			
			$result = $this->MstCustomerDetailsErp->find('all',array(
								'conditions'=>array(
												'MstCustomerDetailsErp.ch_active'=>'Y',
												$conditionArray
												),
								'limit'=>$this->__limit,
								'fields'=>array(
										'replace(replace(MstCustomerDetailsErp.vc_email,chr(60),chr(91)),chr(62),chr(93)) vc_email',
										"MstCustomerDetailsErp.vc_customer_name",
										"MstCustomerDetailsErp.vc_customer_no",
										"MstCustomerDetailsErp.vc_mobile_no",
										"MstCustomerDetailsErp.vc_cust_type"									
										)));			
			
			$email_Pattern ='/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $this->__pattern['hostname'] . '$/i';
			
			foreach ( $result as $key => &$value ) {
					
					unset($saveData);
					
					$value['MstCustomerDetailsErp']['vc_email'] = current(current($value));					
									
					if( preg_match('/[;]+/', trim(isset($value['MstCustomerDetailsErp']['vc_email'])?$value['MstCustomerDetailsErp']['vc_email']:'')) ) {
					
						$test_Email = current(explode(';',$value['MstCustomerDetailsErp']['vc_email'])); 
						
					} elseif( preg_match('/(\[|\])+/', trim(isset($value['MstCustomerDetailsErp']['vc_email'])?$value['MstCustomerDetailsErp']['vc_email']:'')) ) {
						
						unset($start);

						unset($endNiddel);

						unset($end);
						
						$start = strpos(trim($value['MstCustomerDetailsErp']['vc_email']),'[')+1;
						
						$endNiddel = strpos(trim($value['MstCustomerDetailsErp']['vc_email']),']');
						
						$end =  $endNiddel - $start;
						
						$test_Email = substr(trim($value['MstCustomerDetailsErp']['vc_email']), $start, $end);
						
						unset($start);

						unset($endNiddel);

						unset($end);
						
					} else {
						
						$test_Email = trim($value['MstCustomerDetailsErp']['vc_email']); 
					
					}
					
					if( preg_match($email_Pattern, trim($test_Email) ) ) {
						
						if( $this->Member->find('count',array(
															'conditions'=>array(
															'Member.vc_comp_code'=>trim($this->mdc),
															'Member.vc_email_id'=>trim($test_Email)))) == 0  ) {
							
							$vc_username = $this->userCodeID(trim($this->mdc));
							
							$vc_password = strtoupper(substr(trim($value['MstCustomerDetailsErp']['vc_customer_name']), 0, 1)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 8);

							$vc_user_no = strtolower(str_replace('-', '', substr($vc_username, 3)));

							$saveData['Member']['vc_user_no']= $vc_user_no;
							
							$saveData['Member']['vc_comp_code']= trim($this->mdc);

							$saveData['Member']['vc_username']= $vc_username;

							$saveData['Member']['vc_mdc_customer_no']= 'MDC-'.$value['MstCustomerDetailsErp']['vc_customer_no'];

							$saveData['Member']['vc_user_firstname']= implode(' ',explode(' ',$value['MstCustomerDetailsErp']['vc_customer_name'], -1));

							$saveData['Member']['vc_user_lastname']= array_pop(explode(' ',$value['MstCustomerDetailsErp']['vc_customer_name']));

							$saveData['Member']['vc_email_id']= $value['MstCustomerDetailsErp']['vc_email'];

							$saveData['Member']['vc_password']= $this->Auth->password($vc_password);

							$saveData['Member']['dt_user_created']= date('Y-m-d H:i:s');

							$saveData['Member']['vc_user_login_type']= 'USRLOGIN_CUST';

							$saveData['Member']['vc_user_status']= 'USRSTATUSACT';
							
							$this->Member->create(true);	
							
							$this->Member->set($saveData);
														
							if( $this->Member->save($saveData, false) ) {
									
								$this->Email->from = $this->AdminName . '<' . $this->AdminMdcEmailID . '>';
								
								$this->Email->to = trim($value['MstCustomerDetailsErp']['vc_email']);

								$this->Email->subject = "MDC Member Username and Password ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucwords(trim($value['MstCustomerDetailsErp']['vc_customer_name'])));

								$this->Email->delivery = 'smtp';

								$mesage = " Your account has been activated, please use the credentials mentioned below : <br />
								Username : " . $vc_username . " <br />
								Password : " . $vc_password . " <br />	
								";
															
								$this->Email->send($mesage);								
												
								$value['message']= 'Successful';
							
								$value['status_imp'] = 'complete';
							
							} else {
							
								$value['message']= 'Error insert into database';
							
								$value['status_imp'] = 'failure';
							}

						} else {

							$value['message']= 'Already used email id';
							
							$value['status_imp'] = 'failure';							
							
						}	
							
					
					} else {
						
						$value['message']= 'Invalid Email Id Or Empty';
						
						$value['status_imp'] = 'failure';
					}
					
					unset($value);
				
			}
			
			if( count($result) == 0 ){
			
				$this->Session->setFlash('No data found to import!!!', 'info');	
			
			} else {
			
				$this->getImportXmlMDC($result);
				
				$this->Session->setFlash('Data imported successfully!!!', 'success');
			
			}
			
			$this->redirect('dashboard');
			
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
	
	}
		
	/*
	 *
	 */
  
	public function getCbcDataImport() {
		
		try {
			
			$this->checkLogin();
			
			ini_set('max_execution_time', 0);
			
			ini_set('memory_limit','2048M');
			
			$this->layout = false;
		
			$this->loadModel('CbcCustomerDetailsErp');
				
			$this->loadModel('Member');
			
			$conditionArray = array();
			
			$existCustomer = $this->Member->find('list',array(
													'conditions'=>array(
															'Member.vc_cbc_customer_no != '=> NULL,
															'Member.vc_comp_code'=>trim($this->cbc)	
													),
													'fields'=>array('Member.vc_cbc_customer_no','Member.vc_cbc_customer_no')
													));
			if( count($existCustomer) > 0 ) {
			
					$conditionArray  += array("CbcCustomerDetailsErp.vc_cust_no NOT" =>$existCustomer); 
				
			}else {
				
				$conditionArray 	+= array(' 1 = 1');
			
			}
				
			
			$result = $this->CbcCustomerDetailsErp->find('all',array(
											'conditions'=>array(
												'CbcCustomerDetailsErp.vc_comp_code'=>'04',
												'CbcCustomerDetailsErp.vc_cust_type'=>'CARD',
												'CbcCustomerDetailsErp.vc_cust_flag'=>'Y',
												$conditionArray 
												),
											'limit'=>$this->__limit,
											'fields'=>array(
												'replace(replace(CbcCustomerDetailsErp.vc_email,chr(60),chr(91)),chr(62),chr(93)) vc_email',
												"CbcCustomerDetailsErp.vc_first_name",
												"CbcCustomerDetailsErp.vc_cust_no",
												"CbcCustomerDetailsErp.vc_surname",
												"CbcCustomerDetailsErp.vc_mobile_no",
												"CbcCustomerDetailsErp.vc_cust_type"
												)));
			
			$email_Pattern ='/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $this->__pattern['hostname'] . '$/i';
			
			foreach ( $result as $key => &$value ) {					
					
					unset($saveData);
					
					$value['CbcCustomerDetailsErp']['vc_email'] = current(current($value));					
									
					if( preg_match('/[;]+/', trim(isset($value['CbcCustomerDetailsErp']['vc_email'])?$value['CbcCustomerDetailsErp']['vc_email']:'')) ) {
					
						$test_Email = current(explode(';',$value['CbcCustomerDetailsErp']['vc_email'])); 
						
					} elseif( preg_match('/(\[|\])+/', trim(isset($value['CbcCustomerDetailsErp']['vc_email'])?$value['CbcCustomerDetailsErp']['vc_email']:'')) ) {
						
						unset($start);

						unset($endNiddel);

						unset($end);
						
						$start = strpos(trim($value['CbcCustomerDetailsErp']['vc_email']),'[')+1;
						
						$endNiddel = strpos(trim($value['CbcCustomerDetailsErp']['vc_email']),']');
						
						$end =  $endNiddel - $start;
						
						$test_Email = substr(trim($value['CbcCustomerDetailsErp']['vc_email']), $start, $end);
						
						unset($start);

						unset($endNiddel);

						unset($end);
						
					} else {
						
						$test_Email = trim($value['CbcCustomerDetailsErp']['vc_email']); 
					
					}
						
						
					
					if( preg_match($email_Pattern, trim($test_Email)) ) {
						
						if( $this->Member->find('count',array(
															'conditions'=>array(
															'Member.vc_comp_code'=>trim($this->cbc),
															'Member.vc_email_id'=>trim($test_Email)))) == 0  ) {
							
							$vc_username = $this->userCodeID(trim($this->cbc));
							
							$vc_password = strtoupper(substr(trim($value['CbcCustomerDetailsErp']['vc_first_name']), 0, 1)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 8);

							$vc_user_no = strtolower(str_replace('-', '', substr($vc_username, 3)));

							$saveData['Member']['vc_user_no']= $vc_user_no;
							
							$saveData['Member']['vc_comp_code']= trim($this->cbc);

							$saveData['Member']['vc_username']= $vc_username;

							$saveData['Member']['vc_cbc_customer_no']= trim($value['CbcCustomerDetailsErp']['vc_cust_no']);

							$saveData['Member']['vc_user_firstname']= $value['CbcCustomerDetailsErp']['vc_first_name'];

							$saveData['Member']['vc_user_lastname']= $value['CbcCustomerDetailsErp']['vc_surname'];

							$saveData['Member']['vc_email_id']= $value['CbcCustomerDetailsErp']['vc_email'];

							$saveData['Member']['vc_password']= $this->Auth->password($vc_password);

							$saveData['Member']['dt_user_created']= date('Y-m-d H:i:s');

							$saveData['Member']['vc_user_login_type']= 'USRLOGIN_CUST';

							$saveData['Member']['vc_user_status']= 'USRSTATUSACT';
							
							$this->Member->create(true);	
							
							$this->Member->set($saveData);
														
							if( $this->Member->save($saveData, false) ) {
									
								$this->Email->from = $this->AdminName . '<' . $this->AdminCbcEmailID . '>';

								$this->Email->to = trim($value['CbcCustomerDetailsErp']['vc_email']);
								
								$this->Email->subject = "CBC Member Username and Password ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucfirst(trim($value['CbcCustomerDetailsErp']['vc_first_name'])) .' ' . ucfirst(trim($value['CbcCustomerDetailsErp']['vc_surname'])) );

								$this->Email->delivery = 'smtp';

								$mesage = " Your account has been activated, please use the credentials mentioned below : <br />
								Username : " . $vc_username . " <br />
								Password : " . $vc_password . " <br />	
								";

								$this->Email->send($mesage);								
																
								$value['message']= 'Successful';
							
								$value['status_imp'] = 'complete';
							
							} else {
							
								$value['message']= 'Error insert into database';
							
								$value['status_imp'] = 'failure';
							}

						} else {

							$value['message']= 'Already used email id';
							
							$value['status_imp'] = 'failure';							
							
						}	
							
					
					} else {
						
						$value['message']= 'Invalid Email Id Or Empty';
						
						$value['status_imp'] = 'failure';
					}
					
					unset($value);	
			
			}
			
			if( count($result) == 0 ){
			
				$this->Session->setFlash('No data found to import!!!', 'info');	
			
			} else {
			
				$this->getImportXmlCBC($result);
				
				$this->Session->setFlash('Data imported successfully!!!', 'success');
			
			}
			
			$this->redirect('dashboard');
			
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
		
    }
	
	
	/*
	 *
	 *
	 */
  
	public function getFlrDataImport() {
		
		try {
			
			$this->checkLogin();			
			
			ini_set('max_execution_time', 0);
			
			ini_set('memory_limit','2048M');
			
			$this->layout = false;
		
			$this->loadModel('FlrClientDetailsErp');
				
			$this->loadModel('Member');
			
			$conditionArray = array();
			
			$existCustomer = $this->Member->find('list',array(
													'conditions'=>array(
																'Member.vc_flr_customer_no != '=> NULL,
																'Member.vc_comp_code'=>trim($this->flr)
																),
													'fields'=>array('Member.vc_flr_customer_no', 'Member.vc_flr_customer_no')
													));
			if( count($existCustomer) > 0 ) {
			
					$conditionArray  += array("FlrClientDetailsErp.vc_client_no NOT" =>$existCustomer); 
				
			}else {
				
				$conditionArray 	+= array(' 1 = 1');
			
			}
			
			$result = $this->FlrClientDetailsErp->find('all',array(
								'conditions'=>array(
												'FlrClientDetailsErp.ch_active_flag'=>'Y',
												$conditionArray
												),
								'limit'=>$this->__limit,
								'fields'=>array(
									'replace(replace(FlrClientDetailsErp.vc_email,chr(60),chr(91)),chr(62),chr(93)) vc_email',
									"FlrClientDetailsErp.vc_client_name",
									"FlrClientDetailsErp.vc_client_no",
									"FlrClientDetailsErp.vc_cell_no"		
									)));
						
			$email_Pattern ='/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $this->__pattern['hostname'] . '$/i';
			
			foreach ( $result as $key => &$value ) {
					
				unset($saveData);

				$value['FlrClientDetailsErp']['vc_email'] = current(current($value));					
								
				if( preg_match('/[;]+/', trim(isset($value['FlrClientDetailsErp']['vc_email'])?$value['FlrClientDetailsErp']['vc_email']:'')) ) {

					$test_Email = current(explode(';',$value['FlrClientDetailsErp']['vc_email'])); 
					
				} elseif( preg_match('/(\[|\])+/', trim(isset($value['FlrClientDetailsErp']['vc_email'])?$value['FlrClientDetailsErp']['vc_email']:'')) ) {
					
					unset($start);

					unset($endNiddel);

					unset($end);
					
					$start = strpos(trim($value['FlrClientDetailsErp']['vc_email']),'[')+1;
					
					$endNiddel = strpos(trim($value['FlrClientDetailsErp']['vc_email']),']');
					
					$end =  $endNiddel - $start;
					
					$test_Email = substr(trim($value['FlrClientDetailsErp']['vc_email']), $start, $end);
					
					unset($start);

					unset($endNiddel);

					unset($end);
					
				} else {
					
					$test_Email = trim($value['FlrClientDetailsErp']['vc_email']); 

				}
					
					

					
				if( preg_match($email_Pattern, trim($test_Email) ) ) {
						
							$vc_username = $this->userCodeID(trim($this->flr));
							
							$vc_password = strtoupper(substr(trim($value['FlrClientDetailsErp']['vc_client_name']), 0, 1)) . '-' . substr(number_format(time() * rand(), 0, '', ''), 0, 8);

							$vc_user_no = strtolower(str_replace('-', '', substr($vc_username, 3)));

							$saveData['Member']['vc_user_no']= $vc_user_no;
							
							$saveData['Member']['vc_comp_code']= trim($this->flr);

							$saveData['Member']['vc_username']= $vc_username;

							$saveData['Member']['vc_flr_customer_no']= trim($value['FlrClientDetailsErp']['vc_client_no']);
							
							$saveData['Member']['vc_user_firstname']= implode(' ',explode(' ',$value['FlrClientDetailsErp']['vc_client_name'], -1));

							$saveData['Member']['vc_user_lastname']= array_pop(explode(' ',$value['FlrClientDetailsErp']['vc_client_name']));
						
							$saveData['Member']['vc_email_id']= $value['FlrClientDetailsErp']['vc_email'];

							$saveData['Member']['vc_password']= $this->Auth->password($vc_password);

							$saveData['Member']['dt_user_created']= date('Y-m-d H:i:s');

							$saveData['Member']['vc_user_login_type']= 'USRLOGIN_CUST';

							$saveData['Member']['vc_user_status']= 'USRSTATUSACT';
							
							$this->Member->create(true);	
							
							$this->Member->set($saveData);
														
							if( $this->Member->save($saveData, false) ) {
									
								$this->Email->from = $this->AdminName . '<' . $this->AdminFlrEmailID . '>';

								$this->Email->to = trim($value['FlrClientDetailsErp']['vc_email']);

								$this->Email->subject = "FLR Member Username and Password ";

								$this->Email->template = 'registration';

								$this->Email->sendAs = 'html';

								$this->set('name', ucwords(trim($value['FlrClientDetailsErp']['vc_client_name'])));

								$this->Email->delivery = 'smtp';

								$mesage = " Your account has been activated, please use the credentials mentioned below : <br />
								Username : " . $vc_username . " <br />
								Password : " . $vc_password . " <br />	
								";

								$this->Email->send($mesage);								
								
								$value['message']= 'Successful';
							
								$value['status_imp'] = 'complete';
							
							} else {
							
								$value['message']= 'Error insert into database';
							
								$value['status_imp'] = 'failure';
							}													
					
					} else {
						
						$value['message']= 'Invalid Email Id Or Empty';
						
						$value['status_imp'] = 'failure';
					}
					
					unset($value);	
			
			}
			
			if( count($result) == 0 ){
			
				$this->Session->setFlash('No data found to import!!!', 'info');	
			
			} else {
			
				$this->getImportXmlFLR($result);
				
				$this->Session->setFlash('Data imported successfully!!!', 'success');
			
			}
			
			
			$this->redirect('dashboard');
			
			
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
						
		

    }
	
	
	
	/**
     *
     *
     */
    public function userCodeID($comp_code) {

        try {
			
			$this->checkLogin();
			
            list( $VC_USER_CODE, $type, $selectList ) = $this->getRFATypeDetail($comp_code);
			
            $countResult = $this->Member->find('count', array('conditions' => array('Member.vc_user_no like' => "$type%")));
			
            $userCode = 'RFA-' . strtoupper($type);

            $userCode .= '-' . ($countResult + 1);

            $this->__userCode = $userCode;

            $returnValue = $this->Member->find('count', array('conditions' => array('Member.vc_username' => $userCode)));
			
            if ($returnValue == 0) {

                return $this->__userCode;
				
            } else {

                $i = (int) ($countResult + 1);

                while ($i >= 1) {

                   	$userCode = 'RFA-' . strtoupper($type);

					$userCode .= '-' . ($i + 1);

                    $returnValue = $this->Member->find('count', array('conditions' => array('Member.vc_username' => $userCode)));
					
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
	 *
	 */
 
	public function generatetemporarypassword() {
		
		$this->checkLogin();
		
		$encry_password = '';
		
		if( !empty($this->data) &&  $this->RequestHandler->isPost() ) {
			
			$this->loadModel('Generatepassword');
			
			$this->Generatepassword->create(false);
			
			$this->Generatepassword->set($this->data);
			
			if( $this->Generatepassword->validates()) {
				$encry_password = $this->Auth->password(trim($this->data['Generatepassword']['password']));
				unset($this->data);
				$this->data = null;
			}
		}		
		
		$this->layout = 'admin';
		
		$this->set('title_for_layout', 'Generate Password');
		 
		$this->set('encry_password',$encry_password);
	
	}
	
	
	
	/*
	 * Save XML in server
	 */
	 
	function getImportXmlMDC($data) {
		
		$this->checkLogin();
		
		/** Include PHPExcel */
		require_once VENDORS.'PHPExcel'.DS.'PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("w")
								 ->setLastModifiedBy("")
								 ->setTitle("")
								 ->setSubject("")
								 ->setDescription("")
								 ->setKeywords("")
								 ->setCategory("");
								 
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'S. No')
				->setCellValue('B1', 'Customer No.')
				->setCellValue('C1', 'Customer Name')
				->setCellValue('D1', 'Email Id')
				->setCellValue('E1', 'Mobile No.')
				->setCellValue('F1', 'Customer Type')
				->setCellValue('G1', 'Status')
				->setCellValue('H1', 'Remarks');

		 foreach( $data as $key => $value ) :
			// Add some data
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.($key+2), ($key+1))
							->setCellValue('B'.($key+2), $value['MstCustomerDetailsErp']['vc_customer_no'])
							->setCellValue('C'.($key+2), $value['MstCustomerDetailsErp']['vc_customer_name'])
							->setCellValue('D'.($key+2), $value['MstCustomerDetailsErp']['vc_email'])
							->setCellValue('E'.($key+2), $value['MstCustomerDetailsErp']['vc_mobile_no'])
							->setCellValue('F'.($key+2), $value['MstCustomerDetailsErp']['vc_cust_type'])
							->setCellValue('G'.($key+2), $value['status_imp'])
							->setCellValue('H'.($key+2), $value['message']);
			
			unset($value);
		 endforeach;

			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$dir = WWW_ROOT.'DataImportExcel'; 

		if (!file_exists($dir)) {

			mkdir($dir, 0777, true);
		}

		$objWriter->save($dir.DS.'MDC-Import-Data-'.date('Y-M-D-His').'-Portal'.'.xlsx');
	 
	}
	
	
	/*
	 * Save XML in server
	 */
	 
	function getImportXmlCBC($data) {
		
		$this->checkLogin();
		
		/** Include PHPExcel */
		require_once VENDORS.'PHPExcel'.DS.'PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("w")
								 ->setLastModifiedBy("")
								 ->setTitle("")
								 ->setSubject("")
								 ->setDescription("")
								 ->setKeywords("")
								 ->setCategory("");
								 
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'S. No')
				->setCellValue('B1', 'Customer No.')
				->setCellValue('C1', 'Customer Name')
				->setCellValue('D1', 'Email Id')
				->setCellValue('E1', 'Mobile No.')
				->setCellValue('F1', 'Customer Type')
				->setCellValue('G1', 'Status')
				->setCellValue('H1', 'Remarks');

		 foreach( $data as $key => $value ) :
			// Add some data
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.($key+2), ($key+1))
							->setCellValue('B'.($key+2), $value['CbcCustomerDetailsErp']['vc_cust_no'])
							->setCellValue('C'.($key+2), ucwords(trim($value['CbcCustomerDetailsErp']['vc_first_name'])).' '.ucwords(trim($value['CbcCustomerDetailsErp']['vc_surname'])))
							->setCellValue('D'.($key+2), $value['CbcCustomerDetailsErp']['vc_email'])
							->setCellValue('E'.($key+2), $value['CbcCustomerDetailsErp']['vc_mobile_no'])
							->setCellValue('F'.($key+2), $value['CbcCustomerDetailsErp']['vc_cust_type'])
							->setCellValue('G'.($key+2), $value['status_imp'])
							->setCellValue('H'.($key+2), $value['message']);
			
			unset($value);
		 endforeach;

			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$dir = WWW_ROOT.'DataImportExcel'; 

		if (!file_exists($dir)) {

			mkdir($dir, 0777, true);
		}

		$objWriter->save($dir.DS.'CBC-Import-Data-'.date('Y-M-D-His').'-Portal'.'.xlsx');

		 
	}
	
	/*
	 * Save XML in server
	 */
	 
	function getImportXmlFLR($data) {
		
		$this->checkLogin();
		
		/** Include PHPExcel */
		require_once VENDORS.'PHPExcel'.DS.'PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("w")
								 ->setLastModifiedBy("")
								 ->setTitle("")
								 ->setSubject("")
								 ->setDescription("")
								 ->setKeywords("")
								 ->setCategory("");
								 
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'S. No')
				->setCellValue('B1', 'Client No.')
				->setCellValue('C1', 'Client Name')
				->setCellValue('D1', 'Email Id')
				->setCellValue('E1', 'Mobile No.')
				->setCellValue('F1', 'Status')
				->setCellValue('G1', 'Remarks');

		 foreach( $data as $key => $value ) :
			// Add some data
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.($key+2), ($key+1))
							->setCellValue('B'.($key+2), $value['FlrClientDetailsErp']['vc_client_no'])
							->setCellValue('C'.($key+2), $value['FlrClientDetailsErp']['vc_client_name'])
							->setCellValue('D'.($key+2), $value['FlrClientDetailsErp']['vc_email'])
							->setCellValue('E'.($key+2), $value['FlrClientDetailsErp']['vc_cell_no'])
							->setCellValue('F'.($key+2), $value['status_imp'])
							->setCellValue('G'.($key+2), $value['message']);
			
			unset($value);
		 endforeach;

			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$dir = WWW_ROOT.'DataImportExcel'; 

		if (!file_exists($dir)) {

			mkdir($dir, 0777, true);
		}

		$objWriter->save($dir.DS.'FLR-Import-Data-'.date('Y-M-D-His').'-Portal'.'.xlsx');

	
	}
		
  
	/**
	 * Admin Login Check 
	 */
	 
	function checkLogin () {
		
		if(!$this->Session->check('admin')){
			$this->redirect('index');
		}
	}
	
	/**
	 * Admin DashBoard 
	 */
	function dashboard(){
		
		
		$this->layout = 'admin';
		
		$this->set('title_for_layout', 'Admin Dashboard');
	
	}
	
	/**
	 * Admin Logout
	 */
	 
	function logout() {
		
		$this->Session->delete('admin');
		
		$this->Session->setFlash('Successful logout!!', 'success');
		
		$this->redirect('index');

	}
	
 }
 
?>