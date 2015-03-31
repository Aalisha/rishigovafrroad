<?php
/**
 * Generate Password  Model  
 */
class Generatepassword extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Generatepassword';

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
    var $useTable = false;

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = false;
	
	/**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(
		
		'password'=>array(			
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
		'confirmpassword'=>array(
			'compare'=>array(
				'rule'=>'comparePassword',
				'message'=>'Should be equal to password'
			),			
			'length' => array(
                'rule' => array('between', 6, 50),
                'required' => true,
                'message' => 'Use between 6 and 50 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please Confirm password',
            ),
		
		)        
    );
	
	function comparePassword($data){
		return trim($this->data[$this->name]['password']) == trim(current(($data))); 
	}

 }