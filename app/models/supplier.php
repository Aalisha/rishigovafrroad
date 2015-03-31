<?php
/**
 * Registration model.
 *
 * 
 */
class Supplier extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Supplier';

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
    var $useTable = "MST_SUPPLIER_FLR";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    
    var $primaryKey= 'vc_invoice_no';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array();
     

}