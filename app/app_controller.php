<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
class AppController extends Controller {

    /**
     *
     *
     */
    var $components = array('Session', 'Auth', 'RequestHandler', 'Email');

    /*
     *
     *
     */
    public $uses = array('BranchCode', 'ParameterType','Company');

    /**
     *
     *
     *
     */
    public $helpers = array('Form', 'Html', 'Session', 'Common','Suppliername','Invoicedocdetails','Ajax');

    /**
     *  
     * Checked user is login or not
     */
	 
    public $loggedIn = null;

    /**
     *
     *
     */
    public $mdc = null;

    /**
     *
     *
     */
	 
    public $mdcLabel = null;

    /**
     *
     *
     */
	 
    public $flr = null;

    /**
     *
     *
     */
	 
    public $flrLabel = null;

    /**
     *
     *
     */
	 
    public $cbc = null;

    /**
     *
     *
     */
	 
    public $cbcLabel = null;

    /**
     *
     *
     */
	 
    public $AdminName = NULL;

    /**
     *
     *
     */
	 
    public $AdminEmailID=NULL;
	
	 /**
     *
     *
     */
	 
    public $AdminMdcEmailID = NULL;

    /**
     *
     *
     */
	 
    public $AdminCbcEmailID = NULL;

    /**
     *
     *
     */
	 
    public $AdminFlrEmailID = NULL;

    /**
     *
     *
     */
	 
    public $isInspector = false;

    /**
     *
     *
     */
	 
    public $isMdc = false;

    /**
     *
     *
     */
    public $isCbc = false;

    /**
     *
     *
     */
    public $isFlr = false;

    /**
     *
     *
     *
     */
    public $globalParameterarray = array();
	
	
	public $CompanyId = array();
	
	
	public $allCompanyId = array();

    /**
     *
     *
     */
    public function beforeFilter() {

        $prtype = $this->ParameterType->find('all');

        $mdclocal = 'Welcome to RFA MDC Local';
		
        $this->set('mdclocal', $mdclocal);
       
        $this->globalParameterarray = Set::combine($prtype, '{n}.ParameterType.vc_prtype_code', '{n}.ParameterType.vc_prtype_name');

        $this->set('globalParameterarray', $this->globalParameterarray);
		
		
		$vc_username     = $this->Session->read('Auth.Member.vc_username');
		$this->CompanyId = $this->Company->find('list', array('conditions' => array('Company.ch_status' => 'STSTY04','Company.vc_username' =>$vc_username), 'fields' => array('nu_company_id', 'vc_company_name'), 'order' => array('Company.vc_company_name' => 'asc')));
		$this->set('CompanyId',$this->CompanyId);
		
		$this->allCompanyId = $this->Company->find('list', array('conditions' => array('Company.vc_username' =>$vc_username), 'fields' => array('nu_company_id', 'vc_company_name'), 'order' => array('Company.vc_company_name' => 'asc')));
		$this->set('allCompanyId',$this->allCompanyId);

        $this->Email->smtpOptions = array(
            'port' => '465',
            'timeout' => '30',
            'host' => 'ssl://smtp.gmail.com',
            'username' => 'noreply.essportal21.stmp@gmail.com',
            'password' => 'noreply.essportal21.stmpess',
        );
        $this->Email->template = 'default';

        $this->Email->sendAs = 'both';

        $this->Email->delivery = 'smtp';

        $this->Auth->userModel = 'Member';

        $this->Auth->authError = "You are not authorized to access that location.";

        $this->Auth->loginError = "Login failed. Invalid username or password";

        $this->setBranchCode();

        $this->getAdminDetail();

        if ($this->Session->read('Auth.Member.vc_user_login_type') == 'USRLOGIN_INSP') {

            $this->Auth->loginAction = array('controller' => 'inspectors', 'action' => 'login', @$this->Auth->params['prefix'] => false);

            $this->Auth->loginRedirect = array('controller' => 'inspectors', 'action' => 'index', @$this->Auth->params['prefix'] => false);

            $this->Auth->logoutRedirect = array('controller' => 'inspectors', 'action' => 'login', @$this->Auth->params['prefix'] => false);
        } else {

            $this->Auth->loginAction = array('controller' => 'members', 'action' => 'login', @$this->Auth->params['prefix'] => false);

            if ($this->cbc) :

                if ($this->Session->read('Auth.Member.vc_cbc_customer_no') == '') :

                    $this->Auth->loginRedirect = array('controller' => 'customers', 'action' => 'customer_profile', 'cbc' => false);

                elseif ($this->Session->read('Auth.Customer.ch_active') == 'STSTY05'):

                    $this->Auth->loginRedirect = array('controller' => 'customers', 'action' => 'editprofile', 'cbc' => false);

                else:

                    $this->Auth->loginRedirect = array('controller' => 'customers', 'action' => 'view', 'cbc' => false);


                endif;

            elseif ($this->flr) :

                $this->Auth->loginRedirect = array('controller' => 'clients', 'action' => 'index', 'flr' => false);


            else:

                $this->Auth->loginRedirect = array('controller' => 'profiles', 'action' => 'index', @$this->Auth->params['prefix'] => false);

            endif;

            $this->Auth->logoutRedirect = array('controller' => 'members', 'action' => 'login', @$this->Auth->params['prefix'] => false);
        }
    }

