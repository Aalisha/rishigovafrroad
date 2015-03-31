<?php

App::import('Sanitize');

/**
 * 
 *
 *
 *
 */
class ReportsController extends AppController {

    var $name = 'Reports';
    var $uses = array('ParameterType');
    var $helpers = array('Number','Companydetails');
    var $components = array('Mdcreportpdfcreator');

    /**
     *
     *
     */
    function beforeFilter() {

        parent::beforeFilter();

        $currentUser = $this->checkUser();

        if (!$currentUser) {

            $this->Session->setFlash('You are not authorized to access that location');

            $this->redirect($this->Auth->logout());
        }

        if ($this->Session->read('Auth.Profile.ch_active') != 'STSTY04') {

            $this->redirect(array('controller' => 'profiles', 'action' => 'index'));
        }
		
		$vc_comp_code = $this->Session->read('Auth.Member.vc_comp_code');
		$ch_active = $this->Session->read('Auth.Profile.ch_active');
		$vc_mdc_customer_no = $this->Session->read('Auth.Member.vc_mdc_customer_no');
		$vc_cbc_customer_no = $this->Session->read('Auth.Member.vc_cbc_customer_no');
		$vc_username = $this->Session->read('Auth.Member.vc_username');
		
	
		
		if($vc_username!='' && $ch_active=='STSTY04' && $this->mdc==$vc_comp_code &&$vc_mdc_customer_no!='')	
		$this->Auth->allow('vehiclelist','vehiclelistpdf','logdetail','logdetailpdf','assessmenthistory','assessmenthistorypdf','paymenthistory','paymenthistorypdf','getcustomerdetailbysearch'		);
		
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
     */

    function beforeRender() {

        parent::beforeRender();
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

    /**
     *
     *
     *
     */
    public function vehiclelist() {

        try {

            $this->loadModel('VehicleDetail');

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :

                $fromDate = (isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate']))?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) : '';
            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = (isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate']))?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) : '';

            endif;

            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

            else :

                $vehicletype = (isset($this->data['Report']['vehicletype']) && !empty($this->data['Report']['vehicletype'])) ?
                        trim($this->data['Report']['vehicletype']) :
                        '';

            endif;
			
			if (isset($this->params['named']['vehiclelicno'])) :

                $vehiclelicno = trim(ucfirst($this->params['named']['vehiclelicno']));

            else :

                $vehiclelicno = (isset($this->data['Report']['vehiclelicno']) && !empty($this->data['Report']['vehiclelicno'])) ?trim($this->data['Report']['vehiclelicno']) :'';

            endif;
			
			
			
			 if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim($this->params['named']['nu_company_id']);

            else :

               $nu_company_id =  (isset($this->data['Report']['nu_company_id']) && $this->data['Report']['nu_company_id']!='' )?$this->data['Report']['nu_company_id']:'';
			//nu_company_id

            endif;
			
			

            $conditions = array(
                'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code')
            );

            if ($fromDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date <=' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;
			
			 if ($vehiclelicno) :

                $conditions += array(
                    'LOWER(VehicleDetail.vc_vehicle_reg_no)' => strtolower(trim($vehiclelicno))
                );

            endif;
			
			
			
			 if ($nu_company_id) :

                $conditions += array(
                    'VehicleDetail.nu_company_id' => $nu_company_id
                );

            endif;

            $limit = 10;

            $this->paginate = array(
                'conditions' => $conditions,
                'order' => array('VehicleDetail.dt_created_date' => 'desc'),
                'fields' => array(
                    'VehicleDetail.vc_vehicle_lic_no',
                    'VehicleDetail.vc_vehicle_reg_no',
                    'VehicleDetail.dt_created_date',
                    'VehicleDetail.vc_v_rating',
                    'VehicleDetail.vc_dt_rating',
                    'VehicleDetail.vc_rate',
                    'VehicleDetail.vc_vehicle_status',
                    'VehicleDetail.nu_company_id',
                    'VEHICLETYPE.vc_prtype_name'
                ),
                'limit' => $limit
            );

            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;

            $this->set('pagecounter', $pagecounter);

            $this->set('limit', $limit);

            $this->VehicleDetail->unBindModel(array('belongsTo' => array('STATUS', 'PAYFREQUENCY', 'CustomerProfile')));

            unset($this->VehicleDetail->__backAssociation['belongsTo']);

            $this->set('vehiclereport', $this->paginate('VehicleDetail'));

            $this->set('SearchfromDate', $fromDate);
            $this->set('vehiclelicno', $vehiclelicno);

            $this->set('SearchtoDate', $toDate);
			
            $this->set('nu_company_id', $nu_company_id);

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $this->set('vehicletypename', $this->globalParameterarray[$vehicletype]);
            } else {

                $this->set('vehicletypename', '');
            }

            $this->layout = 'userprofile';

            $this->set('title_for_layout', 'Vehicle Report');

            $vehiclelist = $this->VehicleDetail->find('list', array(
                'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no')
                ),
                'fields' => array('vc_vehicle_type', 'vc_vehicle_type'),
            ));

            if (count($vehiclelist) == 0):

                $vehiclelist = null;

            endif;

            $typeList = $this->ParameterType->find('list', array(
                'conditions' => array(
                    'ParameterType.vc_prtype_code' => $vehiclelist),
                'fields' => array('vc_prtype_code', 'vc_prtype_name'),
            ));

            $this->set('vehiclelist', array('' => 'All') + $typeList);
			
		$conditions=array();
		$conditions += array('VehicleDetail.vc_vehicle_status' =>'STSTY04');
		
        $conditions += array('VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'));

		$vehiclelistall = $this->VehicleDetail->find('list', array('conditions' => $conditions,
                    'fields' => array('VehicleDetail.vc_vehicle_lic_no','VehicleDetail.vc_vehicle_reg_no')));
        
				
		$this->set('vehiclelistall', $vehiclelistall);			

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
    public function vehiclelistpdf() {

        try {

            $this->loadModel('VehicleDetail');
			//pr($this->data);die;
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = $this->params['named']['nu_company_id'];

            else :

                $nu_company_id = (isset($this->data['Report']['nu_company_id']) && $this->data['Report']['nu_company_id']!='')?$this->data['Report']['nu_company_id']:'';

            endif;
			
            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromdate']));

            else :

                $fromDate = isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) :
                        '';

            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) :
                        '';

            endif;

            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

            else :

                $vehicletype = isset($this->data['Report']['vehicletype']) && !empty($this->data['Report']['vehicletype']) ?
                        trim($this->data['Report']['vehicletype']) :
                        '';
            endif;
			
			if (isset($this->params['named']['vehiclelicno'])) :

                $vehiclelicno = trim($this->params['named']['vehiclelicno']);

            else :

                $vehiclelicno = (isset($this->data['Report']['vehiclelicno']) && !empty($this->data['Report']['vehiclelicno'])) ?trim($this->data['Report']['vehiclelicno']) :'';

            endif;
			
			 

            $conditions = array(
                'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'));

            if ($fromDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleDetail.dt_created_date <=' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;
			
			 if ($nu_company_id) :
			 
                $conditions += array(
                    'VehicleDetail.nu_company_id' => $nu_company_id
                );

            endif;
			
			if ($vehiclelicno) :

                $conditions += array(
                    'LOWER(VehicleDetail.vc_vehicle_reg_no)' => strtolower(trim($vehiclelicno))
                );

            endif;

            $this->VehicleDetail->unBindModel(array('belongsTo' => array('STATUS', 'PAYFREQUENCY', 'CustomerProfile')));

            unset($this->VehicleDetail->__backAssociation['belongsTo']);


            $vehiclereport = $this->VehicleDetail->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'VehicleDetail.vc_vehicle_lic_no',
                    'VehicleDetail.vc_vehicle_reg_no',
                    'VehicleDetail.dt_created_date',
                    'VehicleDetail.vc_v_rating',
                    'VehicleDetail.nu_company_id',
                    'VehicleDetail.vc_dt_rating',
                    'VehicleDetail.vc_rate',
                    'VehicleDetail.vc_vehicle_status',
                    'VEHICLETYPE.vc_prtype_name'
                ),
                'order' => array('VehicleDetail.dt_created_date' => 'desc')));


            
            //$this->set('vehicletype', $vehicletype);
            //$this->set('vc_customer_no', $this->Session->read('Auth.Profile.vc_customer_no'));
            
			$vc_customer_no = $this->Session->read('Auth.Profile.vc_customer_no');

            $vc_customer_name = $this->Session->read('Auth.Profile.vc_customer_name');

            $this->set('vehiclereport', $vehiclereport);

            if (!empty($vehicletype)) {

                $vehicletypename = $this->globalParameterarray[$vehicletype];
            } else {

                $vehicletypename = '';
            }

             if(empty($nu_company_id)){
			
				$columnsHeadings = array('SI. No.','Company Name', 'Vehicle LIC. No.', 
				'Vehicle Register No.',
				'Registration Date', 'Vehicle Type',
				'GVM Rating', 'D/T Rating', 'Rate (N$)');
				}
			 else{
				 $columnsHeadings = array('SI. No.', 'Vehicle LIC. No.', 
				'Vehicle Register No.',
				'Registration Date', 'Vehicle Type',
				'GVM Rating', 'D/T Rating', 'Rate (N$)');

			 }
			// vehiclelicno
          
            $this->Mdcreportpdfcreator->headerData('Vehicle List Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate,$id=1);
            $this->Mdcreportpdfcreator->genrate_mdc_vehiclereport($columnsHeadings, $vehiclereport, $this->globalParameterarray, $toDate,$fromDate, $vehicletypename,$nu_company_id,$this->CompanyId,$vehiclelicno);
            $this->Mdcreportpdfcreator->output('Vehicle-List-Report' . '.pdf', 'D');
            exit;
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    
	/**
     *
     * Get Customer Detail By  Search 
     *
     */
    function getcustomerdetailbysearch() {

        $this->loadModel('VehicleDetail');
        $this->loadModel('VehicleAmendment');

        $this->layout = null;

        $data = '';

        $conditions = array();

        if ($this->params['isAjax'] && !empty($this->params['data'])) {


            $data .= strtolower(trim($this->params['data']));

            $conditions += array(
                'OR' => array(
                    "lower(VehicleDetail.vc_vehicle_lic_no) like '%$data%'",
                    "lower(VehicleDetail.vc_vehicle_reg_no) like '%$data%'"));
        }


        $conditions += array('VehicleDetail.vc_vehicle_status' =>'STSTY04');
		
        $conditions += array('VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'));

		$vehiclelist = $this->VehicleDetail->find('list', array('conditions' => $conditions,
                    'fields' => array('VehicleDetail.vc_vehicle_lic_no','VehicleDetail.vc_vehicle_reg_no')));
        
				
		$this->set('vehicleList', $vehiclelist);			

			
					
//die;
        /*
          */
    }
	/**
     *
     *Function to generate report of log detail
     *
     */
    public function logdetail() {

        try {

            $this->loadModel('VehicleLogDetail');

            $this->loadModel('VehicleDetail');
			
			$nu_company_id = $this->Session->read('nu_company_id');

			$this->Set('nu_company_id',$nu_company_id);

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :

                $fromDate = (isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate'])) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) :   '';
            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = (isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate'])) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) : '';

            endif;

            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

            else :

                $vehicletype = isset($this->data['Report']['vehicletype']) && !empty($this->data['Report']['vehicletype']) ?
                        trim($this->data['Report']['vehicletype']) :
                        '';

            endif;
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim(ucfirst($this->params['named']['nu_company_id']));

            else :

                $nu_company_id = isset($this->data['Report']['nu_company_id']) && !empty($this->data['Report']['nu_company_id']) ? trim($this->data['Report']['nu_company_id']) : '';
            
			endif;
			
			if (isset($this->params['named']['vehiclelicno'])) :

                $vehiclelicno = trim(ucfirst($this->params['named']['vehiclelicno']));

            else :

                $vehiclelicno = (isset($this->data['Report']['vehiclelicno']) && !empty($this->data['Report']['vehiclelicno'])) ?trim($this->data['Report']['vehiclelicno']) :'';

            endif;

            $conditions = array(
                'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'));

            if ($fromDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date >= ' => $fromDate,
                );


            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;
			if ($vehiclelicno) :

                $conditions += array(
                    'LOWER(VehicleLogDetail.vc_vehicle_reg_no)' => strtolower(trim($vehiclelicno))
                );

            endif;
			
			
			
			if ($nu_company_id) :

                $conditions += array(
                    'VehicleLogDetail.nu_company_id' => $nu_company_id
                );

            endif;

            $limit = 10;

            $this->VehicleLogDetail->unBindModel(array('belongsTo' => array('STATUS', 'PAYFREQUENCY', 'VehicleLogMaster')));

            unset($this->VehicleLogDetail->__backAssociation['belongsTo']);


            $this->paginate = array(
                'conditions' => $conditions,
                'fields' => array(
                    'VehicleLogDetail.dt_log_date',
                    'VehicleLogDetail.vc_vehicle_lic_no',
                    'VehicleLogDetail.vc_vehicle_reg_no',
                    'VehicleLogDetail.vc_remark_by',
                    'VehicleDetail.vc_vehicle_type',
                    'VehicleLogDetail.vc_driver_name',
                    'VehicleLogDetail.nu_start_ometer',
                    'VehicleLogDetail.nu_end_ometer',
                    'VehicleLogDetail.vc_orign_name',
                    'VehicleLogDetail.vc_destination_name',
                    'VehicleLogDetail.vc_other_road_orign_name',
                    'VehicleLogDetail.vc_other_road_destination_name',
                    'VehicleLogDetail.nu_km_traveled',
                    'VehicleLogDetail.nu_other_road_km_traveled',
                    'VehicleLogDetail.ch_road_type',
                    'VehicleLogDetail.nu_company_id'
                ),
                'order' => array('VehicleLogDetail.dt_log_date' => 'desc'),
                'limit' => $limit
            );

            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;

            $this->set('pagecounter', $pagecounter);

            $this->set('limit', $limit);

			$company_name = $this->Company->find('first', array('conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),'Company.nu_company_id' => $nu_company_id)
			));

			$this->Set('company_name',$company_name);			

            $this->set('vehiclelogreport', $this->paginate('VehicleLogDetail'));

            $this->set('fromdate', $fromDate);

            $this->set('todate', $toDate);

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $this->set('vehicletypename', $this->globalParameterarray[$vehicletype]);
            } else {

                $this->set('vehicletypename', '');
            }

            $this->layout = 'userprofile';

            $this->set('title_for_layout', 'Vehicle Log Report');

            $vehiclelist = $this->VehicleDetail->find('list', array(
                'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no')
                ),
                'fields' => array('vc_vehicle_type', 'vc_vehicle_type'),
            ));

            if (count($vehiclelist) == 0):

                $vehiclelist = null;

            endif;
			
			$this->set('nu_company_id', $nu_company_id);

            $typeList = $this->ParameterType->find('list', array(
                'conditions' => array(
                    'ParameterType.vc_prtype_code' => $vehiclelist),
                'fields' => array('vc_prtype_code', 'vc_prtype_name'),
            ));


        $this->set('vehiclelist', array('' => 'All') + $typeList);
			
		$conditions=array();
		$conditions += array('VehicleDetail.vc_vehicle_status' =>'STSTY04');
		
        $conditions += array('VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'));

		$vehiclelistall = $this->VehicleDetail->find('list', array('conditions' => $conditions,
                    'fields' => array('VehicleDetail.vc_vehicle_lic_no','VehicleDetail.vc_vehicle_reg_no')));
        
				
		$this->set('vehiclelistall', $vehiclelistall);			
		$this->set('vehiclelicno', $vehiclelicno);			

			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *
     *Function to generate pdf of log detail
     *
     */
	 
    public function logdetailpdf() {

        try {

            $this->loadModel('VehicleLogDetail');

            $this->loadModel('VehicleDetail');

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) :
                        '';
            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) :
                        '';

            endif;


            if (isset($this->params['named']['vehicletype'])) :
                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));
            else :
                $vehicletype = isset($this->data['Report']['vehicletype']) && !empty($this->data['Report']['vehicletype']) ?
                        trim($this->data['Report']['vehicletype']) :
                        '';
            endif;
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim(ucfirst($this->params['named']['nu_company_id']));

            else :

                $nu_company_id = isset($this->data['Report']['nu_company_id']) && !empty($this->data['Report']['nu_company_id']) ? trim($this->data['Report']['nu_company_id']) :
                        '';
            endif;
			
			
			if (isset($this->params['named']['vehiclelicno'])) :

                $vehiclelicno = trim(ucfirst($this->params['named']['vehiclelicno']));

            else :

                $vehiclelicno = isset($this->data['Report']['vehiclelicno']) && !empty($this->data['Report']['vehiclelicno']) ? trim($this->data['Report']['vehiclelicno']):'';
            endif;
			
			

            $conditions = array(
                'VehicleLogDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'VehicleLogDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
            );

            if ($fromDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date >= ' => $fromDate,
                );


            endif;

            if ($toDate) :

                $conditions += array(
                    'VehicleLogDetail.dt_log_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;
			
			 if ($vehiclelicno) :

                $conditions += array(
                    'LOWER(VehicleLogDetail.vc_vehicle_reg_no)' => strtolower(trim($vehiclelicno))
                );

            endif;
			
			
			
			if ($nu_company_id) :

                $conditions += array(
                    'VehicleLogDetail.nu_company_id' => $nu_company_id
                );
				
			endif;

            $this->VehicleLogDetail->unBindModel(array('belongsTo' => array('STATUS', 'PAYFREQUENCY', 'VehicleLogMaster')));

            unset($this->VehicleLogDetail->__backAssociation['belongsTo']);

            $vehiclelogreport = $this->VehicleLogDetail->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'VehicleLogDetail.dt_log_date',
                    'VehicleLogDetail.vc_vehicle_lic_no',
                    'VehicleLogDetail.vc_vehicle_reg_no',
                    'VehicleLogDetail.vc_remark_by',
                    'VehicleDetail.vc_vehicle_type',
                    'VehicleLogDetail.vc_driver_name',
                    'VehicleLogDetail.nu_start_ometer',
                    'VehicleLogDetail.nu_company_id',
                    'VehicleLogDetail.nu_end_ometer',
                    'VehicleLogDetail.vc_orign_name',
                    'VehicleLogDetail.vc_other_road_destination_name',
                    'VehicleLogDetail.vc_other_road_orign_name',
					'VehicleLogDetail.ch_road_type',
                    'VehicleLogDetail.vc_destination_name',
                    'VehicleLogDetail.nu_km_traveled',
                    'VehicleLogDetail.nu_other_road_km_traveled'
                ),
                'order' => array('VehicleLogDetail.dt_log_date' => 'desc')));


            $this->set('fromdate', $fromDate);

            $this->set('todate', $toDate);

            $this->set('vc_customer_no', $this->Session->read('Auth.Profile.vc_customer_no'));

            $this->set('vc_customer_name', $this->Session->read('Auth.Profile.vc_customer_name'));

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $vehicletypename = $this->globalParameterarray[$vehicletype];
            } else {

                $vehicletypename = '';
            }



            $vehiclelist = $this->VehicleDetail->find('list', array(
                'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no')
                ),
                'fields' => array('vc_vehicle_type', 'vc_vehicle_type'),
            ));

            if (count($vehiclelist) == 0):

                $vehiclelist = null;

            endif;

            $typeList = $this->ParameterType->find('list', array(
                'conditions' => array(
                    'ParameterType.vc_prtype_code' => $vehiclelist),
                'fields' => array('vc_prtype_code', 'vc_prtype_name'),
            ));

            $this->set('vehiclelist', array('' => 'All') + $typeList);
			
			if (empty($nu_company_id)){
			
				$columnsHeadings = array('SI. No.', 'Company Name', 'Log Date', 'Vehicle Register No.', 'Vehicle Licence No.', 
									'Vehicle Type', 'Driver Name', 'Start Odometer', 'End Odometer',
									'Road Type','Origin', 'Destination', 'KM Travelled '
									);
				
			}else{
			
				$columnsHeadings = array('SI. No.', 'Log Date', 'Vehicle Register No.', 'Vehicle Licence No.', 
									'Vehicle Type', 'Driver Name', 'Start Odometer', 'End Odometer',
									'Road Type','Origin', 'Destination','KM Travelled ');
				
			}
			
            $this->Mdcreportpdfcreator->headerData('Vehicle Logsheet History Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate,$id=null,$nu_company_id);
            
			$this->Mdcreportpdfcreator->genrate_mdc_vehiclelogreport($columnsHeadings, $vehiclelogreport, $this->globalParameterarray, $toDate, $fromDate, $vehiclelist, $vehicletypename,$nu_company_id, $this->CompanyId,$vehiclelicno);
            
			$this->Mdcreportpdfcreator->output('Vehicle-Log-Report' . '.pdf', 'D');
            
			exit();
        
		} catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     *
     *Function to generate report of assessment history
     *
     */
	 
    function assessmenthistory() {

        try {
		
			$nu_company_id = $this->Session->read('nu_company_id');

			$this->Set('nu_company_id',$nu_company_id);

            $this->loadModel('AssessmentVehicleDetail');
			
            $this->loadModel('Company');

            $this->loadModel('VehicleDetail');

            if (isset($this->params['named']['fromdate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromdate']));

            else :
                $fromDate = isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) :
                        '';
            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) :
                        '';

            endif;
			
			if (isset($this->params['named']['vehiclelicno'])) :

                $vehiclelicno = trim(ucfirst($this->params['named']['vehiclelicno']));

            else :

                $vehiclelicno = (isset($this->data['Report']['vehiclelicno']) && !empty($this->data['Report']['vehiclelicno'])) ?trim($this->data['Report']['vehiclelicno']) :'';

            endif;
			
			

            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(ucfirst($this->params['named']['vehicletype']));

            else :

                $vehicletype = isset($this->data['Report']['vehicletype']) && !empty($this->data['Report']['vehicletype']) ?
                        trim($this->data['Report']['vehicletype']) :
                        '';
            endif;
			
			
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim(ucfirst($this->params['named']['nu_company_id']));

            else :

                $nu_company_id = isset($this->data['Report']['nu_company_id']) && !empty($this->data['Report']['nu_company_id']) ?
                        trim($this->data['Report']['nu_company_id']) :
                        '';
            endif;

            $conditions = array(
                'AssessmentVehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'AssessmentVehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code')
            );

            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date >=' => $fromDate,
                );

            endif;


            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date <=' => $toDate
                );

            endif;


            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;
			
			if ($vehiclelicno) :

                $conditions += array(
                    'LOWER(AssessmentVehicleDetail.vc_vehicle_reg_no)' => strtolower(trim($vehiclelicno))
                );

            endif;
			
			
			 if ($nu_company_id) :

                $conditions += array(
                    'AssessmentVehicleDetail.nu_company_id' => $nu_company_id
                );

            endif;

            $limit = 10;

            $this->paginate = array(
                'conditions' => $conditions,
                'fields' => array(
                    'AssessmentVehicleDetail.dt_created_date',
                    'AssessmentVehicleDetail.vc_assessment_no',
                    'AssessmentVehicleDetail.vc_vehicle_lic_no',
                    'AssessmentVehicleDetail.vc_vehicle_reg_no',
                    'VehicleDetail.vc_vehicle_type',
                    'AssessmentVehicleDetail.vc_pay_frequency',
                    'AssessmentVehicleDetail.vc_prev_end_om',
                    'AssessmentVehicleDetail.vc_end_om',
                    'AssessmentVehicleDetail.vc_km_travelled',
                    'AssessmentVehicleDetail.vc_rate',
					'AssessmentVehicleDetail.vc_payable',
                    'AssessmentVehicleMaster.vc_status',
                    'AssessmentVehicleMaster.nu_company_id'
                ),
                'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc'),
                'limit' => $limit,
            );

            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;
			
            $this->set('vehiclelicno', $vehiclelicno);
            $this->set('pagecounter', $pagecounter);

            $this->set('limit', $limit);
			
			$company_name = $this->Company->find('first', array('conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
			'Company.nu_company_id' => $nu_company_id)
			));

			$this->Set('company_name',$company_name);

            $assessmentreport = $this->paginate('AssessmentVehicleDetail');

            foreach ($assessmentreport as $key => &$value) {

                $value['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'] = $this->globalParameterarray[trim($value['VehicleDetail']['vc_vehicle_type'])];
            }

            $this->set('assessmentreport', $assessmentreport);

            $this->set('fromdate', $fromDate);

            $this->set('todate', $toDate);

            $this->set('vehicletype', $vehicletype);

            if (!empty($vehicletype)) {

                $this->set('vehicletypename', $this->globalParameterarray[$vehicletype]);
            } else {

                $this->set('vehicletypename', '');
            }

            $vehiclelist = $this->VehicleDetail->find('list', array(
                'conditions' => array(
                    'VehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                    'VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no')
                ),
                'fields' => array('vc_vehicle_type', 'vc_vehicle_type'),
            ));

            if (count($vehiclelist) == 0):

                $vehiclelist = null;

            endif;

            $typeList = $this->ParameterType->find('list', array(
                'conditions' => array(
                    'ParameterType.vc_prtype_code' => $vehiclelist),
                'fields' => array('vc_prtype_code', 'vc_prtype_name'),
            ));

			
			$conditions=array();
		$conditions += array('VehicleDetail.vc_vehicle_status' =>'STSTY04');
		
        $conditions += array('VehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'));

		$vehiclelistall = $this->VehicleDetail->find('list', array('conditions' => $conditions,
                    'fields' => array('VehicleDetail.vc_vehicle_lic_no','VehicleDetail.vc_vehicle_reg_no')));
        
				
		$this->set('vehiclelistall', $vehiclelistall);			

            $this->set('vehiclelist', array('' => 'All') + $typeList);
			
			$this->set('nu_company_id', $nu_company_id);

            $this->layout = 'userprofile';

            $this->set('title_for_layout', 'Assessment History Report');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     * 
	 *Function to generate pdf of assessment history
	 *
     */
	 
    function assessmenthistorypdf() {

        try {

           // Configure::write('debug', 2);

            ini_set('memory_limit', '2048M');

            set_time_limit(0);

            $this->loadModel('AssessmentVehicleDetail');
			
            $this->loadModel('Company');

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :

                $fromDate = isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) :
                        '';
            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) :
                        '';

            endif;
			
            if (isset($this->params['named']['vehicletype'])) :

                $vehicletype = trim(($this->params['named']['vehicletype']));

            else :

                $vehicletype = isset($this->data['Report']['vehicletype']) && !empty($this->data['Report']['vehicletype']) ?
                   trim($this->data['Report']['vehicletype']):'';
            endif;
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim(($this->params['named']['nu_company_id']));

            else :

                $nu_company_id = isset($this->data['Report']['nu_company_id']) && !empty($this->data['Report']['nu_company_id']) ?
                        trim($this->data['Report']['nu_company_id']) :
                        '';
            endif;
			
			if (isset($this->params['named']['vehiclelicno'])) :

                $vehiclelicno = trim(ucfirst($this->params['named']['vehiclelicno']));

            else :

                $vehiclelicno = (isset($this->data['Report']['vehiclelicno']) && !empty($this->data['Report']['vehiclelicno'])) ?trim($this->data['Report']['vehiclelicno']) :'';

            endif;
			

            $conditions = array(
                'AssessmentVehicleDetail.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'),
                'AssessmentVehicleDetail.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
            );

            if ($vehiclelicno) :
                $conditions += array(
                    'LOWER(AssessmentVehicleDetail.vc_vehicle_reg_no)' => strtolower(trim($vehiclelicno))
                );
            endif;
			
			if ($fromDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date >= ' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleDetail.dt_created_date <= ' => $toDate,
                );

            endif;

            if ($vehicletype) :

                $conditions += array(
                    'VehicleDetail.vc_vehicle_type' => $vehicletype
                );

            endif;
			
			 if ($nu_company_id) :

                $conditions += array(
                    'AssessmentVehicleDetail.nu_company_id' => $nu_company_id
                );
				
			endif;
			
			$company_name = $this->Company->find('first', array('conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
			'Company.nu_company_id' => $nu_company_id)
			));
			
			$this->Set('company_name',$company_name);

            $assessmentreport = $this->AssessmentVehicleDetail->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'AssessmentVehicleMaster.nu_company_id',
                    'AssessmentVehicleDetail.dt_created_date',
                    'AssessmentVehicleDetail.vc_assessment_no',
                    'AssessmentVehicleDetail.vc_vehicle_lic_no',
                    'AssessmentVehicleDetail.vc_vehicle_reg_no',
                    'VehicleDetail.vc_vehicle_type',
                    'AssessmentVehicleDetail.vc_pay_frequency',
                    'AssessmentVehicleDetail.vc_prev_end_om',
                    'AssessmentVehicleDetail.vc_end_om',
                    'AssessmentVehicleDetail.vc_km_travelled',
                    'AssessmentVehicleDetail.vc_rate',
                    'AssessmentVehicleDetail.nu_company_id',
					'AssessmentVehicleDetail.vc_payable',
                    'AssessmentVehicleMaster.vc_status'
                ),
                'order' => array('AssessmentVehicleDetail.dt_created_date' => 'desc')));

            foreach ($assessmentreport as $key => &$value) {

                $value['VehicleDetail']['VEHICLETYPE']['vc_prtype_name'] = $this->globalParameterarray[trim($value['AssessmentVehicleMaster']['vc_status'])];
            }

            if (!empty($vehicletype)) {
			
                $vehicletypename = $this->globalParameterarray[$vehicletype];
          
			} else {

                $vehicletypename = '';
            }
			
			if (empty($nu_company_id)){
			
				$columnsHeadings = array('SI. No.', 'Company Name', 'Assessment Date', 'Assessment No.',
					'Vehicle LIC. No.', 'Vehicle Register No.',
					'Vehicle Type', 'Pay Frequency', 'Prev. End OM',
					'End OM', 'KM Travel on Namibian Road Network',
					'Rate(N$)', 'Payable(N$)', 'Status'
				);
				
			}else{
			
				$columnsHeadings = array('SI. No.', 'Assessment Date', 'Assessment No.',
					'Vehicle LIC. No.', 'Vehicle Register No.',
					'Vehicle Type', 'Pay Frequency', 'Prev. End OM',
					'End OM', 'KM Travel on Namibian Road Network',
					'Rate(N$)', 'Payable(N$)', 'Status'
				);
			
			}

            $this->Mdcreportpdfcreator->headerData('Vehicle Assessment History Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate, $id=NULL, $nu_company_id,$vehiclelicno);
			
			$this->Mdcreportpdfcreator->genrate_mdc_vehicleassessreport($columnsHeadings, $assessmentreport, 
			$this->globalParameterarray, $toDate, $fromDate, $vehicletypename, $nu_company_id, $this->CompanyId,$vehiclelicno);
            
			$this->Mdcreportpdfcreator->output('Vehicle-Assessment-Report' . '.pdf', 'D');
            
			exit();
			
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /**
     * 
     *
     */
    function paymenthistory() {

        try{
		
			$nu_company_id = $this->Session->read('nu_company_id');
			
			$this->Set('nu_company_id',$nu_company_id);

            $this->loadModel('AssessmentVehicleMaster');
			
			$this->loadModel('Company');

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Report']['fromdate']) && !empty($this->data['Report']['fromdate']) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromdate'])) :
                        '';
            endif;

            if (isset($this->params['named']['todate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['todate']));

            else :

                $toDate = isset($this->data['Report']['todate']) && !empty($this->data['Report']['todate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['todate'])) :
                        '';

            endif;
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim(ucfirst($this->params['named']['nu_company_id']));

            else :

                $nu_company_id = isset($this->data['Report']['nu_company_id']) && !empty($this->data['Report']['nu_company_id']) ?
                        trim($this->data['Report']['nu_company_id']) :
                        '';
            endif;

            $conditions = array(
                'AssessmentVehicleMaster.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'AssessmentVehicleMaster.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'));

            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date <=' => $toDate
                );


            endif;
			
			if ($nu_company_id) :

                $conditions += array(
                    'AssessmentVehicleMaster.nu_company_id' => $nu_company_id
                );
			
			endif;
			
            $limit = 10;

            $this->paginate = array(
                'conditions' => $conditions,
                'fields' => array(
					'AssessmentVehicleMaster.nu_company_id',
                    'AssessmentVehicleMaster.vc_assessment_no',
                    'AssessmentVehicleMaster.dt_assessment_date',
                    'AssessmentVehicleMaster.nu_total_payable_amount',
                    'AssessmentVehicleMaster.vc_mdc_paid',
                    'AssessmentVehicleMaster.nu_variance_amount',
                    'AssessmentVehicleMaster.dt_received_date',
                    'PaymentStatus.vc_prtype_name'
                ),
                'order' => array('AssessmentVehicleMaster.dt_received_date' => 'desc'),
                'limit' => $limit
            );


            $pagecounter = (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) ? $this->params['named']['page'] : 1;
			
			$company_name = $this->Company->find('first', array('conditions' => array(
															'Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
															'Company.nu_company_id' => $nu_company_id)
															));
			
			$this->Set('company_name',$company_name);
			
            $this->set('pagecounter', $pagecounter);
			
            $this->set('nu_company_id', $nu_company_id);

            $this->set('limit', $limit);
			//pr($this->paginate('AssessmentVehicleMaster'));
            $this->set('paymentreport', $this->paginate('AssessmentVehicleMaster'));

            $this->set('fromDate', $fromDate);

            $this->set('toDate', $toDate);

            $this->layout = 'userprofile';

            $this->set('title_for_layout', 'Payment History Report');
			
        }catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

    /*
     * 
     *
     */

    function paymenthistorypdf() {

        try {

            $this->loadModel('AssessmentVehicleMaster');
			
			$this->loadModel('Company');

            if (isset($this->params['named']['fromDate'])) :

                $fromDate = date('d-M-Y', strtotime($this->params['named']['fromDate']));

            else :
                $fromDate = isset($this->data['Report']['fromDate']) && !empty($this->data['Report']['fromDate']) ?
                        date('d-M-Y', strtotime($this->data['Report']['fromDate'])) :
                        '';
            endif;

            if (isset($this->params['named']['fromDate'])) :

                $toDate = date('d-M-Y 23:59:59', strtotime($this->params['named']['toDate']));

            else :

                $toDate = isset($this->data['Report']['toDate']) && !empty($this->data['Report']['toDate']) ?
                        date('d-M-Y 23:59:59', strtotime($this->data['Report']['toDate'])) :
                        '';

            endif;
			
			if (isset($this->params['named']['nu_company_id'])) :

                $nu_company_id = trim(ucfirst($this->params['named']['nu_company_id']));

            else :

                $nu_company_id = isset($this->data['Report']['nu_company_id']) && !empty($this->data['Report']['nu_company_id']) ?
                        trim($this->data['Report']['nu_company_id']) :
                        '';
            endif;

            $conditions = array(
                'AssessmentVehicleMaster.vc_customer_no' => $this->Session->read('Auth.Profile.vc_customer_no'),
                'AssessmentVehicleMaster.vc_comp_code' => $this->Session->read('Auth.Profile.vc_comp_code'));


            if ($fromDate):

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date >=' => $fromDate,
                );

            endif;

            if ($toDate) :

                $conditions += array(
                    'AssessmentVehicleMaster.dt_received_date <=' => $toDate
                );


            endif;
			
			if ($nu_company_id) :

                $conditions += array(
                    'AssessmentVehicleMaster.nu_company_id' => $nu_company_id
                );
				
			endif;
			
			$company_name = $this->Company->find('first', array('conditions' => array('Company.vc_username' => $this->Session->read('Auth.Member.vc_username'),
			'Company.nu_company_id' => $nu_company_id)
			));
			
			$this->Set('company_name',$company_name);

            $paymentreport = $this->AssessmentVehicleMaster->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'AssessmentVehicleMaster.vc_assessment_no',
                    'AssessmentVehicleMaster.dt_assessment_date',
                    'AssessmentVehicleMaster.nu_total_payable_amount',
                    'AssessmentVehicleMaster.vc_mdc_paid',
                    'AssessmentVehicleMaster.nu_variance_amount',
                    'AssessmentVehicleMaster.nu_company_id',
                    'AssessmentVehicleMaster.dt_received_date',
                    'PaymentStatus.vc_prtype_name'
                ),
                'order' => array('AssessmentVehicleMaster.dt_received_date' => 'desc')));
            
			
			if (empty($nu_company_id)){
            
				$columnsHeadings = array('SI. No.', 'Company Name', 'Assessment No.', 'Assessment Date',
					'Payable Amount (N$)', 'Paid Amount (N$)', 'Variance Amount (N$)',
					'Payment Date', 'Payment Status'
				);
				
			}else{
			
				$columnsHeadings = array('SI. No.', 'Assessment No.', 'Assessment Date',
					'Payable Amount (N$)', 'Paid Amount (N$)', 'Variance Amount (N$)',
					'Payment Date', 'Payment Status'
				);
				
			}

            $this->Mdcreportpdfcreator->headerData('Vehicle Payment History Report', $period = NULL, $this->Session->read('Auth'), $toDate, $fromDate,$id=1, $nu_company_id);
            $this->Mdcreportpdfcreator->genrate_mdc_vehiclepayreport($columnsHeadings, $paymentreport, $this->globalParameterarray, $toDate, $fromDate, $nu_company_id, $this->CompanyId);
            $this->Mdcreportpdfcreator->output('Vehicle-Payment-Report' . '.pdf', 'D');
            exit;
            //$this->layout = 'pdf';
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";

            exit;
        }
    }

}