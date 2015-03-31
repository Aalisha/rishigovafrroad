<?php

/**
 * Registration model.
 *
 * 
 */
class VehicleHeader extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'VehicleHeader';

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
    var $useTable = "HD_REGISTRATION_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_registration_no';

   
	public function lastID() {
        $data = $this->find('first', array(
            'order' => array($this->primaryKey . ' DESC'),
            'fields' => array($this->primaryKey)
                )
        );

        return $data[$this->name][$this->primaryKey];
    }             
    
    
    
    
    
    
    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    
    
    var $validate = array( );
	
	
	
	/**
	 * Get primary key
	 *
	 */
	
	function getPrimaryKey () {
		
		$count = $this->find('count');
		
		$primaryKey = (string) ( "reg-veh".($count+1) );
		
		if( $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey))) > 0) {
								
				$i = (int) $count;

                while ( $i >= 1 ) {

                    $i += 1;
					
					$primaryKey = (string) ( "reg-veh".($i) );
                    
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
	
?>