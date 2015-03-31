<?php

App::import('Sanitize');

/**
 * Handle file uploads via XMLHttpRequest
 */
class QqUploadedFileXhrController extends AppController {

	/**
	 *
	 *
	 */
	var $name = 'QqUploadedFileXhr';

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
	
        $input = fopen("php://input", "r");
        
		$temp = tmpfile();
				        
		$realSize = stream_copy_to_stream($input, $temp);
       
	    fclose($input);

        if ($realSize != $this->getSize()) {
           
			return false;
        
		}
		
        $path = $path.'.'.$ext;
		
        $target = fopen($path, "w");
		
        fseek($temp, 0, SEEK_SET);
		
        stream_copy_to_stream($temp, $target);
		
        fclose($target);
       
	   
        	
        $filename = str_replace("#", "hash", $filename);
		
        $filename = str_replace("$", "dollar", $filename);
		
        $filename = str_replace("%", "Percent", $filename);
		
        $filename = str_replace("^", "", $filename);
		
        $filename = str_replace("&", "and", $filename);
		
        $filename = str_replace("*", "", $filename);
		
        $filename = str_replace("?", "", $filename);
	   
	   /*** Save File***/
	    
	    if( rename( APP.WEBROOT_DIR. DS . $originalfilename,$file_path. DS .$filename ) ) {

			return true;

		} else {
			
			unlink(APP.WEBROOT_DIR.DS.$originalfilename);
			
			return false;
	
		}
	  
    }
	
	/**
	 *
	 *
	 *
	 */
	 
    function getName() {
	
        return $_GET['qqfile'];
    
	}
	
	/**
	 *
	 *
	 *
	 */
	 
    function getSize() {
        
		if (isset($_SERVER["CONTENT_LENGTH"])) {
        
			return (int) $_SERVER["CONTENT_LENGTH"];
        
		} else {
        
			throw new Exception('Getting content length is not supported.');
        }
		
    }
	
	
    /**
	 *
	 *
	 */
	 
    function getfile($filename) {

        $allowed_ext = array(
            // archives
            'zip' => 'application/zip',
            // documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/msword',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'txt' => 'application/txt',
            // executables
            'exe' => 'application/octet-stream',
            // images
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            // audio
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/x-wav',
            // video
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo'
        );

        if (!is_file($filename))
            die("File does not exist. Make sure you specified correct file name.");
        $fsize = filesize($filename);
        $fext = strtolower(substr(strrchr($filename, "."), 1));
        if (!array_key_exists($fext, $allowed_ext))
            die("Not allowed file type.");
        if ($allowed_ext[$fext] == '') {
            $mtype = '';
            // mime type is not set, get from server settings
            if (function_exists('mime_content_type')) {
                $mtype = mime_content_type($filename);
            } else if (function_exists('finfo_file')) {
                $finfo = finfo_open(FILEINFO_MIME); // return mime type
                $mtype = finfo_file($finfo, $filename);
                finfo_close($finfo);
            }
            if ($mtype == '') {
                $mtype = "application/force-download";
            }
        } else {
            // get mime type defined by admin
            $mtype = $allowed_ext[$fext];
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: $mtype");
        header("Content-Disposition: attachment; filename=" . basename($filename));
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);
        ob_clean();
        $file = @fopen($filename, "rb");
        if ($file) {
            while (!feof($file)) {
                print(fread($file, 1024 * 8));
                flush();
                if (connection_status() != 0) {
                    @fclose($file);
                    die();
                }
            }
            @fclose($file);
        }
    }

	 
}

?>