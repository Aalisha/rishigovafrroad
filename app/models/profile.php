<?php

/**
 * Profile model.
 *
 * 
 */
class Profile extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Profile';

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
    var $useTable = "MST_CUSTOMER_DETAILS_MDC";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_customer_no';

    /**
     * Model Belongs to relation Many to One relation
     *
     * @var string
     * @access public
     */
    public $belongsTo = array(
        'VC_CUST_TYPE' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'vc_cust_type',
        ),
        'Status' => array(
            'className' => 'ParameterType',
            'foreignKey' => 'CH_ACTIVE',
        ));
		  

    /* public $hasMany = array(

      'VEHICLES' => array(

      'className' => 'VehicleDetail',

      'foreignKey' => 'vc_customer_no',

      'conditions'=>array('VEHICLES.vc_vehicle_status'=>'STSTY04'),

      'group' => 'VEHICLES.vc_customer_no '
      ));
     */

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'vc_old_password' => array(
            'match' => array(
                'rule' => 'checkOldPassword',
                'message' => 'Incorrect old password.',
            ),
            'length' => array(
                'rule' => array('between', 6, 30),
                'required' => true,
                'message' => 'Use between 6 and 30 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter old password',
            )
        ),
        'vc_password' => array(
            'length' => array(
                'rule' => array('between', 6, 30),
                'required' => true,
                'message' => 'Use between 6 and 30 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter password',
            )
        ),
        'vc_confirm_password' => array(
            'length' => array(
                'rule' => array('between', 6, 30),
                'required' => true,
                'message' => 'Use between 6 and 30 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter confirm password',
            ),
            'match' => array(
                'rule' => 'matchPassword',
                'message' => 'Password not matched'
            )
        ),
        'vc_customer_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            ),
            'customUnique' => array(
                'rule' => 'checkCustomerId',
                'message' => 'Customer Id is already in use'
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
        /* 'vc_bank_supportive_doc' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Required',
            )
        ), */
        'vc_customer_name' => array(
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
        'vc_tel_no' => array(
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
        'vc_fax_no' => array(
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
        )
    );

    function matchPassword($data) {

        if ($data['vc_confirm_password'] == $this->data['Profile']['vc_password']) {

            return true;
        }

        $this->validates('vc_password', 'Not match confirm password ');
        return false;
    }

	
	function checkbusinessidRequired(){
		
		if(isset($this->data['Profile']['vc_cust_type']) && $this->data['Profile']['vc_cust_type']=='CUSTYPE01'){
		
		  if($this->data['Profile']['vc_business_reg']!='')
			return true;
			else
			return false;
		}
		return true;
	
	}
	
	
    function checkCustomerId($data) {

        App::import('Model', 'CakeSession');

        $Session = new CakeSession();

        $conditions = array();

        if ($Session->read('Auth.Profile.ch_active') == 'STSTY05') :

            $conditions += array('Profile.vc_user_no !=' => $Session->read('Auth.Profile.vc_user_no'));

        endif;
		$vc_customer_id=	strtolower(trim($data['vc_customer_id']));
        $conditions += array("LOWER(Profile.vc_customer_id)= '".$vc_customer_id."'");

      $count = $this->find('count', array('conditions' => $conditions));

        if ($count == 0):

            return true;

        endif;

        return false;
    }

    function checkOldPassword($data) {

        $Member = ClassRegistry::init('Member');
        App::import('Model', 'CakeSession');
        $Session = new CakeSession();
        $queryResult = $Member->find('first', array(
            'conditions' => array(
                'Member.vc_username' => $Session->read('Auth.Member.vc_username'),
                'Member.vc_password' => AuthComponent::password($data['vc_old_password'])
        )));

        if ($queryResult) {

            return true;
        }

        return false;
    }

}