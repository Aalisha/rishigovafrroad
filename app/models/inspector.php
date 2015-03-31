<?php

/**
 * Registration model.
 *
 * 
 */
class Inspector extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Inspector';

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
    
    var $primaryKey= 'vc_user_no';
	
	
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
                'rule' => array('between', 2, 40),
                'required' => true,
                'message' => 'Use between 2 and 40 characters',
            ),
            /*'name' => array(
                'rule' => '/^[a-zA-Z]+$/',
                'required' => true,
                'message' => 'Only Alphabetic character are allowed '
            ),*/
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
            
        ),
        'vc_user_lastname' => array(
           
            'length' => array(
                'rule' => array('between', 2, 40),
                'required' => true,
                'message' => 'Use between 2 and 40 characters',
            ),
            /*'name' => array(
                'rule' => '/^[a-zA-Z]+$/',
                'message' => 'Only Alphabetic character are allowed '
            ),*/
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )
            
        ),
        'vc_email_id' => array(
		
		    'length' => array(
                'rule' => array('between', 3, 40),
                'required' => true,
                'message' => 'Use between 6 and 40 characters',
            ),
		
            'customUnique'=>array(
			
				'rule' => 'checkEmailUnique',
                
                'message' => ' Email Id already in used'
				
			),
            'email' => array(
                'rule' => 'customEmailType',
                'message' => 'Invalid email address(..@rfanam.com.na)',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Must not be blank',
            )			
        ),
        'vc_comp_code' => array(
				'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please Select account type',
        ),
        
        'vc_username' => array( 
		
         'length' => array(
               'rule' => array('between', 9, 15),
              'required' => true,
                'message' => 'Username must be  between 9 to 15 characters'
           ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter username'
            ),
            'checkUserName' =>array(
				'rule' => 'checkUserName',
                'message' => 'Invalid username'
			) ,
           'name' => array(
				'rule' => 'alphaNumericDash',
				'message' => 'Username can only be letters, numbers, dash and underscore'
			)
        ),
        'vc_password' => array(          
            'length' => array(
                'rule' => array('between', 6, 30),
                'required' => true,
                'message' => 'Use between 6 and 30 characters',
            ),
			'checkPassword' =>array(
				'rule' => 'checkPassword',
                'message' => 'Invalid password'
			) ,
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
		
		    'customUnique'=>array(
				'rule' => 'checkEmailExist',
                'message' => 'Email id does not exist in RFA Database'
			),
			'length' => array(
                'rule' => array('between', 3, 30),
                'required' => true,
                'message' => 'Use between 3 and 30 characters',
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
    
	/**
	 *
	 *
	 */
    function alphaNumericDash($check)
    {
         $value = array_shift($check);
         return preg_match('|^[0-9a-zA-Z-]*$|', $value);
    }
	
	/**
	 *
	 *
	 */
	
	function checkCaptcha($data){
		
		if( $data['vc_captcha_code'] == $_SESSION['captcha_text'] ){
		
			return true;
		
		}
		return false;
	
	}
	
	/**
	 *
	 *
	 */
	
	function checkEmailUnique($data){
		
		$BranchCode = ClassRegistry::init('BranchCode');
		
		$branchCount = $BranchCode->find('count', array( 
									'conditions' => array(
										'BranchCode.vc_comp_code'=>$this->data['Inspector']['vc_comp_code'],
										)));
				
		if($branchCount > 0 ) {
	
			$coutResult = $this->find('count',array('conditions'=>array(
											'Inspector.vc_comp_code'=>$this->data['Inspector']['vc_comp_code'],
											'Inspector.vc_email_id'=>$data['vc_email_id'],
											'Inspector.vc_user_login_type'=>'USRLOGIN_INSP'
										
										)));
			
			if($coutResult == 0){

				return true;
			
			
			}	

		}

		return false;	
	
		
	}
	
	/**
	 *
	 *
	 */
	
	function checkEmailExist($data){
			
			$resultCheck = $this->find('first',array(
														'conditions'=>array(
															'Inspector.vc_email_id'=>trim($data['vc_email_id_frgt']),
															'Inspector.vc_comp_code'=>$this->data['Inspector']['vc_comp_code'],
															'Inspector.vc_user_status' =>'USRSTATUSACT',
															'Inspector.vc_user_login_type'=>'USRLOGIN_INSP'
														)));

			if($resultCheck){
	
				return true;

			} else {
			
			 return false;  
			
			}
	}
	
	/**
	  * Below Default Email Pattern 
	  * var $__pattern = array(
				'hostname' => '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)'
		);
	  */
	 var $__pattern  = array('hostname' => 'rfanam.com.na');
	 
	 function customEmailType($data) {
	
	    $pattern = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $this->__pattern['hostname'] . '$/i';
		
		if( preg_match($pattern,$data['vc_email_id'] ) ) {
		
					return true;
		}
		
		return false;
	}
	
	
	/**
	 *
	 *
	 *
	 */
	 
	 function checkUserName($data){
	 
		$count = $this->find('count',array('conditions'=>array('Inspector.vc_username'=>$data['vc_username'], 'Inspector.vc_user_status' =>'USRSTATUSACT', 'Inspector.vc_user_login_type'=>'USRLOGIN_INSP')));
		if( $count  > 0) {
			
			return true;
		
		}
		
		return false;
	 }
	 
     /**
	 *
	 *
	 *
	 */	 
	 function checkPassword ($data) {
	 
		$count = $this->find('count',array('conditions'=>array('Inspector.vc_username'=>$this->data['Inspector']['vc_username'], 'Inspector.vc_password'=> AuthComponent::password($data['vc_password']), 'Inspector.vc_user_status' =>'USRSTATUSACT', 'Inspector.vc_user_login_type'=>'USRLOGIN_INSP')));
		if( $count  > 0) {
			
			return true;
		
		}
		
		return false;
	 
	 }
	 

}