    /**
     *
     *  Set branch code
     *
     */
    function setBranchCode() {


        $companyCode = $this->BranchCode->find('all', array(
            'conditions' => array(
                'BranchCode.vc_comp_code like' => 'cm%'
            ),
            'fields' => array(
                'BranchCode.vc_comp_code',
                'BranchCode.vc_company_name',
                'BranchCode.vc_client_code')));

        if (count($companyCode) > 0) :

            foreach ($companyCode as $values):

                if ($this->in_array_recursive('mdc001', $values)) :

                    $mdc = $values;

                elseif ($this->in_array_recursive('cbc001', $values)) :

                    $cbc = $values;

                elseif ($this->in_array_recursive('flr001', $values)):

                    $flr = $values;

                endif;



            endforeach;


            if ($mdc && $cbc && $flr) {

                $this->mdc = $mdc['BranchCode']['vc_comp_code'];

                $this->cbc = $cbc['BranchCode']['vc_comp_code'];

                $this->flr = $flr['BranchCode']['vc_comp_code'];

               $this->mdcLabel = $mdc['BranchCode']['vc_company_name'];//DESIGN-LABEL-MDC
               // $this->mdcLabel = $mdc['BranchCode']['design-label-mdc'];//DESIGN-LABEL-MDC

                $this->cbcLabel = $cbc['BranchCode']['vc_company_name'];

                $this->flrLabel = $flr['BranchCode']['vc_company_name'];

                Configure::write('companyCodecbc', $this->cbc);

                Configure::write('companyCodemdc', $this->mdc);

                Configure::write('companyCodeflr', $this->flr);

                $this->set('mdc', $this->mdc);

                $this->set('cbc', $this->cbc);

                $this->set('flr', $this->flr);

                $this->set('mdcLabel', $this->mdcLabel);

                $this->set('cbcLabel', $this->cbcLabel);

                $this->set('flrLabel', $this->flrLabel);
            } else {

                throw new Exception(" Not Define Branch Code. Please define first in Database.");
            }

        else :

            throw new Exception(" Not Define Branch Code. Please define first in Database.");

        endif;
    }

