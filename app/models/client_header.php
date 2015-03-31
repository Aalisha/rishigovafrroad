<?php
/**
 * Client Header model.
 *
 * 
 */
class ClientHeader extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClientHeader';

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
    var $useTable = 'HD_REGISTRATION_FLR';
	
	 /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $hasOne= array(
	
			'Client'=>array(
					
					'className' => 'Client',
					
					'dependent' => true,
					
					'foreignKey'  => false,
					
					'conditions'=>array('ClientHeader.vc_client_no = Client.vc_client_no '),
					
		
			));
    
    
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
				
		'vc_cateogry'=>array(
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				 'message' => 'Required',
            )
		
		),
		
		'nu_refund'=>array(
			
			
			'length' => array(
			
				'rule' => array('between', 0, 10),
				
				'required' => false,
				
				'message' => 'Please keep this field below 10 characters.',
			),
			
			'numeric'=>array(
				
				'rule' => 'numeric',
								
				'message'=>'Refund should be numeric'
			
			
			), 
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required',
            )
		
		),
		
		'nu_fuel_usage'=>array(
			
			'notDecimalOlyNumber'=>array(
			
				'rule' => 'notDecimalOlyNumber',
								
				'message'=>'Decimal not accepted'
			
										
			),
			'length' => array(
			
				'rule' => array('between', 0, 10),
				
				'required' => false,
				
				'message' => 'Please keep this field below 10 characters.',
			),
			'numeric'=>array(
				
				'rule' => 'numeric',
								
				'message'=>'Fuel Usage Prev. Year should be numeric'
			
			
			), 
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required',
            )
		
		),
		
		'nu_expected_usage'=>array(
		
			'notDecimalOlyNumber'=>array(
			
				'rule' => 'notDecimalOlyNumber',
								
				'message'=>'Decimal not accepted'
			
										
			),
			
			'length' => array(
			
				'rule' => array('between', 0, 10),
				
				'required' => false,
				
				'message' => 'Please keep this field below 10 characters.',
			),	
			
			'numeric'=>array(
				
				'rule' => 'numeric',
								
				'message'=>'Expected Usages Next Year should be numeric'
			
			
			), 
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required',
            )
		
		),
		
		'nu_off_road_usage'=>array(
		
			'notDecimalOlyNumber'=>array(
			
				'rule' => 'notDecimalOlyNumber',
								
				'message'=>'Decimal not accepted'
			
										
			),	
			
			'length' => array(
			
				'rule' => array('between', 0, 10),
				
				'required' => false,
				
				'message' => 'Please keep this field below 10 characters.',
			),	
			
			'numeric'=>array(
				
				'rule' => 'numeric',
								
				'message'=>'Off Road Usage Prev. Year should be numeric'
			
			
			), 
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required',
            )
		
		),
		
		'nu_off_expected_usage'=>array(
		
		
			'notDecimalOlyNumber'=>array(
			
				'rule' => 'notDecimalOlyNumber',
								
				'message'=>'Decimal not accepted'
			
										
			),	
			
			'length' => array(
			
				'rule' => array('between', 0, 10),
				
				'required' => false,
				
				'message' => 'Please keep this field below 10 characters.',
			),	
			
			'numeric'=>array(
				
				'rule' => 'numeric',
								
				'message'=>'Off Road Usages Next Year should be numeric'
			
			
			), 
			
			'required' => array(
           
				'rule' => 'notEmpty',
                
				'required' => true,
                
				'message' => 'Required',
            )
		
		),

			
	);
	
	/**
	 *
	 *
	 */
	 
	 function notDecimalOlyNumber($data){
	 
		return preg_match('/^\+?(0|[0-9]\d*)$/', current($data));
	 
	 }
        	
}