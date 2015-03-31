<?php
/**
 * 
 *   Upload Document Inspector Log
 * 
 */
class UploadDocumentLogInspector extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'UploadDocumentLogInspector';

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
    var $useTable = "PR_DT_UPLOAD_LOG_DOCS_INSP";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'VC_UPLOAD_ID';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
//    var $validate = array( );
	
	var $validate = array(	
			'vc_uploaded_doc_name'=>array(
	
					/* 'extension'=>array(
						
						'rule' => array('extension',array('pdf','png','jpeg','jpg')),
						
						'message' => 'Excepted file type pdf, png, jpeg,jpg',
						
						'required' =>False,
						
						'allowEmpty' =>True
						
					), */
					'size'=> array(
						
						'rule'=>'checkSize',
						
						'message'=>'Files must be no larger than 2MB.'				
					)
	 ) ); 
     
	/**
     *
     *
     */
		
	
	function checkSize($data){
	//pr($data);
		if(isset($data['vc_uploaded_doc_name']['name']) && $data['vc_uploaded_doc_name']['name']!=''){
		
		if( (int) $data['vc_uploaded_doc_name']['size'] <= 2048000 ) {
			
			return true;
		
		}else{	  // pr($data);

			return false;
		}		
		}else{
		return true;
		}	
	} 
	
	/**
	 * Get primary key
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