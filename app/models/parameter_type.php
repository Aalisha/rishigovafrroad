<?php

/**
 * Parameter Type model.
 *
 * 
 */
class ParameterType extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ParameterType';

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
    var $useTable = "PR_MST_PARAMETER_TYPE";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_prtype_code';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
	
	var $validate = array();
  
}