    /**
     *
     * Get Admin Detail 
     *
     */
	 function recursiveRemove($dir) {
	 
		$structure = glob(rtrim($dir, "/").'/*');
		if (is_array($structure)) {
			foreach($structure as $file) {
				if (is_dir($file)) recursiveRemove($file);
				elseif (is_file($file)) unlink($file);
			}
		}
		rmdir($dir);
		
	}

	 
    function getAdminDetail() {

        $queryResult = $this->ParameterType->find('all', array(
            'conditions' => array(
                'ParameterType.vc_prtype_code like' => 'ADMINDET%')));


        foreach ($queryResult as $values):


           if ($this->in_array_recursive('ADMINDETEMAIL', $values)) :

                $this->AdminEmailID = $values['ParameterType']['vc_prtype_name'];

            endif;


     		if ($this->in_array_recursive('ADMINDETNAME', $values)) :

                $this->AdminName = $values['ParameterType']['vc_prtype_name'];

            endif;

            if ($this->in_array_recursive('ADMINDETE-MDC-MAIL', $values)) :

                $this->AdminMdcEmailID = $values['ParameterType']['vc_prtype_name'];

            endif;

            if ($this->in_array_recursive('ADMINDETE-CBC-MAIL', $values)) :

                $this->AdminCbcEmailID = $values['ParameterType']['vc_prtype_name'];

            endif;

            if ($this->in_array_recursive('ADMINDETE-FLR-MAIL', $values)) :

                $this->AdminFlrEmailID = $values['ParameterType']['vc_prtype_name'];

            endif;
        endforeach;
    }

    /**
     * Custom method to refresh the current user from the db
     *
     * @param $overwrite boolean Overwrite the current user session
     * @return array currently logged in user from db
     */
    function checkUser() {

        $result = $this->Auth->User();

        if (empty($result)) {

            return false;
        }

        $this->loggedIn = true;

        $this->set('loggedIn', $this->loggedIn);

        switch (trim($this->Session->read('Auth.Member.vc_comp_code'))) {

            case trim($this->mdc):

                $this->isMdc = true;

                $this->isInspector = $result[$this->Auth->userModel]['vc_user_login_type'] == 'USRLOGIN_INSP' ? true : false;

                $this->set('isInspector', $this->isInspector);

                $this->loadModel('Profile');

                $profile = $this->Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));
				$nu_company_id = $this->Session->read('nu_company_id');// session
				if($nu_company_id =='' && empty($nu_company_id)){
				
					$nu_company_id =$profile['Profile']['nu_company_id'];
					$this->Session->write('nu_company_id',$nu_company_id);
				
				}
				
				if(isset($nu_company_id) && $nu_company_id!=''){				
					
                    $vc_username = $this->Session->read('Auth.Member.vc_username');
					$conditions = array('conditions' => array('Company.nu_company_id' =>$nu_company_id,'Company.vc_username' =>$vc_username,));
					$companydetails = $this->Company->find('first',$conditions);
                                        
					$VC_CUST_TYPE_arra['VC_CUST_TYPE'] = $profile['VC_CUST_TYPE'];
					$VC_CUST_TYPE_arra['Profile']      = $companydetails['Company'];
					$VC_CUST_TYPE_arra['Status']       = $profile['Status'];
					//$array['Profile'] = $companydetails['Company'];
					$addprofile['Profile']             = array_merge($profile['Profile'], $companydetails['Company']);
					
                    $profile = array_merge($profile, $VC_CUST_TYPE_arra);					
					$profile = array_merge($profile, $addprofile);					
					
 
				 }
				 
			//	pr($profile);

                if ($profile) {

                    $Update['Member'] = @$this->Session->read('Auth.Member');

                    $Update['UserLoginDetail'] = @$this->Session->read('Auth.UserLoginDetail');

                    $this->Session->write('Auth', array());

                    $Update += $profile;

                    $this->Session->write('Auth', $Update);
                }

                break;

            case trim($this->cbc):

                $this->loadModel('Customer');

