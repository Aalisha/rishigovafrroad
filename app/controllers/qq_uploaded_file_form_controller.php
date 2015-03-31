<?php

App::import('Sanitize');

/**
 * Specially Manage IE
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileFormController extends AppController {

	/**
	 *
	 *
	 */
	var $name = 'qqUploadedFileForm';

	/**
     *
     *
     */
    var $uses = array();
	
	/**
	 *
	 *
	 */
	 
	public function beforeFilter(){
	
		$this->Auth->allow('*');
		
	}
		
	/**
	 * 
	 * $path => Filename
	 */
	function save($filename, $prefix, $file_path, $path, $ext, $originalfilename) {
	
       		        
		if ($_FILES['qqfile']['size'] != $this->getSize()) {
           
			return false;
        
		}
		
        $path = $path.'.'.$ext;
		
        $filename = str_replace("#", "hash", $filename);
		
        $filename = str_replace("$", "dollar", $filename);
		
        $filename = str_replace("%", "Percent", $filename);
		
        $filename = str_replace("^", "", $filename);
		
        $filename = str_replace("&", "and", $filename);
		
        $filename = str_replace("*", "", $filename);
		
        $filename = str_replace("?", "", $filename);
	   
	   /*** Save File***/
	    
	    if( rename( $_FILES['qqfile']['tmp_name'],$file_path. DS . $filename ) ) {

			return true;

		} else {
			
			unlink($_FILES['qqfile']['tmp_name']);
			
			return false;
	
		}
	  
    }
	
	/**
	 *
	 *
	 *
	 */
	 
	function getName() {
			
		return $_FILES['qqfile']['name'];
    
	}
	
	/**
	 *
	 *
	 *
	 */
	
	
    function getSize() {
		
		return $_FILES['qqfile']['size'];
    
	}
	
	
    /**
	 *
	 *
	 */
	 
    function getfiletype() {
        
		return $_FILES['qqfile']['type'];
    
	}

	 
}

?>