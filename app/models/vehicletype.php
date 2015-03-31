<?php

/**
 * Registration model.
 *
 * 
 */
class Vehicletype extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Vehicle';

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
    var $useTable = "PR_VEHICLE_TYPE_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= false;

    
  
}