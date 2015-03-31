
<?php
/**
 * Vehicle Log Detail model.
 *
 * 
 */
class VehicleLogMaster extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleLogMaster';

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
    var $useTable = "HD_VEHICLE_LOG_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_vehicle_log_no';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = array(); 	
    
     /**
	 *
	 *  Get Primary key
	 *
	 */
	 
	function getPrimaryKey () {
		
		$count = $this->find('count');
		
		$primaryKey = (string) ( 'hdl-veh'.($count+1) );
		
		if( $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey))) > 0) {
								
				$i = (int) $count;

                while ( $i >= 1 ) {

                    $i += 1;
					
					$primaryKey = (string) ( 'hdl-veh'.($i) );
                    
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