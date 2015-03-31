<?php

App::import('Sanitize');

/**
 *
 *
 *
 */
class CronsController extends AppController {

    /**
     *
     *
     *
     */
    var $name = 'Crons';

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
    var $uses = array('Profile', 'Vehicle', 'VehicleDetail');

    /**
     *
     *
     *
     */
    var $helpers = array('Session', 'Html', 'Form');

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow('*');
    }

    /**
     *
     * Function for email shoot on approval and rejection of customer profile in MDC
     *
     */
    function mdcprofileApprovalRejection() {
       
    	set_time_limit(0);
        $this->loadModel('Profile');

        $customersEmailID = $this->Profile->find('all', array(
            'fields' => array('Profile.vc_customer_name',
                'Profile.ch_active',
                'Profile.vc_mobile_no',
                //'Profile.nu_cust_vehicle_card_id',
                'Profile.vc_comp_code',
                'Profile.vc_remarks',
                'Profile.ch_email_flag',
                'Profile.vc_customer_no',
                'Profile.vc_email_id'),
            'conditions' => array(
                array('Profile.ch_email_flag' => 'N'),
                'OR' => array(
                    array('Profile.ch_active' => 'STSTY04'),
                    array('Profile.ch_active' => 'STSTY05')
                )
            ),
            'limit' => 50,
                )
        );

        $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email = $value['Profile']['vc_email_id'];
                $vc_cust_no = $value['Profile']['vc_customer_no'];
                $ch_active = $value['Profile']['ch_active'];
                $ch_email_flag = $value['Profile']['ch_email_flag'];
                $vc_customer_name = $value['Profile']['vc_customer_name'];
                $vc_comp_code = $value['Profile']['vc_comp_code'];
                $vc_mobile_no = $value['Profile']['vc_mobile_no'];
                $vc_remarks = $value['Profile']['vc_remarks'];
                //$vc_username         	  = $value['Profile']['vc_remarks'];

                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);


                if ($ch_active == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($ch_active == 'STSTY05')
                    $mesage = " Your profile  has been rejected by RFA .";
                else
                    $mesage = " Your profile  has been approved by RFA .";

                $mesage .= '<br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($ch_active == 'STSTY05')
                    $mesage .= '<br/> Remarks :  ' . $vc_remarks;

                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */

                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */
                $this->Email->from = ucfirst(trim($vc_customer_name));

                $this->Email->to = trim($this->AdminMdcEmailID);

                if ($ch_active == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Customer Profile Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($ch_active == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . " profile  has been rejected by RFA following are customer details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . " profile  has been approved by RFA following are customer details.";

                $mesage .= '<br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                if ($ch_active == 'STSTY05')
                    $mesage .= '<br/> Remarks :  ' . $vc_remarks;

                $this->Email->send($mesage);
                $mesage = '';


                /*                 * ******************** End Email********************** */

                $data = array('Profile.ch_email_flag' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->Profile->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->Profile->id = $vc_cust_no;
                    $this->Profile->set($data);
                    $this->Profile->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
		
		$this->mdcCompanyApprovalRejection();
    }

    /**
     *
     * Function for email shoot on approval and rejection of vehicle  in MDC
     *
     */
    function mdcVehicleApprovalRejection() {
        set_time_limit(0);
		$this->loadModel('Profile');
		$this->loadModel('VehicleDetail');

        $fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',
            'Profile.vc_customer_id',
            'Profile.vc_cust_type',
            'Profile.vc_address3',
            'Profile.vc_address2',
            'Profile.vc_address1',		
            'VehicleDetail.vc_customer_no',
            'VehicleDetail.vc_vehicle_status',
            'VehicleDetail.vc_vehicle_lic_no',
            'VehicleDetail.vc_vehicle_reg_no',
            'VehicleDetail.ch_email_flag',
            'VehicleDetail.vc_registration_detail_id',
            'VehicleDetail.vc_remarks',
            'VehicleDetail.vc_pay_frequency',
            'VehicleDetail.nu_company_id',
            'VehicleDetail.vc_comp_code',
        );


        $options['joins'] = array(
            array('table' => 'dt_registration_mdc',
                'alias' => 'VehicleDetail',
                'type' => 'INNER',
                'conditions' => array(
                    array('VehicleDetail.ch_email_flag' => 'N'),
                    array('VehicleDetail.vc_customer_no = Profile.vc_customer_no'),
                    'OR' => array(
                        array('VehicleDetail.vc_vehicle_status' => 'STSTY04'),
                        array('VehicleDetail.vc_vehicle_status' => 'STSTY05')
                    )
                )));

        $options['fields'] = $fields;

        //$this->Profile->unBindModel(array('belongsTo' => array('ParameterType')),false);
        //	$this->VehicleDetail->unBindModel(array('belongsTo' => array('ParameterType')),false);
        //$this->Profile->unbindModelAll(); 
        //unset($this->Profile->belongsTo);
        $customersEmailID = $this->Profile->find('all', $options);

        $sizeOf = sizeOf($customersEmailID);
		
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email             = $value['Profile']['vc_email_id'];
                $vc_cust_no        = $value['Profile']['vc_customer_no'];
                $ch_email_flag     = $value['VehicleDetail']['ch_email_flag'];
                $vc_customer_name  = $value['Profile']['vc_customer_name'];
                $vc_comp_code      = $value['Profile']['vc_comp_code'];
                $vc_customer_id      = $value['Profile']['vc_customer_id'];
                $vc_mobile_no      = $value['Profile']['vc_mobile_no'];                
				$vc_cust_type      = $value['Profile']['vc_cust_type'];
                $vc_email_id      = $value['Profile']['vc_email_id'];
                $vc_address3      = $value['Profile']['vc_address3'];
                $vc_address2      = $value['Profile']['vc_address2'];
                $vc_address1      = $value['Profile']['vc_address1'];
				
                $vc_vehicle_status = $value['VehicleDetail']['vc_vehicle_status'];
                $vc_vehicle_reg_no = $value['VehicleDetail']['vc_vehicle_reg_no'];
                $vc_vehicle_lic_no = $value['VehicleDetail']['vc_vehicle_lic_no'];
                $vc_pay_frequency  = $value['VehicleDetail']['vc_pay_frequency'];
                $vehicle_log_customer_no  = $value['VehicleDetail']['vc_customer_no'];
                $vehicle_log_vc_comp_code  = $value['VehicleDetail']['vc_comp_code'];
                $nu_company_id     = $value['VehicleDetail']['nu_company_id'];				
                $vc_registration_detail_id = $value['VehicleDetail']['vc_registration_detail_id'];
                $vc_remarks        = $value['VehicleDetail']['vc_remarks'];
                $vc_oper_est_km        = $value['VehicleDetail']['vc_oper_est_km'];



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);
                //$this->Email->to = 'rishi.kapoor@essindia.co.in';


                if ($vc_vehicle_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($vc_vehicle_status == 'STSTY05')
                    $mesage = " Your vehicle  has been rejected by RFA .";
                else
                    $mesage = " Your vehicle  has been approved by RFA .";

                $mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Vehicle License No. : ' . trim($vc_vehicle_lic_no);

                $mesage .= '<br/> Vehicle Registration No. : ' . trim($vc_vehicle_reg_no);

                if ($vc_vehicle_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_customer_name));

                //$this->Email->to = trim($this->AdminMdcEmailID);
				 //$this->Email->to = 'rishi.kapoor@essindia.co.in';

                if ($vc_vehicle_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($vc_vehicle_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  vehicle  has been rejected by RFA following are customer and vehicle details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "  vehicle  has been approved by RFA following are customer and vehicle details.";

                $mesage .= '<br/> <br/>Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';
                
				$mesage .= '<br/>Vehicle License No. : ' . trim($vc_vehicle_lic_no);
                
				$mesage .= '<br/>Vehicle Registration No. : ' . trim($vc_vehicle_reg_no);

                if ($vc_vehicle_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $this->Email->send($mesage);
                $mesage = '';

				$arrayofnu_start_odometer=array();
                /*                 * ******************** End Email********************** */
                if ($vc_vehicle_status == 'STSTY04'){
				
                    $this->loadModel('CustomerInactiveVehicleLog');
                    
                    $conditions= array('conditions'=>array('CustomerInactiveVehicleLog.vc_status'=>'STSTY03',
					'CustomerInactiveVehicleLog.vc_vehicle_lic_no'=>trim($vc_vehicle_lic_no)));
                    $countotherlogtable = $this->CustomerInactiveVehicleLog->find('all',$conditions);
					pr($countotherlogtable);
					// update dt_registarion_mdc  VC_START_OMETER to min value of start_nu_odometer of above
					// delete all
					
					if(count($countotherlogtable)>0){
					
					$this->loadModel('VehicleLogMaster');
                    $this->loadModel('ParameterType');
                    $this->loadModel('VehicleLogDetail');
                    //$this->loadModel('Profile');
                    $this->loadModel('VehicleDetail');
					
					
					
					$hdvehlogID = $this->VehicleLogMaster->getPrimaryKey();

                    //$logdetails = $this->Session->read('Auth.Profile');

                    $logdetails['vc_vehicle_log_no'] = $hdvehlogID;

					$logdetails['vc_pay_frequency'] = $vc_pay_frequency;

					$logdetails['vc_vehicle_lic_no'] = $vc_vehicle_lic_no;

					$logdetails['dt_created_date'] = date('d-M-Y H:i:s');
					$logdetails['vc_customer_id'] = $vc_customer_id;
					$logdetails['vc_customer_name'] = $vc_customer_id;
					$logdetails['VC_ADDRESS1'] = $vc_address1;
					$logdetails['VC_ADDRESS2'] = $vc_address2;
					$logdetails['VC_ADDRESS3'] = $vc_address3;
					$logdetails['vc_telephone_no'] = $vc_customer_id;
					$logdetails['VC_FAX_NO']     = $vc_customer_id;
					$logdetails['vc_mobile_no'] = $vc_mobile_no;
					$logdetails['vc_email_id'] = $vc_email_id;
					$logdetails['vc_cust_type'] = $vc_cust_type;
					

					$this->VehicleLogMaster->save($logdetails, false);
					
					$arrayofnu_start_odometer=array();
					foreach($countotherlogtable as $logindex=>$logvalue){
					
						
						$arrayofnu_start_odometer[] = $logvalue['CustomerInactiveVehicleLog']['nu_start_ometer'];
						
						/*
						if ($checkRequest = $this->VehicleLogDetail->find('count', array(
                                            'conditions' => array(
                                                'lower(VehicleLogDetail.vc_vehicle_lic_no)' => strtolower(trim( $vc_vehicle_lic_no)),
                                                array('OR' => array(
                                                    array('VehicleLogDetail.nu_start_ometer' => trim($logvalue['nu_start_ometer'])),
                                                    array('VehicleLogDetail.nu_end_ometer' => trim($logvalue['nu_end_ometer']))
                                        ))))) == 0) 	{
										*/

                                    $vc_log_detail_id                                 = $this->VehicleLogDetail->getPrimaryKey();
									$vehicleLogData['vc_log_detail_id']               = $vc_log_detail_id;
									
									$vehicleLogData['nu_start_ometer'] = $logvalue['CustomerInactiveVehicleLog']['nu_start_ometer'];
									$vehicleLogData['nu_end_ometer']  = $logvalue['CustomerInactiveVehicleLog']['nu_end_ometer'];
									$vehicleLogData['nu_oper_est_km'] = $vc_oper_est_km;
									$vehicleLogData['vc_orign']                       = $logvalue['CustomerInactiveVehicleLog']['vc_orign'];
									$vehicleLogData['vc_destination']                 = $logvalue['CustomerInactiveVehicleLog']['vc_destination'];
									$vehicleLogData['vc_orign_name']                  = $logvalue['CustomerInactiveVehicleLog']['vc_orign_name'];
                                    $vehicleLogData['vc_destination_name']            = $logvalue['CustomerInactiveVehicleLog']['vc_destination_name'];
                                    $vehicleLogData['vc_other_road_orign_name']       = $logvalue['CustomerInactiveVehicleLog']['vc_other_road_orign_name'];
                                    $vehicleLogData['vc_other_road_destination_name'] = $logvalue['CustomerInactiveVehicleLog']['vc_other_road_destination_name'];
                                    
                                    
									$vehicleLogData['dt_log_date']      = date('d-M-Y', strtotime($logvalue['CustomerInactiveVehicleLog']['dt_log_date']));
									
                                    //$vehicleLogData['CH_ROAD_TYPE']    = $logvalue['CH_ROAD_TYPE'];
                                    $vehicleLogData['ch_road_type']      = $logvalue['CustomerInactiveVehicleLog']['ch_road_type'];
									$vehicleLogData['nu_company_id']     = $nu_company_id;   
                                    $vehicleLogData['dt_created_date']   = date('d-M-Y H:i:s');
                                    $vehicleLogData['vc_pay_frequency']          = $vc_pay_frequency;
                                    $vehicleLogData['vc_vehicle_lic_no']         = $vc_vehicle_lic_no;
                                    $vehicleLogData['vc_status']                 = 'STSTY01'; 
                                    $vehicleLogData['vc_vehicle_reg_no']         = $vc_vehicle_reg_no;
                                    $vehicleLogData['vc_vehicle_log_no']         = $hdvehlogID;
                                    $vehicleLogData['vc_remark']                 = $logvalue['CustomerInactiveVehicleLog']['vc_remark'];									
									$vehicleLogData['nu_other_road_km_traveled'] = $logvalue['CustomerInactiveVehicleLog']['nu_other_road_km_traveled'];
									$vehicleLogData['nu_road_km_traveled']       = $logvalue['CustomerInactiveVehicleLog']['nu_km_traveled'];
									$vehicleLogData['vc_other_road_destination'] = $logvalue['CustomerInactiveVehicleLog']['vc_other_road_destination'];
									$vehicleLogData['vc_other_road_orign']       = $logvalue['CustomerInactiveVehicleLog']['vc_other_road_orign'];
									$vehicleLogData['vc_remark_by']              = 'USRTYPE01';
									$vehicleLogData['vc_customer_no']            = $vehicle_log_customer_no;
									$vehicleLogData['vc_comp_code']              = $vehicle_log_vc_comp_code;
                                    
                                    $this->VehicleLogDetail->create();									
                                    $this->VehicleLogDetail->set($vehicleLogData);									
									$this->VehicleLogDetail->save($vehicleLogData, false);
									
									
									
									$CustomerInactiveVehicleLogarray=array('CustomerInactiveVehicleLog.vc_log_detail_id'=>
									$logvalue['vc_log_detail_id'],'CustomerInactiveVehicleLog.vc_status'=>'STSTY04');
									
									$this->CustomerInactiveVehicleLog->create();
									
                                    $this->CustomerInactiveVehicleLog->set($CustomerInactiveVehicleLogarray);
									$this->CustomerInactiveVehicleLog->id = $logvalue['vc_log_detail_id'];
									$this->CustomerInactiveVehicleLog->save($CustomerInactiveVehicleLogarray, false);
									

				  //}

					
				}
				
					
					
				//	$this->VehicleDetail->create();					
				///	$this->VehicleDetail->set($VehicleDetail);
				//	$this->VehicleDetail->id = $vc_vehicle_lic_no;					
				//	$this->VehicleDetail->save($VehicleDetail, false);
					
				 
					
					
					}
                    
                } // vehicle status =04
                
                
                $data = array('VehicleDetail.ch_email_flag' => 'Y','vc_start_ometer'=>min($arrayofnu_start_odometer));
				//mail('rishi.kapoor@essindia.co.in',$vc_registration_detail_id.'==lic no--statrt-ododmeter-'.min($arrayofnu_start_odometer), $message, '');
                if ($customerEmailStatus == true) {

                    $this->VehicleDetail->create();
                    $data['ch_email_flag'] = 'Y';
                    $data['vc_start_ometer'] = min($arrayofnu_start_odometer);
					//$VehicleDetail = array('VehicleDetail.vc_start_ometer'=>min($arrayofnu_start_odometer));
                    $this->VehicleDetail->id = $vc_registration_detail_id;
                    $this->VehicleDetail->set($data);
                    $this->VehicleDetail->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }

    
	
	/**
     *
     * Function for email shoot on approval and rejection of vehicle  in MDC
     *
     */
    function mdcCompanyApprovalRejection() {
	
        set_time_limit(0);
		
		$this->loadModel('Profile');
		$this->loadModel('Company');

        $fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',
            'Profile.vc_customer_id',
            'Profile.vc_cust_type',
            'Profile.vc_address3',
            'Profile.vc_address2',
            'Profile.vc_address1',		
            'Company.vc_customer_no',
            'Company.vc_company_name',
            'Company.ch_status',
            'Company.vc_username',
            'Company.vc_address1',
            'Company.vc_address2',
            'Company.vc_address3',
            'Company.vc_business_reg',
            'Company.vc_account_no',
            'Company.ch_email_flag',
            'Company.nu_company_id',
            'Company.vc_remarks'
        );


        $options['joins'] = array(
            array('table' => 'mst_company_mdc',
                'alias' => 'Company',
                'type' => 'INNER',
                'conditions' => array(
                    array('Company.ch_email_flag' => 'N'),
                    array('Company.vc_customer_no = Profile.vc_customer_no'),
                    'OR' => array(
                        array('Company.ch_status' => 'STSTY04'),
                        array('Company.ch_status' => 'STSTY05')
                    )
                )));

        $options['fields'] = $fields;

        //$this->Profile->unBindModel(array('belongsTo' => array('ParameterType')),false);
        //	$this->VehicleDetail->unBindModel(array('belongsTo' => array('ParameterType')),false);
        //$this->Profile->unbindModelAll(); 
        //unset($this->Profile->belongsTo);
        $customersEmailID = $this->Profile->find('all', $options);

        $sizeOf = sizeOf($customersEmailID);
		
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email             = $value['Profile']['vc_email_id'];
                $vc_cust_no        = $value['Profile']['vc_customer_no'];
                $vc_customer_name  = $value['Profile']['vc_customer_name'];
                $vc_comp_code      = $value['Profile']['vc_comp_code'];
                $vc_customer_id      = $value['Profile']['vc_customer_id'];
                $vc_mobile_no      = $value['Profile']['vc_mobile_no'];                
				$vc_cust_type      = $value['Profile']['vc_cust_type'];
                $vc_email_id      = $value['Profile']['vc_email_id'];
                $vc_address3      = $value['Profile']['vc_address3'];
                $vc_address2      = $value['Profile']['vc_address2'];
                $vc_address1      = $value['Profile']['vc_address1'];					
				
                $vc_username = $value['Company']['vc_username'];
                $vc_account_no = $value['Company']['vc_account_no'];
                $vc_business_reg  = $value['Company']['vc_business_reg'];            
                $nu_company_id     = $value['Company']['nu_company_id'];				
                $vc_remarks        = $value['Company']['vc_remarks'];
				$ch_email_flag     = $value['Company']['ch_email_flag'];				
				$vc_company_name     = $value['Company']['vc_company_name'];				
                $ch_status = $value['Company']['ch_status'];



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);
                //$this->Email->to = 'rishi.kapoor@essindia.co.in';


                if ($ch_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Company Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Company Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($ch_status == 'STSTY05')
                    $mesage = " Your company  has been rejected by RFA .";
                else
                    $mesage = " Your company  has been approved by RFA .";

                $mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

               

                $mesage .= '<br/> Company Name : ' . trim($vc_company_name);

                $mesage .= '<br/> Business Registration No. : ' . trim($vc_business_reg);
				//  $mesage .= '<br/> Bank Account No. : ' . trim($vc_account_no);

                if ($ch_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_customer_name));

                $this->Email->to = trim($this->AdminMdcEmailID);
				// $this->Email->to = 'rishi.kapoor@essindia.co.in';

                 if ($ch_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Company Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Company Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';
				if ($ch_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  company  approval request has been rejected by RFA following are company details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "   company  approval has been approved by RFA following are company details.";

              
                
				$mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

                $mesage .= '<br/> Company Name : ' . trim($vc_company_name);

                $mesage .= '<br/> Business Registration No. : ' . trim($vc_business_reg);
               //  $mesage .= '<br/> Bank Account No. : ' . trim($vc_account_no);

                if ($ch_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;

                $this->Email->send($mesage);
                $mesage = '';

				
                
                $data = array('Company.ch_email_flag' => 'Y');
				
                if ($customerEmailStatus == true) {

                    $this->Company->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->Company->id = $nu_company_id;
                    $this->Company->set($data);
                    $this->Company->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }

    
     function mdcVehicleTransferApprovalRejection() {
	 
		set_time_limit(0);
        $this->loadModel('Profile');
        $this->loadModel('VehicleAmendment');

        $fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',            
             'VehicleAmendment.vc_vehicle_amend_no',
            'VehicleAmendment.vc_vehicle_lic_no',
            'VehicleAmendment.vc_vehicle_reg_no',
            'VehicleAmendment.ch_email_flag',
            'VehicleAmendment.ch_approve',
            'VehicleAmendment.vc_remarks',
             'VehicleAmendment.dt_transfer_date',
            'VehicleAmendment.vc_customer_no'
        );


        $options['joins'] = array(
            array('table' => 'MST_VEHICLE_AMENDMENTS_MDC',
                'alias' => 'VehicleAmendment',
                'type' => 'INNER',
                'conditions' => array(
                    array('VehicleAmendment.ch_email_flag' => 'N'),
                    array('VehicleAmendment.vc_customer_no = Profile.vc_customer_no'),
                    'OR' => array(
                        array('VehicleAmendment.ch_approve' => 'STSTY04'),
                        array('VehicleAmendment.ch_approve' => 'STSTY05')
                    )
                )));

        $options['fields'] = $fields;

        //$this->Profile->unBindModel(array('belongsTo' => array('ParameterType')),false);
        //	$this->VehicleDetail->unBindModel(array('belongsTo' => array('ParameterType')),false);
        //$this->Profile->unbindModelAll(); 
        //unset($this->Profile->belongsTo);
        $customersEmailID = $this->Profile->find('all', $options);
        pr( $customersEmailID );

        $sizeOf = sizeOf($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email = $value['Profile']['vc_email_id'];
                $vc_cust_no = $value['Profile']['vc_customer_no'];                
                $ch_email_flag = $value['VehicleAmendment']['ch_email_flag'];
                $ch_approve = $value['VehicleAmendment']['ch_approve'];
                $vc_customer_name  = $value['Profile']['vc_customer_name'];
                $vc_comp_code      = $value['Profile']['vc_comp_code'];
                $vc_mobile_no      = $value['Profile']['vc_mobile_no'];
                $vc_vehicle_reg_no = $value['VehicleAmendment']['vc_vehicle_reg_no'];
                $vc_vehicle_lic_no = $value['VehicleAmendment']['vc_vehicle_lic_no'];
                $vc_registration_detail_id = $value['VehicleAmendment']['vc_vehicle_amend_no'];
                $vc_remarks = $value['VehicleAmendment']['vc_remarks'];



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);


                if ($ch_approve == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Transfer Request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Transfer Request Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($ch_approve == 'STSTY05')
                    $mesage = " Your vehicle transfer request has been rejected by RFA .";
                else
                    $mesage = " Your vehicle transfer request has been approved by RFA .";

                $mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Vehicle License No. : ' . trim($vc_vehicle_lic_no);

                $mesage .= '<br/> Vehicle Registration No. : ' . trim($vc_vehicle_reg_no);

                if ($ch_approve == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_customer_name));

                $this->Email->to = trim($this->AdminMdcEmailID);
                
                if ($ch_approve == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Transfer Request Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Vehicle Transfer Request Approval  ";

                 


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($ch_approve == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  vehicle  transfer request has been rejected by RFA following are customer and vehicle details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "  vehicle  transfer request has been approved by RFA following are customer and vehicle details.";

                $mesage .= '<br/> <br/>Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';
                $mesage .= '<br/> Vehicle License No. : ' . trim($vc_vehicle_lic_no);
                $mesage .= '<br/> Vehicle Registration No. : ' . trim($vc_vehicle_reg_no);

                 if ($ch_approve == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;



                $this->Email->send($mesage);
                $mesage = '';


                /*                 * ******************** End Email********************** */

                $data = array('VehicleAmendment.ch_email_flag' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->VehicleAmendment->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->VehicleAmendment->id = $vc_registration_detail_id;
                    $this->VehicleAmendment->set($data);
                    $this->VehicleAmendment->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }
    /**
     *
     * Function for email shoot on approval and rejection of vehicle  in MDC
     *
     */
    function mdcAssessmentApprovalRejection() {
        set_time_limit(0);
        $this->loadModel('Profile');
        $this->loadModel('AssessmentVehicleMaster');

        $fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',
            'AssessmentVehicleMaster.vc_assessment_no',
            'AssessmentVehicleMaster.vc_authorized_user',
            'AssessmentVehicleMaster.vc_status',
            'AssessmentVehicleMaster.nu_total_payable_amount',
            'AssessmentVehicleMaster.ch_email_flag',
            'AssessmentVehicleMaster.vc_payment_status',
            'AssessmentVehicleMaster.vc_remarks',
        );


        $options['joins'] = array(
            array('table' => 'hd_assessment_mdc',
                'alias' => 'AssessmentVehicleMaster',
                'type' => 'INNER',
                'conditions' => array(
                    array('AssessmentVehicleMaster.ch_email_flag' => 'N'),
                    array('AssessmentVehicleMaster.vc_customer_no = Profile.vc_customer_no'),
                    'OR' => array(
                        array('AssessmentVehicleMaster.vc_status' => 'STSTY04'),
                        array('AssessmentVehicleMaster.vc_status' => 'STSTY05')
                    )
                ), 'limit' => 50,
            )
        );

        $options['fields'] = $fields;

        //unset($this->Profile->belongsTo);
        $customersEmailID = $this->Profile->find('all', $options);

        $sizeOf = sizeOf($customersEmailID);

        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email = $value['Profile']['vc_email_id'];
                $vc_cust_no = $value['Profile']['vc_customer_no'];
                $vc_customer_name = $value['Profile']['vc_customer_name'];
                $vc_comp_code = $value['Profile']['vc_comp_code'];
                $vc_mobile_no = $value['Profile']['vc_mobile_no'];

                $ch_email_flag = $value['AssessmentVehicleMaster']['ch_email_flag'];
                $vc_assessment_no = $value['AssessmentVehicleMaster']['vc_assessment_no'];
                $nu_total_payable_amount = $value['AssessmentVehicleMaster']['nu_total_payable_amount'];
                //$vc_vehicle_lic_no           = $value['AssessmentVehicleMaster']['vc_vehicle_lic_no'];
                $vc_payment_status = $value['AssessmentVehicleMaster']['vc_payment_status'];
                $vc_status = $value['AssessmentVehicleMaster']['vc_status'];
                //$vc_registration_detail_id   = $value['AssessmentVehicleMaster']['vc_registration_detail_id'];
                $vc_remarks = $value['AssessmentVehicleMaster']['vc_remarks'];
                $vc_authorized_user = $value['AssessmentVehicleMaster']['vc_authorized_user'];



                /*         *************Email Shoot to Customer***************** */
                
				list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);


                if ($vc_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Approval  ";

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($vc_status == 'STSTY05')
                    $mesage = " Your assessment has been rejected by RFA.";
                else
                    $mesage = " Your assessment has been approved by RFA.";

                $mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Assessment No. : ' . trim($vc_assessment_no);

                if ($vc_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_customer_name));

                $this->Email->to = trim($this->AdminMdcEmailID);

                if ($vc_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Approval  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($vc_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  assessment has been rejected by RFA following are customer and assessment details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "  assessment has been approved by RFA following are customer and assessment details.";

                $mesage .= '<br/> <br/>Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Assessment No. : ' . trim($vc_assessment_no);

                if ($vc_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;



                $this->Email->send($mesage);
                $mesage = '';


                /*                 * ******************** End Email********************** */

                $data = array('AssessmentVehicleMaster.ch_email_flag' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->AssessmentVehicleMaster->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->AssessmentVehicleMaster->id = $vc_assessment_no;
                    $this->AssessmentVehicleMaster->set($data);
                    $this->AssessmentVehicleMaster->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }

// end of function

    /**
     *
     * Function for email shoot on approval and rejection of vehicle  in MDC
     *
     */
    function mdcPaymentApprovalRejection() {
        set_time_limit(0);
        $this->loadModel('Profile');
        $this->loadModel('AssessmentVehicleMaster');
        App::import('Controller', 'Vehicles');
        $vehicleclass = new VehiclesController();


        //include_file('/views/vehicles/download_print_receipt');
        //die;
        $fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',
            'AssessmentVehicleMaster.vc_assessment_no',
            'AssessmentVehicleMaster.vc_authorized_user',
            'AssessmentVehicleMaster.vc_status',
            'AssessmentVehicleMaster.nu_total_payable_amount',
            'AssessmentVehicleMaster.ch_email_flag',
            'AssessmentVehicleMaster.vc_payment_status',
            'AssessmentVehicleMaster.vc_payment_reference_no',
            'AssessmentVehicleMaster.vc_mdc_paid',
            'AssessmentVehicleMaster.vc_remarks',
        );


        $options['joins'] = array(
            array('table' => 'hd_assessment_mdc',
                'alias' => 'AssessmentVehicleMaster',
                'type' => 'INNER',
                'conditions' => array(
                    array('AssessmentVehicleMaster.ch_email_flag' => 'N'),
                    array('AssessmentVehicleMaster.vc_customer_no = Profile.vc_customer_no'),
                    'OR' => array(
                        array('AssessmentVehicleMaster.vc_payment_status' => 'STSTY04'),
                        array('AssessmentVehicleMaster.vc_payment_status' => 'STSTY05')
                    )
                ), 'limit' => 50,
            )
        );

        $options['fields'] = $fields;

        unset($this->Profile->belongsTo);
        $customersEmailID = $this->Profile->find('all', $options);

        $sizeOf = sizeOf($customersEmailID);
        //pr($customersEmailID);
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email = $value['Profile']['vc_email_id'];
                $vc_cust_no = $value['Profile']['vc_customer_no'];
                $vc_customer_name = $value['Profile']['vc_customer_name'];
                $vc_comp_code = $value['Profile']['vc_comp_code'];
                $vc_mobile_no = $value['Profile']['vc_mobile_no'];

                $ch_email_flag = $value['AssessmentVehicleMaster']['ch_email_flag'];
                $vc_assessment_no = $value['AssessmentVehicleMaster']['vc_assessment_no'];
                $nu_total_payable_amount = $value['AssessmentVehicleMaster']['nu_total_payable_amount'];
                //$vc_vehicle_lic_no           = $value['AssessmentVehicleMaster']['vc_vehicle_lic_no'];
                $vc_payment_status = $value['AssessmentVehicleMaster']['vc_payment_status'];
                $vc_status = $value['AssessmentVehicleMaster']['vc_status'];
                $vc_paid_amt = $value['AssessmentVehicleMaster']['vc_mdc_paid'];
                //$vc_registration_detail_id   = $value['AssessmentVehicleMaster']['vc_registration_detail_id'];
                $vc_remarks = $value['AssessmentVehicleMaster']['vc_remarks'];
                $vc_payment_reference_no = $value['AssessmentVehicleMaster']['vc_payment_reference_no'];
                $vc_authorized_user = $value['AssessmentVehicleMaster']['vc_authorized_user'];

                $cron = 1;
                if ($cron == 1) {
                    $this->set('cron', $cron);
                } else {
                    $this->set('cron', 0);
                }

                $assessmentno = $vc_assessment_no;
                //$vehicleclass->cronpdfattachment($vc_assessment_no);
                //$vehicleclass->downloadPrintReceipt($vc_assessment_no,1);
                sleep(5);


                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);
                //$this->Email->to = 'rishi.kapoor@essindia.co.in';

                if ($vc_payment_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Payment Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Payment Approval  ";

                //$this->Email->attachments = array($vehicleClass->downloadPrintReceipt($vc_assessment_no));
                /*
				$this->Email->attachments = array('MDC_Assessment_Payment_Receipt_' . $vc_assessment_no . '.pdf' => WWW_ROOT . 'upload-files-for-cbc-mdc/MDC_Assessment_Payment_Receipt_' . $vc_assessment_no . '.pdf');
				*/
                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($vc_payment_status == 'STSTY05')
                    $mesage = " Your payment for assessment has been rejected by RFA.";
                else
                    $mesage = " Your payment for assessment has been approved by RFA.";

                $mesage .= '<br/><br/> Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Assessment No. : ' . trim($vc_assessment_no);
                if ($vc_payment_status == 'STSTY04')
                    $mesage .= '<br/> Paid Amt. : (N$) ' . trim($vc_paid_amt);
                $mesage .= '<br/> Ref No. :  ' . trim($vc_payment_reference_no);




                if ($vc_payment_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_customer_name));

                $this->Email->to = trim($this->AdminMdcEmailID);

                //$this->Email->to = 'rishi.kapoor@essindia.co.in';

                if ($vc_payment_status == 'STSTY05')
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Payment Rejection  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Assessment Payment Approval  ";
                //$vehicleClass->downloadPrintReceipt($vc_assessment_no)
                
				/*
				
				$this->Email->attachments = array('MDC_Assessment_Payment_Receipt_' . $vc_assessment_no . '.pdf' => WWW_ROOT . 'upload-files-for-cbc-mdc/MDC_Assessment_Payment_Receipt_' . $vc_assessment_no . '.pdf');
				
				*/

                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';


                if ($vc_payment_status == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  payment for assessment  has been rejected by RFA following are customer and payment details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "  payment for assessment  has been approved by RFA following are customer and payment details.";

                $mesage .= '<br/> <br/>Customer No. : ' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';

                $mesage .= '<br/> Assessment No. : ' . trim($vc_assessment_no);

                if ($vc_payment_status == 'STSTY04')
                    $mesage .= '<br/> Paid Amt. : (N$) ' . trim($vc_paid_amt);
                $mesage .= '<br/> Ref No. :  ' . trim($vc_payment_reference_no);


                if ($vc_payment_status == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;




                $this->Email->send($mesage);
                $mesage = '';

                /*                 * ******************** End Email********************** */

                $data = array('AssessmentVehicleMaster.ch_email_flag' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->AssessmentVehicleMaster->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->AssessmentVehicleMaster->id = $vc_assessment_no;
                    $this->AssessmentVehicleMaster->set($data);
                    $this->AssessmentVehicleMaster->save($data, false);
                    //unlink(WWW_ROOT . 'upload-files-for-cbc-mdc/MDC_Assessment_Payment_Receipt_' . $vc_assessment_no . '.pdf');

                    // mail("rishi.kapoor@essindia.co.in","scheduler run","");
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }

// end of function

    /**
     *
     * Function for email shoot on approval and rejection of ownership pending work in MDC
     *
     */
    function mdcOwnershipApprovalRejection() {
        set_time_limit(0);
        $this->loadModel('Profile');
        $this->loadModel('CustomerAmendment');


        $fields = array('Profile.vc_customer_name',
            'Profile.vc_comp_code',
            'Profile.vc_mobile_no',
            'Profile.vc_customer_no',
            'Profile.vc_email_id',
            'CustomerAmendment.vc_customer_name',
            'CustomerAmendment.vc_cust_amend_no',
            'CustomerAmendment.vc_mobile_no',
            'CustomerAmendment.vc_email_id',
            'CustomerAmendment.vc_amend_type',
            'CustomerAmendment.ch_approve',
            'CustomerAmendment.vc_tel_no',
            'CustomerAmendment.ch_email_flag',
            'CustomerAmendment.vc_customer_id',
            'CustomerAmendment.vc_tel_no',
            'CustomerAmendment.vc_remarks',
        );


        $options['joins'] = array(
            array('table' => 'mst_customer_amendments_mdc',
                'alias' => 'CustomerAmendment',
                'type' => 'INNER',
                'conditions' => array(
                    array('CustomerAmendment.ch_email_flag' => 'N'),
                    array('CustomerAmendment.vc_customer_no = Profile.vc_customer_no'),
                    'OR' => array(
                        array('CustomerAmendment.ch_approve' => 'STSTY04'),
                        array('CustomerAmendment.ch_approve' => 'STSTY05')
                    )
                ), 'limit' => 50,
            )
        );

        $options['fields'] = $fields;

        //unset($this->Profile->belongsTo);
        $customersEmailID = $this->Profile->find('all', $options);

        $sizeOf = sizeOf($customersEmailID);
//pr($customersEmailID);die;
        if ($sizeOf > 0) {

            $counter = 0;

            foreach ($customersEmailID as $index => $value) {

                $this->Email->reset();

                $email = $value['Profile']['vc_email_id'];
                $vc_cust_no = $value['Profile']['vc_customer_no'];
                $vc_customer_name = $value['Profile']['vc_customer_name'];
                $vc_comp_code = $value['Profile']['vc_comp_code'];
                $vc_mobile_no = $value['Profile']['vc_mobile_no'];

                $ch_email_flag = $value['CustomerAmendment']['ch_email_flag'];
                $vc_amend_customer_name = $value['CustomerAmendment']['vc_customer_name'];
                $vc_cust_amend_no = $value['CustomerAmendment']['vc_cust_amend_no'];
                $vc_amend_mobile_no = $value['CustomerAmendment']['vc_mobile_no'];
                $vc_amend_email_id = $value['CustomerAmendment']['vc_email_id'];
                $vc_amend_type = $value['CustomerAmendment']['vc_amend_type'];
                $ch_approve = $value['CustomerAmendment']['ch_approve'];
                //$vc_paid_amt                 = $value['CustomerAmendment']['vc_mdc_paid'];
                $vc_remarks = $value['CustomerAmendment']['vc_remarks'];
                $vc_customer_id = $value['CustomerAmendment']['vc_customer_id'];
                $vc_amend_tel_no = $value['CustomerAmendment']['vc_tel_no'];




                //$assessmentno=	$vc_assessment_no;



                /*                 * *************Email Shoot to Customer***************** */
                list( $selectedType, $type, $selectList ) = $this->getRFATypeDetail($vc_comp_code);

                $this->Email->from = $this->AdminName . '<' . $this->AdminEmailID . '>';

                $this->Email->to = trim($email);
                //$this->Email->to = 'rishi.kapoor@essindia.co.in';

                if ($ch_approve == 'STSTY05' && $vc_amend_type == 'CUSTAMDTYP01')
                    $this->Email->subject = strtoupper($selectedType) . " Name Rejection  ";
                else if ($ch_approve == 'STSTY04' && $vc_amend_type == 'CUSTAMDTYP01')
                    $this->Email->subject = strtoupper($selectedType) . " Name Approval  ";
                else if ($ch_approve == 'STSTY04' && $vc_amend_type == 'CUSTAMDTYP02')
                    $this->Email->subject = strtoupper($selectedType) . " Ownership Approval  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Ownership Rejection  ";

                //$this->Email->attachments = array($vehicleClass->downloadPrintReceipt($vc_assessment_no));
                //$this->Email->attachments = array('MDC_Assessment_Payment_Receipt_'.$vc_assessment_no.'.pdf'  => WWW_ROOT . 'upload-files-for-cbc-mdc/MDC_Assessment_Payment_Receipt_'.$vc_assessment_no.'.pdf');
                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', ucfirst(trim($vc_customer_name)));

                $this->Email->delivery = 'smtp';

                if ($ch_approve == 'STSTY05')
                    $mesage = " Your request has been rejected by RFA.";
                else
                    $mesage = " Your request has been approved by RFA.";


                if ($vc_amend_type == 'CUSTAMDTYP01') {

                    $mesage .= '<br/><br/> <u><b>Name Change Details</b></u> : ';

                    $message.='<br/></br>Customer Name:   ' . trim($vc_amend_customer_name);

                    $message.='<br/></br>ID No.\Reg No.:   ' . trim($vc_customer_id);
                } else {
                    $mesage .= '<br/><br/> <u><b>Ownership Change Details</b></u> : ';

                    $mesage .= '<br/><br/> Customer Name. : ' . trim($vc_amend_customer_name);

                    $mesage.='<br/></br>Customer Mobile:   ' . trim($vc_amend_mobile_no);

                    $mesage.='<br/></br>Customer Email-id:   ' . trim($vc_amend_email_id);

                    $mesage.='<br/></br>Customer Tel No.:   ' . trim($vc_amend_tel_no);
                }


                $mesage .='<br/><br/> <u><b>Requested by</b></u> : ';
                $mesage .='<br/>Customer No.:' . trim($vc_cust_no);

                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';





                if ($ch_approve == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;


                $customerEmailStatus = $this->Email->send($mesage);

                $mesage = '';


                /* ======End of email shoot for customer ============= */


                $this->Email->reset();


                /*                 * ****************Email Send To Admin************************** */

                $this->Email->from = ucfirst(trim($vc_customer_name));

                $this->Email->to = trim($this->AdminMdcEmailID);

                //$this->Email->to = 'rishi.kapoor@essindia.co.in';

                if ($ch_approve == 'STSTY05' && $vc_amend_type == 'CUSTAMDTYP01')
                    $this->Email->subject = strtoupper($selectedType) . " Name Rejection  ";
                else if ($ch_approve == 'STSTY04' && $vc_amend_type == 'CUSTAMDTYP01')
                    $this->Email->subject = strtoupper($selectedType) . " Name Approval  ";
                else if ($ch_approve == 'STSTY04' && $vc_amend_type == 'CUSTAMDTYP02')
                    $this->Email->subject = strtoupper($selectedType) . " Ownership Approval  ";
                else
                    $this->Email->subject = strtoupper($selectedType) . " Ownership Rejection  ";


                $this->Email->template = 'registration';

                $this->Email->sendAs = 'html';

                $this->set('name', $this->AdminName);

                $this->Email->delivery = 'smtp';

                if ($ch_approve == 'STSTY05')
                    $mesage = ucfirst(trim($vc_customer_name)) . "  Request  has been rejected by RFA following are customer  details.";
                else
                    $mesage = ucfirst(trim($vc_customer_name)) . "  Request   has been approved by RFA following are customer  details.";

                $mesage .= '<br/> <br/>Customer No. : ' . trim($vc_cust_no);


                if ($vc_amend_type == 'CUSTAMDTYP01') {

                    $mesage .= '<br/><br/> <u><b>Name Change Details</b></u> : ';

                    $mesage.='<br/></br>Customer Name:   ' . trim($vc_amend_customer_name);

                    $mesage.='<br/></br>ID No.\Reg No.:   ' . trim($vc_customer_id);
                } else {
                    $mesage .= '<br/><br/> <u><b>Ownership Change Details</b></u> : ';

                    $mesage .= '<br/><br/> Customer Name. : ' . trim($vc_amend_customer_name);

                    $mesage.='<br/></br>Customer Mobile:   ' . trim($vc_amend_mobile_no);

                    $mesage.='<br/></br>Customer Email-id:   ' . trim($vc_amend_email_id);

                    $mesage.='<br/></br>Customer Tel No.:   ' . trim($vc_amend_tel_no);
                }


                $mesage .='<br/><br/> <u><b>Requested by</b></u> : ';
                $mesage .='<br/>Customer No.:' . trim($vc_cust_no);


                if ($vc_mobile_no != '')
                    $mesage .= '<br/> Mobile No. : ' . trim($vc_mobile_no);
                else
                    $mesage .= '<br/> Mobile No. :  N/A ';


                if ($ch_approve == 'STSTY05')
                    $mesage .= '<br/> Remarks : ' . $vc_remarks;




                $this->Email->send($mesage);
                $mesage = '';

                /*                 * ******************** End Email********************** */

                $data = array('CustomerAmendment.ch_email_flag' => 'Y');

                if ($customerEmailStatus == true) {

                    $this->CustomerAmendment->create();
                    $data['ch_email_flag'] = 'Y';
                    $this->CustomerAmendment->id = $vc_cust_amend_no;
                    $this->CustomerAmendment->set($data);
                    $this->CustomerAmendment->save($data, false);
                }

                $counter++;

                if ($counter > 50)
                    break;
            } // end of foreach
        }// end of if
    }

// end of function
}

// closing of class 	
?>
