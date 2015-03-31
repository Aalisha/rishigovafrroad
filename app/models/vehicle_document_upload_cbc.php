<?php
	
/**
*
*	Class name
*
*/
	
class VehicleDocumentUploadCbc extends Model{

/**
*
*	Model name
*
*/
	
	var $name='VehicleDocumentUploadCbc';
		
/**
*
*	
*
*/
	
	var $useDbconfig='default';
		
/**
*
*	Table used
*
*/

	var $useTable='PR_DT_UPLOAD_VEHICLE_DOCS_CBC';
	
/**
*
*	Primary key
*
*/

	var $primaryKey='nu_upload_vehicle_id';
	
/**
*
*Function to generate primary key
*
*/
	
	function getPrimaryKey () {
		
		$count = $this->find('count');
		
		$primaryKey = $count+1;
		
		if( $this->find('count',array('conditions'=>array($this->name . '.' . $this->primaryKey=>$primaryKey))) > 0) {
								
				$i = (int) $count;

                while ( $i >= 1 ) {

                    $i += 1;
					
					$primaryKey = $i;
                    
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