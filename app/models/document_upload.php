<?php

/**
 * Document Upload model.
 *
 * 
 */
class DocumentUpload extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'DocumentUpload';

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
    var $useTable = "PR_DT_UPLOAD_DOCS_MDC";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'vc_upload_id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
	 
	 var $validate = array(
		
			'vc_uploaded_doc_name'=>array(				
					
					'size' => array(
					
					'rule' => array('checkfileSize'),
					
					'message' =>  'Files must be less than 2MB'
				) ),
				'vc_municipal_doc_name'=>array(			
					
					'size' => array(
					
					'rule' => array('checkfileSizeMunicipal'),
					
					'message' => 'Files must be less than 2MB'
				)),
				'vc_business_reg_doc'=>array(			
					
					'size' => array(
					
					'rule' => array('checkfileSizeBusiness'),
					
					'message' => 'Files must less than 2MB'
				)),
				
				//checkfileSizeBusiness
					
					
					/* 					
					
					'extension'=>array(
						
						'rule' => array('extension',array('pdf','png','jpeg','jpg')),
						
						'message' => 'Excepted file type pdf, png, jpeg,jpg',
						
					)					
					*/
					
					

				
		
	 );
     
	/**
     *
     *
     */
		
	 function checkfileSize($data){
	
		if(isset($data['vc_uploaded_doc_name']['name']) && $data['vc_uploaded_doc_name']['name']!='' ){
			if((int)$data['vc_uploaded_doc_name']['size'] <= 2048000)
			return true;
			else 
			return false;
		
		}else{
		
			return true;
		
		}			
	 }
	
	
	function checkfileSizeMunicipal($data){
	
		if(isset($data['vc_municipal_doc_name']['name']) && $data['vc_municipal_doc_name']['name']!='' ){
			if((int)$data['vc_municipal_doc_name']['size'] <= 2048000)
			return true;
			else 
			return false;
		
		}else{
		
			return true;
		
		}
			
			
	}
	
	function checkfileSizeBusiness($data){
	
		if(isset($data['vc_business_reg_doc']['name']) && $data['vc_business_reg_doc']['name']!='' ){
			if((int)$data['vc_business_reg_doc']['size'] <= 2048000)
			return true;
			else 
			return false;
		
		}else{
		
			return true;
		
		}
			
			
	}
	
	
	function fileExtensionCheck($data){
	   // pr($data);
		$filename= $data['vc_uploaded_doc_name']['name'];
		if(isset($filename) && $filename!='')
		{
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$extensionruleArray = array('pdf','png','jpeg','jpg');
			if(in_array($ext,$extensionruleArray)){
			
			return true;
			}
		}

			
			
	}
	
	/**
     *
     *
     */
		
	function requiredCheck($data){
	  
		return ( isset($data['vc_uploaded_doc_name']['name']) && !empty($data['vc_uploaded_doc_name']['name'])  );
			
			
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