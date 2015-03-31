<?php

/**
 * Company Code model.
 *
 * 
 */
class Company extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Company';

    /**
     * Model Database Configuration
     *
     * @var string
     * @access public
     */
    var $useDbConfig = 'default';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "MST_COMPANY_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'nu_company_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
	
	var $validate = array(
	
		'vc_company_name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            ),
            'customUnique' => array(
                'rule' => 'checkCompany',
                'message' => 'Company name is already in use'
            )
        ),
		'vc_business_reg' => array(
			'rule' => array('checkbusinessidRequired'),
			'message' => 'Required',
		),
		/*'vc_business_reg' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        )*/
		'vc_cust_type' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
		'vc_tel_no' => array(
            'length' => array(
                'rule' => array('maxLength', 15),
                'required' => true,
                'message' => 'Use maximum 15 characters',
            )
        ),
        'vc_fax_no' => array(
            'length' => array(
                'rule' => array('maxLength', 15),
                'required' => true,
                'message' => 'Use maximum 15 characters',
            )
        ),
        'vc_mobile_no' => array(
            'length' => array(
                'rule' => array('between', 7, 15),
                'required' => true,
                'message' => 'Use between 7 and 15 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),		
		'vc_bank_struct_code' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
		'vc_account_no' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
		'vc_address1' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ),
		/*'vc_uploaded_doc_name'=>array(
			'size' => array(
			'rule' => array('fileSize', '<', '2MB'),
			'message' => 'Files must not be larger than 2MB'
			)
		)*/
	);
	
	function checkbusinessidRequired(){
		
		if(isset($this->data['Company']['vc_cust_type']) && $this->data['Company']['vc_cust_type']=='CUSTYPE01'){
				//pr($this->data);die;
		if($this->data['Company']['vc_business_reg']!='')
			return true;
			else
			return false;
		}
		return true;
	
	}
	/*
     *
     *Function to check file size
	 *
     */
		/*
	 function fileSize($data){
	  //  pr($data);
		if(isset($data['vc_uploaded_doc_name']['name']) && $data['vc_uploaded_doc_name']['name']!='')
		return ( (int) $data['vc_uploaded_doc_name']['size'] <= 2048000 );

	}*/
	
	/*
	function checkCustomerBusinessregid($data) {

        App::import('Model', 'CakeSession');

        $Session = new CakeSession();

        $conditions = array();

        if ($Session->read('Auth.Profile.ch_active') == 'STSTY05') :

            $conditions += array('Profile.vc_user_no !=' => $Session->read('Auth.Profile.vc_user_no'));

        endif;
		$vc_customer_id=	strtolower(trim($data['vc_customer_id']));
        $conditions += array("LOWER(Profile.vc_customer_id)= '".$vc_customer_id."'");

        'cony=='.$count = $this->find('count', array('conditions' => $conditions));

        if ($count == 0):

            return true;

        endif;

        return false;
    }
	*/
	/*
	*
	*Function to check unique company
	*
	*/
		
	function checkCompany($data) {

        App::import('Model', 'CakeSession');
        
		App::import('Model', 'Profile');

		$Profile = new Profile();
        
		$Session = new CakeSession();

        $conditions = array();
		
		$vc_company_name =	strtolower(trim($data['vc_company_name']));
		
        $conditions += array("LOWER(Company.vc_company_name)= '".$vc_company_name."'");
		
		$nu_company_id = $Session->read('Auth.Profile.nu_company_id');
		
		//pr($Session->read('Auth.Profile.nu_company_id'));
		
		$profile = $Profile->find('first', array('conditions' => array('Profile.vc_user_no' => $Session->read('Auth.Member.vc_user_no'))));

		if($profile['Profile']['ch_active'] == 'STSTY05'){
		
			$companydetail = $this->find('first',array('conditions' => array('Company.nu_company_id' =>$nu_company_id,
				)));
	
			$compid = $companydetail['Company']['nu_company_id'];
		
			$conditions += array('NOT' => array('Company.nu_company_id' => $compid));
		
		}
		
		if(isset($this->data['Company']['nu_company_id']) && $this->data['Company']['nu_company_id']!=''){
		
			$company_id = $this->data['Company']['nu_company_id'];
		
		}else{
		
			$company_id = '';
		}
		
		if($company_id > 0){
				
			$conditions += array('NOT' => array('Company.nu_company_id' => $company_id));
			
		}

        $count = $this->find('count', array('conditions' => $conditions));

        if ($count == 0):

            return true;

        endif;

        return false;
    }
	
	/*
	*
	*Function to generate primary key
	*
	*/
	
	function getPrimaryKey() {

        $count = $this->find('count');
        $primaryKey = $count + 1;

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = $i;

                $returnValue = $this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey)));

                if ($returnValue == 0) {

                    break;
                }

                $i++;
            }

            return $primaryKey;
        } else {

            return $primaryKey;
        }
    }
  
}