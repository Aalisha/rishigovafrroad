<?php
/**
 * 
 * Customer location Distance
 * 
 */
class CustomerLocationDistance extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'CustomerLocationDistance';

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
    var $useTable = "LOCATION_DISTANCE";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = null;

    /**
     * validate name
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */

    var $validate = array();

  }