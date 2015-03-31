<?php
/**
 * Vehicle Log Detail Rejected model.
 *
 * 
 */
class VehicleLogDetailRejected extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleLogDetailRejected';

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
    var $useTable = "DT_VEHICLE_LOG_REJ_MDC";
    
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