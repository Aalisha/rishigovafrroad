
<?php
/**
 * Vehicle Log Detail model.
 *
 * 
 */
class VehicleLogDetail extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleLogDetail';

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
    var $useTable = "dt_vehicle_log_mdc";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_log_detail_id';
    
    
   

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(); 	
    
	public $belongsTo = array(
			'PAYFREQUENCY' => array(
				'className' => 'ParameterType',
				'foreignKey' => 'vc_pay_frequency',
			),
			'STATUS'=>array(
				'className' => 'ParameterType',
				'foreignKey' => 'vc_status',
			),
			'VehicleLogMaster'=>array(
			
				'className' => 'VehicleLogMaster',
				'foreignKey' => 'vc_vehicle_log_no',
			
			
			)
			
			);
	
			public $hasOne = array(

				'VehicleDetail'=>array(
						'className'=>'VehicleDetail',
						'foreignKey' => false,
						'conditions'=>array('VehicleDetail.vc_vehicle_lic_no = VehicleLogDetail.vc_vehicle_lic_no')
				));	

    /**
	 *
	 *  Get Primary key
	 *
	 */
	 
	function getPrimaryKey () {
		
		$count = $this->find('count');
		
		$primaryKey = (string) ( 'dtl-veh'.($count+1) );
		
		if( $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey))) > 0) {
								
				$i = (int) $count;

                while ( $i >= 1 ) {

                    $i += 1;
					
					$primaryKey = (string) ( 'dtl-veh'.($i) );
                    
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