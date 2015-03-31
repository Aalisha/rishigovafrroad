<?php

/**
 * Registration model.
 *
 * 
 */
class Bank extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Bank';

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
    var $useTable = "BANK_LIST";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_struct_code';    

}