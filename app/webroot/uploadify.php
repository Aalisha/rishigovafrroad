<?php

//session_start();
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
//ini_set('display_errors',1);
define('DS', DIRECTORY_SEPARATOR);
$webrootpath = $_SERVER['DOCUMENT_ROOT'].DS.'rfa'.DS.'app'.DS.'webroot';
// Define a destination
$verifyToken = md5('unique_salt'.$_POST['timestamp']);
 $vc_customer_no = $_POST['vc_customer_no'];
$targetFolder = 'uploadify'; // Relative to the root
 $targetFolder = $webrootpath.DS.$targetFolder.DS.$vc_customer_no;

//die;
if(!is_dir($targetFolder)){
	mkdir($targetFolder,0777,true);

}else{
	$files_in_directory = scandir($targetFolder);
	$items_count = count($files_in_directory);
	if($items_count==0)
	mkdir($targetFolder,0777,true);
}

//print_r($_FILES);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile        = $_FILES['Filedata']['tmp_name'];
	$tempFilesize    = $_FILES['Filedata']['size'];
	$targetPath      = $targetFolder;
	$targetfilename  = $_FILES['Filedata']['name'];
	 $targetFile     = rtrim($targetPath,' ').DS.$targetfilename;
	// Validate the file type
	$fileTypes       = array('jpg','jpeg','png','pdf'); // File extensions
	$fileParts       = pathinfo($_POST['timestamp'].$_FILES['Filedata']['name']);
	
	//if($tempFilesize < 2048000){
		if (in_array($fileParts['extension'],$fileTypes)) {
			if(move_uploaded_file($tempFile,$targetFile)==true)			
			echo $targetfilename;
			
		} else {
		
			echo 'Invalid file type.';
		
		}
	
}
?>