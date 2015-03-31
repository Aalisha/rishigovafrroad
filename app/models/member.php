<?php

/**
 * Member model.
 *
 * 
 */
class Member extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Member';

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
    var $useTable = "PR_DT_USERS_DETAILS_ALL";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_user_no';
	
    public $hasOne = array(
        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => false,
            'conditions' => array('Profile.vc_customer_no = Member.vc_mdc_customer_no')
    ));

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
        'vc_user_firstname' => array(
            'length' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'message' => 'Use between 2 and 50 characters',
            ),
            
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		'vc_user_firstname1' => array(
            'length' => array(
                'rule' => array('between', 2, 100),
                'required' => true,
                'message' => 'Use between 2 and 100 characters',
            ),
            
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
		
		
        'vc_user_lastname' => array(
            'length' => array(
                'rule' => array('between', 2, 50),
                'required' => true,
                'message' => 'Use between 2 and 50 characters',
            ),
           
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
        'vc_email_id' => array(
            'length' => array(
                'rule' => array('between', 3, 50),
                'required' => true,
                'message' => 'Use between 6 and 50 characters',
            ),
            'customUnique' => array(
                'rule' => 'checkEmailUnique',
                'message' => ' Email Id already in use'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Must be a valid email address',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
        'vc_comp_code' => array(
            'codeexist' => array(
                'rule' => 'notEmpty',
                'message' => 'Invalid Type '
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please Select account type'
            )
        ),
        'vc_username' => array(
            'length' => array(
                'rule' => array('between', 9, 30),
                'required' => true,
                'message' => 'Username must be  between 9 to 30 characters'
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter username'
            ),
            'name' => array(
                'rule' => 'alphaNumericDash',
                'message' => 'Username can only be letters, numbers, dash and underscore'
            )
        ),
        'vc_password' => array(
            'length' => array(
                'rule' => array('between', 6, 50),
                'required' => true,
                'message' => 'Use between 6 and 50 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter password',
            ),
        ),
        'vc_captcha_code' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Enter code',
            ),
            'match' => array(
                'rule' => 'checkCaptcha',
                'message' => ' Invalid Code '
            )
        ),
        'vc_email_id_frgt' => array(
            'customUnique' => array(
                'rule' => 'checkEmailExist',
                'message' => 'Email id does not exist in RFA Database'
            ),
            'length' => array(
                'rule' => array('between', 3, 50),
                'required' => true,
                'message' => 'Use between 3 and 50 characters',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Must be a valid email address',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
        ),
    );

    function alphaNumericDash($check) {
        $value = array_shift($check);
        return preg_match('|^[0-9a-zA-Z-]*$|', $value);
    }

    function checkCaptcha($data) {

        if ($data['vc_captcha_code'] == @$_SESSION['captcha_text']) {

            return true;
        }
        return false;
    }

    var $__checkpattern = array(
        'hostname' => '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)'
    );

    function checkEmailUnique($data) {

        $BranchCode = ClassRegistry::init('BranchCode');
       
        App::import('Model', 'Customer');
       
	   $Customer = new Customer();

        if ($BranchCode->find('count', array('conditions' => array(
                        'BranchCode.vc_comp_code' => $this->data['Member']['vc_comp_code'],
                        'BranchCode.vc_client_code like' => 'mdc%'))) > 0 || $BranchCode->find('count', array('conditions' => array(
                        'BranchCode.vc_comp_code' => $this->data['Member']['vc_comp_code'],
                        'BranchCode.vc_client_code like' => 'cbc%'))) > 0) {

            $companyCodecbc = Configure::read('companyCodecbc');
           
            $this->unbindModel(array('hasOne' => array('Profile')));
           
			if ($this->data['Member']['vc_comp_code'] == $companyCodecbc) {

                $countResult = $this->find('count', array(
                    'conditions' => array('Member.vc_email_id' => $data['vc_email_id'],
                        'Member.vc_comp_code' => $this->data['Member']['vc_comp_code']
                )));

                $countResultcustomer = $Customer->find('count', array(
                    'conditions' => array(
                        array('Customer.vc_alter_email' => $data['vc_email_id']),
                        'Customer.vc_comp_code' => $this->data['Member']['vc_comp_code']
                )));
                if ($countResult == 0 && $countResultcustomer == 0) {

                    return true;
                }
                return false;
            } else {

                $countResult = $this->find('count', array(
                    'conditions' => array(
                        'Member.vc_email_id' => $data['vc_email_id'],
                        'Member.vc_comp_code' => $this->data['Member']['vc_comp_code']
                )));
                if ($countResult == 0) {

                    return true;
                }

                return false;
            }
        } elseif ($BranchCode->find('first', array('conditions' => array(
                        'BranchCode.vc_comp_code' => $this->data['Member']['vc_comp_code'],
                        'BranchCode.vc_client_code like' => 'flr%'))) > 0) {
						
						if($this->data['Member']['wholesaler_supplier']==1){
							$countsupplier = $this->find('count', array(
							'conditions' => array(
							'Member.vc_email_id' => $data['vc_email_id'],
							'Member.vc_comp_code' => $this->data['Member']['vc_comp_code'],
							'Member.vc_user_login_type' => 'USRLOGIN_SUPL'
							
							)));
							if($countsupplier>0){
								
						
								return false;
							}
							else{
								
								return true;
							}
						
						}
						else{
						return true;
						}
						//pr($this->data);

            
        }

        return false;
    }

    function checkEmailExist($data) {

        $resultCheck = $this->find('first', array(
            'conditions' => array(
                'Member.vc_email_id' => trim($data['vc_email_id_frgt']),
                'Member.vc_comp_code' => $this->data['Member']['vc_comp_code'],
                'Member.vc_user_login_type !=' => 'USRLOGIN_INSP',
                'Member.vc_user_status' => 'USRSTATUSACT'
        )));
        if ($resultCheck) {

            return true;
        } else {

            return false;
        }
    }

    function codeexist($data) {

        if ($BranchCode->find('first', array('conditions' => array(
                        'BranchCode.vc_comp_code' => $data['vc_comp_code']
            ))) > 0) {

            return true;
        }

        return false;
    }

}