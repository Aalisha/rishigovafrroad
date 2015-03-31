<?php 
/**
 *	
 * Client Fuel Outlets Model.
 * 
 */
class ClientFuelOutlet extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'ClientFuelOutlet';

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
    var $useTable = 'MST_CLIENT_FUEL_FLR';
    
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
    var $validate = array(
		
		'fueloutlets' => array(
		
			'outlets' => array(
				
				'rule' => array('multiple', array('in'=>array(0,1,2),'min' => 1)),
				
				'required' => true, 
				
				'message' => 'Required'
			)		
        ) 
	
	);
	
	
        	
}