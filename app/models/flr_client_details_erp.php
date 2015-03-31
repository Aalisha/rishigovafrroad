<?php
/**
 * 
 * Flr Master Client Detail ERP
 * 
 */
class FlrClientDetailsErp extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'FlrClientDetailsErp';

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
    var $useTable = "MST_CLIENT_ERP";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = false;

    /**
     * validate name
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */

    var $validate = array();
}