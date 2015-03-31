<?php
/**
 * 
 * MDC Master Customer Detail ERP
 * 
 */
class MstCustomerDetailsErp extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'MstCustomerDetailsErp';

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
    var $useTable = "MST_CUSTOMER_DETAILS_ERP";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_mdc_customer_no';

    /**
     * validate name
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */

    var $validate = array();
}