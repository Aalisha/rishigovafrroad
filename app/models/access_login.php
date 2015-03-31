<?php
/**
 *  Access Login  Model  
 */
class AccessLogin extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'AccessLogin';

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
    var $useTable = 'PR_MST_ACCESS_LOGIN';

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'NU_ID';
	
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
                'rule' => array('between', 1, 50),
                'required' => true,
                'message' => 'Use between 1 and 50 characters',
            ),
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter password',
            ),
		
		),
		'username'=>array(
			'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please enter username',
            ),
		
		)        
    );
 }