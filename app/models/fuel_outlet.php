<?php
/**
 * 
 * Fuel Outlet
 * 
 */
class FuelOutlet extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'FuelOutlet';

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
    var $useTable = 'FULE_OUTLET_FLR';
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_fuel_outlet';
    
	
    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array();
  	
}