                $profile = $this->Customer->find('first', array('conditions' => array('Customer.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));

                if ($profile) {

                    $Update['Member'] = @$this->Session->read('Auth.Member');

                    $Update['UserLoginDetail'] = @$this->Session->read('Auth.UserLoginDetail');

                    $this->Session->write('Auth', array());

                    $Update += $profile;

                    $this->Session->write('Auth', $Update);
                }

                $this->isCbc = true;

                break;

            case trim($this->flr):
				$this->loadModel('Clientsupplier');
                $this->loadModel('Client');
			
			    $isthissupplier = $this->Session->read('Auth.Member.vc_user_login_type');
				if($isthissupplier=='USRLOGIN_SUPL'){
                $Client = $this->Clientsupplier->find('first', array('conditions' => array('Clientsupplier.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));
							$Client['Client']=$Client['Clientsupplier'];
						//	pr($Client);
				}else{
                $Client = $this->Client->find('first', array('conditions' => array('Client.vc_user_no' => $this->Session->read('Auth.Member.vc_user_no'))));
				
				}
				//pr($this->Session->read('Auth.Member.vc_user_login_type'));
                

                if ($Client) {

                    $Update['Member'] = @$this->Session->read('Auth.Member');

                    $Update['UserLoginDetail'] = @$this->Session->read('Auth.UserLoginDetail');

                    $this->Session->write('Auth', array());

                    $Update += $Client;

                    $this->Session->write('Auth', $Update);
                }

                $this->isFlr = true;

                break;
        }

        return true;
    }

    /**
     *
     *
     *
     */
    function getRFATypeDetail($type = null) {

        switch (trim($type)) {

            case $this->mdc :

                $selectedType = strtoupper($this->mdcLabel);

                $selectList = array($this->mdc => strtoupper($this->mdcLabel));

                break;

            case $this->cbc :

                $selectedType = strtoupper($this->cbcLabel);

                $selectList = array($this->cbc => strtoupper($this->cbcLabel));

                break;

            case $this->flr :

                $selectedType = strtoupper($this->flrLabel);

                $selectList = array($this->flr => strtoupper($this->flrLabel));

                break;

            default:

                $selectedType = '';

                $type = '';

                $selectList = array('' => ' Select Type ',
                    $this->mdc => strtoupper($this->mdcLabel),
                    $this->cbc => strtoupper($this->cbcLabel),
                    $this->flr => strtoupper($this->flrLabel)
                );
        }

        return array($selectedType, $type, $selectList);
    }

    /**
     *
     * This function is use to set and unset validates so that your save function will work properly
     *
     */
    function unsetValidateVariable(array $setValidates, array $defaultsetValidates, object $modelName) {

        try {

            if (is_array($setValidates) && is_array($defaultsetValidates) && is_object($modelName)) {

                foreach ($defaultsetValidates as $value) {

                    if (!in_array($value, $setValidates)) {

                        unset($modelName->validate[$value]);
                    }
                }
            } else {

                echo 'Caught exception: ', $e->getMessage(), "\n";
                exit;
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     * Mdc Navigation Header Set
     *
     */
    function getMdcNavigationHeader() {

        if (trim($this->Session->read('Auth.Member.vc_mdc_customer_no')) == '') :

            $child['Add Profile'] = array(
                'controller' => 'profiles',
                'action' => 'index',
                'alt' => 'Add Profile'
            );

        elseif (trim($this->Session->read('Auth.Profile.ch_active')) == 'STSTY05') :

            $child['Edit Profile'] = array(
                'controller' => 'profiles',
                'action' => 'index',
                'alt' => 'Edit Profile'
            );

        else :

            $child['View Profile'] = array(
                'controller' => 'profiles',
                'action' => 'index',
                'alt' => ' View Profile'
            );

        endif;

        $key = key($child);

        $values = current($child);

        $mdcHeaderNavigation = array();

        $mdcHeaderNavigation['My Profile'] = array(
            $key => $values,
            'Change Password' => array(
                'controller' => 'profiles',
                'action' => 'changepassword',
                'alt' => 'Change Password'
        ));

        if (trim($this->Session->read('Auth.Profile.ch_active')) == 'STSTY04') :

			$mdcHeaderNavigation['My Profile'] += array(
                    'Add More Company' => array(
                        'controller' => 'profiles',
						'action' => 'add_more_company',
						'alt' => 'Add More Company'
						),
                    'View / Edit Company' => array(
                        'controller' => 'profiles',
						'action' => 'view_company',
						'alt' => 'View/Edit Company'
                    )
				);
		
            $mdcHeaderNavigation +=array(
				'Vehicle' => array(
                    'Add Vehicle' => array(
                        'controller' => 'vehicles',
                        'action' => 'index',
                        'alt' => 'Add Vehicle'
                    ),
                    'View Vehicle' => array(
                        'controller' => 'vehicles',
                        'action' => 'view',
                        'alt' => 'View Vehicle'
                    ),
                    'Transfer Vehicle' => array(
                        'controller' => 'vehicles',
                        'action' => 'transfer',
                        'alt' => 'Transfer Vehicle'
                    ), 'View Transfer Vehicle Request' => array(
                        'controller' => 'vehicles',
                        'action' => 'vehicletransferlist',
                        'alt' => 'Transfer Vehicle'
                    ),
                    'Change Vehicle Ownership' => array(
                        'controller' => 'vehicles',
                        'action' => 'ownershipchange',
                        'alt' => 'Change Vehicle Ownership'
                    ),
                    'View Ownershipchange request' => array(
                        'controller' => 'vehicles',
                        'action' => 'ownershipchangedetail',
                        'alt' => 'View Ownershipchange request'
                    )
                ),
                'Log Sheet' => array(
                    'Add Log Detail' => array(
                        'controller' => 'vehicles',
                        'action' => 'addlogdetail',
                        'alt' => 'Add Log Detail'
                    ),
                    'View Log Detail' => array(
                        'controller' => 'vehicles',
                        'action' => 'viewlogdetail',
                        'alt' => 'View Log Detail'
                    )
                ),
                'Assessment' => array(
                    'Add  Assessment' => array(
                        'controller' => 'vehicles',
                        'action' => 'addassessment',
                        'alt' => 'Add  Assessment'
                    ),
                    'View Assessment' => array(
                        'controller' => 'vehicles',
                        'action' => 'viewassessment',
                        'alt' => 'View Assessment'
                    )
                ),
                'Report' => array(
                    'Vehicles List' => array(
                        'controller' => 'reports',
                        'action' => 'vehiclelist',
                        'alt' => 'Vehicles List'
                    ),
                    'Log Sheet History ' => array(
                        'controller' => 'reports',
                        'action' => 'logdetail',
                        'alt' => 'Log Sheet History'
                    ),
                    'Payment History' => array(
                        'controller' => 'reports',
                        'action' => 'paymenthistory',
                        'alt' => 'Payment History'
                    ),
                    'Assessment History' => array(
                        'controller' => 'reports',
                        'action' => 'assessmenthistory',
                        'alt' => 'Assessment History'
                    )
            ));

        endif;

        $this->set('mdcHeaderNavigation', $mdcHeaderNavigation);
        return $mdcHeaderNavigation;
    }

    /**
     *
     * CBC Navigation Header Set
     *
     */
    function getCbcNavigationHeader() {

        if (trim($this->Session->read('Auth.Member.vc_cbc_customer_no')) == '') :

            $child['Add Profile'] = array(
                'controller' => 'customers',
                'action' => 'cbc_customer_profile',
                'alt' => 'Add Customer Profile'
            );

        elseif (trim($this->Session->read('Auth.Customer.ch_active')) == 'STSTY05') :

            $child['Edit Profile'] = array(
                'controller' => 'customers',
                'action' => 'cbc_editprofile',
                'alt' => 'Edit Customer Profile'
            );

        else :

            $child['View Profile'] = array(
                'controller' => 'customers',
                'action' => 'cbc_view',
                'alt' => ' View Customer Profile'
            );

        endif;

        $key = key($child);

        $values = current($child);

        $cbcHeaderNavigation = array();

        $cbcHeaderNavigation['My Profile'] = array(
            $key => $values,
            'Change Password' => array(
                'controller' => 'customers',
                'action' => 'cbc_changepassword',
                'alt' => 'Customer Change Password'
        ));

        if (trim($this->Session->read('Auth.Customer.ch_active')) == 'STSTY04') :

            $cbcHeaderNavigation +=array(
                'Cards' => array(
                    'Account Recharge' => array(
                        'controller' => 'cards',
                        'action' => 'cbc_account_recharge',
                        'alt' => 'Account Recharge'
                    ),
                    'Add Prepaid Card Request' => array(
                        'controller' => 'cards',
                        'action' => 'cbc_card_request',
                        'alt' => 'Add Prepaid Card Request'
                    ),
                    'View Prepaid Card Requests' => array(
                        'controller' => 'cards',
                        'action' => 'cbc_submit_card',
                        'alt' => 'View Prepaid Card Requests'
                    ),
                    'Activation/Deactivation Card' => array(
                        'controller' => 'cards',
                        'action' => 'cbc_activationdeactivation',
                        'alt' => 'Activation/Deactivation Card'
                    ),
                    'Refund Request' => array(
                        'controller' => 'cards',
                        'action' => 'cbc_refund_request',
                        'alt' => 'Refund Request'
                    )
                ),
                'Vehicles' => array(
                    'Add Vehicles' => array(
                        'controller' => 'vehicles',
                        'action' => 'cbc_vehiclesreg',
                        'alt' => 'Add Vehicles'
                    ),
                    'View Vehicles' => array(
                        'controller' => 'vehicles',
                        'action' => 'cbc_vehiclesview',
                        'alt' => 'View Vehicles'
                    ),
                    'Vehicles Activation/Deactivation ' => array(
                        'controller' => 'vehicles',
                        'action' => 'cbc_activationdeactivation',
                        'alt' => 'Vehicles Activation/Deactivation '
                    ),
                ),
                'Reports' => array(
                    'Customer Recharge' => array(
                        'controller' => 'cbcreports',
                        'action' => 'cbc_customerrecharge',
                        'alt' => 'Customer Recharge'
                    ),
                    'Customer Statement' => array(
                        'controller' => 'cbcreports',
                        'action' => 'cbc_customerstatements',
                        'alt' => 'Customer Statement'
                    ),
                    'Vehicles List ' => array(
                        'controller' => 'cbcreports',
                        'action' => 'cbc_vehicleslist',
                        'alt' => 'Vehicle List'
                    )
                ),
                'Feedback/Complaint' => array(
                    'Customer Feedback' => array(
                        'controller' => 'feedbacks',
                        'action' => 'cbc_addcomplaint',
                        'alt' => 'Customer Feedback Form'
            )));

        endif;

        $this->set('cbcHeaderNavigation', $cbcHeaderNavigation);
        return $cbcHeaderNavigation;
    }

    /**
     *
     * Inspector MDC Navigation Header Set
     *
     */
    function inspectorHeaderNavigation() {

        $inspectorHeaderNavigation = array(
            'Reports' => array(
                'Customer Reports' => array(
                    ' Vehicles List' => array(
                        'controller' => 'inspectors',
                        'action' => 'vehiclelist',
                        'alt' => ' Vehicles List'
                    ),
                    'Log Sheet' => array(
                        'controller' => 'inspectors',
                        'action' => 'logsheet',
                        'alt' => 'Log Sheet'
                    ),
                    'Payment' => array(
                        'controller' => 'inspectors',
                        'action' => 'paymenthistory',
                        'alt' => 'Customers List'
                    ),
                    'Assessment' => array(
                        'controller' => 'inspectors',
                        'action' => 'assessmenthistory',
                        'alt' => 'Customers List'
                    )),
                'Vehicle Reports' => array(
                    ' Vehicle Log Sheet' => array(
                        'controller' => 'inspectors',
                        'action' => 'vehiclelogsheet',
                        'alt' => ' Vehicle Log Sheet'
                    ),
                    'Vehicle Asseessment' => array(
                        'controller' => 'inspectors',
                        'action' => 'vehicleassessment',
                        'alt' => 'Vehicle Asseessment'
                    ))),
            'Feedback' => array(
                ' Feedback Form ' => array(
                    'controller' => 'inspectors',
                    'action' => 'feedbackform',
                    'alt' => ' Feedback Form '
                ),
                'Non Registered Vehicles ' => array(
                    'controller' => 'inspectors',
                    'action' => 'inactivevehicles',
                    'alt' => ' Non Registered Vehicles '
                ),
				
        ),
		   'E-Natis Enquiry' => array(
               'View Vehicle Details ' => array(
                    'controller' => 'inspectors',
                    'action' => 'viewvehicledetail',
                    'alt' => ' Vehicle Details '
                )
        )
		
		);

        $this->set('inspectorHeaderNavigation', $inspectorHeaderNavigation);
        return $inspectorHeaderNavigation;
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

        $controller = $this->params['controller'];
        $action = $this->params['action'];

        $allowGlobalarray = array('Home' => array(
                'My Home' => array('controller' => 'homes', 'action' => 'index', 'alt' => 'home'),
                'Registration' => array('controller' => 'members', 'action' => 'registration', 'alt' => 'home'),
                'Feedabck' => array('controller' => 'feedbacks', 'action' => 'userfeedback', 'alt' => 'feedback'),
                'Login' => array('controller' => 'members', 'action' => 'login', 'alt' => 'login'),
        ));

        if ($this->isMdc && !$this->isInspector):

            $MdcNavigationHeader = $this->getMdcNavigationHeader();

        elseif ($this->isMdc && $this->isInspector):

            $inspectorHeaderNavigation = $this->inspectorHeaderNavigation();


        elseif ($this->isCbc):
            $cbcHeaderNavigation = $this->getCbcNavigationHeader();

        elseif ($this->isFlr):

            $flrHeaderNavigation = $this->getFlrHeaderNavigation();


        endif;
    }

    /**
     *
     * @recursively check if a value is in array
     *
     * @param string $string (needle)
     *
     * @param array $array (haystack)
     *
     * @param bool $type (optional)
     *
     * @return bool
     *
     */
    function in_array_recursive($string, $array, $type = false) {
        /*         * * an recursive iterator object ** */
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));

        /*         * * traverse the $iterator object ** */
        while ($it->valid()) {
            /*             * * check for a match ** */
            if ($type === false) {
                if ($it->current() == $string) {
                    return true;
                }
            } else {
                if ($it->current() === $string) {
                    return true;
                }
            }
            $it->next();
        }
        /*         * * if no match is found ** */
        return false;
    }

    /**
     *
     * FLR Navigation Header Set
     *
     */
    function getFlrHeaderNavigation() {


        $FRL_USER_TYPE = $this->Session->read('Auth.Member.vc_user_login_type');

        if ($FRL_USER_TYPE == 'USRLOGIN_SUPL') {

            if (trim($this->Session->read('Auth.Member.vc_flr_customer_no')) == '') :

                $child['Add Profile'] = array(
                    'controller' => 'suppliers',
                    'action' => 'flr_index',
                    'alt' => 'Add Supplier Profile'
                );

            elseif (trim($this->Session->read('Auth.Client.ch_active_flag')) == 'STSTY05') :

                $child['Edit Profile'] = array(
                    'controller' => 'suppliers',
                    'action' => 'flr_index',
                    'alt' => 'Edit Supplier Profile'
                );

            else :

                $child['View Profile'] = array(
                    'controller' => 'suppliers',
                    'action' => 'flr_view',
                    'alt' => ' View Supplier Profile'
                );

            endif;

            $key = key($child);

            $values = current($child);

            $flrHeaderNavigation = array();

            $flrHeaderNavigation['My Profile'] = array(
                $key => $values,
                'Change Password' => array(
                    'controller' => 'suppliers',
                    'action' => 'flr_changepassword',
                    'alt' => 'Supplier Change Password'
            ));

            if (trim($this->Session->read('Auth.Client.ch_active_flag')) == 'STSTY04') :

                $flrHeaderNavigation +=array(
                    'Import Data' => array('Upload File' => array(
                            'controller' => 'suppliers',
                            'action' => 'flr_supplier',
                            'alt' => 'Import Data')));

            endif;
            //echo $this->Session->read('Auth.Client.ch_active_flag');
        }
        else {

            if (trim($this->Session->read('Auth.Member.vc_flr_customer_no')) == '') :

                $child['Add Profile'] = array(
                    'controller' => 'clients',
                    'action' => 'flr_index',
                    'alt' => 'Add Client Profile'
                );

            elseif (trim($this->Session->read('Auth.Client.ch_active_flag')) == 'STSTY05') :

                $child['Edit Profile'] = array(
                    'controller' => 'clients',
                    'action' => 'flr_index',
                    'alt' => 'Edit Client Profile'
                );

            else :

                $child['View Profile'] = array(
                    'controller' => 'clients',
                    'action' => 'flr_view',
                    'alt' => ' View Client Profile'
                );

            endif;


            $key = key($child);

            $values = current($child);

            $flrHeaderNavigation = array();

            $flrHeaderNavigation['My Profile'] = array(
                $key => $values,
                'Change Password' => array(
                    'controller' => 'clients',
                    'action' => 'flr_changepassword',
                    'alt' => 'Client Change Password'
            ));

            if (trim($this->Session->read('Auth.Client.ch_active_flag')) == 'STSTY04') :

                $flrHeaderNavigation['My Profile'] += array(
                    'Change Name/Ownership Details' => array(
                        'controller' => 'clients',
                        'action' => 'flr_changeofownership',
                        'alt' => 'Client Change Ownership'
                    ),
                    'View Name/Ownership Request ' => array(
                        'controller' => 'clients',
                        'action' => 'flr_viewchangeofownership',
                        'alt' => 'View Name/Ownership details'
                    ),
                    'Change Bank Details' => array(
                        'controller' => 'clients',
                        'action' => 'flr_bankdetailschanges',
                        'alt' => 'Client Change Bank Detail Changes'
                    ),
                    'View Bank Change Request ' => array(
                        'controller' => 'clients',
                        'action' => 'flr_viewbankdetailschanges',
                        'alt' => 'View Bank Detail Changes'
                    ),
                    'Manage Fuel Outlets' => array(
                        'controller' => 'clients',
                        'action' => 'flr_managefueloutlets',
                        'alt' => 'Manage Fuel Outlets'
                    ),
                );


                $flrHeaderNavigation +=array(
                    'Claim Processing' => array(
                        'Add Claim' => array(
                            'controller' => 'claims',
                            'action' => 'flr_index',
                            'alt' => 'Client Add Claim'
                        ),
                        'View Claim' => array(
                            'controller' => 'claims',
                            'action' => 'flr_view',
                            'alt' => 'Client View / Edit Claim'
                        )
                    ),
                    'Feedback & Complaint' => array(
                        'Add Complaint/Feedback' => array(
                            'controller' => 'feedbacks',
                            'action' => 'flr_addcomplaint',
                            'alt' => 'Client Add Complaint/Feedback'
                        )
                    ),
                    'Reports' => array(
                        'Claim Details' => array(
                            'controller' => 'flrreports',
                            'action' => 'flr_claimdetails',
                            'alt' => 'Client Claim Details'
                        ),
                        'Claim Summary' => array(
                            'controller' => 'flrreports',
                            'action' => 'flr_claimsummarys',
                            'alt' => 'Client Claim Summary'
                        ),
                        'Payment Details' => array(
                            'controller' => 'flrreports',
                            'action' => 'flr_paymentdetails',
                            'alt' => 'Client Payment Details'
                )));

            endif;
        }

        $this->set('flrHeaderNavigation', $flrHeaderNavigation);
        return $flrHeaderNavigation;
    }

    /**
     *
     * Funftion for rename of file name while upload 
     *
     * 	
     */
    public function renameUploadFile($filename = null) {

        $expFile = explode(".", $filename);
        $countexp = count($expFile);
        $getExt = $expFile[$countexp - 1];
        return time().'.'.$getExt;
    }

}