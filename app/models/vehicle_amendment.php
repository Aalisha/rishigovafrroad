<?php

/**
 * Registration model.
 *
 * 
 */
class VehicleAmendment extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleAmendment';

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
    var $useTable = "MST_VEHICLE_AMENDMENTS_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_vehicle_amend_no';
	
	
	/**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */	 
	 
	/* public $validate = array( 
	 
		'vc_vehicle_lic_no'=>array(
		
			'checkRequired'=>array(
			
				'required' => true,
				'message' => 'Required'
			)	
			
		
		),
		
		'vc_vehicle_reg_no'=>array(
		
			'required' => true,
            
			'message' => 'Required'
			
		),
		
		'to_vc_customer_name'=>array(
		
			'required' => true,
            
			'message' => 'Required'
		
		)
	 
	 
	 );*/

    
   /**
	 * Get primary key
	 *
	 */
	
	function getPrimaryKey () {
		
		$count = $this->find('count');
		
		$primaryKey = (string) ( 'VEH-AMD-'.($count+1) );
		
		if( $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey))) > 0) {
								
				$i = (int) $count;

                while ( $i >= 1 ) {

                    $i += 1;
					
					$primaryKey = (string) ( 'VEH-AMD-'.($i) );
                    
					$returnValue = $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey)));

                    if ($returnValue == 0) {
                        									
                        break;
                    }
					
					$i++;
                }

                return  $primaryKey;
			
		} else {
		
			return  $primaryKey;

		}	
	
	}
	
	
}