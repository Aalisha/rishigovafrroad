<?php

/**
 * Registration model.
 *
 * 
 */
class Assessment extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'Assessment';

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
    var $primaryKey = false;

}