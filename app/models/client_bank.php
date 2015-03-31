<?php
/**
 * Client Bank model.
 *
 * 
 */
class ClientBank extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClientBank';

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
    var $useTable = 'MST_BANK_FLR';
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= false;
	
	
	/**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
		
		'vc_account_holder_name'=>array(
		
			'length' => array(
			
				'rule' => array('between', 1, 100),
				
				'required' => true,
				
				'message' => 'Please keep this field below 100 characters.',
			),
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required',
            )
		),
		'vc_bank_account_no'=>array(
			
			'length' => array(

				'rule' => array('between', 1, 25),

				'required' => true,

				'message' => 'Please keep this field below 25 characters.',
			),
			'characters' => array(

				'rule'     => 'alphaNumeric',

				'message'  => 'Alphanumeric characters only'
			),
			'required' => array(

				'rule' => 'notEmpty',

				'required' => true,

				'message' => 'Required'
			)
		),
		'vc_account_type'=>array(
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required'
            )
		),
		'vc_bank_name'=>array(
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required'
            )
		),
		'vc_branch_code'=>array(
		
			'characters' => array(

				'rule'     => 'alphaNumeric',

				'message'  => 'Alphanumeric characters only'
			),
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required'
            )
		),		
		'vc_bank_branch_name'=>array(
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required'
            )
		
		)
	);
        	
}