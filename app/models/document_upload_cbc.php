<?php
	
/**
*
*	Class name
*
*/
	
class DocumentUploadCbc extends Model{

/**
*
*	Model name
*
*/
	
	var $name='DocumentUploadCbc';
		
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

	var $useTable='DT_UPLOAD_DOCS_CBC';
	
/**
*
*	Primary key
*
*/

	var $primaryKey='nu_upload_id';
	
	 var $validate = array(
		
			'vc_upload_doc_name'=>array(
	
					'extension'=>array(
						
						'rule' => array('extension',array('pdf','png','jpeg','jpg')),
						
						'message' => 'Excepted file type pdf, png, jpeg,jpg',
						
					),
					'size'=> array( 
						
						'rule'=>'checkSize',
						
						'message'=>'Could not be more than 2MB.'				
					)				

			)	
		
	 );

//	vc_upload_doc_name
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
	
	
	function checkSize($data){
		if((int)$data['vc_upload_doc_name']['size'] <= 2048000 ) {
			//echo 'aya';
			return true;
		
		}
		
		return false;
	
	}
	
	
	   
}
?>