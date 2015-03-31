<?php

App::import('Sanitize');

/**
 * 
 * Get File Uploads Controller
 *
 */
 
 App::import('Controller', 'QqUploadedFileXhr'); 
 
 App::import('Controller', 'qqUploadedFileForm'); 
 
 Class GetuploadsController  extends AppController {

	/**
	 *
	 *
	 */
	var $name = 'Getuploads';

	/**
     *
     *
     */
    var $uses = array();
		
	/**
	 *
	 */	 
	private $allowedExtensions = array('gif', 'jpeg', 'png', 'jpg', 'pdf');
	
	/**
	 *
	 */	
    private $sizeLimit = 2097152; /**Max File Upload Size = 2MB => 2*1024*1024 In byte ***/
	
	/**
	 *
	 */	
    private $file;
	
	/**
	 *
	 *
	 */
	public function beforeFilter() {
		
		$this->Auth->allow('*');
		
	}

	/**
	 *
	 *
	 */
	 
	public function index( array $allowedExtensions = array(), $sizeLimit = 2097152 ) {	 
	 
		$allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
		
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();
			
		
		if (isset($_GET['qqfile'])) {
		
            $this->file = new QqUploadedFileXhrController();
			
			$foldername = $_GET['param2'];
			
        } elseif(isset($_FILES['qqfile'])) {
			
			$foldername = 'vehicleAdd';
			
			$this->file = new qqUploadedFileFormController();
		
		} else {
         
			$this->file = false;
		
		}		
		
		$uploadDirectory = TMP;
        
		$output = $this->handleUpload($uploadDirectory, FALSE, $foldername,  $prefix='');		
		
		echo json_encode($output);

		exit(0);
	 
	 }
	
	
	/*
	 * 
	 * Check Server Post Request Setting
	 *
	 */
		
    private function checkServerSettings() {
	
        $postSize = $this->toBytes(ini_get('post_max_size'));
        
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
          
			$size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            
			die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
		
    }
	
	/**
	 *
	 * Convert to bytes
	 *
	 */
	
    private function toBytes($str) {
        
		$val = trim($str);
        
		$last = strtolower($str[strlen($str) - 1]);
        
		switch ($last) {
            
			case 'g': $val *= 1024;
           
		    case 'm': $val *= 1024;
            
			case 'k': $val *= 1024;
        }
		
        return $val;
    }

   	/**
	 *
	 *
	 *
	 */
	 
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE, $foldername, $prefix='') {
		
        if (!$this->file) {
		
            return array('error' => 'No files were uploaded.');
        
		}

        $size = $this->file->getSize();
		
        if ($size == 0) {
		
            return array('error' => 'File is empty');
        
		}
		
		if ($size > $this->sizeLimit) {
		
            return array('error' => 'File is too large');
        
		}
		      
		$pathinfo = pathinfo($this->file->getName());
        
		$filename = $pathinfo['filename'];
       
	    $pathinfo['basename'];
		
		if( isset($_GET['qqfile']) ) {
		
			$ext = $this->getfileextension($pathinfo['basename']);
			
			$type = $this->getfiletype($pathinfo['basename']);
		
		} else if( $_FILES['qqfile'] ) {
			
			$type = $_FILES['qqfile']['type'];
			
			$ext = $this->getext($_FILES['qqfile']['type']);
		
		}else {
		
			$type = '';
			
			$ext = '';
		
		}
		
		if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            
			$these = implode(', ', $this->allowedExtensions);
            
			return array('error' => 'File has an invalid extension, it should be one of ' . $these . '.');
        
		}

        if (!$replaceOldFile) {
            
			while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
            
				$filename .= rand(10, 99);
            }
			
        }

        //new added
		
        $file_path = $uploadDirectory.$foldername;
		
        $current_timestamp = date("Y-m-d-h-i-s");
		
        $newfile_name = $current_timestamp."-".$filename.".".$ext;
		
        //$originalfilename = $pathinfo['basename'];
		 
		$originalfilename  =  $filename.".".$ext;		
		
		if (is_dir($file_path)) {
            
			if (!is_writable($file_path)) {
            
				return array('error' => "Server error. Upload directory isn't writable.");
            }
			
        } else {
		
             mkdir($file_path);
		}
		
       
        if ($this->file->save($newfile_name, $prefix, $file_path, $filename, $ext,  $originalfilename )) {
			
			return array('success' => true,
									'newfilename'=>base64_encode($newfile_name),
									'fullpath' =>base64_encode($file_path),
									'type'=>base64_encode($type)
									);
									
			
        
		} else {
		
            return array('error' => 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        
		}
		
    }
	
	
	
	/**
	 *
	 *
	 *
	 */
	 
	function getfiletype($file) {
	 
		$input = fopen("php://input", "r");
        
		$temp = tmpfile();
       
		$realSize = stream_copy_to_stream($input, $temp);
		
		fclose($input);		
		
		return  mime_content_type($temp);
	 
	 
	}
	 
	/**
	 *
	 *
	 *
	 */
	 
    function getfileextension($file) {
		
		$string = $this->getfiletype($file);
		
		return  $this->getext($string);   
	}
	
	/**
	 *
	 *
	 *
	 */
	 
    function getext($type) {
				
			$mime_types = array(
				'txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',

				// images
				'png' => 'image/png',
				'jpeg' => 'image/jpeg',
				'jpeg' => 'image/pjpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',

				// archives
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',

				// audio/video
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',

				// adobe
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',

				// ms office
				'doc' => 'application/msword',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',

				// open office
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			
			);
		
			if( $key = array_search($type, $mime_types) ) {

				return $key; 
				
			} else {
				
				return 'exe';
				
			}
        

        }
    
	
}