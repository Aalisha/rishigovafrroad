<?php
/**
 * 
 * Bank Branch
 * 
 */
class BankBranch extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'BankBranch';

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
    var $useTable = 'BANK_BRANCH_LIST_FLR';
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= FALSE;
    
	
    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array();
  	
}