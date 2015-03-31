<?php
/**
 * 
 * CBC Master Customer Detail ERP
 * 
 */
class CbcCustomerDetailsErp extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'CbcCustomerDetailsErp';

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
    var $useTable = "HD_CUST_VEHICLE_CARD_ERP";

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