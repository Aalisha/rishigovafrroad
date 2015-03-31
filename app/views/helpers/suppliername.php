<?php
class SuppliernameHelper extends AppHelper {
    function showHeadername($firstname, $lastname) {
      
	   $explodeName = explode(' ',$firstname);
	   $len= count($explodeName);
	   if($len>1){
	   $concatstr= array();
	   for($i=1;$i<$len;$i++) {
	   
	   $concatstr[]= $explodeName[$i];
	   
	   }
		$finalconcatstr = implode(" ",$concatstr);
		return ucfirst(substr(trim($explodeName[0]), 0, 1)).' '.$finalconcatstr;
	   
	   }else{
		
		return ucfirst(trim($firstname));
	   
	   }
		//return $explodeName[1];
    }
}
?>