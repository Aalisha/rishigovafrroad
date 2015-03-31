<?php

/**
 * Company Code model.
 *
 * 
 */
class BranchCode extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'BranchCode';

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
    var $useTable = "PR_MST_COMPANY_CODE";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_comp_code';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
	
	var $validate = array();
  
}