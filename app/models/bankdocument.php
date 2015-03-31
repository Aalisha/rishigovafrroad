<?php

/**
 * Registration model.
 *
 * 
 */
class Bankdocument extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Bankdocument';

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
    var $useTable = "PR_BANK_DOCS_MDC";
    
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
   

}