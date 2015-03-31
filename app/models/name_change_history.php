<?php
/**
 * Client Change History model.
 *
 * 
 */
class NameChangeHistory extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'NameChangeHistory';

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
    var $useTable = 'MST_CUSTOMER_AMENDMENTS_MDC';
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'VC_CUST_AMEND_NO';
	   
	/**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    
	
}