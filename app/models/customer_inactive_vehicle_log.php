<?php
/**
 * 
 * Customer Inactive Vehicle Log
 * 
 */
class CustomerInactiveVehicleLog extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'CustomerInactiveVehicleLog';

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
    var $useTable = "DT_VEHICLE_INACTIVE_LOG_MDC";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'vc_log_detail_id';

    /**
     * validate name
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */

    var $validate = array(
	
		'dt_log_date'=>array(
			'date' => array(
				'rule' => array('date', array('dMy')),
				'message' => 'Invalid date format',
				'allowEmpty' => true
			),
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),	
		'vc_driver_name'=>array(			
			'between' => array(
                'rule' => array('between', 1, 100),
                'message' => 'Between 1 to 100 characters'
            ) ,
			'letter' => array(
				'rule' => '/^[A-Za-z\s]+$/',
				'message' => 'Only letters are allowed'
			),			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)			
		),
		'vc_vehicle_lic_no'=>array(			
			'uniqueCheck' => array(
				'rule' => array('getQunique'),
				'message' => 'Already has been used'
			),
			'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Alphabets and numbers only'
            ),	
			'between' => array(
                'rule' => array('between', 1, 15),
                'message' => 'Between 1 to 15 characters'
            ),			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),
		'vc_vehicle_reg_no'=>array(
			'compareValue'=>array(
				'rule' => array('compareValue'),
				'message' => 'Should be unique'					
			),
			'uniqueCheck' => array(
				'rule' => array('getQunique'),
				'message' => 'Already has been used'
			),
			'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Alphabets and numbers only'
            ),	
			'between' => array(
                'rule' => array('between', 1, 15),
                'message' => 'Between 1 to 15 characters'
            ),			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),
		'nu_start_ometer'=>array(
			
			'checkUnique'=>array(
				
				'rule' => array('nuStartMeterUnique'),
				
				'message' => 'Start meter is already use.'
			
			),
			'numeicOnly' => array(
				'rule' => 'customNumeric',
				'message' => 'Accept numbers only'
			),		
			'between' => array(
                'rule' => array('between', 1, 10),
                'message' => 'Between 1 to 10 characters'
            ),	
			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
			
		),
		'nu_end_ometer'=>array(

			'checkUnique'=>array(
				
				'rule' => array('nuEndMeterUnique'),
				
				'message' => 'End meter is already use.'
			
			),
			
			'numeicOnly' => array(
				'rule' => array('customNumeric'),
				'message' => 'Accept numbers only'
			),		
			'between' => array(
                'rule' => array('between', 1, 10),
                'message' => 'Between 1 to 10 characters'
            ),	
			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),
		'vc_orign'=>array(
			'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Between 1 to 50 characters'
            ) ,
			'letter' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Alphabets and numbers only'
			),			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)		
		),
		'vc_destination'=>array(

			'notequallocation'=>array(
					
					'rule' => array('locationComparision' ),
					
					'message' => 'The location not a same',
			),
			'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Between 1 to 50 characters'
            ) ,
			'letter' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Alphabets and numbers only'
			),			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),
		'nu_km_traveled'=>array(

			'distanceCalc'=>array(
					'rule' => array('distanceCalculation'),
					'message' => 'Invalid distance value'
			),
			'numeicOnly' => array(
				'rule' => array('customNumeric'),
				'message' => 'Accept numbers only'
			),		
			'between' => array(
                'rule' => array('between', 1, 10),
                'message' => 'Between 1 to 10 characters'
            ),				
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),		
		'selectedroad'=>array(			
				
			'between' => array(
                'rule' => array('between', 0, 1),
                'message' => 'Between 1 to 15 characters'
            ),			
			'mustRequired' => array(
				'rule' => 'notEmpty',
				'message' => 'Required',
			)
		),
		'vc_other_road_orign'=>array(
			'between' => array(
                'rule' => array('between', 1, 50),
				'allowEmpty' => true,
                'message' => 'Between 1 to 50 characters'
            ) ,
			'letter' => array(
				'rule' => array('alphaNumeric'),
				'allowEmpty' => true,
				'message' => 'Alphabets and numbers only'
			)
		),		
		'vc_other_road_destination'=>array(
			
			/*'notequallocation'=>array(
					
					'rule' => array('otherLocationComparision'),
					
					'message' => 'The location not a same',
			),
			*/
			'between' => array(
                'rule' => array('between', 1, 50),
                'message' => 'Between 1 to 50 characters',
				'allowEmpty' => true,
            ) ,
			'letter' => array(
				'rule' => array('alphaNumeric'),
				'allowEmpty' => true,
				'message' => 'Alphabets and numbers only'
			)
		),
		'nu_other_road_km_traveled'=>array(

			/*'distanceCalc'=>array(
					'rule' => array('Invalid distance value'),
					'message' => 'Accept numbers only'
			),*/
			'numeicOnly' => array(
				'rule' => array('customNumeric'),
				'allowEmpty' => true,
				'message' => 'Accept numbers only'
			),		
			'between' => array(
                'rule' => array('between', 1, 10),
				'allowEmpty' => true,
                'message' => 'Between 1 to 10 characters'
            )
		)
		
	
	);

    /**
     *
     * Get Primary Key Value  
     *
     */
    function getPrimaryKey() {

        $count = $this->find('count');

        $primaryKey = $count + 1;

        if ($this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey))) > 0) {

            $i = (int) $count;

            while ($i >= 1) {

                $i += 1;

                $primaryKey = $i;

                $returnValue = $this->find('count', array('conditions' => array($this->name . '.' . $this->primaryKey => $primaryKey)));

                if ($returnValue == 0) {

                    break;
                }

                $i++;
            }

            return $primaryKey;
        } else {

            return $primaryKey;
        }
    }
	
	/**
	 *	
	 *  Below Function is used to check comparing value
	 *
	 */
	 
	 function compareValue($data) {

		return ( strtolower(trim($data['vc_vehicle_reg_no'])) != strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_lic_no'])) );
		
	 }
	 
	 
	/**
	 *
	 * Below function is use to check number will be positive integer number
	 *
	 */
	 
	 function customNumeric($data) {
		
		return Validation::numeric(current($data)) && current($data) >= 0;
		
	 }
	 
	/*
	 *
	 *
	 *
	 */
	 
	 function getQunique($data) {
	 
		App::import('model','VehicleDetail');
		
		$VehicleDetail = new VehicleDetail();
		
		$vehicleNo = strtolower(trim(current($data)));
		
		 return $VehicleDetail->find('count', array(
											'conditions'=>array(
												'OR'=>array(
													'lower(VehicleDetail.vc_vehicle_lic_no)'=>"{$vehicleNo}",
													'lower(VehicleDetail.vc_vehicle_reg_no)'=>"{$vehicleNo}"
												)
											))) > 0 ? false : true;
		
	 
	 }
	 
	/*
	 *
	 * Unique Check Start Odometer across vehicle lic. no or vehicle reg. no.
	 *
	 */
	 
	 function nuStartMeterUnique( $data ) {
	 
			
		if( $this->find('count',array(

										'conditions'=>array(
													'OR'=>array(
														"lower({$this->name}.vc_vehicle_lic_no)"=>array( strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_reg_no'])) ,strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_lic_no'])) ),
														"lower({$this->name}.vc_vehicle_reg_no)"=>array( strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_reg_no'])) ,strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_lic_no'])) )),
														"{$this->name}.nu_start_ometer"=>trim(current($data))))) == 0 ) :

			return true;							

		endif;							

			return false;
		
	 }
	 
	 
	 
	/*
	 *
	 * Unique Check End Odometer across vehicle lic. no or vehicle reg. no.
	 *
	 */
	 
	 function nuEndMeterUnique( $data ) {
	 
			
		if( $this->find('count',array(
							
								'conditions'=>array(
									
									'OR'=>array(
										"lower({$this->name}.vc_vehicle_lic_no)"=>array( strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_reg_no'])) ,	strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_lic_no'])) ),
										"lower({$this->name}.vc_vehicle_reg_no)"=>array( strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_reg_no'])) ,strtolower(trim($this->data['CustomerInactiveVehicleLog']['vc_vehicle_lic_no'])) )
										),
										"{$this->name}.nu_end_ometer"=>trim(current($data))))) == 0 ) :
									
		return true;							
									
		endif;							
						
		return false;
		
	 }


	/*
	*
	* Check Origin and Destination not be same.
	*
	*/
	
	function locationComparision( $data ) {
		
		return trim(current($data)) == trim($this->data['CustomerInactiveVehicleLog']['vc_orign']) ? false : true; 
	
	}
	
	/*
	*
	* Check Other Origin and Destination not be same.
	*
	*/
	
	function otherLocationComparision( $data ) {
		
		return trim(current($data)) == trim($this->data['CustomerInactiveVehicleLog']['vc_other_road_orign']) ? false : true; 
	
	}
	
	/*
	*
	*	Check kilometre travel  mean distance between origin and distance by vehicle
	*
	*/
	
	function distanceCalculation($data) {
		
		$CustomerLocationDistance = ClassRegistry::init('CustomerLocationDistance');
		
		
		$returnResult = $CustomerLocationDistance->find('first', array(
			'conditions'=>array(
'lower(CustomerLocationDistance.vc_loc_from_code)'=>trim(strtolower($this->data['CustomerInactiveVehicleLog']['vc_orign'])),
'lower(CustomerLocationDistance.vc_loc_to_code)'=>trim(strtolower($this->data['CustomerInactiveVehicleLog']['vc_destination']))
			),
			'fields'=>array('CustomerLocationDistance.nu_distance')
			
		));
		
		$distance = $returnResult == true ? current($returnResult['CustomerLocationDistance']) : 0 ;
		
	    return ( $distance <= current($data) ) ? true : false;
		
	}
	
	
	/*
	*
	*	Check Other kilometre travel  mean distance between origin and distance by vehicle
	*
	*/
	
	function otherDistanceCalculation($data) {
	
		$CustomerLocationDistance = ClassRegistry::init('CustomerLocationDistance');
		
		$returnResult = $CustomerLocationDistance->find('first', array(
			'conditions'=>array(
'lower(CustomerLocationDistance.vc_other_road_orign)'=>trim(strtolower($this->data['CustomerInactiveVehicleLog']['vc_other_road_orign'])),
'lower(CustomerLocationDistance.vc_other_road_destination)'=>trim(strtolower($this->data['CustomerInactiveVehicleLog']['vc_other_road_destination']))
			),
			'fields'=>array('CustomerLocationDistance.nu_distance')
			
		));
		
		$distance = $returnResult == true ? current($returnResult['CustomerLocationDistance']) : 0 ;
		
	    return ( $distance <= current($data) ) ? true : false;
	
	
	}
	
		
}